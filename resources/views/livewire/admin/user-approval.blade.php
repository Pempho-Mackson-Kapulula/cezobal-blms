<div class="p-4 sm:p-8 bg-zinc-950 min-h-screen font-sans text-zinc-100">
    
    <div class="max-w-4xl mx-auto mb-10 border-b-2 border-zinc-900 pb-8">
        <div class="flex items-center gap-3 mb-2">
            <span class="px-3 py-1 bg-amber-500/10 text-amber-500 border border-amber-500/20 text-[10px] font-black uppercase tracking-widest rounded-full">Security Gateway</span>
        </div>
        <h1 class="text-5xl font-black uppercase tracking-tighter italic">ACCESS <span class="text-red-600">CONTROL</span></h1>
        <p class="text-zinc-500 text-xs font-black uppercase tracking-[0.4em] mt-3">Pending Personnel Verification</p>
    </div>

    <div class="max-w-4xl mx-auto space-y-6">
        
        @if (session()->has('message'))
            <div class="flex items-center gap-3 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 rounded-2xl animate-in fade-in slide-in-from-top-4 duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                <p class="text-xs font-black uppercase tracking-widest">{{ session('message') }}</p>
            </div>
        @endif

        @forelse ($this->pendingUsers as $user)
            <div wire:key="user-{{ $user->id }}" 
                 class="group relative bg-zinc-900 rounded-3xl border border-zinc-800 p-6 shadow-2xl transition-all hover:border-zinc-700 overflow-hidden">
                
                <div class="absolute top-0 right-0 px-6 py-2 bg-zinc-800 text-[9px] font-black uppercase tracking-[0.2em] text-zinc-500 rounded-bl-2xl italic border-l border-b border-zinc-700">
                    Priority: Normal
                </div>

                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                    <div class="flex-1 space-y-3">
                        <div>
                            <h2 class="text-2xl font-black uppercase tracking-tighter text-white group-hover:text-red-500 transition-colors italic">
                                {{ $user->name }}
                            </h2>
                            <p class="text-[11px] font-mono text-zinc-500 uppercase tracking-tight">{{ $user->email }}</p>
                        </div>
                        
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-600/5 border border-red-600/20 rounded-lg">
                            <span class="text-[9px] font-black uppercase tracking-widest text-zinc-500">Requesting Role:</span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-red-500">
                                {{ $user->roles->first()?->name ?? 'No Role Assigned' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-end sm:items-center gap-4">
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <input type="text"
                                   wire:model="rejectionReasons.{{ $user->id }}"
                                   placeholder="Reason (Optional)"
                                   class="flex-1 sm:w-48 bg-black border-2 border-zinc-800 rounded-xl px-4 py-2.5 text-xs font-bold text-zinc-300 placeholder:text-zinc-700 focus:border-red-600 focus:ring-0 transition-all" />
                            
                            <button wire:click="confirmReject({{ $user->id }})"
                                    class="p-2.5 bg-zinc-800 hover:bg-red-600 text-zinc-500 hover:text-white rounded-xl border border-zinc-700 transition-all active:scale-95 shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <button wire:click="approve({{ $user->id }})"
                                class="w-full sm:w-auto px-8 py-3 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black uppercase tracking-[0.2em] rounded-xl transition-all active:scale-95 shadow-[0_10px_20px_rgba(16,185,129,0.2)]">
                            Authorize
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-24 text-center bg-zinc-900 rounded-3xl border-4 border-dashed border-zinc-800">
                <div class="relative w-20 h-20 mx-auto mb-6">
                    <div class="absolute inset-0 bg-zinc-800 rounded-full animate-pulse"></div>
                    <svg class="relative z-10 w-20 h-20 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-xl font-black uppercase italic tracking-tighter text-zinc-500">System Secure</h3>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-zinc-700 mt-2">Zero Pending Authorizations</p>
            </div>
        @endforelse
    </div>

    @if ($showRejectModal)
        <div class="fixed inset-0 flex items-center justify-center z-[100] px-4">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" wire:click="cancelReject"></div>
            
            <div class="relative bg-zinc-900 p-8 rounded-3xl border border-zinc-800 shadow-[0_0_50px_rgba(0,0,0,1)] w-full max-w-md animate-in zoom-in duration-200">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-red-600/10 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-600/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <h2 class="text-2xl font-black uppercase italic tracking-tighter text-white">Deny Access?</h2>
                    <p class="text-zinc-500 text-[10px] font-black uppercase tracking-widest mt-2">This will permanently revoke the pending request.</p>
                </div>

                @if($rejectUserId)
                    @php $targetUser = $this->pendingUsers->find($rejectUserId); @endphp
                    <div class="bg-black border border-zinc-800 p-5 rounded-2xl mb-8">
                        <p class="text-xs font-black uppercase text-zinc-400 mb-1">User Entity</p>
                        <p class="text-sm font-bold text-white">{{ $targetUser?->name ?? 'Unknown' }}</p>
                        <div class="mt-4 pt-4 border-t border-zinc-800">
                            <p class="text-[9px] font-black uppercase text-red-500 mb-1">Rejection Reason</p>
                            <p class="text-xs italic text-zinc-500">"{{ $rejectionReasons[$rejectUserId] ?? 'Policy Violation / Incorrect Role' }}"</p>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <button wire:click="cancelReject" class="py-4 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">
                        Abort
                    </button>
                    <button wire:click="rejectConfirmed" class="py-4 bg-red-600 hover:bg-red-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-red-900/40 transition-all">
                        Confirm Denial
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>