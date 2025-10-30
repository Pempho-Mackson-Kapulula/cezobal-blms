<div x-data @team-created="$wire.refreshTeam()">
    @if (session()->has('error'))
        <div class="p-3 text-red-800 bg-red-100 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('message'))
        <div class="p-3 text-green-800 bg-green-100 rounded-md">
            {{ session('message') }}
        </div>
    @endif

    @if ($team)
        {{-- Display the new team dashboard structure --}}
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-6 md:p-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">Team Dashboard</h1>

            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                {{-- Team Details Card --}}
                <div
                    class="relative overflow-hidden rounded-xl bg-white border border-neutral-200 shadow-md dark:bg-zinc-800 dark:border-zinc-700 p-6 flex flex-col items-center text-center">
                    @if ($team->logo_path)
                        <img src="{{ asset('storage/' . $team->logo_path) }}" alt="Team Logo"
                            class="h-24 w-24 rounded-full object-cover ring-4 ring-red-600 mb-4">
                    @else
                        <div
                            class="h-24 w-24 rounded-full flex items-center justify-center bg-red-600 text-white font-bold text-4xl mb-4 ring-4 ring-red-600">
                            {{ substr($team->name, 0, 1) }}
                        </div>
                    @endif
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $team->name }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Coach: {{ $team->coach_name }}</p>
                    <div class="mt-4 w-full text-left">
                        <p class="text-gray-600 dark:text-gray-400">
                            **Division:** {{ $team->division->name }}
                        </p>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 italic leading-snug">
                            "{{ $team->bio }}"
                        </p>
                    </div>
                </div>

                {{-- Player Management Card --}}
                <div
                    class="relative overflow-hidden rounded-xl bg-white border border-neutral-200 shadow-md dark:bg-zinc-800 dark:border-zinc-700 p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Player Management</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Add, view, and manage your team's
                            players from here.</p>
                        <p class="text-4xl font-extrabold text-red-600">{{ count($players) }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Players</p>
                    </div>
                    <div class="mt-auto pt-4 border-t border-neutral-200 dark:border-zinc-700">
                        <a href="{{ route('team-manager.create-player', ['teamId' => $team->id]) }}" wire:navigate
                            class="inline-flex w-full justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 transition">
                            Add Player
                        </a>
                    </div>
                </div>

                {{-- Dummy Card 2: Upcoming Match --}}
                <div
                    class="relative overflow-hidden rounded-xl bg-white border border-neutral-200 shadow-md dark:bg-zinc-800 dark:border-zinc-700 p-6 flex flex-col justify-center items-center">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Upcoming Match</h3>
                    <div class="flex flex-col items-center text-center space-y-2">
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">vs. **Rival Squad**</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">**Date:** November 15, 2025</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">**Location:** Main Stadium</p>
                    </div>
                </div>
            </div>

            {{-- Main Content Area: Player Roster --}}
            <div
                class="relative h-full flex-1 overflow-hidden rounded-xl bg-white border border-neutral-200 shadow-md dark:bg-zinc-800 dark:border-zinc-700 p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Player Roster</h3>
                <ul class="space-y-4">
                    @forelse ($players as $player)
                        <li class="flex items-center space-x-4">
                            <img src="{{ asset('storage/' . $player->photo_path) }}" alt="{{ $player->name }}'s Photo"
                                class="h-10 w-10 rounded-full object-cover"
                                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($player->name) }}&color=FFFFFF&background=EF4444'">
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $player->name }} -
                                #{{ $player->jersey_number }} ({{ $player->position }})</span>
                        </li>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">No players have been added to this team yet.</p>
                    @endforelse
                </ul>
            </div>
        </div>
    @else
        @livewire('team-manager.create-form')
    @endif
</div>
