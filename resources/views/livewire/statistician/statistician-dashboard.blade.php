<div class="p-6 bg-zinc-900 rounded-xl shadow-2xl space-y-6 border border-zinc-700">
    <header class="mb-4 border-b-4 border-red-600 pb-3">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-red-500 tracking-tight">
            Statisticians Dashboard
        </h1>
        <p class="text-lg text-zinc-400 mt-1">
            Manage players statistitics in real-time during games.
        </p>
    </header>

    @if ($assignedGames->isEmpty())
        <div class="text-center text-zinc-500 py-6 bg-zinc-800 rounded-lg">
            You currently have no assigned games.
        </div>
    @else
        <ul class="space-y-4">
            @foreach ($assignedGames as $game)
                <li
                    class="p-4 rounded-lg flex flex-col md:flex-row justify-between items-start md:items-center 
                           bg-zinc-800 border border-zinc-700 shadow-lg 
                           transition duration-200 ease-in-out hover:bg-zinc-700">

                    <div class="mb-3 md:mb-0">
                        <p class="text-xl font-bold text-zinc-100">
                            <span class="text-red-400">{{ $game->homeTeam->name }}</span> vs <span
                                class="text-red-400">{{ $game->awayTeam->name }}</span>
                        </p>
                        <p class="text-sm text-zinc-400 mt-1">
                            Time: <span class="font-medium text-zinc-300">{{ $game->date->format('M d, Y') }} at
                                {{ $game->date->format('H:i') }}</span>
                        </p>
                    </div>

                    <div>
                        <a href="{{ route('statistician.stat-input', $game) }}"
                            class="inline-block px-5 py-2 text-sm font-semibold rounded-full shadow-md
                                  bg-red-600 hover:bg-red-700 text-white
                                  focus:outline-none focus:ring-4 focus:ring-red-500/50
                                  transition duration-150 ease-in-out transform hover:scale-[1.02]">
                            ➡️ Open Stat Input
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
