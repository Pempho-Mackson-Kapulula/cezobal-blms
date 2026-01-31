<div class="p-4 sm:p-8 bg-zinc-950 min-h-screen font-sans text-zinc-100">
    <div class="max-w-5xl mx-auto mb-10 border-b-2 border-zinc-900 pb-8">
        <div class="flex items-center gap-2 mb-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-[10px] font-black uppercase tracking-[0.4em] text-emerald-500">Live Feed Active</span>
        </div>
        <h1 class="text-5xl font-black uppercase tracking-tighter italic leading-none">
            STATS <span class="text-red-600">COMMAND</span>
        </h1>
        <p class="text-zinc-500 text-[10px] font-black uppercase tracking-[0.4em] mt-3">
            Personnel: {{ auth()->user()->name }} // Node: SAST UTC+2
        </p>
    </div>

    <div class="max-w-5xl mx-auto">
        <h2 class="text-xs font-black uppercase tracking-[0.2em] text-zinc-600 mb-6 flex items-center gap-4">
            Assigned Operations 
            <span class="flex-1 h-[1px] bg-zinc-900"></span>
        </h2>

        @if ($assignedGames->isEmpty())
            <div class="py-20 text-center bg-zinc-900/50 rounded-3xl border-2 border-dashed border-zinc-800">
                <p class="text-[10px] font-black uppercase tracking-widest text-zinc-600">No active assignments found in the sector.</p>
            </div>
        @else
            <div class="grid gap-4">
                @foreach ($assignedGames as $game)
                    <div class="group relative bg-zinc-900 rounded-2xl border border-zinc-800 p-6 transition-all hover:border-red-600/40 hover:shadow-[0_0_30px_rgba(220,38,38,0.05)] overflow-hidden">
                        
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-zinc-800 group-hover:bg-red-600 transition-colors"></div>

                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-[9px] font-black px-2 py-0.5 bg-zinc-800 text-zinc-400 uppercase tracking-widest rounded">Match ID: #{{ $game->id }}</span>
                                    @if($game->date->isToday())
                                        <span class="text-[9px] font-black px-2 py-0.5 bg-red-600/10 text-red-500 uppercase tracking-widest rounded border border-red-600/20">Active Today</span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center gap-4 text-2xl font-black uppercase italic tracking-tighter">
                                    <span class="text-white group-hover:text-red-500 transition-colors">{{ $game->homeTeam->name }}</span>
                                    <span class="text-zinc-700 text-sm italic">vs</span>
                                    <span class="text-white group-hover:text-red-500 transition-colors">{{ $game->awayTeam->name }}</span>
                                </div>

                                <div class="flex items-center gap-4 mt-4 text-[10px] font-bold text-zinc-500 uppercase tracking-widest font-mono">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $game->date->format('d M Y') }}
                                    </div>
                                    <div class="flex items-center gap-1.5 text-zinc-400">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $game->date->setTimezone('Africa/Johannesburg')->format('H:i') }} CAT
                                    </div>
                                </div>
                            </div>

                            <div class="relative">
                                <a href="{{ route('statistician.stat-input', $game) }}"
                                   class="inline-flex items-center gap-3 px-8 py-4 bg-zinc-100 hover:bg-red-600 text-black hover:text-white rounded-xl text-[11px] font-black uppercase tracking-[0.2em] transition-all active:scale-95 shadow-xl group/btn">
                                    Initialize Entry
                                    <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>