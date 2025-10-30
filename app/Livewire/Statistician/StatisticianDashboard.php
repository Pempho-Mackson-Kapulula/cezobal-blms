<?php

namespace App\Livewire\Statistician;

use Livewire\Component;
use App\Models\User;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class StatisticianDashboard extends Component
{
    public function render()
    {
        $assignedGames = auth()->user()->assignedGames()->with(['homeTeam', 'awayTeam'])->orderBy('date')->get();

        return view('livewire.statistician.statistician-dashboard', compact('assignedGames'));
    }

}
