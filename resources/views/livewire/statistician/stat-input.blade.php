<div class="p-4 bg-zinc-900 rounded-xl shadow-xl space-y-4 border border-zinc-700">

    <h2 class="text-xl font-bold text-red-500 border-b border-zinc-700 pb-2">
        Stat Input: {{ $game->homeTeam->name }} vs {{ $game->awayTeam->name }}
    </h2>

    @php
        // Define colors and hover for the stats
        $statColors = [
            'reb' => 'bg-blue-600 hover:brightness-125',
            'ast' => 'bg-green-600 hover:brightness-125',
            'stl' => 'bg-yellow-600 hover:brightness-125',
            'blk' => 'bg-purple-600 hover:brightness-125',
            'to'  => 'bg-red-600 hover:brightness-125',
            'pf'  => 'bg-gray-600 hover:brightness-125',
        ];
        $statsList = ['reb', 'ast', 'stl', 'blk', 'to', 'pf'];
    @endphp

    {{-- Player Stat Input Grid (Two Columns) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- Home Players --}}
        <div class="space-y-2 p-2 bg-zinc-800 rounded-lg border border-zinc-700">
            <h3 class="text-base font-semibold text-red-400 border-b border-zinc-700 pb-1">{{ $game->homeTeam->name }}</h3>
            @foreach ($game->homeTeam->players as $player)
                <div class="flex items-center justify-between bg-zinc-900 p-1.5 rounded border border-zinc-700">
                    <span class="text-white text-sm font-medium truncate">{{ $player->name }}</span>
                    <div class="flex gap-0.5 ml-2"> {{-- Reduced spacing and gap --}}
                        @foreach ($statsList as $stat)
                            <button wire:click="addStat({{ $player->id }}, '{{ $stat }}')"
                                class="px-1 py-0.5 rounded text-white text-xs font-semibold transition duration-150 {{ $statColors[$stat] }}">
                                {{ strtoupper($stat) }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Away Players --}}
        <div class="space-y-2 p-2 bg-zinc-800 rounded-lg border border-zinc-700">
            <h3 class="text-base font-semibold text-red-400 border-b border-zinc-700 pb-1">{{ $game->awayTeam->name }}</h3>
            @foreach ($game->awayTeam->players as $player)
                <div class="flex items-center justify-between bg-zinc-900 p-1.5 rounded border border-zinc-700">
                    <span class="text-white text-sm font-medium truncate">{{ $player->name }}</span>
                    <div class="flex gap-0.5 ml-2"> {{-- Reduced spacing and gap --}}
                        @foreach ($statsList as $stat)
                            <button wire:click="addStat({{ $player->id }}, '{{ $stat }}')"
                                class="px-1 py-0.5 rounded text-white text-xs font-semibold transition duration-150 {{ $statColors[$stat] }}">
                                {{ strtoupper($stat) }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    ---

    {{-- Box Score Section --}}
    <div class="mt-4 pt-4 border-t border-zinc-700">
        <h2 class="text-xl font-bold text-white mb-3">
            Box Score
        </h2>

        {{-- Box Score Tables (Full Width) --}}
        <div class="col-span-1 md:col-span-2 overflow-x-auto bg-zinc-800/50 rounded-lg border border-zinc-700 p-2">
            @foreach ([$game->homeTeam, $game->awayTeam] as $team)
                <h3 class="text-lg font-semibold text-red-400 mt-4 mb-2">{{ $team->name }}</h3>
                <table class="min-w-full text-xs text-white border-collapse mb-4">
                    <thead class="bg-zinc-700/70">
                        <tr>
                            <th class="px-2 py-1 text-left sticky left-0 bg-zinc-700/70 z-10">Player</th>
                            <th class="px-1 py-1">#</th>
                            <th class="px-1 py-1">MIN</th>
                            <th class="px-1 py-1">FG</th>
                            <th class="px-1 py-1">3PT</th>
                            <th class="px-1 py-1">FT</th>
                            <th class="px-1 py-1">REB</th>
                            <th class="px-1 py-1">AST</th>
                            <th class="px-1 py-1">STL</th>
                            <th class="px-1 py-1">BLK</th>
                            <th class="px-1 py-1">TO</th>
                            <th class="px-1 py-1">PF</th>
                            <th class="px-1 py-1">+/-</th>
                            <th class="px-1 py-1">PTS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($team->players as $player)
                            @php $stats = $player->stats ?? []; @endphp
                            <tr class="border-t border-zinc-700 hover:bg-zinc-700/30 transition duration-100">
                                <td class="px-2 py-1 text-left font-medium sticky left-0 bg-zinc-800/50 hover:bg-zinc-700/30 z-0">{{ $player->name }}</td>
                                <td class="text-center">{{ $player->jersey_number }}</td>
                                <td class="text-center">{{ $stats['min'] ?? 0 }}</td>
                                <td class="text-center">{{ $stats['fg'] ?? '0-0' }}</td>
                                <td class="text-center">{{ $stats['3pt'] ?? '0-0' }}</td>
                                <td class="text-center">{{ $stats['ft'] ?? '0-0' }}</td>
                                <td class="text-center">{{ $stats['reb'] ?? 0 }}</td>
                                <td class="text-center">{{ $stats['ast'] ?? 0 }}</td>
                                <td class="text-center">{{ $stats['stl'] ?? 0 }}</td>
                                <td class="text-center">{{ $stats['blk'] ?? 0 }}</td>
                                <td class="text-center">{{ $stats['to'] ?? 0 }}</td>
                                <td class="text-center">{{ $stats['pf'] ?? 0 }}</td>
                                <td class="text-center">{{ $stats['plus_minus'] ?? 0 }}</td>
                                <td class="text-center font-bold text-red-400">{{ $stats['pts'] ?? 0 }}</td>
                            </tr>
                        @endforeach

                        {{-- Team totals --}}
                        <tr class="border-t-2 border-red-600 font-bold bg-zinc-700/50">
                            <td class="px-2 py-1 text-left sticky left-0 bg-zinc-700/50 z-0">Team Totals</td>
                            <td class="text-center">-</td>
                            <td class="text-center">{{ $team->players->sum(fn($p) => $p->stats['min'] ?? 0) }}</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">{{ $team->players->sum(fn($p) => $p->stats['reb'] ?? 0) }}</td>
                            <td class="text-center">{{ $team->players->sum(fn($p) => $p->stats['ast'] ?? 0) }}</td>
                            <td class="text-center">{{ $team->players->sum(fn($p) => $p->stats['stl'] ?? 0) }}</td>
                            <td class="text-center">{{ $team->players->sum(fn($p) => $p->stats['blk'] ?? 0) }}</td>
                            <td class="text-center">{{ $team->players->sum(fn($p) => $p->stats['to'] ?? 0) }}</td>
                            <td class="text-center">{{ $team->players->sum(fn($p) => $p->stats['pf'] ?? 0) }}</td>
                            <td class="text-center">-</td>
                            <td class="text-center font-extrabold text-red-500">{{ $team->players->sum(fn($p) => $p->stats['pts'] ?? 0) }}</td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
</div>