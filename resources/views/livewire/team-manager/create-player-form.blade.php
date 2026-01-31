<div class="p-4 sm:p-8 bg-zinc-950 min-h-screen font-sans text-zinc-100">
    <div class="max-w-2xl mx-auto mb-10 border-b-4 border-red-600 pb-6 flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-black uppercase tracking-tighter italic">ADD <span
                    class="text-red-600">ATHLETE</span></h1>
            <p class="text-zinc-500 text-xs font-black uppercase tracking-[0.3em] mt-1">Roster Expansion</p>
        </div>
        <a href="{{ route('team-manager.dashboard') }}" wire:navigate
            class="text-[10px] font-black uppercase tracking-widest text-zinc-500 hover:text-white transition-colors">
            Back to Court
        </a>
    </div>

    <div class="max-w-2xl mx-auto mb-8 p-4 bg-black rounded-2xl border border-zinc-800">
        <div class="flex justify-between items-center mb-2">
            <span class="text-[10px] font-black uppercase tracking-widest text-zinc-500">Roster Capacity</span>
            <span
                class="text-[10px] font-black uppercase tracking-widest {{ $currentCount >= 15 ? 'text-red-600' : 'text-emerald-500' }}">
                {{ $currentCount }} / 15 Slots Used
            </span>
        </div>
        <div class="w-full bg-zinc-900 h-1.5 rounded-full overflow-hidden">
            <div class="bg-red-600 h-full transition-all duration-500" style="width: {{ ($currentCount / 15) * 100 }}%">
            </div>
        </div>
    </div>

    <div class="bg-zinc-900 rounded-3xl border border-zinc-800 shadow-2xl max-w-2xl mx-auto overflow-hidden">
        <div class="p-8 sm:p-12">
            @if ($currentCount < 15)
                <form wire:submit.prevent="createPlayer" class="space-y-8">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-red-500 ml-1">Full
                            Legal Name</label>
                        <input type="text" wire:model="name" placeholder="E.G. MADALITSO PHIRI"
                            class="block w-full rounded-2xl border-2 border-zinc-800 bg-black text-white placeholder-zinc-800 focus:border-red-600 focus:ring-0 py-5 px-6 font-black text-xl uppercase italic tracking-tight transition-all">
                        @error('name')
                            <span
                                class="text-red-500 text-[10px] font-black uppercase mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label
                                class="block text-[10px] font-black uppercase tracking-[0.2em] text-red-500 ml-1">On-Court
                                Position</label>
                            <div class="relative">
                                <select wire:model="position"
                                    class="block w-full rounded-2xl border-2 border-zinc-800 bg-black text-white focus:border-red-600 focus:ring-0 py-4 px-6 font-bold uppercase appearance-none cursor-pointer">
                                    <option value="">Select Position</option>
                                    <option value="Point Guard">Point Guard</option>
                                    <option value="Shooting Guard">Shooting Guard</option>
                                    <option value="Small Forward">Small Forward</option>
                                    <option value="Power Forward">Power Forward</option>
                                    <option value="Center">Center</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-red-500">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </div>
                            </div>
                            @error('position')
                                <span
                                    class="text-red-500 text-[10px] font-black uppercase mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label
                                class="block text-[10px] font-black uppercase tracking-[0.2em] text-red-500 ml-1">Jersey
                                Number</label>
                            <input type="number" wire:model="jersey_number" placeholder="00"
                                class="block w-full rounded-2xl border-2 border-zinc-800 bg-black text-white placeholder-zinc-800 focus:border-red-600 focus:ring-0 py-4 px-6 font-black text-xl">
                            @error('jersey_number')
                                <span
                                    class="text-red-500 text-[10px] font-black uppercase mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-red-500 ml-1">Date of
                            Birth</label>
                        <input type="date" wire:model="date_of_birth"
                            class="block w-full rounded-2xl border-2 border-zinc-800 bg-black text-white focus:border-red-600 focus:ring-0 py-4 px-6 font-bold uppercase">
                        @error('date_of_birth')
                            <span
                                class="text-red-500 text-[10px] font-black uppercase mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-red-500 ml-1">Player
                            Biography / Notes</label>
                        <textarea wire:model="bio" rows="4" placeholder="Brief summary of the player's history..."
                            class="block w-full rounded-2xl border-2 border-zinc-800 bg-black text-white placeholder-zinc-800 focus:border-red-600 focus:ring-0 py-4 px-6 font-medium text-sm transition-all"></textarea>
                        @error('bio')
                            <span
                                class="text-red-500 text-[10px] font-black uppercase mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="p-8 bg-black rounded-3xl border-2 border-zinc-800">
                        <div class="flex flex-col items-center text-center">
                            <div class="relative mb-6">
                                @if ($photo_path)
                                    <img src="{{ $player->photo_path ? asset('storage/' . $player->photo_path) : 'https://ui-avatars.com' . urlencode($player->name) . '&background=18181b&color=ef4444' }}"
                                        class="h-full w-full object-cover">

                                    <div
                                        class="w-32 h-32 rounded-2xl bg-zinc-900 border-2 border-dashed border-zinc-700 flex flex-col items-center justify-center text-zinc-700">
                                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="text-[8px] font-black uppercase tracking-widest">No Photo</span>
                                    </div>
                                @endif
                                <div wire:loading wire:target="photo_path"
                                    class="absolute inset-0 bg-black/80 rounded-2xl flex items-center justify-center">
                                    <div
                                        class="w-6 h-6 border-2 border-red-600 border-t-transparent rounded-full animate-spin">
                                    </div>
                                </div>
                            </div>
                            <input type="file" wire:model="photo_path" id="photo_input" class="hidden"
                                accept="image/*">
                            <button type="button" onclick="document.getElementById('photo_input').click()"
                                class="bg-red-600/10 hover:bg-red-600 hover:text-white text-red-500 text-[10px] font-black uppercase tracking-widest px-8 py-3 rounded-xl transition-all border border-red-600/50">
                                Upload Headshot
                            </button>
                        </div>
                        @error('photo_path')
                            <span
                                class="text-red-500 text-[10px] font-black uppercase mt-3 text-center block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full py-5 rounded-2xl bg-red-600 hover:bg-red-500 text-white font-black uppercase tracking-[0.2em] text-sm shadow-[0_10px_40px_rgba(220,38,38,0.3)] transition-all active:scale-95 flex items-center justify-center gap-3">
                            <span wire:loading.remove wire:target="createPlayer">Enlist Player</span>
                            <span wire:loading wire:target="createPlayer">Enlisting Athlete...</span>
                        </button>
                    </div>
                </form>
            @else
                <div class="p-12 text-center">
                    <h3 class="text-xl font-black text-red-500 uppercase mb-4">Roster Full</h3>
                    <p class="text-zinc-400">You have reached the maximum of 15 players per roster for the 2026 season.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
