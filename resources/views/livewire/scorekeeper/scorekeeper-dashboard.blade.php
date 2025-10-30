<div class="p-4 space-y-4">
    <h2 class="text-xl font-bold mb-2">Your Assigned Games</h2>

    <ul class="space-y-2">
        @foreach ($assignedGames as $game)
            <li class="border p-2 rounded flex justify-between items-center">
                <div>
                    {{ $game->homeTeam->name }} vs {{ $game->awayTeam->name }} <br>
                    {{ $game->date->format('Y-m-d H:i') }}
                </div>
                <div>
                    <a href="{{ route('scorekeeper.score-input', $game) }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded">
                        Open Score Input
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
</div>
