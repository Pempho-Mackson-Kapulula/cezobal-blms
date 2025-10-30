<div class="p-6 bg-zinc-900 text-white rounded-xl shadow-xl max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Edit Fixture</h1>

    @if (session()->has('success'))
        <div class="bg-green-600 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="updateFixture" class="space-y-5">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-sm text-gray-400">Home Team</label>
                <p class="text-lg font-semibold">{{ $home_team }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-400">Away Team</label>
                <p class="text-lg font-semibold">{{ $away_team }}</p>
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-400">Match Date</label>
            <input type="date" wire:model="match_date"
                class="w-full bg-zinc-800 border border-zinc-700 rounded-lg p-3 text-white">
            @error('match_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-400">Match Time</label>
            <input type="time" wire:model="match_time"
                class="w-full bg-zinc-800 border border-zinc-700 rounded-lg p-3 text-white">
            @error('match_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-400">Court</label>
            <select wire:model="court_id"
                class="w-full bg-zinc-800 border border-zinc-700 rounded-lg p-3 text-white">
                <option value="">Select Court</option>
                @foreach($courts as $court)
                    <option value="{{ $court->id }}">{{ $court->name }}</option>
                @endforeach
            </select>
            @error('court_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-400">Scorekeeper</label>
            <select wire:model="scorekeeper_id"
                class="w-full bg-zinc-800 border border-zinc-700 rounded-lg p-3 text-white">
                <option value="">Select Scorekeeper</option>
                @foreach($scorekeepers as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-400">Statistician</label>
            <select wire:model="statistician_id"
                class="w-full bg-zinc-800 border border-zinc-700 rounded-lg p-3 text-white">
                <option value="">Select Statistician</option>
                @foreach($statisticians as $stat)
                    <option value="{{ $stat->id }}">{{ $stat->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit"
            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            Update Fixture
        </button>
    </form>
</div>
