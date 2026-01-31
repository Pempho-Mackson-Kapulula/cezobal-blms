<div class="p-4 sm:p-8 bg-zinc-950 min-h-screen font-sans text-zinc-100">
   
    <div class="max-w-7xl mx-auto mb-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b-2 border-zinc-900 pb-8">
            <div>
                <h1 class="text-5xl font-black uppercase tracking-tighter italic leading-none">
                    PAYMENT <span class="text-red-600">LEDGER</span>
                </h1>
                <p class="text-zinc-500 text-xs font-black uppercase tracking-[0.4em] mt-3">
                    Master Transaction Database
                </p>
            </div>

            <div class="flex gap-4">
                <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-2xl min-w-[160px]">
                    <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-1">Total Verified</p>
                    <p class="text-xl font-black text-emerald-500 tracking-tighter">
                        {{ number_format($payments->where('status', 'successful')->sum('amount')) }} <span
                            class="text-[10px]">MWK</span>
                    </p>
                </div>
                <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-2xl min-w-[160px]">
                    <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-1">Pending Volume</p>
                    <p class="text-xl font-black text-amber-500 tracking-tighter">
                        {{ number_format($payments->where('status', 'pending')->sum('amount')) }} <span
                            class="text-[10px]">MWK</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-zinc-800/50 border-b border-zinc-800">
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-red-500">Team
                                Entity</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500">
                                Category</th>
                            <th
                                class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-right">
                                Amount</th>
                            <th
                                class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-center">
                                Status</th>
                            <th
                                class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-right">
                                Timestamp</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/50">
                        @foreach ($payments as $payment)
                            <tr class="group hover:bg-black/40 transition-colors cursor-default">
                                <td class="px-6 py-5">
                                    <p
                                        class="text-sm font-black uppercase tracking-tight text-white group-hover:text-red-500 transition-colors">
                                        {{ $payment->team->name }}
                                    </p>
                                    <p
                                        class="text-[10px] text-zinc-600 font-bold uppercase tracking-widest mt-0.5 italic">
                                        REF: {{ $payment->tx_ref }}
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    <span
                                        class="text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded bg-zinc-800 text-zinc-400">
                                        {{ $payment->payment_type }}
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-right">
                                    <p class="text-sm font-black tracking-tighter text-white">
                                        {{ number_format($payment->amount) }} <span class="text-zinc-500">MWK</span>
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-center">
                                        @php
                                            $status = strtolower($payment->status);
                                            $statusClasses = match ($status) {
                                                'successful',
                                                'completed'
                                                    => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                                'pending' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                                'failed' => 'bg-red-500/10 text-red-500 border-red-500/20',
                                                default => 'bg-zinc-500/10 text-zinc-500 border-zinc-500/20',
                                            };
                                        @endphp
                                        <span
                                            class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $statusClasses }}">
                                            {{ $status }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-right">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-zinc-500">
                                        {{ $payment->created_at->format('d M Y') }}
                                    </p>
                                    <p class="text-[9px] text-zinc-700 font-bold uppercase tracking-tighter">
                                        {{ $payment->created_at->format('H:i') }} CAT
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($payments->isEmpty())
                <div class="py-20 text-center">
                    <svg class="w-12 h-12 text-zinc-800 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <p class="text-xs font-black uppercase text-zinc-700 tracking-[0.2em]">Zero transactions found in
                        database</p>
                </div>
            @endif
        </div>
    </div>
</div>
