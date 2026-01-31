<div class="space-y-10">
    {{-- Header Section --}}
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-zinc-900 pb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="w-8 h-1 bg-red-600"></span>
                <span class="text-xs font-black uppercase tracking-[0.3em] text-zinc-500">Official 2026 Rankings</span>
            </div>
            <h1 class="text-5xl font-black uppercase tracking-tighter text-white italic">Player <span
                    class="text-red-600">Averages</span></h1>
        </div>

        <div class="flex flex-col md:flex-row gap-4 items-center">
            {{-- Search Bar --}}
            <div class="relative group w-full md:w-64">
                <input wire:model.live="search" type="text" placeholder="Search player..."
                    class="w-full bg-zinc-900 border-2 border-zinc-800 text-white rounded-xl px-4 py-2.5 pl-10 text-sm focus:border-red-600 outline-none transition-all placeholder:text-zinc-600">
                <svg class="absolute left-3 top-3 w-4 h-4 text-zinc-600 group-focus-within:text-red-600 transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            {{-- Division Filter --}}
            <select wire:model.live="selectedDivision"
                class="w-full md:w-48 bg-zinc-900 border-2 border-zinc-800 text-white rounded-xl px-4 py-2.5 font-bold text-sm focus:border-red-600 outline-none cursor-pointer">
                @foreach ($divisions as $division)
                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                @endforeach
            </select>
        </div>
    </header>

    {{-- Stats Table --}}
    <div class="overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-900/30 shadow-2xl backdrop-blur-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-zinc-900 text-zinc-500 text-[10px] font-black uppercase tracking-widest border-b border-zinc-800">
                        <th class="p-6">Player</th>
                        <th class="p-6 text-center">GP</th>
                        <th class="p-6 text-center text-red-500">PPG</th>
                        <th class="p-6 text-center">RPG</th>
                        <th class="p-6 text-center">APG</th>
                        <th class="p-6 text-center">SPG</th>
                        <th class="p-6 text-center">TOPG</th>
                        <th class="p-6 text-center">PFPG</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/50">
                    @forelse($players as $stat)
                        <tr class="hover:bg-zinc-800/40 transition-colors group">
                            <td class="p-6">
                                {{-- Link added around the player's name and team details --}}
                                <a href="{{ route('public-player-show', $stat->player->id) }}" wire:navigate
                                    class="flex flex-col group-hover:text-red-500 transition-colors">
                                    <span
                                        class="font-black text-white uppercase group-hover:text-red-500 transition">{{ $stat->player->name }}</span>
                                    <span
                                        class="text-[9px] text-zinc-600 font-bold uppercase">{{ $stat->player->team->name }}</span>
                                </a>
                            </td>
                            <td class="p-6 text-center font-bold text-zinc-500">{{ $stat->games_played }}</td>
                            <td class="p-6 text-center font-black text-red-500 text-lg">{{ $stat->ppg }}</td>
                            <td class="p-6 text-center font-bold text-zinc-300">{{ $stat->rpg }}</td>
                            <td class="p-6 text-center font-bold text-zinc-300">{{ $stat->apg }}</td>
                            <td class="p-6 text-center font-bold text-zinc-300">{{ $stat->spg }}</td>
                            {{-- Steals --}}
                            <td class="p-6 text-center font-bold text-zinc-500">{{ $stat->topg }}</td>
                            <td class="p-6 text-center font-bold text-zinc-500">{{ $stat->pfpg }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"
                                class="p-24 text-center text-zinc-700 font-black uppercase text-2xl italic">No Data
                                Available matching 2026 criteria</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
