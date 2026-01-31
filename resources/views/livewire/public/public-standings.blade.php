<div>
    @if($isSidebar)
        {{-- ==========================================
             SIDEBAR VIEW (For Homepage)
             ========================================== --}}
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-black uppercase tracking-tighter text-white flex items-center gap-2">
                    <span class="w-2 h-6 bg-red-600"></span>
                    Standings
                </h2>
                <select wire:model.live="selectedDivision" class="bg-zinc-800 text-[10px] text-zinc-400 border-none rounded p-1 font-bold uppercase focus:ring-0">
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-xl">
                <div class="space-y-4">
                    @forelse($standings as $index => $standing)
                        <a href="{{ route('public-team-show', $standing['team_id']) }}" wire:navigate 
                           class="flex items-center justify-between group hover:bg-zinc-800/40 p-2 -mx-2 rounded-xl transition-all cursor-pointer">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-black {{ $index < 3 ? 'text-red-500' : 'text-zinc-600' }}">{{ $index + 1 }}</span>
                                <span class="text-sm font-bold text-zinc-300 group-hover:text-red-500 transition line-clamp-1">
                                    {{ $standing['team'] }}
                                </span>
                            </div>
                            <div class="flex items-center gap-4 text-[10px] font-mono font-bold shrink-0">
                                <span class="text-zinc-100">{{ $standing['wins'] }}-{{ $standing['losses'] }}</span>
                                <span class="text-zinc-500">{{ $standing['league_points'] }} PTS</span>
                                <svg class="w-3 h-3 text-zinc-600 group-hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                    @empty
                        <p class="text-zinc-600 text-[10px] text-center font-bold uppercase py-4">No Data Available</p>
                    @endforelse
                </div>
                
                <a href="{{ route('public-standings') }}" wire:navigate class="block w-full text-center mt-8 py-3 rounded-xl bg-zinc-800 text-[10px] font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all">
                    Full Standings
                </a>
            </div>
        </div>

    @else
        {{-- ==========================================
             FULL PAGE VIEW
             ========================================== --}}
        <div class="space-y-10 py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-zinc-900 pb-8">
                <div>
                    <h1 class="text-5xl font-black uppercase tracking-tighter text-white italic">League <span class="text-red-600">Standings</span></h1>
                    <p class="text-zinc-500 text-sm mt-2 font-bold uppercase tracking-widest">{{ $currentDivisionName }} • 2026 Regular Season</p>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black uppercase text-zinc-500 tracking-widest">Filter by Division</label>
                    <select wire:model.live="selectedDivision" class="bg-zinc-900 border-2 border-zinc-800 text-white rounded-xl px-4 py-2 font-bold focus:border-red-600 transition-all cursor-pointer shadow-lg">
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                        @endforeach
                    </select>
                </div>
            </header>

            <div class="overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-900/30 backdrop-blur-sm shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-zinc-900 text-zinc-500 text-[11px] font-black uppercase tracking-[0.2em] border-b border-zinc-800">
                                <th class="p-6 text-center w-20">Rank</th>
                                <th class="p-6">Team Name</th>
                                <th class="p-6 text-center">Played</th>
                                <th class="p-6 text-center">Wins</th>
                                <th class="p-6 text-center">Losses</th>
                                <th class="p-6 text-center text-red-500 bg-red-500/5 border-l border-zinc-800/50">Points</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/50">
                            @forelse($standings as $index => $standing)
                                <tr class="hover:bg-zinc-800/40 transition-colors group">
                                    <td class="p-6 text-center">
                                        <span class="text-lg font-black {{ $index < 3 ? 'text-red-500' : 'text-zinc-600' }}">{{ $index + 1 }}</span>
                                    </td>
                                    <td class="p-6">
                                        <a href="{{ route('public-team-show', $standing['team_id']) }}" wire:navigate class="flex items-center gap-4 group cursor-pointer">
                                            <div class="w-10 h-10 bg-zinc-800 rounded-lg flex items-center justify-center font-black text-zinc-500 group-hover:bg-red-600 group-hover:text-white transition-all shadow-inner uppercase">
                                                {{ substr($standing['team'], 0, 1) }}
                                            </div>
                                            <div>
                                                <span class="font-black text-white uppercase tracking-tight group-hover:text-red-500 transition-colors block">{{ $standing['team'] }}</span>
                                                <span class="text-[10px] text-zinc-500 font-bold uppercase tracking-tighter">{{ $currentDivisionName }}</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="p-6 text-center font-bold text-zinc-400">{{ $standing['played'] }}</td>
                                    <td class="p-6 text-center font-bold text-white italic">{{ $standing['wins'] }}</td>
                                    <td class="p-6 text-center font-bold text-white italic">{{ $standing['losses'] }}</td>
                                    <td class="p-6 text-center bg-red-500/5 border-l border-zinc-800/50">
                                        <span class="text-xl font-black text-red-500">{{ $standing['league_points'] }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="p-24 text-center text-zinc-600 font-black uppercase italic tracking-tighter text-3xl">No Standings Data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
