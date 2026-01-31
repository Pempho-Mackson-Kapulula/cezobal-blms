<div class="p-4 sm:p-8 bg-zinc-950 min-h-screen font-sans text-zinc-100">

    <div
        class="max-w-6xl mx-auto mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4 border-b-2 border-zinc-900 pb-8">
        <div>
            <h1 class="text-5xl font-black uppercase tracking-tighter italic">TEAM <span
                    class="text-red-600">FINANCE</span></h1>
            <p class="text-zinc-500 text-xs font-black uppercase tracking-[0.4em] mt-2">Manage Registration & League Fees
            </p>
        </div>
        <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-2xl flex items-center gap-6">
            <div>
                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">Active Team</p>
                <p class="text-lg font-black text-white uppercase tracking-tight">
                    {{ Auth::user()->team->name ?? 'No Team' }}</p>
            </div>
            <div class="h-10 w-px bg-zinc-800"></div>
            <div>
                <p class="text-[10px] font-black text-red-500 uppercase tracking-widest">Current Status</p>
                <p class="text-lg font-black text-white uppercase tracking-tight italic">ACTIVE</p>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8">

        <div class="lg:col-span-4">
            <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl sticky top-8">
                <div class="bg-red-600 px-6 py-5">
                    <h2 class="text-sm font-black uppercase tracking-[0.2em] text-white">Make a Payment</h2>
                </div>

                <div class="p-6 sm:p-8">
                    @if (session()->has('error'))
                        <div
                            class="mb-6 p-4 bg-red-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest animate-pulse">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session()->has('message'))
                        <div
                            class="mb-6 p-4 bg-emerald-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="submit" class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-red-500 ml-1">Fee
                                Category</label>
                            <select wire:model="payment_type"
                                class="w-full rounded-xl border-2 border-zinc-800 bg-black text-white py-4 px-4 text-xs font-black uppercase focus:border-red-600 focus:ring-0 cursor-pointer transition-colors">
                                <option value="">Select Category</option>
                                <option value="registration">Season Registration</option>
                                <option value="transfer">Player Transfer</option>
                                <option value="fine">Disciplinary Fine</option>
                            </select>
                            @error('payment_type')
                                <span class="text-[10px] text-red-500 font-bold uppercase">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label
                                class="block text-[10px] font-black uppercase tracking-widest text-red-500 ml-1">Amount
                                (MWK)</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 text-zinc-600 font-black text-xs italic">MWK</span>
                                <input type="number" wire:model="amount" placeholder="5000"
                                    class="w-full rounded-xl border-2 border-zinc-800 bg-black text-white py-4 pl-14 pr-4 font-black text-2xl tracking-tighter focus:border-red-600 focus:ring-0">
                            </div>
                            @error('amount')
                                <span class="text-[10px] text-red-500 font-bold uppercase">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full py-5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-black uppercase tracking-widest text-sm shadow-xl shadow-red-900/40 transition-all active:scale-95 group">
                            <span wire:loading.remove wire:target="submit"
                                class="flex items-center justify-center gap-3">
                                Proceed to Pay
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                            <span wire:loading wire:target="submit" class="flex items-center justify-center gap-2">
                                <div
                                    class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin">
                                </div>
                                Initializing Gateway...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="bg-zinc-900 rounded-3xl border border-zinc-800 p-6 sm:p-8 shadow-2xl">

                <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 mb-8">
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Financial Records</h2>

                    <div class="flex flex-wrap items-center gap-3 w-full xl:w-auto">
                        <div class="relative flex-grow xl:flex-grow-0">
                            <input type="text" wire:model.live="search" placeholder="SEARCH REF..."
                                class="w-full xl:w-48 bg-black border-2 border-zinc-800 rounded-xl px-4 py-2 text-[10px] font-black uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 transition-all placeholder-zinc-700">
                        </div>

                        <select wire:model.live="dateFilter"
                            class="bg-black border-2 border-zinc-800 rounded-xl px-4 py-2 text-[10px] font-black uppercase tracking-widest text-zinc-400 focus:border-red-600 focus:ring-0 cursor-pointer transition-all">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="week">Last 7 Days</option>
                            <option value="month">Last 30 Days</option>
                        </select>

                        <div class="flex gap-2 items-center ml-auto xl:ml-0">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span
                                class="text-[10px] font-black uppercase tracking-widest text-zinc-500 italic">Live</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($history as $payment)
                        <div
                            class="group flex items-center justify-between p-5 bg-black rounded-2xl border-2 border-zinc-800 hover:border-red-600/30 transition-all">
                            <div class="flex items-center gap-5">
                                <div
                                    class="w-12 h-12 rounded-xl bg-zinc-900 flex items-center justify-center border border-zinc-800 text-red-600 group-hover:scale-110 transition-transform shadow-inner">
                                    @if ($payment->payment_type == 'registration')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-black uppercase tracking-tight text-white">
                                        {{ $payment->payment_type }}</p>
                                    <p
                                        class="text-[10px] text-zinc-600 font-bold uppercase tracking-widest mt-1 italic">
                                        REF: {{ $payment->tx_ref }}</p>
                                </div>
                            </div>

                            <div class="text-right flex flex-col items-end gap-2">
                                <p class="text-lg font-black tracking-tighter text-white">
                                    {{ number_format($payment->amount) }} <span
                                        class="text-[10px] text-zinc-500">MWK</span>
                                </p>

                                <div class="flex items-center gap-3">
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest 
                                        {{ $payment->status == 'completed' ? 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' : 'bg-amber-500/10 text-amber-500 border border-amber-500/20' }}">
                                        {{ $payment->status ?? 'Pending' }}
                                    </span>

                                    @if ($payment->status == 'pending')
                                        <button wire:click="cancelPayment({{ $payment->id }})"
                                            wire:confirm="ABORT TRANSACTION? This will remove the reference number."
                                            class="p-2 rounded-lg bg-zinc-900 border border-zinc-800 text-zinc-500 hover:text-red-500 hover:border-red-600 transition-all active:scale-90"
                                            title="Cancel Pending Payment">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-20 text-center border-4 border-dashed border-zinc-800 rounded-3xl group">
                            <svg class="w-12 h-12 text-zinc-800 mx-auto mb-4 group-hover:text-zinc-700 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 12H4" />
                            </svg>
                            <p class="text-xs font-black uppercase text-zinc-700 tracking-[0.2em]">No financial data on
                                record</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="p-4 sm:p-8 bg-zinc-950 min-h-screen font-sans text-zinc-100">

        <div
            class="max-w-6xl mx-auto mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4 border-b-2 border-zinc-900 pb-8">
        </div>

        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8">
        </div>

        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #27272a;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #dc2626;
            }
        </style>
    </div> ```
</div>
