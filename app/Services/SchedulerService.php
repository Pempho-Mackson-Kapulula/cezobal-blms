<?php

namespace App\Services;

use App\Models\Division;
use App\Models\Court;
use App\Models\TimeSlot;
use App\Models\Game;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SchedulerService
{
    protected $weekendStart;

    public function __construct($weekendStart = null)
    {
        // Default start date = next Saturday
        $this->weekendStart = $weekendStart ?? now()->next('Saturday');
    }

    /**
     * Public: generate schedule for one division by ID.
     * Returns true on success, false on skip/error.
     */
    public function generateForDivision($divisionId)
    {
        $division = Division::with('teams')->find($divisionId);

        if (!$division) {
            Log::warning("SchedulerService: Division with ID {$divisionId} not found.");
            return false;
        }

        $teams = $division->teams->shuffle();
        $numTeams = $teams->count();

        if ($numTeams < 2) {
            Log::warning("SchedulerService: Division '{$division->name}' skipped — not enough teams ({$numTeams}).");
            return false;
        }

        $this->generateDivisionSchedule($division, $teams);

        return true;
    }

    /**
     * Alias for backward-compatibility: some callers used generateForDivisionId()
     */
    public function generateForDivisionId($divisionId)
    {
        $division = Division::with('teams')->findOrFail($divisionId);
        return $this->generateDivisionSchedule($division, $division->teams->shuffle());
    }

    // ... (generateForDivision and generateForDivisionId methods remain the same)

    /**
     * Internal: generate schedule for a specific division given teams.
     */
    protected function generateDivisionSchedule(Division $division, $teams)
    {
        // Get all matches (Double Round Robin)
        $matches = $this->generateDoubleRoundRobin($teams);
        $numMatches = count($matches);

        // Fetch all courts and time slots (assuming they are fixed resources)
        $courts = Court::all();
        $timeSlots = TimeSlot::all(); // Assuming TimeSlot is ordered by start_time

        if ($courts->isEmpty() || $timeSlots->isEmpty()) {
            Log::error("SchedulerService: Missing courts or time slots for {$division->name}");
            return;
        }

        // Prepare support staff (same as before)
      
        $statisticians = User::whereIs('statistician')->get();
        if ($statisticians->isEmpty()) $statisticians = collect([null]);

        // --- SCHEDULING LOGIC ---

        $scheduledMatches = 0;
        $scoreIndex = 0;
        $statIndex = 0;
        $currentDate = clone $this->weekendStart;

        // Key: Date string (Y-m-d), Value: Array of Team IDs that have played on this date
        $teamDailyAvailability = [];

        // Loop until all matches are scheduled, or we run out of reasonable dates
        while ($scheduledMatches < $numMatches && $currentDate->diffInMonths($this->weekendStart) < 12) {
            $dateString = $currentDate->toDateString();
            
            // Initialize availability tracking for the current date
            if (!isset($teamDailyAvailability[$dateString])) {
                $teamDailyAvailability[$dateString] = [];
            }

            $dateHasSlotsUsed = false;
            
            // Iterate through ALL Courts
            foreach ($courts as $court) {
                
                // Then iterate through all TimeSlots for the current court/date
                foreach ($timeSlots as $slot) {
                    
                    // 🚨 NEW GLOBAL AVAILABILITY CHECK 🚨
                    // Check if this specific court/time slot is ALREADY booked by ANY division
                    $isSlotBooked = Game::where('date', $dateString)
                                        ->where('time_slot_id', $slot->id)
                                        ->where('court_id', $court->id)
                                        ->exists();

                    if ($isSlotBooked) {
                        // Skip this slot and move to the next one
                        Log::debug("SchedulerService: Court {$court->name} at {$slot->start_time} on {$dateString} is already booked by another division. Skipping.");
                        continue; 
                    }
                    
                    // --- Original Team Availability Check Remains ---
                    $foundMatchKey = -1;
                    
                    // Search for the first available match from the division's match list
                    for ($i = 0; $i < count($matches); $i++) {
                        $match = $matches[$i];
                        $homeId = $match['home']->id;
                        $awayId = $match['away']->id;

                        // Check if either team in the current division has already played on this date
                        if (!in_array($homeId, $teamDailyAvailability[$dateString]) &&
                            !in_array($awayId, $teamDailyAvailability[$dateString])) {
                            
                            // Found a suitable match!
                            $foundMatchKey = $i;
                            break;
                        }
                    }

                    if ($foundMatchKey !== -1) {
                        $match = $matches[$foundMatchKey];
                        $stat = $statisticians[$statIndex % $statisticians->count()];

                        // Create the Game (booking the slot for this division)
                        Game::create([
                            'division_id' => $division->id,
                            'home_team_id' => $match['home']->id,
                            'away_team_id' => $match['away']->id,
                            'date' => $dateString,
                            'time_slot_id' => $slot->id,
                            'court_id' => $court->id,
                            'statistician_id' => $stat ? $stat->id : null,
                            'status' => 'scheduled',
                        ]);

                        // --- Update tracking and rotate staff ---

                        // 1. Mark teams as played on this date
                        $teamDailyAvailability[$dateString][] = $match['home']->id;
                        $teamDailyAvailability[$dateString][] = $match['away']->id;
                        
                        // 2. Remove match from the division's list
                        array_splice($matches, $foundMatchKey, 1);

                        // 3. Increment counters
                        $scheduledMatches++;
                        $scoreIndex++;
                        $statIndex++;
                        $dateHasSlotsUsed = true;
                    } 
                    // If $foundMatchKey is -1, it means all teams in *this division* have played for the day, 
                    // so we move to the next time slot/court.
                } // end time slot loop
            } // end court loop
            
            // Advance to the next weekend (Saturday)
            if ($dateHasSlotsUsed || $currentDate->equalTo($this->weekendStart)) {
                $currentDate = $currentDate->addDay()->next('Saturday');
            } else {
                // If no slots were used and we are stuck, advance the date
                $currentDate = $currentDate->addDay()->next('Saturday');
                Log::warning("SchedulerService: Advanced date without finding matches for {$dateString} in division {$division->name}.");
            }
        }

        if ($scheduledMatches < $numMatches) {
            Log::error("SchedulerService: Could not schedule all matches for {$division->name}. Scheduled {$scheduledMatches}/{$numMatches}.");
        } else {
            Log::info("SchedulerService: Schedule generated for '{$division->name}'", [
                'division_id' => $division->id,
                'games_created' => $scheduledMatches,
            ]);
        }
    }

    // ... (generateDoubleRoundRobin method remains the same)
    /**
     * Build double round-robin match list.
     * Returns array of ['home' => Team, 'away' => Team]
     */
    protected function generateDoubleRoundRobin($teams)
    {
        $matches = [];
        $numTeams = $teams->count();

        // Single round robin
        for ($i = 0; $i < $numTeams - 1; $i++) {
            for ($j = $i + 1; $j < $numTeams; $j++) {
                $matches[] = ['home' => $teams[$i], 'away' => $teams[$j]];
            }
        }

        // Double round robin: add swapped fixtures
        $doubleMatches = [];
        foreach ($matches as $m) {
            $doubleMatches[] = $m;
            $doubleMatches[] = ['home' => $m['away'], 'away' => $m['home']];
        }

        return $doubleMatches;
    }
}
