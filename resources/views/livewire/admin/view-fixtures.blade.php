<div class="p-4 sm:p-6 lg:p-8 space-y-8 bg-zinc-950 min-h-screen text-zinc-100">

    <div class="border-b-4 border-red-600 pb-3">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-red-500 tracking-tight">
            Fixtures
        </h1>
        <p class="text-zinc-400 mt-1 text-lg">View and manage upcoming games for your selected division.</p>
    </div>

    <div class="bg-zinc-900 p-5 rounded-xl shadow-2xl border border-zinc-800/80">
        <div class="flex flex-wrap items-center gap-6">
            <div>
                <label for="division" class="block text-sm font-semibold uppercase tracking-wider text-red-400 mb-1">
                    Select Division
                </label>
                <select id="division" wire:model.live="selectedDivision"
                    class="block w-full sm:w-64 rounded-xl border-2 border-red-500/50 bg-zinc-800 text-zinc-100 shadow-lg
                           focus:border-red-500 focus:ring-4 focus:ring-red-500/30 transition duration-300 ease-in-out py-2 px-3">
                    <option value="">-- All Divisions --</option> @foreach ($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-bold text-zinc-200 mb-4 border-l-4 border-zinc-700 pl-3">Upcoming Games</h2>

        <div class="overflow-x-auto rounded-xl shadow-2xl border border-zinc-800/80">
            @if (isset($games) && $games->count() > 0)
                <table class="min-w-full divide-y divide-zinc-700/50">
                    
                    <thead class="bg-zinc-800 sticky top-0 z-10">
                        <tr>
                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-400">Date
                            </th>
                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-500">Home
                            </th>
                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-500">Away
                            </th>
                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-400">
                                Court</th>
                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-400">Time
                            </th>
                            <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-400 hidden lg:table-cell">
                                Scorekeeper</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-400 hidden lg:table-cell">
                                Statistician</th>
                            <th class="px-5 py-4"></th>
                        </tr>
                    </thead>
                    
                    <tbody class="bg-zinc-900 divide-y divide-zinc-800/50">
                        @foreach ($games as $game)
                            <tr class="transition duration-300 ease-in-out hover:bg-zinc-800">
                                <td class="px-5 py-3 whitespace-nowrap text-sm text-zinc-300 font-medium">
                                    {{ \Carbon\Carbon::parse($game->date)->format('D, M d') }}
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap text-base text-red-300 font-extrabold">
                                    {{ $game->homeTeam?->name ?? 'TBD' }}
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap text-base text-red-300 font-extrabold">
                                    {{ $game->awayTeam?->name ?? 'TBD' }}
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap text-sm text-zinc-300">
                                    {{ $game->court?->name ?? 'TBD' }}
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap text-sm text-zinc-300 font-mono">
                                    @if ($game->timeSlot)
                                        <span class="bg-zinc-800/50 px-2 py-1 rounded-md text-red-300 border border-red-500/20">
                                            {{ \Carbon\Carbon::parse($game->timeSlot->start_time)->format('h:i A') }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td class="px-5 py-3 whitespace-nowrap text-sm text-zinc-400 hidden lg:table-cell">
                                    {{ $game->scorekeeper?->name ?? 'N/A' }}
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap text-sm text-zinc-400 hidden lg:table-cell">
                                    {{ $game->statistician?->name ?? 'N/A' }}
                                </td>
                                
                                <td class="px-5 py-3 text-right whitespace-nowrap">
                                    <button wire:click="editFixture({{ $game->id }})"
                                        class="text-red-400 hover:text-red-300 font-bold text-sm bg-red-900/20 hover:bg-red-900/40 rounded-full px-4 py-1 transition duration-200 ease-in-out shadow-md">
                                         Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center text-zinc-500 py-12 bg-zinc-900 rounded-xl">
                    <svg class="mx-auto h-12 w-12 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <h3 class="mt-2 text-lg font-medium text-zinc-300">No Fixtures Found</h3>
                    <p class="mt-1 text-sm text-zinc-500">
                        {{ $message ?? 'Please select a division or check if games have been scheduled.' }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>