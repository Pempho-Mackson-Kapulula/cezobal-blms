<div x-data @team-created="$wire.refreshTeam()"
    class="min-h-screen bg-zinc-50 dark:bg-zinc-950 p-4 md:p-10 font-sans selection:bg-red-500 selection:text-white">

    {{-- Alerts --}}
    @if (session()->has('error') || session()->has('message'))
        <div class="max-w-7xl mx-auto mb-6 space-y-2">
            @if (session()->has('error'))
                <div class="p-4 text-xs font-black uppercase tracking-widest bg-red-600 text-white rounded-lg">
                    {{ session('error') }}</div>
            @endif
            @if (session()->has('message'))
                <div class="p-4 text-xs font-black uppercase tracking-widest bg-emerald-600 text-white rounded-lg">
                    {{ session('message') }}</div>
            @endif
        </div>
    @endif

    @if ($team)
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- HEADER: MINIMALIST -->
            <div
                class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b-2 border-zinc-200 dark:border-zinc-800 pb-8">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-red-600 mb-1">League Operations</p>
                    <h1 class="text-5xl font-black uppercase tracking-tighter italic leading-none">
                        TEAM<span class="text-red-600">DASHBOARD</span>
                    </h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('team-manager.create-player', ['teamId' => $team->id]) }}" wire:navigate
                        class="inline-flex items-center px-6 py-3 bg-zinc-900 dark:bg-zinc-100 dark:text-black text-white text-[10px] font-black uppercase tracking-widest rounded-md hover:bg-red-600 dark:hover:bg-red-600 dark:hover:text-white transition-colors duration-200">
                        Register Athlete
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- LEFT COLUMN: CLEAN PROFILE -->
                <div class="lg:col-span-4 space-y-6">
                    <div
                        class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
                        <!-- Solid Header -->
                        <div class="h-2 bg-red-600"></div>

                        <div class="p-8">
                            <div class="flex items-center gap-5 mb-8">
                                @if ($team->logo_path)
                                    <img src="{{ asset('storage/' . $team->logo_path) }}"
                                        class="h-20 w-20 rounded-xl object-cover border border-zinc-200 dark:border-zinc-800">
                                @else
                                    <div
                                        class="h-20 w-20 rounded-xl bg-zinc-100 dark:bg-black border border-zinc-200 dark:border-zinc-800 flex items-center justify-center text-red-600 font-black text-3xl">
                                        {{ substr($team->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h2
                                        class="text-2xl font-black uppercase text-zinc-900 dark:text-white leading-none mb-1">
                                        {{ $team->name }}</h2>
                                    <span
                                        class="text-[10px] font-black text-zinc-400 uppercase tracking-widest">{{ $team->division->name ?? 'Division I' }}</span>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="flex justify-between py-3 border-b border-zinc-100 dark:border-zinc-800">
                                    <span class="text-[10px] font-black text-zinc-500 uppercase">Head Coach</span>
                                    <span
                                        class="text-sm font-bold text-zinc-900 dark:text-zinc-200 italic">{{ $team->coach_name }}</span>
                                </div>
                                <div class="flex justify-between py-3 border-b border-zinc-100 dark:border-zinc-800">
                                    <span class="text-[10px] font-black text-zinc-500 uppercase">Active Status</span>
                                    <span
                                        class="text-[10px] font-black text-emerald-500 uppercase tracking-widest italic">Confirmed</span>
                                </div>
                            </div>

                            <p class="mt-6 text-xs text-zinc-500 leading-relaxed italic">
                                "{{ $team->bio }}"
                            </p>
                        </div>
                    </div>

                    <!-- CAPACITY CARD -->
                    <div
                        class="bg-zinc-900 text-white p-6 rounded-2xl border border-zinc-800 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-1">Roster Count
                            </p>
                            <p class="text-3xl font-black italic">{{ count($players) }} <span
                                    class="text-sm text-red-600">/ 15</span></p>
                        </div>
                        <svg class="w-10 h-10 text-zinc-800" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                    </div>
                </div>

                <!-- RIGHT COLUMN: ROSTER & MATCHES -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- UPCOMING FIXTURE (CLEAN) -->
                    <div
                        class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="h-12 w-12 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-zinc-400 uppercase tracking-widest">Next Scheduled
                                    Match</p>
                                @if ($nextMatch)
                                    @php
                                        // Identify if we are home or away to find the opponent
                                        $isHome = $nextMatch->home_team_id === $team->id;
                                        $opponent = $isHome ? $nextMatch->awayTeam : $nextMatch->homeTeam;
                                    @endphp
                                    <h3 class="text-lg font-black text-zinc-900 dark:text-white uppercase italic">
                                        vs. {{ $opponent->name }}
                                    </h3>
                                @else
                                    <h3 class="text-lg font-black text-zinc-500 uppercase italic">TBD / No Match
                                        Scheduled</h3>
                                @endif
                            </div>
                        </div>

                        @if ($nextMatch)
                            <div class="text-right">
                                <p class="text-sm font-bold text-zinc-900 dark:text-zinc-100 uppercase italic">
                                    {{ $nextMatch->date->format('M d, Y') }}
                                </p>
                                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">
                                    {{ $nextMatch->court->name ?? 'Main Court' }} •
                                    {{ $nextMatch->timeSlot?->start_time ?? 'TBD' }}
                                </p>
                            </div>
                        @endif
                    </div>


                    <!-- ROSTER LIST (SIMPLE TABLE) -->
                    <div
                        class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
                        <div class="p-6 border-b border-zinc-100 dark:border-zinc-800">
                            <h3
                                class="text-sm font-black uppercase tracking-[0.2em] text-zinc-900 dark:text-white italic">
                                Athlete Roster</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead
                                    class="bg-zinc-50 dark:bg-black/50 text-[10px] font-black text-zinc-400 uppercase tracking-widest border-b border-zinc-100 dark:border-zinc-800">
                                    <tr>
                                        <th class="px-6 py-4">Player</th>
                                        <th class="px-6 py-4">Position</th>
                                        <th class="px-6 py-4">Jersey</th>
                                        <th class="px-6 py-4 text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                    @forelse ($players as $player)
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                            <td class="px-6 py-4 flex items-center gap-3">
                                                <img src="{{ asset('storage/' . $player->photo_path) }}"
                                                    class="h-8 w-8 rounded-md object-cover border border-zinc-200 dark:border-zinc-700"
                                                    onerror="this.src='https://ui-avatars.com{{ urlencode($player->name) }}&color=71717a&background=18181b'">
                                                <span
                                                    class="text-sm font-bold text-zinc-900 dark:text-white">{{ $player->name }}</span>
                                            </td>
                                            <td
                                                class="px-6 py-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest">
                                                {{ $player->position }}</td>
                                            <td class="px-6 py-4 font-black italic text-red-600">
                                                #{{ $player->jersey_number }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <span
                                                    class="text-[10px] font-black text-emerald-500 uppercase tracking-widest italic">Active</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="px-6 py-12 text-center text-zinc-400 text-xs font-black uppercase tracking-widest">
                                                No athletes registered in this franchise</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="max-w-2xl mx-auto py-12">
            @livewire('team-manager.create-form')
        </div>
    @endif
</div>
