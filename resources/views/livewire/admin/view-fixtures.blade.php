<div class="p-4 sm:p-8 bg-zinc-950 min-h-screen font-sans text-zinc-100">
    
    <div class="max-w-7xl mx-auto mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 border-b-2 border-zinc-900 pb-8">
        <div>
            <h1 class="text-5xl font-black uppercase tracking-tighter italic leading-none">
                GAME <span class="text-red-600">FIXTURES</span>
            </h1>
            <p class="text-zinc-500 text-xs font-black uppercase tracking-[0.4em] mt-3">
                {{ $divisions->firstWhere('id', $selectedDivision)?->name ?? 'All Divisions' }} // Schedule Management
            </p>
        </div>

        <div class="flex flex-col gap-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-red-500 ml-1">Filter by Division</label>
            <div class="relative">
                <select wire:model.live="selectedDivision"
                    class="appearance-none bg-zinc-900 border-2 border-zinc-800 rounded-2xl px-6 py-3 pr-12 text-sm font-black uppercase tracking-tight text-white focus:border-red-600 focus:ring-0 transition-all cursor-pointer">
                    <option value="">-- All Divisions --</option>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-red-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-sm font-black uppercase tracking-[0.2em] text-zinc-400 flex items-center gap-3">
                <span class="w-8 h-px bg-red-600"></span>
                Upcoming Schedule
            </h2>
            <div class="flex gap-2 items-center">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-zinc-600 italic">Live Database</span>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl">
            @if (isset($games) && $games->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-black/50 border-b border-zinc-800">
                                <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500">Date & Venue</th>
                                <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-red-500 text-center">Matchup</th>
                                <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-center">Time</th>
                                <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 hidden lg:table-cell">Official</th>
                                <th class="px-6 py-5"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/50">
                            @foreach ($games as $game)
                                <tr class="group hover:bg-black/40 transition-colors">
                                    <td class="px-6 py-5">
                                        <p class="text-sm font-black uppercase tracking-tighter text-white">
                                            {{ \Carbon\Carbon::parse($game->date)->format('D, M d') }}
                                        </p>
                                        <p class="text-[10px] text-zinc-600 font-bold uppercase tracking-widest mt-1">
                                            {{ $game->court?->name ?? 'TBD Venue' }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center gap-4">
                                            <div class="text-right flex-1">
                                                <span class="text-sm font-black uppercase tracking-tight text-white group-hover:text-red-500 transition-colors">
                                                    {{ $game->homeTeam?->name ?? 'TBD' }}
                                                </span>
                                            </div>
                                            <div class="px-3 py-1 bg-zinc-800 border border-zinc-700 rounded-lg text-[10px] font-black text-zinc-500 italic">
                                                VS
                                            </div>
                                            <div class="text-left flex-1">
                                                <span class="text-sm font-black uppercase tracking-tight text-white group-hover:text-red-500 transition-colors">
                                                    {{ $game->awayTeam?->name ?? 'TBD' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        @if ($game->timeSlot)
                                            <span class="inline-block px-4 py-1.5 bg-red-600/10 border border-red-600/20 rounded-xl text-xs font-black text-red-500 tracking-tighter shadow-inner">
                                                {{ \Carbon\Carbon::parse($game->timeSlot->start_time)->format('h:i A') }}
                                            </span>
                                        @else
                                            <span class="text-[10px] font-black text-zinc-700 uppercase italic">Unscheduled</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 hidden lg:table-cell">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-zinc-800 flex items-center justify-center border border-zinc-700">
                                                <svg class="w-3 h-3 text-zinc-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                            </div>
                                            <span class="text-[10px] font-black uppercase tracking-widest text-zinc-500 italic">
                                                {{ $game->statistician?->name ?? 'None Assigned' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 text-right">
                                        <button wire:click="editFixture({{ $game->id }})"
                                            class="inline-flex items-center gap-2 px-6 py-2 bg-zinc-800 hover:bg-red-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-full transition-all active:scale-95 border border-zinc-700 hover:border-red-500 group-hover:shadow-[0_0_20px_rgba(220,38,38,0.2)]">
                                            Edit
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-32 text-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-[0.02] pointer-events-none">
                        <svg class="w-full h-full" fill="currentColor" viewBox="0 0 100 100"><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/></pattern><rect width="100%" height="100%" fill="url(#grid)" /></svg>
                    </div>
                    <svg class="mx-auto h-20 w-20 text-zinc-800 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <h3 class="text-xl font-black uppercase italic tracking-tighter text-zinc-700">No Fixtures Found</h3>
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-800 mt-2">
                        {{ $message ?? 'Deploy a schedule from the Engine Room to see games here.' }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>