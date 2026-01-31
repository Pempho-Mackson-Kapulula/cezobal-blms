<div class="p-4 sm:p-8 bg-zinc-950 min-h-screen font-sans text-zinc-100">
    
    <div class="max-w-6xl mx-auto mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4 border-b-2 border-zinc-900 pb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-red-600 text-[10px] font-black uppercase tracking-widest rounded-full">Admin Tools</span>
                <div class="h-1 w-12 bg-zinc-800 rounded-full"></div>
            </div>
            <h1 class="text-5xl font-black uppercase tracking-tighter italic">SCHEDULE <span class="text-red-600">GENERATOR</span></h1>
            <p class="text-zinc-500 text-xs font-black uppercase tracking-[0.4em] mt-2">Automated Round-Robin Engine</p>
        </div>
        
        <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-2xl flex items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                </div>
                <div>
                    <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest leading-none">System Status</p>
                    <p class="text-sm font-black text-white uppercase tracking-tight">Ready for Deployment</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-4">
            <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl sticky top-8">
                <div class="bg-zinc-800/50 px-6 py-5 border-b border-zinc-700">
                    <h2 class="text-xs font-black uppercase tracking-[0.2em] text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Generator Settings
                    </h2>
                </div>

                <div class="p-6 sm:p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-red-500 ml-1">Target Division</label>
                        <select wire:model.live="selectedDivision" class="w-full rounded-xl border-2 border-zinc-800 bg-black text-white py-4 px-4 text-xs font-black uppercase focus:border-red-600 focus:ring-0 cursor-pointer transition-all">
                            <option value="">Choose Division...</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button wire:click="generateSchedule" wire:loading.attr="disabled" 
                        class="w-full py-5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-black uppercase tracking-widest text-sm shadow-xl shadow-red-900/40 transition-all active:scale-95 group relative overflow-hidden">
                        <span wire:loading.remove wire:target="generateSchedule" class="flex items-center justify-center gap-3 relative z-10">
                            Generate Fixtures
                            <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </span>
                        <span wire:loading wire:target="generateSchedule" class="flex items-center justify-center gap-3 relative z-10">
                            <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                            Calculating...
                        </span>
                    </button>

                    <div class="p-4 bg-black border border-zinc-800 rounded-2xl">
                        <p class="text-[9px] text-zinc-600 font-bold uppercase tracking-widest leading-relaxed">
                            <span class="text-red-600">Note:</span> Generating a new schedule will overwrite any existing unpublished fixtures for the selected division.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="bg-zinc-900 rounded-3xl border border-zinc-800 p-6 sm:p-10 shadow-2xl min-h-[400px] flex flex-col items-center justify-center text-center relative overflow-hidden">
                
                <div class="absolute inset-0 opacity-[0.03] pointer-events-none">
                    <svg class="w-full h-full" fill="currentColor" viewBox="0 0 100 100">
                        <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                        </pattern>
                        <rect width="100%" height="100%" fill="url(#grid)" />
                    </svg>
                </div>

                @if ($message)
                    @php $isError = str_contains($message, '⚠') || str_contains($message, 'Error'); @endphp
                    
                    <div class="relative z-10 space-y-6 max-w-sm animate-in zoom-in duration-300">
                        <div class="w-24 h-24 rounded-full mx-auto flex items-center justify-center border-4 {{ $isError ? 'border-red-600 text-red-600' : 'border-emerald-500 text-emerald-500' }} shadow-[0_0_30px_rgba(0,0,0,0.5)]">
                            @if($isError)
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            @else
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </div>
                        
                        <div>
                            <h3 class="text-2xl font-black uppercase italic tracking-tighter {{ $isError ? 'text-red-500' : 'text-emerald-500' }}">
                                {{ $isError ? 'Action Blocked' : 'Engine Success' }}
                            </h3>
                            <p class="text-zinc-500 text-xs font-black uppercase tracking-widest mt-2 leading-relaxed">
                                {{ $message }}
                            </p>
                        </div>

                        @if(!$isError)
                            <a href="{{ route('admin.view-fixtures') }}" class="inline-block px-8 py-3 bg-zinc-100 text-black text-[10px] font-black uppercase tracking-widest rounded-lg hover:bg-emerald-500 transition-colors">
                                View Fixtures
                            </a>
                        @endif
                    </div>
                @else
                    <div class="relative z-10 text-zinc-800">
                        <div class="mb-6 relative">
                            <svg class="w-32 h-32 mx-auto opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-12 h-1 border-b-2 border-zinc-800 animate-pulse"></div>
                            </div>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-[0.5em] text-zinc-700">Awaiting Division Selection</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .animate-in {
            animation: fadeInZoom 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes fadeInZoom {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>
</div>