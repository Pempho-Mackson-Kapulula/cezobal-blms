<div class="space-y-10" wire:poll.30s>
    {{-- Top Navigation / Breadcrumbs --}}
    <div class="flex items-center gap-2">
        <a href="{{ route('public-teams-page') }}" wire:navigate
            class="text-[10px] font-black uppercase tracking-widest text-zinc-500 hover:text-red-500 transition flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Teams
        </a>
    </div>

    {{-- Header / Hero Section --}}
    <div
        class="bg-zinc-900 border border-zinc-800 p-8 rounded-3xl shadow-2xl flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">
        {{-- Aesthetic Background Accent --}}
        <div class="absolute -right-10 -bottom-10 opacity-5">
            <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L1 21h22L12 2z" />
            </svg>
        </div>

        <div
            class="w-32 h-32 bg-red-600 rounded-2xl flex items-center justify-center text-5xl font-black text-white shadow-lg shadow-red-900/40 relative z-10">
            {{ substr($team->name, 0, 1) }}
        </div>

        <div class="text-center md:text-left relative z-10">
            <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tighter text-white">{{ $team->name }}</h1>
            <div class="flex flex-wrap justify-center md:justify-start items-center gap-4 mt-2">
                <p class="text-red-500 font-bold uppercase tracking-widest text-xs">
                    {{ $team->division->name ?? 'Unassigned Division' }}
                </p>
                <span class="w-1 h-1 rounded-full bg-zinc-700 hidden md:block"></span>
                <p class="text-zinc-400 font-mono text-xs uppercase tracking-widest">
                    Record: <span class="text-white">{{ $recentResults->count() }} Games Tracked</span>
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Roster --}}
        <div class="lg:col-span-1 space-y-6">
            <h2 class="text-xl font-black uppercase text-white border-l-4 border-red-600 pl-3">Roster</h2>
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-xl">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-zinc-800/50 text-[10px] font-black uppercase text-zinc-500 tracking-widest">
                        <tr>
                            <th class="p-4 w-16">#</th>
                            <th class="p-4">Player Name</th>
                            <th class="p-4 text-right">Profile</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/50">
                        @foreach ($team->players as $player)
                            <tr wire:key="player-{{ $player->id }}" class="hover:bg-zinc-800/40 transition-all group">
                                <td class="p-4 text-red-500 font-bold">
                                    #{{ $player->jersey_number ?? '00' }}
                                </td>
                                <td class="p-4">
                                    <a href="{{ route('public-player-show', $player->id) }}" wire:navigate
                                        class="text-zinc-300 font-medium group-hover:text-white transition-colors block">
                                        {{ $player->name }}
                                    </a>
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('public-player-show', $player->id) }}" wire:navigate
                                        class="inline-flex items-center justify-center w-6 h-6 rounded bg-zinc-800 text-zinc-500 group-hover:bg-red-600 group-hover:text-white transition-all shadow-lg">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        {{-- Right Column: Results & Schedule --}}
        <div class="lg:col-span-2 space-y-10">

            {{-- Recent Results --}}
            <section class="space-y-4">
                <h2 class="text-xl font-black uppercase text-white border-l-4 border-zinc-700 pl-3">Recent Results</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse ($recentResults as $game)
                        <div wire:key="result-{{ $game->id }}"
                            class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl shadow-xl hover:border-red-600/50 transition-all group">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">
                                    Final - {{ $game->completed_at->format('M d') }}
                                </span>
                                <span
                                    class="px-2 py-0.5 rounded bg-zinc-800 text-zinc-400 text-[10px] font-bold uppercase">
                                    {{ $game->division->name ?? 'League' }}
                                </span>
                            </div>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span
                                        class="font-bold text-zinc-300 {{ $game->home_team_id == $team->id ? 'underline decoration-red-600 decoration-2' : '' }}">
                                        {{ $game->homeTeam->name }}
                                    </span>
                                    <span
                                        class="text-2xl font-black {{ $game->score_home > $game->score_away ? 'text-red-500' : 'text-white' }}">
                                        {{ $game->score_home }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span
                                        class="font-bold text-zinc-300 {{ $game->away_team_id == $team->id ? 'underline decoration-red-600 decoration-2' : '' }}">
                                        {{ $game->awayTeam->name }}
                                    </span>
                                    <span
                                        class="text-2xl font-black {{ $game->score_away > $game->score_home ? 'text-red-500' : 'text-white' }}">
                                        {{ $game->score_away }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-zinc-900/50 border border-zinc-800 border-dashed p-8 rounded-2xl text-center">
                            <p class="text-zinc-500 text-sm italic">No recent results found for this team.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- Upcoming Schedule Section --}}
            <section class="space-y-4">
                <h2 class="text-xl font-black uppercase text-white border-l-4 border-zinc-700 pl-3">Upcoming Schedule
                </h2>
                <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-xl">
                    <table class="w-full text-left border-collapse">
                        <tbody class="divide-y divide-zinc-800/50">
                            @forelse ($upcomingSchedule as $game)
                                <tr wire:key="upcoming-{{ $game->id }}"
                                    class="hover:bg-zinc-800/30 transition group">
                                    <td class="p-4">
                                        <div class="text-sm font-bold text-white">{{ $game->date->format('l, M d') }}
                                        </div>
                                        <div class="text-[10px] text-zinc-500 uppercase tracking-widest">
                                            {{ $game->timeSlot ? \Carbon\Carbon::parse($game->timeSlot->start_time)->format('h:i A') : 'TBD' }}
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="text-[10px] font-black text-zinc-600 uppercase italic">VS</span>
                                            <span class="text-sm font-black uppercase tracking-tight text-zinc-300">
                                                {{ $game->home_team_id == $team->id ? $game->awayTeam->name : $game->homeTeam->name }}
                                            </span>
                                            <span
                                                class="text-[9px] px-1.5 py-0.5 rounded bg-zinc-800 text-zinc-500 font-bold uppercase">
                                                {{ $game->home_team_id == $team->id ? 'Home' : 'Away' }}
                                            </span>
                                        </div>
                                        <div class="text-[10px] text-zinc-600 font-bold uppercase mt-1">
                                            {{ $game->court->name ?? 'TBD' }}
                                        </div>
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="{{ route('match-center', $game->id) }}" wire:navigate
                                            class="text-[10px] font-black text-red-500 uppercase tracking-widest hover:underline decoration-2">
                                            Preview →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        class="p-12 text-center text-zinc-600 text-xs font-bold uppercase italic tracking-widest">
                                        No upcoming fixtures scheduled for 2026.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>


        </div>
    </div>
</div>
