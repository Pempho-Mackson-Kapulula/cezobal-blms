<div class="space-y-8">
    <header class="border-b border-zinc-800 pb-4">
        <h1 class="text-3xl font-black uppercase text-white tracking-tighter">Teams Directory</h1>
        
        {{-- Division Filter --}}
        <div class="mt-4 flex gap-2 overflow-x-auto pb-2">
            <button wire:click="$set('selectedDivision', '')" 
                class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest transition {{ $selectedDivision === '' ? 'bg-red-600 text-white' : 'bg-zinc-800 text-zinc-400' }}">
                All Divisions
            </button>
            @foreach($divisions as $division)
                <button wire:click="$set('selectedDivision', {{ $division->id }})" 
                    class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest transition {{ $selectedDivision == $division->id ? 'bg-red-600 text-white' : 'bg-zinc-800 text-zinc-400' }}">
                    {{ $division->name }}
                </button>
            @endforeach
        </div>
    </header>

    {{-- Teams Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @forelse($teams as $team)
            <a href="{{ route('public-team-show', $team->id) }}" 
                class="group bg-zinc-900 border border-zinc-800 p-6 rounded-2xl hover:border-red-600/50 transition-all shadow-xl">
                <div class="flex flex-col items-center text-center space-y-4">
                    {{-- Placeholder for Logo --}}
                    <div class="w-20 h-20 bg-zinc-800 rounded-full flex items-center justify-center text-2xl font-black text-zinc-700 group-hover:bg-red-600 group-hover:text-white transition">
                        {{ substr($team->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-black text-lg text-white group-hover:text-red-500 transition">{{ $team->name }}</h3>
                        <p class="text-[10px] text-zinc-500 uppercase font-bold tracking-widest">{{ $team->division->name ?? 'No Division' }}</p>
                    </div>
                </div>
            </a>
        @empty
            <p class="text-zinc-500 col-span-full py-12 text-center italic">No teams found in this division.</p>
        @endforelse
    </div>
</div>
