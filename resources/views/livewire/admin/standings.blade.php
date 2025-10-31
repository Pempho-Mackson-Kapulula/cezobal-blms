<div class="p-4 sm:p-6 lg:p-8 space-y-8 bg-zinc-950 min-h-screen text-zinc-100">

{{-- Main Page Title --}}
<div class="border-b-4 border-red-600 pb-3">
    <h1 class="text-4xl sm:text-5xl font-extrabold text-red-500 tracking-tight">
        {{ $divisions->firstWhere('id', $selectedDivision)?->name ?? 'League' }} Standings
    </h1>
    <p class="text-zinc-400 mt-1 text-lg">Current league table and division rankings, sorted by League Points.</p>
</div>

<!-- Division Selector Card -->
<div class="bg-zinc-900 p-5 rounded-xl shadow-2xl border border-zinc-800/80">
    <div class="flex flex-wrap items-center gap-6">
        <div>
            <label for="division-select" class="block text-sm font-semibold uppercase tracking-wider text-red-400 mb-1">
                Select Division
            </label>
            <select wire:model.live="selectedDivision"
                    id="division-select"
                    class="block w-full sm:w-64 rounded-xl border-2 border-red-500/50 bg-zinc-800 text-zinc-100 shadow-lg
                           focus:border-red-500 focus:ring-4 focus:ring-red-500/30 transition duration-300 ease-in-out py-2 px-3">
                @foreach($divisions as $division)
                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<!-- Standings Table Container -->
<div class="mt-8">
    <h2 class="text-2xl font-bold text-zinc-200 mb-4 border-l-4 border-red-600 pl-3">League Table</h2>

    <div class="overflow-x-auto rounded-xl shadow-2xl border border-zinc-800/80">
        
        @if(count($standings) > 0)
        <table class="min-w-full table-auto text-sm text-zinc-100 divide-y divide-zinc-800/50">
            {{-- Table Header --}}
            <thead class="bg-zinc-800 sticky top-0 z-10">
                <tr>
                    <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-red-400">Rank</th>
                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-500">Team</th>
                    <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-red-400">GP</th>
                    <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-red-400">W</th>
                    <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-red-400">L</th>
                    <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-red-400">PF</th>
                    <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-red-400">PA</th>
                    <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-red-400">Diff</th>
                    <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-red-500">Points</th>
                </tr>
            </thead>

            {{-- Table Body --}}
            <tbody class="bg-zinc-900 divide-y divide-zinc-800/50">
                @foreach($standings as $index => $team)
                @php
                    // Highlight top 2 teams with a red accent background
                    $isTopTeam = $index < 2;
                    // Use alternating rows for the rest, and stronger accent for top teams
                    $rowClass = $isTopTeam ? 'bg-red-900/20 hover:bg-red-900/30 font-bold' : 'odd:bg-zinc-900 even:bg-zinc-800/50 hover:bg-zinc-800';
                    $rankClass = $isTopTeam ? 'text-red-400 font-extrabold' : 'text-zinc-300 font-bold';
                    $teamNameClass = $isTopTeam ? 'text-red-300 font-extrabold' : 'text-white font-bold';
                @endphp
                <tr class="transition duration-300 ease-in-out {{ $rowClass }}">
                    {{-- Rank --}}
                    <td class="px-5 py-3 text-center text-lg {{ $rankClass }}">
                        {{ $index + 1 }}
                    </td>
                    {{-- Team Name --}}
                    <td class="px-5 py-3 text-left tracking-wide {{ $teamNameClass }}">
                        {{ $team['team'] }}
                    </td>
                    {{-- Other Stats --}}
                    <td class="px-5 py-3 text-center text-zinc-300">{{ $team['played'] }}</td>
                    <td class="px-5 py-3 text-center font-semibold text-green-400">{{ $team['wins'] }}</td>
                    <td class="px-5 py-3 text-center font-semibold text-red-400">{{ $team['losses'] }}</td>
                    <td class="px-5 py-3 text-center">{{ $team['points_for'] }}</td>
                    <td class="px-5 py-3 text-center">{{ $team['points_against'] }}</td>
                    {{-- Point Differential --}}
                    <td class="px-5 py-3 text-center font-medium {{ $team['point_diff'] > 0 ? 'text-green-300' : ($team['point_diff'] < 0 ? 'text-red-300' : 'text-zinc-400') }}">
                        {{ $team['point_diff'] > 0 ? '+' : '' }}{{ $team['point_diff'] }}
                    </td>
                    {{-- League Points --}}
                    <td class="px-5 py-3 text-center font-extrabold text-xl text-red-400 bg-zinc-800/50">
                        {{ $team['league_points'] }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="text-center text-zinc-500 py-12 bg-zinc-900 rounded-xl">
                <svg class="mx-auto h-12 w-12 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <h3 class="mt-2 text-lg font-medium text-zinc-300">No Teams Found</h3>
                <p class="mt-1 text-sm text-zinc-500">
                    Please select a division or ensure teams have been added and completed games have been recorded.
                </p>
            </div>
        @endif
    </div>
</div>


</div>