<?php
namespace App\Livewire\Public;

use App\Models\Team;
use App\Models\Division;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.public')] 
class TeamsPage extends Component
{
    public $selectedDivision = ''; // For filtering

    public function render()
    {
        return view('livewire.public.teams-page', [
            'divisions' => Division::all(),
            'teams' => Team::query()
                ->when($this->selectedDivision, fn($q) => $q->where('division_id', $this->selectedDivision))
                ->orderBy('name')
                ->get(),
        ]);
    }
}
