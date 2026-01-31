<div class="bg-black min-h-screen text-zinc-100 font-sans flex overflow-hidden">
    @php
        $statColors = [
            'reb' => 'bg-blue-600/10 text-blue-400 border-blue-500/20 hover:bg-blue-600 hover:text-white',
            'ast' => 'bg-emerald-600/10 text-emerald-400 border-emerald-500/20 hover:bg-emerald-600 hover:text-white',
            'stl' => 'bg-amber-600/10 text-amber-400 border-amber-500/20 hover:bg-amber-600 hover:text-white',
            'blk' => 'bg-purple-600/10 text-purple-400 border-purple-500/20 hover:bg-purple-600 hover:text-white',
            'to'  => 'bg-rose-600/10 text-rose-400 border-rose-500/20 hover:bg-rose-600 hover:text-white',
            'pf'  => 'bg-zinc-600/10 text-zinc-400 border-zinc-500/20 hover:bg-zinc-600 hover:text-white',
        ];
    @endphp

    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-zinc-950">
        {{-- HUD: Score & Period --}}
        <div class="bg-zinc-900 border-b border-zinc-800 px-6 py-2 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-4">
                <div class="flex items-center bg-black rounded-lg border border-zinc-700 px-4 py-1">
                    <span class="text-2xl font-mono font-black text-white tracking-tighter">
                        {{ $game->score_home }} <span class="text-zinc-600 px-1">-</span> {{ $game->score_away }}
                    </span>
                    <span class="ml-4 text-[11px] font-black uppercase text-orange-500">{{ $this->periodLabel }}</span>
                </div>
                <button wire:click="undoLastAction" @disabled(!$lastActionId || $isLocked)
                    @class([
                        'text-[10px] font-black uppercase px-4 py-2 rounded border transition-all',
                        $lastActionId && !$isLocked ? 'bg-amber-600/10 border-amber-600/50 text-amber-500 hover:bg-amber-600' : 'opacity-20 border-zinc-700 text-zinc-500',
                    ])>Undo</button>
            </div>

            <div class="flex gap-2">
                @if(!$isLocked)
                    <button wire:click="changePeriod" class="bg-zinc-800 px-4 py-2 rounded font-black text-[10px] hover:bg-white hover:text-black">NEXT PERIOD</button>
                    <button wire:confirm="Finalize game stats?" wire:click="finalizeGame" class="bg-red-600/20 border border-red-600 text-red-500 px-4 py-2 rounded font-black text-[10px] hover:bg-red-600 hover:text-white">END GAME</button>
                @else
                    <span class="text-[10px] font-black uppercase text-zinc-500">Game Finalized</span>
                @endif
            </div>
        </div>

        {{-- THE FLOOR: 2-Column Team Layout --}}
        <div class="flex-1 flex divide-x divide-zinc-800 overflow-hidden">
            @foreach (['home', 'away'] as $side)
                @php
                    $team = $side === 'home' ? $game->homeTeam : $game->awayTeam;
                    $players = $side === 'home' ? $this->homePlayers : $this->awayPlayers;
                    $accentColor = $side === 'home' ? 'text-red-500' : 'text-blue-500';
                @endphp

                <div class="flex-1 flex flex-col min-w-0">
                    {{-- TOP: ACTIVE LINEUP (STAT INPUT) --}}
                    <div class="p-2 border-b border-zinc-800 bg-zinc-950/50 flex-none">
                        <div class="flex justify-between items-center mb-2 px-1">
                            <h3 class="text-[11px] font-black uppercase tracking-widest {{ $accentColor }}">{{ $team->name }} (On Court)</h3>
                            <span class="text-[9px] font-bold text-zinc-600 uppercase">Team Fouls: {{ $this->teamFouls[$team->id] ?? 0 }}</span>
                        </div>

                        <div class="space-y-1.5">
                            @foreach ($players->whereIn('id', $onCourtIds) as $player)
                                @php
                                    $pStats = $this->stats[$player->id] ?? collect();
                                    $fouls = $pStats->where('event_type', 'pf')->first()->count ?? 0;
                                    $isDQ = $fouls >= self::MAX_PLAYER_FOULS;
                                @endphp

                                <div wire:key="active-{{ $player->id }}" @class([
                                    'grid grid-cols-12 gap-1 h-14 bg-zinc-900 border rounded-lg p-1 transition-all',
                                    'border-zinc-800' => !$isDQ,
                                    'border-red-900 bg-red-950/20' => $isDQ,
                                    'border-orange-500 ring-1 ring-orange-500' => $swappingPlayerId == $player->id,
                                ])>
                                    {{-- Jersey & Swap --}}
                                    <div class="col-span-1 flex flex-col justify-center items-center border-r border-zinc-800/50">
                                        @if($isDQ) <span class="text-[8px] font-black text-red-500 uppercase leading-none">OUT</span> @endif
                                        <span class="text-sm font-black text-white leading-none">#{{ $player->jersey_number }}</span>
                                        <button wire:click="initiateSwap({{ $player->id }})" class="text-[7px] font-black text-zinc-500 hover:text-orange-500 mt-1 uppercase">Swap</button>
                                    </div>

                                    {{-- Shot Buttons --}}
                                    <div class="col-span-4 grid grid-cols-3 gap-0.5 border-r border-zinc-800/50 px-0.5">
                                        @foreach (['2fg' => '2P', '3pt' => '3P', 'ft' => 'FT'] as $type => $label)
                                            <div class="flex flex-col gap-0.5">
                                                <button wire:click="addShot({{ $player->id }}, '{{ $type }}', true)" @disabled($isDQ || $isLocked)
                                                    class="flex-1 bg-emerald-500/10 hover:bg-emerald-500 text-emerald-500 hover:text-black rounded text-[10px] font-black border border-emerald-500/20">{{ $label }}</button>
                                                <button wire:click="addShot({{ $player->id }}, '{{ $type }}', false)" @disabled($isDQ || $isLocked)
                                                    class="h-3 bg-zinc-800 hover:bg-red-600 rounded text-[7px] font-black text-zinc-500 hover:text-white uppercase">X</button>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Rapid Stats (REB, AST, STL, TO, PF) --}}
                                    <div class="col-span-6 grid grid-cols-5 gap-0.5 px-0.5">
                                        @foreach (['reb', 'ast', 'stl', 'to', 'pf'] as $stat)
                                            @php $count = $pStats->where('event_type', $stat)->first()->count ?? 0; @endphp
                                            <button wire:click="addStat({{ $player->id }}, '{{ $stat }}')" @disabled($isLocked || ($isDQ && $stat !== 'pf'))
                                                class="rounded border flex flex-col items-center justify-center transition-all active:scale-95 {{ $statColors[$stat] }}">
                                                <span class="text-[7px] font-black uppercase opacity-60 leading-none mb-0.5">{{ $stat }}</span>
                                                <span class="text-sm font-mono font-black leading-none">{{ $count }}</span>
                                            </button>
                                        @endforeach
                                    </div>

                                    {{-- Points display --}}
                                    <div class="col-span-1 bg-black/40 rounded flex flex-col items-center justify-center border border-zinc-800">
                                        <span class="text-[7px] font-black text-zinc-600 uppercase">P</span>
                                        <span class="text-sm font-black font-mono">
                                            {{ ($pStats->where('event_type', '2pt')->first()->count ?? 0) * 2 + ($pStats->where('event_type', '3pt')->first()->count ?? 0) * 3 + ($pStats->where('event_type', 'ft')->first()->count ?? 0) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- BOTTOM: FULL BOX SCORE TABLE --}}
                    <div class="flex-1 overflow-y-auto bg-zinc-900/30 p-2">
                        <table class="w-full text-left text-[9px]">
                            <thead class="sticky top-0 bg-zinc-950 text-zinc-500 border-b border-zinc-800">
                                <tr>
                                    <th class="p-1 font-black">PLAYER</th>
                                    <th class="p-1 font-black">PTS</th>
                                    <th class="p-1 font-black">REB</th>
                                    <th class="p-1 font-black">AST</th>
                                    <th class="p-1 font-black">STL</th>
                                    <th class="p-1 font-black">TO</th>
                                    <th class="p-1 font-black">PF</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-800/50">
                                @foreach ($players as $player)
                                    @php $pStats = $this->stats[$player->id] ?? collect(); @endphp
                                    <tr @class(['hover:bg-zinc-800/50', 'bg-emerald-500/5' => in_array($player->id, $onCourtIds)])>
                                        <td class="p-1 whitespace-nowrap">
                                            <span class="font-bold">#{{ $player->jersey_number }}</span> 
                                            <span class="uppercase text-zinc-400">{{ substr($player->last_name, 0, 8) }}</span>
                                        </td>
                                        <td class="p-1 font-mono font-black text-white">
                                            {{ ($pStats->where('event_type', '2pt')->first()->count ?? 0) * 2 + ($pStats->where('event_type', '3pt')->first()->count ?? 0) * 3 + ($pStats->where('event_type', 'ft')->first()->count ?? 0) }}
                                        </td>
                                        <td class="p-1 text-zinc-400">{{ $pStats->where('event_type', 'reb')->first()->count ?? 0 }}</td>
                                        <td class="p-1 text-zinc-400">{{ $pStats->where('event_type', 'ast')->first()->count ?? 0 }}</td>
                                        <td class="p-1 text-zinc-400">{{ $pStats->where('event_type', 'stl')->first()->count ?? 0 }}</td>
                                        <td class="p-1 text-rose-400/70">{{ $pStats->where('event_type', 'to')->first()->count ?? 0 }}</td>
                                        <td @class(['p-1 font-bold', 'text-red-500' => ($pStats->where('event_type', 'pf')->first()->count ?? 0) >= 5])>
                                            {{ $pStats->where('event_type', 'pf')->first()->count ?? 0 }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    {{-- SUB MODAL --}}
    @if($swappingPlayerId)
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-xl max-w-md w-full">
                <h2 class="text-xl font-black mb-4 uppercase">Select Sub For #{{ \App\Models\Player::find($swappingPlayerId)->jersey_number }}</h2>
                <div class="grid grid-cols-2 gap-2">
                    @php
                        $subTeamId = \App\Models\Player::find($swappingPlayerId)->team_id;
                        $bench = ($subTeamId == $game->home_team_id ? $this->homePlayers : $this->awayPlayers)->whereNotIn('id', $onCourtIds);
                    @endphp
                    @foreach($bench as $sub)
                        <button wire:click="confirmSwap({{ $sub->id }})" class="p-3 bg-zinc-800 hover:bg-orange-600 rounded text-left transition-colors">
                            <span class="block text-[10px] font-bold text-zinc-400 uppercase">#{{ $sub->jersey_number }}</span>
                            <span class="font-black uppercase">{{ $sub->last_name }}</span>
                        </button>
                    @endforeach
                </div>
                <button wire:click="cancelSwap" class="mt-6 w-full py-2 text-zinc-500 font-bold uppercase text-xs">Cancel</button>
            </div>
        </div>
    @endif
</div>
