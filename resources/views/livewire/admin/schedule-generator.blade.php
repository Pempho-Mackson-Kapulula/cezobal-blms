<div class="p-8 space-y-6 bg-zinc-900 min-h-screen rounded-xl shadow-2xl">
    <h1 class="text-3xl font-extrabold text-red-500 border-b border-red-700/50 pb-2">
        Schedule Generator
    </h1>

    <select wire:model="selectedDivision"
        class="block w-full max-w-sm p-3 mt-1 rounded-lg border-zinc-600 bg-zinc-700 text-zinc-100 shadow-lg
               focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50 transition duration-150 ease-in-out cursor-pointer">
        <option value="" class="bg-zinc-800 text-zinc-300">-- Choose a Division --</option>
        @foreach ($divisions as $division)
            <option value="{{ $division->id }}" class="bg-zinc-800 text-zinc-100">{{ $division->name }}</option>
        @endforeach
    </select>


    <button wire:click="generateSchedule"
        class="px-6 py-3 text-lg font-semibold rounded-lg shadow-xl
               bg-red-600 hover:bg-red-700 text-white
               focus:outline-none focus:ring-4 focus:ring-red-500/50
               transition duration-200 ease-in-out transform hover:scale-[1.02] active:scale-[0.98]">
        Generate Schedule
    </button>

    @if ($message)
        @php
            // Determine colors based on message content
            $isError = str_starts_with($message, 'Error');
            $bgColor = $isError ? 'bg-red-900/50 border-red-600' : 'bg-green-900/50 border-green-600';
            $textColor = $isError ? 'text-red-400' : 'text-green-400';
        @endphp
        <div class="flex items-center space-x-3 p-4 mt-4 rounded-lg border {{ $bgColor }} {{ $textColor }} shadow-md">
            <p>{{ $message }}</p>
        </div>
    @endif
</div>