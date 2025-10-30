<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Game;
use App\Models\Court;
use App\Models\User;
use App\Models\Division;
use Silber\Bouncer\BouncerFacade as Bouncer;

class EditFixture extends Component
{
    public $gameId;
    public $home_team;
    public $away_team;
    public $match_date;
    public $match_time;
    public $venue;
    public $court_id;
    public $scorekeeper_id;
    public $statistician_id;
    public $division_id;

    public $courts = [];
    public $divisions = [];
    public $scorekeepers = [];
    public $statisticians = [];

    protected $rules = [
        'match_date'      => 'required|date',
        'match_time'      => 'required',
        'venue'           => 'required|string',
        'court_id'        => 'required|exists:courts,id',
        'scorekeeper_id'  => 'nullable|exists:users,id',
        'statistician_id' => 'nullable|exists:users,id',
    ];

    public function mount($gameId)
    {
        $this->gameId = $gameId;

        // Load game with relationships
        $game = Game::with(['homeTeam', 'awayTeam', 'court', 'timeSlot'])->findOrFail($gameId);

        $this->home_team       = $game->homeTeam->name ?? 'N/A';
        $this->away_team       = $game->awayTeam->name ?? 'N/A';
        $this->match_date      = $game->date->format('Y-m-d');
        $this->match_time      = $game->timeSlot->name ?? null;
        $this->venue           = $game->court->venue ?? null;
        $this->court_id        = $game->court_id;
        $this->scorekeeper_id  = $game->scorekeeper_id;
        $this->statistician_id = $game->statistician_id;
        $this->division_id     = $game->division_id;

        // Load reference data
        $this->courts        = Court::all();
        $this->divisions     = Division::all();
        $this->scorekeepers  = User::whereIs('scorekeeper')->get();   // Bouncer roles
        $this->statisticians = User::whereIs('statistician')->get();  // Bouncer roles
    }

    public function updateFixture()
    {
        $this->validate();

        $game = Game::findOrFail($this->gameId);
        $game->update([
            'date'            => $this->match_date,
            'time_slot_id'    => $this->match_time,  // if storing time slot ID
            'venue'           => $this->venue,
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
