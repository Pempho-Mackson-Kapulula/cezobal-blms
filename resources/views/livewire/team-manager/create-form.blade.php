<div class="p-4 sm:p-8 bg-zinc-950 min-h-screen font-sans text-zinc-100">

    <div class="max-w-2xl mx-auto mb-10 border-l-8 border-red-600 pl-6 py-2">
        <h1 class="text-5xl font-black text-white tracking-tighter uppercase italic">
            Team <span class="text-red-600">Entry</span>
        </h1>
        <p class="text-zinc-500 mt-1 text-xs font-black uppercase tracking-[0.3em]">Official CEZOBAL Registration</p>
    </div>

    <div class="bg-zinc-900 rounded-3xl shadow-2xl border border-zinc-800/50 max-w-2xl mx-auto overflow-hidden relative">
        
        @if ($errors->any())
            <div class="bg-red-600 text-white p-4 text-xs font-black uppercase tracking-widest">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>w
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-500/10 border-b border-red-500/50 p-4 text-red-500 text-xs font-black uppercase tracking-widest">
                {{ session('error') }}
            </div>
        @endif

        <div class="p-8 sm:p-12">
            <form wire:submit.prevent="createTeam" class="space-y-8">

                <div class="group">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-red-500 mb-3 group-focus-within:text-white transition-colors">
                        01. Team Identity
                    </label>
                    <input type="text" wire:model="name" placeholder="E.G. LILONGWE GIANTS"
                        class="block w-full rounded-2xl border-2 border-zinc-800 bg-black text-white placeholder-zinc-800 focus:border-red-600 focus:ring-0 py-5 px-6 transition-all font-black text-xl uppercase italic tracking-tight">
                    @error('name') <span class="text-red-500 text-[11px] font-black uppercase mt-2 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-red-500 mb-3 group-focus-within:text-white transition-colors">
                            02. Head Coach
                        </label>
                        <input type="text" wire:model="coach_name" placeholder="COACH NAME"
                            class="block w-full rounded-2xl border-2 border-zinc-800 bg-black text-white focus:border-red-600 focus:ring-0 py-4 px-6 transition-all font-bold uppercase">
                    </div>

                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-red-500 mb-3 group-focus-within:text-white transition-colors">
                            03. Division
                        </label>
                        <div class="relative">
                            <select wire:model="division_id"
                                class="block w-full rounded-2xl border-2 border-zinc-800 bg-black text-white focus:border-red-600 focus:ring-0 py-4 px-6 transition-all font-bold appearance-none cursor-pointer uppercase">
                                <option value="">Select Tier</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-red-500">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-red-500 mb-3 group-focus-within:text-white transition-colors">
                        04. Team History / Bio
                    </label>
                    <textarea wire:model="bio" rows="3" placeholder="Brief history of the club..."
                        class="block w-full rounded-2xl border-2 border-zinc-800 bg-black text-white focus:border-red-600 focus:ring-0 py-4 px-6 transition-all font-medium"></textarea>
                </div>

                <div class="p-8 bg-black rounded-3xl border-2 border-zinc-800">
                    <div class="flex flex-col items-center text-center">
                        <div class="relative mb-6">
                            @if ($logo_path)
                                <img src="{{ $logo_path->temporaryUrl() }}" class="w-24 h-24 rounded-full object-cover border-4 border-red-600 shadow-xl">
                            @else
                                <div class="w-24 h-24 rounded-full bg-zinc-900 border-2 border-dashed border-zinc-700 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                            @endif
                            <div wire:loading wire:target="logo_path" class="absolute inset-0 bg-black/80 rounded-full flex items-center justify-center">
                                <div class="w-5 h-5 border-2 border-red-600 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </div>
                        
                        <input type="file" wire:model="logo_path" id="logo_path_input" class="hidden">
                        <button type="button" onclick="document.getElementById('logo_path_input').click()" 
                            class="bg-zinc-800 hover:bg-zinc-700 text-white text-[10px] font-black uppercase tracking-widest px-6 py-2 rounded-full transition-all">
                            Upload Insignia
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-zinc-800">
                    <button type="button" class="text-[10px] font-black uppercase text-zinc-600 hover:text-white transition-colors tracking-[0.2em]">
                        Discard Draft
                    </button>
                    
                    <button type="submit" wire:loading.attr="disabled"
                        class="py-5 px-12 rounded-2xl bg-red-600 hover:bg-red-500 text-white font-black uppercase tracking-[0.2em] text-sm shadow-[0_10px_40px_rgba(220,38,38,0.4)] transition-all active:scale-95 disabled:opacity-50">
                        <span wire:loading.remove wire:target="createTeam">Confirm Registration</span>
                        <span wire:loading wire:target="createTeam">Finalizing...</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
    
</div>