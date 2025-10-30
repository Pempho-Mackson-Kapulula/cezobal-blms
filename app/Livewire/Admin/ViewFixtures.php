<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Division;
use App\Models\Game;
use Carbon\Carbon;

class ViewFixtures extends Component
{
    public $divisions = [];
    public $selectedDivision = null;
    public $games;
    public $filterStatus = 'all'; // all | upcoming | completed
    public $message = null;

    protected $listeners = ['fixturesUpdated' => 'loadFixtures'];

    public function mount()
    {
        $this->divisions = Division::orderBy('name')->get();

        // default to first division if nothing selected
        $this->selectedDivision = $this->divisions->first()?->id;
        $this->loadFixtures();
    }

    public function updatedSelectedDivision($value)
    {
        $this->selectedDivision = $value; // ensure selectedDivision is updated
        $this->loadFixtures();
    }

    public function updatedFilterStatus()
    {
        $this->loadFixtures();
    }

    public function loadFixtures()
    {
        if (!$this->selectedDivision) {
            $this->games = collect();
            $this->message = "No division selected.";
            return;
        }

        $query = Game::with(['homeTeam', 'awayTeam', 'court', 'timeSlot', 'scorekeeper', 'statistician'])
            ->where('division_id', $this->selectedDivision)
            ->orderBy('date');

        // Apply filter
        if ($this->filterStatus === 'upcoming') {
            $query->whereDate('date', '>=', Carbon::today());
        } elseif ($this->filterStatus === 'completed') {
            $query->whereDate('date', '<', Carbon::today());
        }

        $this->games = $query->get();

        $this->message = $this->games->isEmpty() ? 'No fixtures found for this division.' : null;
    }
    public function editFixture($id)
    {
        return redirect()->route('admin.edit-fixture', ['gameId' => $id]);
    }


    public function render()
    {
        return view('livewire.admin.view-fixtures');
    }
}
