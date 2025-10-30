<div class="p-8 space-y-4 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Add New Player</h1>
    <p class="text-gray-600 dark:text-gray-400">Fill out the details below to add a new player to your roster.</p>

    <form wire:submit.prevent="createPlayer" class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Player Name</label>
            <input type="text" wire:model="name" id="name"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-600 focus:ring-red-600 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-200">
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
            <select wire:model="position" id="position"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-600 focus:ring-red-600 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-200">
                <option value="">Select Position</option>
                <option value="Point Guard">Point Guard</option>
                <option value="Shooting Guard">Shooting Guard</option>
                <option value="Small Forward">Small Forward</option>
                <option value="Power Forward">Power Forward</option>
                <option value="Center">Center</option>
            </select>
            @error('position')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="jersey_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jersey
                Number</label>
            <input type="number" wire:model="jersey_number" id="jersey_number" min="0"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-600 focus:ring-red-600 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-200">
            @error('jersey_number')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>


        <div>
            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of
                Birth</label>
            <input type="date" wire:model="date_of_birth" id="date_of_birth"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-600 focus:ring-red-600 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-200">
            @error('date_of_birth')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="photo_path" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Player
                Photo</label>
            <input type="file" wire:model="photo_path" id="photo_path"
                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-red-50 file:text-red-600 hover:file:bg-red-100 dark:file:bg-zinc-700 dark:file:text-red-400">
            @error('photo_path')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        @if ($photo_path)
            <div class="mt-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">Photo Preview:</p>
                <img src="{{ $photo_path->temporaryUrl() }}" alt="Player Photo Preview"
                    class="mt-2 h-24 w-24 object-cover rounded-md">
            </div>
        @endif

        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 disabled:opacity-25 transition">
                Create Player
            </button>
        </div>
    </form>
</div>
