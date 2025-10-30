<div class="p-6 space-y-6 bg-zinc-900 min-h-screen">
    <h1 class="text-3xl font-extrabold text-red-500">
        Fixtures
    </h1>

    <div class="flex flex-wrap items-center gap-4 p-4 rounded-lg bg-zinc-800 shadow-xl">
        <div>
            <label for="division" class="block text-sm font-medium text-zinc-300">
                Select Division
            </label>
            <select id="division" wire:model.live="selectedDivision"
                class="mt-1 block w-64 rounded-lg border-zinc-600 bg-zinc-700 text-zinc-100 shadow-sm
                       focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50 transition duration-150 ease-in-out">
                @foreach ($divisions as $division)
                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="overflow-x-auto mt-6 rounded-lg shadow-xl border border-zinc-700">
        @if ($games && $games->count() > 0)
            <table class="min-w-full divide-y divide-zinc-700">
                <thead class="bg-zinc-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-red-400">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-red-400">Home</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-red-400">Away</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-red-400">Court</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-red-400">Time</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-red-400">Scorekeeper</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-red-400">Statistician</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-zinc-800 divide-y divide-zinc-700">
                    @foreach ($games as $game)
                        <tr
                            class="transition duration-200 ease-in-out hover:bg-zinc-700/70">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-200">
                                {{ \Carbon\Carbon::parse($game->date)->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-200 font-medium">
                                {{ $game->homeTeam?->name ?? 'TBD' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-200 font-medium">
                                {{ $game->awayTeam?->name ?? 'TBD' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-200">
                                {{ $game->court?->name ?? 'TBD' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-200">
                                {{ $game->timeSlot?->start_time ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-300">
                                {{ $game->scorekeeper?->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-300">
                                {{ $game->statistician?->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <button wire:click="editFixture({{ $game->id }})"
                                    class="text-red-500 hover:text-red-400 font-semibold text-sm transition duration-150 ease-in-out">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center text-zinc-500 py-8 bg-zinc-800 rounded-lg">
                {{ $message }}
            </div>
        @endif
    </div>
</div>