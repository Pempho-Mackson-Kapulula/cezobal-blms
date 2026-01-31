<div class="space-y-10">
    {{-- Header --}}
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-zinc-900 pb-8">
        <div>
            <h1 class="text-5xl font-black uppercase tracking-tighter text-white italic">Team <span class="text-red-600">Analytics</span></h1>
            <p class="text-zinc-500 text-sm mt-2 font-bold uppercase tracking-widest">2026 Season Performance Metrics</p>
        </div>
        <select wire:model.live="selectedDivision" class="w-full md:w-64 bg-zinc-900 border-2 border-zinc-800 text-white rounded-xl px-4 py-2.5 font-bold focus:border-red-600 outline-none cursor-pointer">
            @foreach($divisions as $division)
                <option value="{{ $division->id }}">{{ $division->name }}</option>
            @endforeach
        </select>
    </header>

    {{-- Stats Table --}}
    <div class="overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-900/30 shadow-2xl backdrop-blur-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-zinc-900 text-zinc-500 text-[10px] font-black uppercase tracking-widest border-b border-zinc-800">
                        <th class="p-6">Team Name</th>
                        <th class="p-6 text-center">GP</th>
                        <th class="p-6 text-center text-red-500">PPG</th>
                        <th class="p-6 text-center">PA</th>
                        <th class="p-6 text-center">FG%</th>
                        <th class="p-6 text-center">REB</th>
                        <th class="p-6 text-center">AST</th>
                        <th class="p-6 text-center">STL</th>
                        <th class="p-6 text-center">BLK</th>
                        <th class="p-6 text-center">TOV</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/50">
                    @forelse($stats as $teamStat)
                        <tr class="hover:bg-zinc-800/40 transition-colors group">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-8 h-8 bg-zinc-800 rounded-full flex items-center justify-center font-black text-zinc-500 group-hover:bg-red-600 group-hover:text-white transition-all uppercase">
                                        {{ substr($teamStat['team_name'], 0, 1) }}
                                    </div>
                                    <span class="font-black text-white uppercase tracking-tight group-hover:text-red-500 transition-colors">{{ $teamStat['team_name'] }}</span>
                                </div>
                            </td>
                            <td class="p-6 text-center font-bold text-zinc-400">{{ $teamStat['games_played'] }}</td>
                            <td class="p-6 text-center font-black text-red-500 text-lg bg-red-500/5">{{ $teamStat['ppg'] }}</td>
                            <td class="p-6 text-center font-bold text-zinc-300">{{ $teamStat['pa'] }}</td>
                            <td class="p-6 text-center font-bold text-zinc-300">{{ $teamStat['fg_percent'] }}%</td>
                            <td class="p-6 text-center font-bold text-zinc-300">{{ $teamStat['rebounds'] }}</td>
                            <td class="p-6 text-center font-bold text-zinc-300">{{ $teamStat['assists'] }}</td>
                            <td class="p-6 text-center font-bold text-zinc-300">{{ $teamStat['steals'] }}</td>
                            <td class="p-6 text-center font-bold text-zinc-300">{{ $teamStat['blocks'] }}</td>
                            <td class="p-6 text-center font-bold text-zinc-300">{{ $teamStat['turnovers'] }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="p-20 text-center text-zinc-600 font-black uppercase text-2xl italic">No Team Data Available</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
