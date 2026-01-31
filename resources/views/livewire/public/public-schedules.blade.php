<div class="space-y-10 py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
    {{-- Header Section --}}
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-zinc-900 pb-8">
        <div>
            <h1 class="text-5xl font-black uppercase tracking-tighter text-white italic">
                Game <span class="text-red-600">Schedules</span>
            </h1>
            <p class="text-zinc-500 text-sm mt-2 font-bold uppercase tracking-widest">
                {{ $currentDivisionName }} • 2026 Season Overview
            </p>
        </div>

        <div class="flex flex-col gap-2">
            <label class="text-[10px] font-black uppercase text-zinc-500 tracking-widest px-1">Filter Division</label>
            <select wire:model.live="selectedDivision" 
                    class="bg-zinc-900 border-2 border-zinc-800 text-white rounded-xl px-5 py-3 font-bold focus:border-red-600 focus:ring-0 transition-all cursor-pointer shadow-2xl min-w-[200px]">
                @foreach($divisions as $division)
                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                @endforeach
            </select>
        </div>
    </header>

    {{-- Schedule Timeline --}}
    <div class="space-y-16">
        @forelse($schedule as $date => $games)
            @php 
                $isToday = \Carbon\Carbon::parse($date)->isToday(); 
            @endphp
            <div class="relative">
                {{-- Date Header --}}
                <div class="sticky top-0 z-10 bg-zinc-950/80 backdrop-blur-md py-4 mb-6">
                    <h3 class="text-xl font-black uppercase tracking-tighter flex items-center gap-4 {{ $isToday ? 'text-red-500' : 'text-white' }}">
                        <span class="w-12 h-1 {{ $isToday ? 'bg-red-500' : 'bg-zinc-800' }}"></span>
                        {{ $date }}
                        @if($isToday)
                            <span class="text-[10px] bg-red-600 text-white px-2 py-0.5 rounded-md tracking-widest animate-pulse">TODAY</span>
                        @endif
                    </h3>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    @foreach($games as $game)
                        <div class="relative overflow-hidden bg-zinc-900 border {{ $game->status === 'completed' ? 'border-zinc-800' : 'border-zinc-800 hover:border-red-600/50' }} rounded-3xl transition-all group shadow-xl">
                            
                            {{-- Status Bar for Completed Games --}}
                            @if($game->status === 'completed')
                                <div class="absolute top-0 left-0 w-1 h-full bg-zinc-700"></div>
                            @endif

                            <div class="p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-8">
                                
                                {{-- Time & Venue --}}
                                <div class="flex flex-col items-center md:items-start min-w-[140px] border-b md:border-b-0 md:border-r border-zinc-800 pb-4 md:pb-0 md:pr-8 w-full md:w-auto">
                                    <span class="text-2xl font-black text-white italic tracking-tighter">
                                        {{ $game->timeSlot ? \Carbon\Carbon::parse($game->timeSlot->start_time)->format('h:i A') : 'TBD' }}
                                    </span>
                                    <span class="text-[10px] text-zinc-500 font-black uppercase tracking-[0.2em] mt-1">
                                        {{ $game->court->name ?? 'Court TBD' }}
                                    </span>
                                </div>

                                {{-- Matchup Container --}}
                                <div class="flex-1 flex items-center justify-between w-full max-w-2xl px-4">
                                    
                                    {{-- Home Team --}}
                                    <div class="flex flex-col items-end flex-1 gap-2">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg md:text-xl font-black text-white uppercase tracking-tight text-right group-hover:text-red-500 transition line-clamp-1">
                                                {{ $game->homeTeam->name }}
                                            </span>
                                        </div>
                                        @if($game->status === 'completed')
                                            <span class="text-3xl font-black {{ $game->score_home > $game->score_away ? 'text-white' : 'text-zinc-600' }}">
                                                {{ $game->score_home }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Divider / VS --}}
                                    <div class="px-6 flex flex-col items-center">
                                        <div class="text-[10px] font-black italic text-zinc-600 mb-1 uppercase tracking-widest">
                                            {{ $game->status === 'completed' ? 'Final' : 'Match' }}
                                        </div>
                                        <div class="w-12 h-12 rounded-full bg-zinc-800 border-4 border-zinc-900 flex items-center justify-center">
                                            <span class="text-xs font-black italic text-zinc-400">VS</span>
                                        </div>
                                    </div>

                                    {{-- Away Team --}}
                                    <div class="flex flex-col items-start flex-1 gap-2">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg md:text-xl font-black text-white uppercase tracking-tight group-hover:text-red-500 transition line-clamp-1">
                                                {{ $game->awayTeam->name }}
                                            </span>
                                        </div>
                                        @if($game->status === 'completed')
                                            <span class="text-3xl font-black {{ $game->score_away > $game->score_home ? 'text-red-500' : 'text-zinc-600' }}">
                                                {{ $game->score_away }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Action Button --}}
                                <div class="w-full md:w-auto pt-4 md:pt-0">
                                    <a href="{{ route('match-center', $game->id) }}" class="block w-full md:w-auto text-center px-8 py-3 bg-zinc-800 hover:bg-red-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl transition-all transform active:scale-95 shadow-lg">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-32 bg-zinc-900/20 rounded-[3rem] border-4 border-dashed border-zinc-900">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-zinc-900 rounded-full mb-6">
                    <svg class="w-10 h-10 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-3xl font-black text-zinc-700 uppercase italic">No Schedule Found</h3>
                <p class="text-zinc-500 font-bold uppercase tracking-[0.2em] text-xs mt-2">Games haven't been assigned to this division yet.</p>
            </div>
        @endforelse
    </div>

    {{-- Floating Info --}}
    <footer class="mt-20 p-8 rounded-3xl bg-zinc-900/50 border border-zinc-800 text-center">
        <p class="text-[10px] font-black text-zinc-500 uppercase tracking-[0.3em]">
            Central Zone Basketball League • Official 2026 Season Schedule
        </p>
    </footer>
</div>
