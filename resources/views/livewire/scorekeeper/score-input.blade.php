<div class="p-3 bg-zinc-900 rounded-xl shadow-lg border border-zinc-700 max-w-full">

    {{-- Scoreboard - Kept at the top and made prominent --}}
    <div class="mb-3 p-2 flex justify-between items-center bg-zinc-800 rounded-lg border border-red-600 shadow-md">
        <div class="text-center flex-1">
            <h3 class="text-xs font-semibold text-zinc-400 uppercase tracking-widest">{{ $homeTeamName }}</h3>
            <p class="text-3xl font-extrabold text-red-500">{{ $homeScore }}</p>
        </div>
        <div class="text-2xl font-bold text-zinc-500 mx-3">-</div>
        <div class="text-center flex-1">
            <h3 class="text-xs font-semibold text-zinc-400 uppercase tracking-widest">{{ $awayTeamName }}</h3>
            <p class="text-3xl font-extrabold text-red-500">{{ $awayScore }}</p>
        </div>
    </div>

    {{-- Main Content: Two Columns on Medium Screens and Up --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        {{-- Home Team Card (First Column) --}}
        <div class="p-2 bg-zinc-800 rounded-lg border border-zinc-700 space-y-2">
            <h2 class="text-base font-bold text-red-500 border-b border-zinc-700 pb-1 mb-1 uppercase tracking-wide">
                {{ $homeTeamName }} Players
            </h2>

            @foreach ($homePlayers as $player)
                {{-- Player Row: Optimized for horizontal space --}}
                <div wire:key="home-player-{{ $player->id }}"
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-zinc-900 p-1.5 rounded-lg border border-zinc-700 hover:border-red-600 transition duration-150">

                    <span class="text-zinc-100 text-sm font-medium mb-1 sm:mb-0 truncate">
                        #{{ $player->jersey_number ?? '??' }} - {{ $player->name }}
                    </span>

                    {{-- Extremely Compact Button Group --}}
                    <div class="flex flex-wrap justify-end gap-0.5 ml-2">
                        <button wire:click="addEvent({{ $player->id }}, '2pt')"
                            class="px-1.5 py-0.5 bg-red-600 hover:bg-red-700 rounded text-white text-xs font-semibold transition duration-150">2pt</button>
                        <button wire:click="addEvent({{ $player->id }}, '3pt')"
                            class="px-1.5 py-0.5 bg-red-600 hover:bg-red-700 rounded text-white text-xs font-semibold transition duration-150">3pt</button>
                        <button wire:click="addEvent({{ $player->id }}, 'ft')"
                            class="px-1.5 py-0.5 bg-red-600 hover:bg-red-700 rounded text-white text-xs font-semibold transition duration-150">FT</button>
                        <button wire:click="addEvent({{ $player->id }}, 'foul')"
                            class="px-1.5 py-0.5 bg-red-800 hover:bg-red-900 rounded text-white text-xs font-semibold transition duration-150">Foul</button>
                        <button wire:click="addEvent({{ $player->id }}, 'turnover')"
                            class="px-1.5 py-0.5 bg-red-800 hover:bg-red-900 rounded text-white text-xs font-semibold transition duration-150">TO</button>
                        <button wire:click="addEvent({{ $player->id }}, 'steal')"
                            class="px-1.5 py-0.5 bg-red-800 hover:bg-red-900 rounded text-white text-xs font-semibold transition duration-150">Steal</button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Away Team Card (Second Column) --}}
        <div class="p-2 bg-zinc-800 rounded-lg border border-zinc-700 space-y-2">
            <h2 class="text-base font-bold text-red-500 border-b border-zinc-700 pb-1 mb-1 uppercase tracking-wide">
                {{ $awayTeamName }} Players
            </h2>

            @foreach ($awayPlayers as $player)
                {{-- Player Row: Optimized for horizontal space --}}
                <div wire:key="away-player-{{ $player->id }}"
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-zinc-900 p-1.5 rounded-lg border border-zinc-700 hover:border-red-600 transition duration-150">
                    <span class="text-zinc-100 text-sm font-medium mb-1 sm:mb-0 truncate">
                        #{{ $player->jersey_number ?? '??' }} - {{ $player->name }}
                    </span>

                    {{-- Extremely Compact Button Group --}}
                    <div class="flex flex-wrap justify-end gap-0.5 ml-2">
                        <button wire:click="addEvent({{ $player->id }}, '2pt')"
                            class="px-1.5 py-0.5 bg-red-600 hover:bg-red-700 rounded text-white text-xs font-semibold transition duration-150">2pt</button>
                        <button wire:click="addEvent({{ $player->id }}, '3pt')"
                            class="px-1.5 py-0.5 bg-red-600 hover:bg-red-700 rounded text-white text-xs font-semibold transition duration-150">3pt</button>
                        <button wire:click="addEvent({{ $player->id }}, 'ft')"
                            class="px-1.5 py-0.5 bg-red-600 hover:bg-red-700 rounded text-white text-xs font-semibold transition duration-150">FT</button>
                        <button wire:click="addEvent({{ $player->id }}, 'foul')"
                            class="px-1.5 py-0.5 bg-red-800 hover:bg-red-900 rounded text-white text-xs font-semibold transition duration-150">Foul</button>
                        <button wire:click="addEvent({{ $player->id }}, 'turnover')"
                            class="px-1.5 py-0.5 bg-red-800 hover:bg-red-900 rounded text-white text-xs font-semibold transition duration-150">TO</button>
                        <button wire:click="addEvent({{ $player->id }}, 'steal')"
                            class="px-1.5 py-0.5 bg-red-800 hover:bg-red-900 rounded text-white text-xs font-semibold transition duration-150">Steal</button>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
