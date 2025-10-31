<div class="p-6 bg-zinc-900 text-zinc-100 rounded-xl shadow-2xl max-w-3xl mx-auto border border-zinc-800/80">
    <h1 class="text-3xl font-extrabold mb-6 text-red-500 border-l-4 border-red-600 pl-3">
        Edit Fixture
    </h1>

    @if (session()->has('success'))
        <div class="bg-green-700/50 text-green-300 p-4 rounded-xl mb-6 font-medium border border-green-600/50">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="updateFixture" class="space-y-6">
        <div class="grid grid-cols-2 gap-6 bg-zinc-800 p-4 rounded-lg border border-zinc-700/50">
            <div>
                <label class="block text-sm font-semibold uppercase tracking-wider text-red-400 mb-1">Home Team</label>
                <p class="text-xl font-extrabold text-red-300">{{ $home_team }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold uppercase tracking-wider text-red-400 mb-1">Away Team</label>
                <p class="text-xl font-extrabold text-red-300">{{ $away_team }}</p>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-5">

            <div>
                <label class="block text-sm font-semibold uppercase tracking-wider text-zinc-400 mb-2">Match
                    Date</label>
                <input type="date" wire:model="match_date"
                    class="w-full rounded-xl border-2 border-zinc-700 bg-zinc-800 text-zinc-100 shadow-lg py-3 px-4
                           focus:border-red-500 focus:ring-4 focus:ring-red-500/30 transition duration-300 ease-in-out">
                @error('match_date')
                    <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror

            </div>

            <div>
                <label class="block text-sm font-semibold uppercase tracking-wider text-zinc-400 mb-2">Match
                    Time</label>
                <select wire:model="match_time"
                    class="w-full rounded-xl border-2 border-zinc-700 bg-zinc-800 text-zinc-100 shadow-lg py-3 px-4
                           focus:border-red-500 focus:ring-4 focus:ring-red-500/30 transition duration-300 ease-in-out">
                    <option value="">Select Time Slot</option>
                    @foreach ($timeSlots as $slot)
                        <option value="{{ $slot->id }}">
                            {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}
                            -
                            {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                        </option>
                    @endforeach
                </select>
                @error('match_time')
                    <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror

            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold uppercase tracking-wider text-zinc-400 mb-2">Court</label>
            <select wire:model="court_id"
                class="w-full rounded-xl border-2 border-zinc-700 bg-zinc-800 text-zinc-100 shadow-lg py-3 px-4
                           focus:border-red-500 focus:ring-4 focus:ring-red-500/30 transition duration-300 ease-in-out">
                <option value="">Select Court</option>
                @foreach ($courts as $court)
                    <option value="{{ $court->id }}">{{ $court->name }}</option>
                @endforeach
            </select>
            @error('court_id')
                <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span>
            @enderror

        </div>

        <div class="grid sm:grid-cols-2 gap-5">
            <div>
                <label
                    class="block text-sm font-semibold uppercase tracking-wider text-zinc-400 mb-2">Scorekeeper</label>
                <select wire:model="scorekeeper_id"
                    class="w-full rounded-xl border-2 border-zinc-700 bg-zinc-800 text-zinc-100 shadow-lg py-3 px-4
                           focus:border-red-500 focus:ring-4 focus:ring-red-500/30 transition duration-300 ease-in-out">
                    <option value="">Select Scorekeeper</option>
                    @foreach ($scorekeepers as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label
                    class="block text-sm font-semibold uppercase tracking-wider text-zinc-400 mb-2">Statistician</label>
                <select wire:model="statistician_id"
                    class="w-full rounded-xl border-2 border-zinc-700 bg-zinc-800 text-zinc-100 shadow-lg py-3 px-4
                           focus:border-red-500 focus:ring-4 focus:ring-red-500/30 transition duration-300 ease-in-out">
                    <option value="">Select Statistician</option>
                    @foreach ($statisticians as $stat)
                        <option value="{{ $stat->id }}">{{ $stat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit"
            class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-bold uppercase tracking-wider transition duration-200 ease-in-out shadow-lg transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-red-500/50">
            Save Changes
        </button>
    </form>
</div>
