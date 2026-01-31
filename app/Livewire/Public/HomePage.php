<?php

namespace App\Livewire\Public;

use App\Models\Game;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.public')] 
#[Title('Home - CEZOBAL')]
class HomePage extends Component
{
    public function render()
    {
        return view('livewire.public.home-page', [
            // Get last 3 completed games
            'recentResults' => Game::where('status', 'completed')
                ->with(['homeTeam', 'awayTeam', 'division'])
                ->orderBy('date', 'desc')
                ->take(3)
                ->get(),

            // Get next 5 upcoming games (starting from today)
            'upcomingGames' => Game::where('status', '!=', 'completed')
                ->where('date', '>=', now()->startOfDay())
                ->with(['homeTeam', 'awayTeam', 'court', 'timeSlot'])
                ->orderBy('date', 'asc')
                ->take(5)
                ->get(),
        ]);
    }
}
