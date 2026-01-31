<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Division;
use App\Models\Game;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.public')]
class PublicSchedules extends Component
{
    public $selectedDivision;

    public function mount()
    {
        $this->selectedDivision = Division::first()?->id;
    }

    public function render()
    {
        $divisions = Division::all();
        $currentDivision = $divisions->firstWhere('id', $this->selectedDivision);

        $schedule = Game::where('division_id', $this->selectedDivision)
            ->with(['homeTeam', 'awayTeam', 'court', 'timeSlot'])
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy(function($game) {
                return $game->date ? $game->date->format('l, F j, Y') : 'Date TBD';
            });

        return view('livewire.public.public-schedules', [
            'divisions' => $divisions,
            'currentDivisionName' => $currentDivision?->name ?? 'League',
            'schedule' => $schedule,
        ]);
    }
}

