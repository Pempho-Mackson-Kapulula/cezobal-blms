<div class="p-8 space-y-4 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Create a New Team</h1>
    <p class="text-gray-600 dark:text-gray-400">Fill out the details below to register your team with CEZOBAL.</p>

    <form wire:submit.prevent="createTeam" class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Team Name</label>
            <input type="text" wire:model="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-600 focus:ring-red-600 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-200">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="coach_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Coach Name</label>
            <input type="text" wire:model="coach_name" id="coach_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-600 focus:ring-red-600 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-200">
            @error('coach_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="division" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Division</label>
            <select wire:model="division_id" id="division" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-600 focus:ring-red-600 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-200">
                <option value="">Select Division</option>
                @foreach ($this->divisions as $division)
                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                @endforeach
            </select>
            @error('division_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Team Bio</label>
            <textarea wire:model="bio" id="bio" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-600 focus:ring-red-600 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-200"></textarea>
            @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="logo_path" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Team Logo</label>
            <input type="file" wire:model="logo_path" id="logo_path" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-red-50 file:text-red-600 hover:file:bg-red-100 dark:file:bg-zinc-700 dark:file:text-red-400">
            @error('logo_path') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        @if ($logo_path)
            <div class="mt-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">Logo Preview:</p>
                <img src="{{ $logo_path->temporaryUrl() }}" alt="Team Logo Preview" class="mt-2 h-24 w-24 object-cover rounded-md">
            </div>
        @endif
        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 disabled:opacity-25 transition">
                Create Team
            </button>
        </div>
    </form>
</div>
