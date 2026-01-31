<div class="space-y-10">
    {{-- Hero Section --}}
    <header class="py-6 border-b border-zinc-900">
        <h1 class="text-4xl font-black uppercase tracking-tighter text-white italic">League <span
                class="text-red-600">Overview</span></h1>
        <p class="text-zinc-500 text-sm font-bold uppercase tracking-widest">Central Zone Basketball League Management
            System • 2026</p>
    </header>

    {{-- Recent Results Section --}}
    <section>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-black uppercase tracking-tighter text-white flex items-center gap-2">
                <span class="w-2 h-8 bg-red-600"></span>
                Recent Results
            </h2>
            <a href="{{ route('public-schedules') }}" wire:navigate
                class="text-[10px] font-black text-zinc-500 hover:text-red-500 transition uppercase tracking-[0.2em]">View
                All Games →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse ($recentResults as $game)
                @php
                    $homeWon = (int) $game->score_home > (int) $game->score_away;
                    $awayWon = (int) $game->score_away > (int) $game->score_home;
                @endphp

                <a href="{{ route('match-center', $game->id) }}" wire:navigate
                    class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl shadow-xl hover:border-red-600 hover:scale-[1.02] transition-all group relative overflow-hidden">

                    {{-- Background Accent for Winner --}}
                    <div class="absolute top-0 right-0 w-16 h-16 bg-red-600/5 rotate-45 translate-x-8 -translate-y-8">
                    </div>

                    <div class="flex justify-between items-center mb-6 relative z-10">
                        <span
                            class="text-[10px] font-black text-zinc-500 uppercase tracking-widest flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-zinc-700"></span>
                            Final • {{ $game->date->format('M d') }}
                        </span>
                        <span class="px-2 py-0.5 rounded bg-zinc-800 text-zinc-400 text-[10px] font-bold uppercase">
                            {{ $game->division->name }}
                        </span>
                    </div>

                    <div class="space-y-4 relative z-10">
                        {{-- Home Team --}}
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                @if ($homeWon)
                                    <span class="w-1 h-4 bg-red-600 rounded-full"></span>
                                @endif
                                <span
                                    class="font-bold uppercase tracking-tight {{ $homeWon ? 'text-white' : 'text-zinc-500' }}">
                                    {{ $game->homeTeam->name }}
                                </span>
                            </div>
                            <span class="text-2xl font-black {{ $homeWon ? 'text-white' : 'text-zinc-800' }}">
                                {{ $game->score_home }}
                            </span>
                        </div>

                        {{-- Away Team --}}
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                @if ($awayWon)
                                    <span class="w-1 h-4 bg-red-600 rounded-full"></span>
                                @endif
                                <span
                                    class="font-bold uppercase tracking-tight {{ $awayWon ? 'text-red-500' : 'text-zinc-500' }}">
                                    {{ $game->awayTeam->name }}
                                </span>
                            </div>
                            <span class="text-2xl font-black {{ $awayWon ? 'text-red-500' : 'text-zinc-800' }}">
                                {{ $game->score_away }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-zinc-800/50 flex justify-between items-center">
                        <span class="text-[9px] font-black text-zinc-600 uppercase tracking-widest">Stats
                            Available</span>
                        <span
                            class="text-[10px] font-black text-red-500 uppercase opacity-0 group-hover:opacity-100 transition-opacity">View
                            Box Score →</span>
                    </div>
                </a>
            @empty
                {{-- ... empty state ... --}}
            @endforelse
        </div>

    </section>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        {{-- Left: Upcoming Schedule --}}
        <div class="lg:col-span-2 space-y-6">
            <h2 class="text-xl font-black uppercase tracking-tighter text-white flex items-center gap-2">
                <span class="w-2 h-6 bg-zinc-700"></span>
                Upcoming Schedule
            </h2>

            <div class="overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900/30">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-zinc-900 text-zinc-500 text-[10px] font-black uppercase tracking-widest border-b border-zinc-800">
                            <th class="p-4">Date & Time</th>
                            <th class="p-4">Matchup</th>
                            <th class="p-4">Court</th>
                            <th class="p-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/50">
                        @forelse ($upcomingGames as $game)
                            <tr class="hover:bg-zinc-800/30 transition group">
                                <td class="p-4">
                                    <div class="text-sm font-bold text-white">{{ $game->date->format('D, M d') }}</div>
                                    <div class="text-[10px] text-zinc-500 font-bold uppercase">
                                        {{ $game->timeSlot ? \Carbon\Carbon::parse($game->timeSlot->start_time)->format('h:i A') : 'TBD' }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="text-sm font-bold text-zinc-300 uppercase tracking-tight">
                                        {{ $game->homeTeam->name }} <span
                                            class="text-zinc-600 text-[10px] px-1 italic font-black">VS</span>
                                        {{ $game->awayTeam->name }}
                                    </div>
                                    <div class="text-[9px] text-zinc-600 font-black uppercase tracking-widest">
                                        {{ $game->division->name }}</div>
                                </td>
                                <td class="p-4 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">
                                    {{ $game->court->name ?? 'TBD' }}
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('match-center', $game->id) }}" wire:navigate
                                        class="text-[10px] font-black text-red-500 uppercase tracking-widest hover:underline">Preview</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-16 text-center">
                                    <p class="text-zinc-600 text-[10px] font-black uppercase tracking-[0.3em]">No
                                        upcoming games scheduled</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right: Quick Standings --}}
        <livewire:public.public-standings :is-sidebar="true" />


    </div>
</div>
