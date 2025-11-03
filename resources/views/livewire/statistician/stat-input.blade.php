<div class="space-y-8">

    {{-- Live Game Scoreboard --}}
    <div class="mt-6">
        <h2 class="text-xl font-bold text-red-500 mb-2 border-b border-zinc-700 pb-1.5">Live Game Status</h2>
        <div class="p-4 bg-zinc-900 rounded-xl shadow-xl text-center border border-red-600/50">
            {{-- Score Row --}}
            <div class="flex justify-between items-center text-4xl sm:text-6xl font-extrabold my-4">
                {{-- Home Team Score --}}
                <div class="flex-1 text-center">
                    <p class="text-xl font-semibold text-zinc-300 uppercase tracking-wider mb-1">
                        {{ $game->homeTeam->name }}</p>
                    <span class="text-red-500 text-5xl sm:text-6xl">{{ $homeScore }}</span>
                </div>
                {{-- VS Separator --}}
                <div class="flex-shrink-0 mx-4">
                    <span class="text-red-600 text-2xl font-light">VS</span>
                </div>
                {{-- Away Team Score --}}
                <div class="flex-1 text-center">
                    <p class="text-xl font-semibold text-zinc-300 uppercase tracking-wider mb-1">
                        {{ $game->awayTeam->name }}</p>
                    <span class="text-red-500 text-5xl sm:text-6xl">{{ $awayScore }}</span>
                </div>
            </div>

            {{-- Period and Live Status --}}
            <div class="flex justify-center items-center gap-3 mt-2">
                <div class="text-zinc-400 text-base font-medium">
                    Period: <span class="text-white font-bold">{{ $period }}</span>
                </div>
                <span
                    class="px-3 py-0.5 rounded-full bg-red-600 text-white text-xs font-bold uppercase tracking-wider shadow-md shadow-red-900/50">
                    LIVE
                </span>
            </div>

            {{-- Last Updated --}}
            <div class="text-zinc-500 text-xs mt-2">
                Last Updated: {{ now()->format('H:i:s') }}
            </div>
        </div>


    </div>

    @php
        $statColors = [
            'reb' => 'bg-blue-700 hover:bg-blue-600',
            'ast' => 'bg-green-700 hover:bg-green-600',
            'stl' => 'bg-yellow-700 hover:bg-yellow-600',
            'blk' => 'bg-purple-700 hover:bg-purple-600',
            'to' => 'bg-red-700 hover:bg-red-600',
            'pf' => 'bg-gray-700 hover:bg-gray-600',
        ];
        $statsList = ['reb', 'ast', 'stl', 'blk', 'to', 'pf'];
        $shotTypes = ['2fg' => '2FG', '3pt' => '3PT', 'ft' => 'FT'];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

        {{-- Home Players --}}
        <div class="space-y-1 p-1.5 bg-zinc-800/80 rounded-xl border border-red-700/50 shadow-inner">
            <h3 class="text-base font-bold text-red-400 border-b border-red-700 pb-1 uppercase tracking-wide">
                🏀 {{ $game->homeTeam->name }}
            </h3>

            @foreach ($game->homeTeam->players as $player)
                {{-- Reduced card padding and gap, smaller font size --}}
                <div wire:key="home-{{ $player->id }}"
                    class="flex flex-col gap-0.5 bg-zinc-900 p-1 rounded-md border border-zinc-700/80 text-xs shadow-sm">
                    {{-- Reduced padding and removed bottom border --}}
                    <div class="flex justify-between items-center pb-0">
                        <span class="font-bold truncate text-red-300">#{{ $player->jersey_number ?? '?' }} -
                            {{ $player->name }}</span>

                    </div>

                    {{-- Combined Button Section (Shots and Other Stats in one tight row, gap-0.5 for compactness) --}}
                    <div class="flex flex-wrap gap-0.5 pt-0.5">


                        @foreach ($shotTypes as $type => $label)
                            <button wire:click="addShot({{ $player->id }}, '{{ $type }}', true)"
                                class="px-0.5 py-0.5 rounded text-xs font-bold text-white 
                            {{ $type === 'ft' ? 'bg-orange-600 hover:bg-orange-500' : 'bg-emerald-600 hover:bg-emerald-500' }}
                            {{ $isLocked ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $isLocked ? 'disabled' : '' }}>{{ $label }} ✅
                            </button>
                            <button wire:click="addShot({{ $player->id }}, '{{ $type }}', false)"
                                class="px-0.5 py-0.5 rounded text-xs font-bold text-white bg-red-800 hover:bg-red-700
                            {{ $isLocked ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $isLocked ? 'disabled' : '' }}>{{ $label }} ❌
                            </button>
                        @endforeach

                        {{-- Other Stat Buttons (Moved up and integrated, reduced padding) --}}
                        @foreach ($statsList as $stat)
                            <button wire:click="addStat({{ $player->id }}, '{{ $stat }}')"
                                class="px-0.5 py-0.5 rounded text-xs font-semibold text-white
                            {{ $statColors[$stat] ?? 'bg-zinc-600 hover:bg-zinc-500' }}
                            {{ $isLocked ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $isLocked ? 'disabled' : '' }}>{{ strtoupper($stat) }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Away Players --}}
        <div class="space-y-1 p-1.5 bg-zinc-800/80 rounded-xl border border-red-700/50 shadow-inner">
            <h3 class="text-base font-bold text-red-400 border-b border-zinc-700 pb-1 uppercase tracking-wide">
                🏀 {{ $game->awayTeam->name }}
            </h3>

            @foreach ($game->awayTeam->players as $player)
                {{-- Reduced card padding and gap, smaller font size --}}
                <div wire:key="away-{{ $player->id }}"
                    class="flex flex-col gap-0.5 bg-zinc-900 p-1 rounded-md border border-zinc-700/80 text-xs shadow-sm">
                    {{-- Reduced padding and removed bottom border --}}
                    <div class="flex justify-between items-center pb-0">
                        <span class="font-bold truncate text-red-300">#{{ $player->jersey_number ?? '?' }} -
                            {{ $player->name }}</span>

                    </div>

                    {{-- Combined Button Section (Shots and Other Stats in one tight row, gap-0.5 for compactness) --}}
                    <div class="flex flex-wrap gap-0.5 pt-0.5">

                        {{-- Shot Buttons (Reduced padding, removed flex-1) --}}
                        @foreach ($shotTypes as $type => $label)
                            <button wire:click="addShot({{ $player->id }}, '{{ $type }}', true)"
                                class="px-0.5 py-0.5 rounded text-xs font-bold text-white
                            {{ $type === 'ft' ? 'bg-orange-600 hover:bg-orange-500' : 'bg-emerald-600 hover:bg-emerald-500' }}
                            {{ $isLocked ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $isLocked ? 'disabled' : '' }}>{{ $label }} ✅
                            </button>
                            <button wire:click="addShot({{ $player->id }}, '{{ $type }}', false)"
                                class="px-0.5 py-0.5 rounded text-xs font-bold text-white bg-red-800 hover:bg-red-700
                            {{ $isLocked ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $isLocked ? 'disabled' : '' }}>{{ $label }} ❌
                            </button>
                        @endforeach

                        {{-- Other Stat Buttons (Moved up and integrated, reduced padding) --}}
                        @foreach ($statsList as $stat)
                            <button wire:click="addStat({{ $player->id }}, '{{ $stat }}')"
                                class="px-0.5 py-0.5 rounded text-xs font-semibold text-white
                            {{ $statColors[$stat] ?? 'bg-zinc-600 hover:bg-zinc-500' }}
                            {{ $isLocked ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $isLocked ? 'disabled' : '' }}>{{ strtoupper($stat) }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>


    </div>

    {{-- Home Team Stats Table --}}
    <table class="min-w-full text-xs text-zinc-100 border-collapse table-auto mt-4">
        <thead class="bg-zinc-700/80 text-zinc-300 uppercase tracking-wider font-semibold border-b-2 border-red-600">
            <tr>
                <th class="px-2 py-1 text-left sticky left-0 bg-zinc-700/90 z-10 rounded-tl-lg">Player</th>
                <th class="px-1 py-1 text-center">2FG</th>
                <th class="px-1 py-1 text-center">3PT</th>
                <th class="px-1 py-1 text-center">FG</th>
                <th class="px-1 py-1 text-center">FT</th>
                <th class="px-1 py-1 text-center">REB</th>
                <th class="px-1 py-1 text-center">AST</th>
                <th class="px-1 py-1 text-center">STL</th>
                <th class="px-1 py-1 text-center">BLK</th>
                <th class="px-1 py-1 text-center">TO</th>
                <th class="px-1 py-1 text-center">PF</th>
                <th class="px-2 py-1 text-center text-red-400">PTS</th>
            </tr>
        </thead>
        <tbody class="text-zinc-200">
            @foreach ($game->homeTeam->players as $player)
                @php $s = $homePlayerStats[$player->id]; @endphp
                <tr class="border-b border-zinc-700 odd:bg-zinc-800/20 even:bg-zinc-800/40 hover:bg-zinc-700/50">
                    <td class="px-2 py-1 text-left font-medium sticky left-0 bg-inherit z-0">{{ $player->name }}</td>
                    <td class="px-1 py-1 text-center text-red-200">{{ $s['2fg_made'] }}-{{ $s['2fg_attempt'] }}</td>
                    <td class="px-1 py-1 text-center text-red-200">{{ $s['3pt_made'] }}-{{ $s['3pt_attempt'] }}</td>
                    <td class="px-1 py-1 text-center text-red-200">{{ $s['fg_made'] }}-{{ $s['fg_attempt'] }}</td>
                    <td class="px-1 py-1 text-center text-red-200">{{ $s['ft_made'] }}-{{ $s['ft_attempt'] }}</td>
                    <td class="px-1 py-1 text-center">{{ $s['reb'] }}</td>
                    <td class="px-1 py-1 text-center">{{ $s['ast'] }}</td>
                    <td class="px-1 py-1 text-center">{{ $s['stl'] }}</td>
                    <td class="px-1 py-1 text-center">{{ $s['blk'] }}</td>
                    <td class="px-1 py-1 text-center text-yellow-400">{{ $s['to'] }}</td>
                    <td class="px-1 py-1 text-center text-yellow-400">{{ $s['pf'] }}</td>
                    <td class="px-2 py-1 text-center font-extrabold text-red-500">{{ $s['pts'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="bg-zinc-700/70 border-t-2 border-red-500 font-extrabold text-sm text-white">
            <tr>
                <td class="px-2 py-1 text-left sticky left-0 bg-inherit z-0">TOTALS</td>
                @foreach (['2fg', '3pt', 'fg', 'ft', 'reb', 'ast', 'stl', 'blk', 'to', 'pf', 'pts'] as $key)
                    <td class="px-1 py-1 text-center">{{ $teamTotals['homeTeam'][$key] ?? 0 }}</td>
                @endforeach
            </tr>
        </tfoot>
    </table>

    {{-- Away Team Stats Table --}}
    <table class="min-w-full text-xs text-zinc-100 border-collapse table-auto mt-8">
        <thead class="bg-zinc-700/80 text-zinc-300 uppercase tracking-wider font-semibold border-b-2 border-red-600">
            <tr>
                <th class="px-2 py-1 text-left sticky left-0 bg-zinc-700/90 z-10 rounded-tl-lg">Player</th>
                <th class="px-1 py-1 text-center">2FG</th>
                <th class="px-1 py-1 text-center">3PT</th>
                <th class="px-1 py-1 text-center">FG</th>
                <th class="px-1 py-1 text-center">FT</th>
                <th class="px-1 py-1 text-center">REB</th>
                <th class="px-1 py-1 text-center">AST</th>
                <th class="px-1 py-1 text-center">STL</th>
                <th class="px-1 py-1 text-center">BLK</th>
                <th class="px-1 py-1 text-center">TO</th>
                <th class="px-1 py-1 text-center">PF</th>
                <th class="px-2 py-1 text-center text-red-400">PTS</th>
            </tr>
        </thead>
        <tbody class="text-zinc-200">
            @foreach ($game->awayTeam->players as $player)
                @php $s = $awayPlayerStats[$player->id]; @endphp
                <tr class="border-b border-zinc-700 odd:bg-zinc-800/20 even:bg-zinc-800/40 hover:bg-zinc-700/50">
                    <td class="px-2 py-1 text-left font-medium sticky left-0 bg-inherit z-0">{{ $player->name }}</td>
                    <td class="px-1 py-1 text-center text-red-200">{{ $s['2fg_made'] }}-{{ $s['2fg_attempt'] }}</td>
                    <td class="px-1 py-1 text-center text-red-200">{{ $s['3pt_made'] }}-{{ $s['3pt_attempt'] }}</td>
                    <td class="px-1 py-1 text-center text-red-200">{{ $s['fg_made'] }}-{{ $s['fg_attempt'] }}</td>
                    <td class="px-1 py-1 text-center text-red-200">{{ $s['ft_made'] }}-{{ $s['ft_attempt'] }}</td>
                    <td class="px-1 py-1 text-center">{{ $s['reb'] }}</td>
                    <td class="px-1 py-1 text-center">{{ $s['ast'] }}</td>
                    <td class="px-1 py-1 text-center">{{ $s['stl'] }}</td>
                    <td class="px-1 py-1 text-center">{{ $s['blk'] }}</td>
                    <td class="px-1 py-1 text-center text-yellow-400">{{ $s['to'] }}</td>
                    <td class="px-1 py-1 text-center text-yellow-400">{{ $s['pf'] }}</td>
                    <td class="px-2 py-1 text-center font-extrabold text-red-500">{{ $s['pts'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="bg-zinc-700/70 border-t-2 border-red-500 font-extrabold text-sm text-white">
            <tr>
                <td class="px-2 py-1 text-left sticky left-0 bg-inherit z-0">TOTALS</td>
                @foreach (['2fg', '3pt', 'fg', 'ft', 'reb', 'ast', 'stl', 'blk', 'to', 'pf', 'pts'] as $key)
                    <td class="px-1 py-1 text-center">{{ $teamTotals['awayTeam'][$key] ?? 0 }}</td>
                @endforeach
            </tr>
        </tfoot>
    </table>

</div>
