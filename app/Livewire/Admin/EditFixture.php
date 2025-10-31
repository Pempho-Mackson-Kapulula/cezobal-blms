<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Game;
use App\Models\Court;
use App\Models\User;
use App\Models\Division;
use Silber\Bouncer\BouncerFacade as Bouncer;
use App\Models\TimeSlot;

class EditFixture extends Component
{
    public $gameId;
    public $home_team;
    public $away_team;
    public $match_date;
    public $match_time; // this will now hold time_slot_id
    public $venue;
    public $court_id;
    public $scorekeeper_id;
    public $statistician_id;
    public $division_id;

    public $courts = [];
    public $divisions = [];
    public $scorekeepers = [];
    public $statisticians = [];
    public $timeSlots = []; // ✅ Add this

    protected $rules = [
        'match_date'      => 'required|date',
        'match_time'      => 'required|exists:time_slots,id',
        'court_id'        => 'required|exists:courts,id',
        'scorekeeper_id'  => 'nullable|exists:users,id',
        'statistician_id' => 'nullable|exists:users,id',
    ];

    public function mount($gameId)
    {
        $this->gameId = $gameId;

        $game = Game::with(['homeTeam', 'awayTeam', 'court', 'timeSlot'])->findOrFail($gameId);

        $this->home_team       = $game->homeTeam->name ?? 'N/A';
        $this->away_team       = $game->awayTeam->name ?? 'N/A';
        $this->match_date      = $game->date->format('Y-m-d');
        $this->match_time      = $game->time_slot_id; // ✅ use the foreign key
        $this->court_id        = $game->court_id;
        $this->scorekeeper_id  = $game->scorekeeper_id;
        $this->statistician_id = $game->statistician_id;
        $this->division_id     = $game->division_id;

        $this->courts        = Court::all();
        $this->divisions     = Division::all();
        $this->scorekeepers  = User::whereIs('scorekeeper')->get();
        $this->statisticians = User::whereIs('statistician')->get();
        $this->timeSlots     = TimeSlot::orderBy('start_time')->get(); // ✅ load times
    }

    public function updateFixture()
    {
        $this->validate();

        $game = Game::findOrFail($this->gameId);

        $game->update([
            'date'            => $this->match_date,
            'time_slot_id'    => $this->match_time, // ✅ save slot ID
            'court_id'        => $this->court_id,
            'scorekeeper_id'  => $this->scorekeeper_id,
            'statistician_id' => $this->statistician_id,
        ]);

        session()->flash('success', 'Fixture updated successfully!');
        return redirect()->route('admin.view-fixtures');
    }

    public function render()
    {
        return view('livewire.admin.edit-fixture');
    }
}