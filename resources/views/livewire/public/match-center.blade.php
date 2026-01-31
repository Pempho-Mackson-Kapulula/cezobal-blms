<div class="min-h-screen bg-[#050505] text-zinc-300 font-sans antialiased pb-20 selection:bg-red-600 selection:text-white"
    @if ($game->status === 'live') wire:poll.10s @endif>

    {{-- 1. BROADCAST HEADER --}}
   <header class="sticky top-0 z-40 bg-black/90 backdrop-blur-xl border-b border-white/5 shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 h-14 flex justify-between items-center">
            <div class="flex items-center gap-6">
                <div class="flex flex-col">
                    <span class="text-[10px] font-black tracking-[.2em] uppercase text-red-600 leading-none">League</span>
                    <span class="text-xs font-bold text-white uppercase tracking-tighter">{{ $game->division->name }}</span>
                </div>
                <div class="h-8 w-px bg-white/10"></div>
                <div class="hidden md:flex flex-col">
                    <span class="text-[10px] font-black tracking-[.2em] uppercase text-zinc-500 leading-none">Venue</span>
                    <span class="text-xs font-medium text-zinc-400 uppercase leading-tight">{{ $game->court->name ?? 'Main Arena' }}</span>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="#full-stats" class="text-[10px] font-black uppercase bg-zinc-800 hover:bg-zinc-700 text-white px-4 py-2 rounded transition-all tracking-widest border border-white/5">
                    Stats
                </a>
                <div class="px-3 py-1 bg-red-600 text-white text-[10px] font-black uppercase tracking-widest rounded animate-pulse">
                    Live
                </div>
            </div>
        </div>
    </header>

    {{-- 2. THE SCOREBOARD (Hero) --}}
    <section class="relative pt-12 pb-24 overflow-hidden">
        {{-- High-End Ambient Light --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[500px] opacity-30 pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-b from-red-600/20 via-transparent to-transparent blur-[120px]"></div>
            <div class="absolute top-0 left-1/4 w-px h-full bg-gradient-to-b from-white/10 to-transparent"></div>
            <div class="absolute top-0 right-1/4 w-px h-full bg-gradient-to-b from-white/10 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                
                {{-- Home --}}
                <div class="flex-1 space-y-2">
                    <div class="text-[10px] font-black text-zinc-500 uppercase tracking-[.4em]">Home</div>
                    <h2 class="text-4xl md:text-6xl font-black text-white italic uppercase tracking-tighter leading-none">
                        {{ $game->homeTeam->name }}
                    </h2>
                </div>

                {{-- Center Score --}}
                <div class="flex flex-col items-center">
                    <div class="flex items-center gap-6 md:gap-12">
                        <span class="text-7xl md:text-9xl font-black text-white italic tracking-tighter drop-shadow-[0_10px_10px_rgba(0,0,0,0.5)]">
                            {{ $game->score_home }}
                        </span>
                        <div class="flex flex-col items-center gap-2">
                            <span class="text-xl md:text-2xl font-black text-zinc-700 italic opacity-50 text-stroke">VS</span>
                            <div class="px-4 py-1 bg-zinc-900 border border-white/10 rounded text-[10px] font-black text-zinc-400 uppercase tracking-widest">
                                {{ $game->current_period > 4 ? 'OT' : 'Q' . $game->current_period }}
                            </div>
                        </div>
                        <span class="text-7xl md:text-9xl font-black text-red-600 italic tracking-tighter drop-shadow-[0_10px_10px_rgba(255,0,0,0.2)]">
                            {{ $game->score_away }}
                        </span>
                    </div>
                </div>

                {{-- Away --}}
                <div class="flex-1 space-y-2">
                    <div class="text-[10px] font-black text-zinc-500 uppercase tracking-[.4em]">Away</div>
                    <h2 class="text-4xl md:text-6xl font-black text-white italic uppercase tracking-tighter leading-none">
                        {{ $game->awayTeam->name }}
                    </h2>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. ANALYTICS GRID --}}
    <main class="max-w-7xl mx-auto px-4 -mt-12 relative z-30">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- Scoring Breakdown --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-[#0a0a0a] border border-white/5 rounded-xl shadow-2xl overflow-hidden">
                    <div class="p-4 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-zinc-400">Scoring Summary</h3>
                    </div>
                    <table class="w-full">
                        <thead>
                            <tr class="text-[9px] font-black uppercase text-zinc-600 border-b border-white/5">
                                <th class="p-4 text-left">Squad</th>
                                @for ($i = 1; $i <= 4; $i++)
                                    <th class="p-4">Q{{ $i }}</th>
                                @endfor
                                <th class="p-4 text-white bg-white/5">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach ([$game->homeTeam, $game->awayTeam] as $team)
                                <tr class="group hover:bg-white/[0.02] transition-colors">
                                    <td class="p-4 text-xs font-black uppercase italic text-white">{{ $team->name }}</td>
                                    @for ($i = 1; $i <= 4; $i++)
                                        <td class="p-4 text-center text-xs font-bold text-zinc-400">
                                            {{ $this->periodScores->get($team->id)?->where('period', $i)->first()->total ?? 0 }}
                                        </td>
                                    @endfor
                                    <td class="p-4 text-center text-sm font-black bg-white/5 text-red-500 italic">
                                        {{ $team->id === $game->home_team_id ? $game->score_home : $game->score_away }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- BOX SCORE SECTION --}}
                <div id="full-stats" class="bg-[#0a0a0a] border border-white/5 rounded-xl shadow-2xl overflow-hidden">
                    <div class="p-4 border-b border-white/5 bg-white/[0.02]">
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-white">Full Box Score</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-px bg-white/5">
                        @foreach ([['team' => $game->homeTeam, 'players' => $this->homePlayers], ['team' => $game->awayTeam, 'players' => $this->awayPlayers]] as $teamData)
                            <div class="bg-[#0a0a0a] p-4">
                                <h4 class="text-[10px] font-black uppercase text-red-600 mb-4 tracking-tighter">{{ $teamData['team']->name }} Stats</h4>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-[10px]">
                                        <thead>
                                            <tr class="text-zinc-600 uppercase font-black border-b border-white/5">
                                                <th class="text-left pb-2 w-32">Player</th>
                                                <th class="pb-2">PTS</th>
                                                <th class="pb-2">2PM</th>
                                                <th class="pb-2">3PM</th>
                                                <th class="pb-2">FTM</th>
                                                <th class="pb-2">FOULS</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-white/5">
                                            @foreach ($teamData['players'] as $player)
                                                @php
                                                    $stats = $this->playerStats[$player->id] ?? collect();
                                                    $two = $stats->where('event_type', '2pt')->first()->count ?? 0;
                                                    $three = $stats->where('event_type', '3pt')->first()->count ?? 0;
                                                    $ft = $stats->where('event_type', 'ft')->first()->count ?? 0;
                                                    $pts = ($two * 2) + ($three * 3) + $ft;
                                                    $fouls = $stats->where('event_type', 'pf')->first()->count ?? 0;
                                                @endphp
                                                <tr class="hover:bg-white/[0.02]">
                                                    <td class="py-2 font-bold text-zinc-300">
                                                        <span class="text-zinc-600 mr-2">#{{ $player->number }}</span>{{ $player->name }}
                                                    </td>
                                                    <td class="text-center font-black text-white text-xs">{{ $pts }}</td>
                                                    <td class="text-center text-zinc-500">{{ $two }}</td>
                                                    <td class="text-center text-zinc-500">{{ $three }}</td>
                                                    <td class="text-center text-zinc-500">{{ $ft }}</td>
                                                    <td class="text-center {{ $fouls >= 4 ? 'text-red-500 font-black' : 'text-zinc-500' }}">{{ $fouls }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Sidebar: Live Feed --}}
            <aside class="lg:col-span-4">
                <div class="bg-[#0a0a0a] border border-white/5 rounded-xl overflow-hidden sticky top-20">
                    <div class="p-4 border-b border-white/5 bg-red-600 flex justify-between items-center">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-white">Live Play-by-Play</h4>
                        <span class="w-2 h-2 bg-white rounded-full animate-ping"></span>
                    </div>
                    <div class="h-[600px] overflow-y-auto p-4 space-y-4 scrollbar-hide">
                        @forelse($this->recentEvents as $event)
                            <div class="flex gap-4 relative group">
                                <span class="text-[9px] font-black text-zinc-700 w-8 pt-1">P{{ $event->period }}</span>
                                <div class="flex-grow pb-4 border-b border-white/5">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-[10px] font-black text-white italic uppercase">{{ $event->player->name ?? 'Team' }}</span>
                                        @if($event->event_type == '3pt')
                                            <span class="text-[7px] bg-red-600 text-white px-1 font-black rounded">SPLASH</span>
                                        @endif
                                    </div>
                                    <p class="text-[11px] text-zinc-500 font-medium tracking-tight">
                                        {{ str_replace('_', ' ', $event->event_type) }} recorded for {{ $event->team->name }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-20">
                                <p class="text-[10px] text-zinc-600 font-black uppercase tracking-[.3em]">Awaiting Tip-off</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </main>
</div>