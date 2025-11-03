<div class="p-4 sm:p-6 lg:p-8 space-y-8 bg-zinc-950 min-h-screen text-zinc-100">

    <!-- Header Section -->
    <div class="border-b-4 border-red-600 pb-3">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-red-500 tracking-tight">
            Create a New Team
        </h1>
        <p class="text-zinc-400 mt-1 text-lg">Fill out the details below to register your team with CEZOBAL.</p>
    </div>

    <!-- Form Card (bg-zinc-900) -->
    <div class="bg-zinc-900 p-6 sm:p-8 rounded-xl shadow-2xl border border-zinc-800/80 max-w-xl mx-auto">

        <!-- Session Messages -->
        @if (session()->has('message'))
            <div class="p-4 bg-green-900/50 border border-green-500 text-green-300 rounded-xl shadow-md">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="p-4 bg-red-900/50 border border-red-500 text-red-300 rounded-xl shadow-md">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="createTeam" class="space-y-6 mt-4">

            <!-- Team Name Field -->
            <div>
                <label for="name" class="block text-sm font-semibold uppercase tracking-wider text-red-400 mb-2">
                    Team Name
                </label>
                <input type="text" wire:model="name" id="name" placeholder="E.g., The Blazers"
                    class="block w-full rounded-xl border-2 border-red-500/50 bg-zinc-800 text-zinc-100 shadow-lg
                           focus:border-red-500 focus:ring-4 focus:ring-red-500/30 transition duration-300 ease-in-out py-2.5 px-4 placeholder-zinc-500">
                @error('name')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Coach Name Field -->
            <div>
                <label for="coach_name" class="block text-sm font-semibold uppercase tracking-wider text-red-400 mb-2">
                    Coach Name
                </label>
                <input type="text" wire:model="coach_name" id="coach_name" placeholder="Enter Coach's Full Name"
                    class="block w-full rounded-xl border-2 border-red-500/50 bg-zinc-800 text-zinc-100 shadow-lg
                           focus:border-red-500 focus:ring-4 focus:ring-red-500/30 transition duration-300 ease-in-out py-2.5 px-4 placeholder-zinc-500">
                @error('coach_name')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Division Field -->
            <div>
                <label for="division" class="block text-sm font-semibold uppercase tracking-wider text-red-400 mb-2">
                    Division
                </label>
                <select wire:model="division_id" id="division"
                    class="block w-full rounded-xl border-2 border-red-500/50 bg-zinc-800 text-zinc-100 shadow-lg
                           focus:border-red-500 focus:ring-4 focus:ring-red-500/30 transition duration-300 ease-in-out py-2.5 px-4 appearance-none cursor-pointer">
                    <option value="" class="bg-zinc-700 text-zinc-300">-- Select Division --</option>
                    {{-- @foreach ($divisions as $division) --}}
                    <option value="1" class="bg-zinc-700">Division A (Mock)</option>
                    <option value="2" class="bg-zinc-700">Division B (Mock)</option>
                    {{-- @endforeach --}}
                </select>
                @error('division_id')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Team Bio Field -->
            <div>
                <label for="bio" class="block text-sm font-semibold uppercase tracking-wider text-red-400 mb-2">
                    Team Bio
                </label>
                <textarea wire:model="bio" id="bio" rows="4" placeholder="Briefly describe your team's history and goals..."
                    class="block w-full rounded-xl border-2 border-red-500/50 bg-zinc-800 text-zinc-100 shadow-lg
                           focus:border-red-500 focus:ring-4 focus:ring-red-500/30 transition duration-300 ease-in-out py-2.5 px-4 placeholder-zinc-500"></textarea>
                @error('bio')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Team Logo Field -->
            <div>
                <label for="logo_path" class="block text-sm font-semibold uppercase tracking-wider text-red-400 mb-2">
                    Team Logo
                </label>
                <input type="file" wire:model="logo_path" id="logo_path"
                    class="block w-full text-sm text-zinc-400
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-full file:border-0
                           file:text-sm file:font-semibold
                           file:bg-red-900/20 file:text-red-400
                           hover:file:bg-red-900/40 cursor-pointer">
                @error('logo_path')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Logo Preview (Mocked since we can't run Livewire methods here) -->
            {{-- @if ($logo_path) --}}
            {{-- Mocked Preview for demonstration --}}
            <div class="p-3 bg-zinc-800/50 rounded-lg border border-zinc-700" style="display: none;">
                <p class="text-sm text-red-400 font-medium">Logo Preview:</p>
                <img src="https://placehold.co/96x96/7f1d1d/f87171?text=Logo+Preview" alt="Team Logo Preview"
                    class="h-24 w-24 object-cover rounded-md mt-2 border-2 border-red-500/50">
            </div>
            {{-- @endif --}}

            <!-- Submit Button -->
            <div class="flex justify-end pt-4">
                <button type="submit"
                    class="py-3 px-6 rounded-xl text-lg font-bold bg-red-600 hover:bg-red-700 text-white shadow-xl shadow-red-900/50
                           transform hover:scale-[1.02] transition duration-300 ease-in-out uppercase tracking-wider focus:outline-none focus:ring-4 focus:ring-red-500/50">
                    Create Team
                    <!-- Icon for effect -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block ml-2 -mt-0.5"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd"
                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
