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


    /**
     * Internal: generate schedule for a specific division given teams.
     */
    protected function generateDivisionSchedule(Division $division, $teams)
    {
        $matches = $this->generateDoubleRoundRobin($teams);

        $courts = Court::all();
        $timeSlots = TimeSlot::all();
        $scorekeepers = User::whereIs('scorekeeper')->get();
        $statisticians = User::whereIs('statistician')->get();

        if ($courts->isEmpty() || $timeSlots->isEmpty()) {
            Log::error("SchedulerService: Missing courts or time slots for {$division->name}");
            return;
        }

        if ($scorekeepers->isEmpty())
            $scorekeepers = collect([null]);
        if ($statisticians->isEmpty())
            $statisticians = collect([null]);

        $currentDate = clone $this->weekendStart;
        $courtIndex = $slotIndex = $scoreIndex = $statIndex = 0;

        foreach ($matches as $match) {
            $court = $courts[$courtIndex % $courts->count()];
            $slot = $timeSlots[$slotIndex % $timeSlots->count()];
            $score = $scorekeepers[$scoreIndex % $scorekeepers->count()];
            $stat = $statisticians[$statIndex % $statisticians->count()];

            \Log::info('Creating game', [
                'division' => $division->name,
                'home' => $match['home']->name,
                'away' => $match['away']->name,
                'date' => $currentDate->toDateString(),
            ]);


            Game::create([
                'division_id' => $division->id,
                'home_team_id' => $match['home']->id,
                'away_team_id' => $match['away']->id,
                'date' => $currentDate->toDateString(),
                'time_slot_id' => $slot->id,
                'court_id' => $court->id,
                'scorekeeper_id' => $score ? $score->id : null,
                'statistician_id' => $stat ? $stat->id : null,
                'status' => 'scheduled',
            ]);

            // Rotate indexes
            $slotIndex++;
            $scoreIndex++;
            $statIndex++;

            // Move to next weekend after consuming all time slots
            if ($slotIndex % $timeSlots->count() === 0) {
                $currentDate->addWeek()->next('Saturday');
                $courtIndex++;
            }
        }

        Log::info("SchedulerService: Schedule generated for '{$division->name}'", [
            'division_id' => $division->id,
            'games_created' => count($matches),
        ]);
    }

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
