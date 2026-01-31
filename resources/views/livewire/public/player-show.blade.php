<div class="space-y-10">
    {{-- 1. HERO SECTION --}}
    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center gap-8">
        {{-- Jersey Watermark --}}
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] select-none text-[15rem] font-black italic">
            #{{ $player->jersey_number ?? '00' }}
        </div>

        {{-- Avatar/Photo Placeholder --}}
        <div class="w-40 h-40 bg-red-600 rounded-2xl flex items-center justify-center text-7xl font-black text-white shadow-xl relative z-10 shrink-0">
            {{ substr($player->name, 0, 1) }}
        </div>

        <div class="text-center md:text-left z-10 flex-1">
            <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
                <span class="px-3 py-1 bg-red-600/10 text-red-500 text-[10px] font-black uppercase tracking-widest rounded-full border border-red-600/20">
                    {{ $player->position ?? 'ATHLETE' }}
                </span>
                <span class="text-zinc-500 font-bold text-xs uppercase tracking-widest">#{{ $player->jersey_number }}</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tighter text-white italic leading-none">{{ $player->name }}</h1>
            
            {{-- PLAYER BIO --}}
            <div class="mt-4 max-w-2xl">
                <p class="text-zinc-400 text-sm leading-relaxed font-medium italic">
                    {{ $player->bio ?? 'No biography available for this athlete for the 2026 season.' }}
                </p>
            </div>

            <a href="{{ route('public-team-show', $player->team->id) }}" wire:navigate class="inline-block mt-6 text-zinc-500 font-bold hover:text-red-500 transition uppercase tracking-widest text-[10px] border-t border-white/5 pt-4">
                {{ $player->team->name }} <span class="mx-2 text-zinc-800">|</span> {{ $player->team->division->name }}
            </a>
        </div>
    </div>

    {{-- 2. STATS GRID --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @foreach(['PPG' => 'ppg', 'RPG' => 'rpg', 'APG' => 'apg', 'SPG' => 'spg', 'GP' => 'gp'] as $label => $key)
            <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl text-center shadow-lg group hover:border-red-600/50 transition-all">
                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-1">{{ $label }}</p>
                <p class="text-3xl font-black text-white italic group-hover:text-red-500 transition-colors">
                    {{ number_format($this->averages->$key ?? 0, 1) }}
                </p>
            </div>
        @endforeach
    </div>

    {{-- 3. RECENT GAME LOG --}}
    <section class="space-y-6">
        <h2 class="text-xl font-black uppercase tracking-tighter text-white flex items-center gap-2">
            <span class="w-2 h-6 bg-red-600"></span>
            Recent Performances
        </h2>
        <div class="overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900/30 backdrop-blur-sm shadow-xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-zinc-900 text-zinc-500 text-[10px] font-black uppercase tracking-widest border-b border-zinc-800">
                        <th class="p-4">Date</th>
                        <th class="p-4">Matchup</th>
                        <th class="p-4 text-center">Outcome</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/50">
                    @forelse($this->recentGames as $event)
                        <tr class="hover:bg-zinc-800/30 transition group">
                            <td class="p-4 text-xs font-bold text-zinc-400">{{ $event->game->date->format('M d, Y') }}</td>
                            <td class="p-4 text-xs font-black text-white uppercase">
                                {{ $event->game->homeTeam->name }} 
                                <span class="text-zinc-600 px-1 italic">vs</span> 
                                {{ $event->game->awayTeam->name }}
                            </td>
                            <td class="p-4 text-center">
                                <span class="text-[10px] font-black uppercase px-2 py-1 rounded bg-zinc-800 text-zinc-500">
                                    {{ $event->game->score_home }} - {{ $event->game->score_away }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('match-center', $event->game_id) }}" wire:navigate class="text-[10px] text-red-500 font-black uppercase hover:underline tracking-widest">Match Center →</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-12 text-center text-zinc-600 text-[10px] font-black uppercase tracking-[0.3em]">No game data recorded yet for 2026</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
