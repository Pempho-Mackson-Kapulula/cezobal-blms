<div class="p-4 sm:p-8 bg-zinc-950 min-h-screen font-sans text-zinc-100">
    
    <div class="max-w-7xl mx-auto mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 border-b-2 border-zinc-900 pb-8">
        <div>
            <h1 class="text-5xl font-black uppercase tracking-tighter italic leading-none">
                LEAGUE <span class="text-red-600">STANDINGS</span>
            </h1>
            <p class="text-zinc-500 text-xs font-black uppercase tracking-[0.4em] mt-3">
                {{ $divisions->firstWhere('id', $selectedDivision)?->name ?? 'Selection Required' }} // Division Rankings
            </p>
        </div>

        <div class="flex flex-col gap-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-red-500 ml-1">Switch Division</label>
            <div class="relative">
                <select wire:model.live="selectedDivision"
                    class="appearance-none bg-zinc-900 border-2 border-zinc-800 rounded-2xl px-6 py-3 pr-12 text-sm font-black uppercase tracking-tight text-white focus:border-red-600 focus:ring-0 transition-all cursor-pointer">
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-red-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>
    </div>

    @if(count($standings) > 0)
    <div class="max-w-7xl mx-auto space-y-12">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach(collect($standings)->take(3) as $index => $team)
            <div class="relative group">
                <div class="absolute -top-4 -left-2 text-7xl font-black italic text-zinc-900/50 group-hover:text-red-600/20 transition-colors z-0">
                    #{{ $index + 1 }}
                </div>
                
                <div class="relative z-10 bg-zinc-900 border border-zinc-800 p-6 rounded-3xl group-hover:border-red-600/50 transition-all shadow-2xl">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-black uppercase tracking-tighter italic text-white leading-tight">
                            {{ $team['team'] }}
                        </h3>
                        <span class="text-2xl font-black text-red-600 italic">{{ $team['league_points'] }} <span class="text-[10px] uppercase not-italic text-zinc-500">PTS</span></span>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-2 border-t border-zinc-800 pt-4 mt-2">
                        <div class="text-center">
                            <p class="text-[9px] font-black uppercase text-zinc-500">Record</p>
                            <p class="text-xs font-bold text-white">{{ $team['wins'] }}-{{ $team['losses'] }}</p>
                        </div>
                        <div class="text-center border-x border-zinc-800">
                            <p class="text-[9px] font-black uppercase text-zinc-500">Diff</p>
                            <p class="text-xs font-bold {{ $team['point_diff'] >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                                {{ $team['point_diff'] > 0 ? '+' : '' }}{{ $team['point_diff'] }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-[9px] font-black uppercase text-zinc-500">GP</p>
                            <p class="text-xs font-bold text-white">{{ $team['played'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-black/50 border-b border-zinc-800">
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-center">Rank</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-red-500">Club</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-center">GP</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-center">W</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-center">L</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-center">PF</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-center">PA</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-center">DIFF</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-red-500 text-center bg-red-600/5">PTS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/50">
                        @foreach($standings as $index => $team)
                        <tr class="group hover:bg-black/40 transition-colors {{ $index < 2 ? 'bg-red-600/[0.02]' : '' }}">
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-black italic {{ $index < 2 ? 'text-red-600' : 'text-zinc-700' }}">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-black uppercase tracking-tight text-white group-hover:text-red-500 transition-colors">
                                    {{ $team['team'] }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-center text-xs font-bold text-zinc-400">{{ $team['played'] }}</td>
                            <td class="px-6 py-4 text-center text-xs font-bold text-emerald-500">{{ $team['wins'] }}</td>
                            <td class="px-6 py-4 text-center text-xs font-bold text-red-500">{{ $team['losses'] }}</td>
                            <td class="px-6 py-4 text-center text-xs font-bold text-zinc-400">{{ $team['points_for'] }}</td>
                            <td class="px-6 py-4 text-center text-xs font-bold text-zinc-400">{{ $team['points_against'] }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs font-black {{ $team['point_diff'] >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                                    {{ $team['point_diff'] > 0 ? '+' : '' }}{{ $team['point_diff'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center bg-red-600/5">
                                <span class="text-lg font-black italic text-red-500 leading-none">
                                    {{ $team['league_points'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
        <div class="max-w-7xl mx-auto py-32 bg-zinc-900 rounded-3xl border-4 border-dashed border-zinc-800 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p class="text-xs font-black uppercase tracking-[0.4em] text-zinc-700">No data available for this division</p>
        </div>
    @endif
</div>