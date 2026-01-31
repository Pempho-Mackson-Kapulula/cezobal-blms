<div class="p-4 sm:p-8 bg-zinc-950 min-h-screen font-sans text-zinc-100">
    <div class="max-w-7xl mx-auto mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 border-b-2 border-zinc-900 pb-8">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                <span class="text-[10px] font-black uppercase tracking-[0.4em] text-red-500">System Live // Pretoria-Harare Time</span>
            </div>
            <h1 class="text-5xl font-black uppercase tracking-tighter italic leading-none">
                ADMIN <span class="text-red-600">CENTER</span>
            </h1>
        </div>

        <div class="bg-zinc-900 border border-zinc-800 px-4 py-2 rounded-2xl flex items-center gap-4 shadow-xl">
            <div class="text-right border-r border-zinc-800 pr-4">
                <p class="text-[9px] font-black uppercase text-zinc-600 tracking-widest">Local Node</p>
                <p class="text-xs font-bold text-zinc-400">SAST (UTC+2)</p>
            </div>
            <div class="min-w-[80px]">
                <p class="text-[9px] font-black uppercase text-zinc-600 tracking-widest">Current Time</p>
                <p class="text-sm font-mono font-bold text-red-500">
                    {{ now()->setTimezone('Africa/Johannesburg')->format('H:i:s') }}
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
        <div class="relative group overflow-hidden bg-zinc-900 rounded-3xl border border-zinc-800 p-8 transition-all hover:border-red-600/50 shadow-2xl">
            <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:100%_4px] pointer-events-none"></div>
            <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
            </div>
            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-500 mb-2">Pending Authorizations</h3>
            <p class="text-6xl font-black italic tracking-tighter text-red-600 mb-6 group-hover:scale-105 transition-transform duration-500 origin-left">{{ $pendingUsers }}</p>
            <a href="{{ route('admin.user-approvals') }}"
                class="inline-flex w-full items-center justify-center gap-2 py-3 bg-red-600 hover:bg-red-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all active:scale-95 shadow-lg shadow-red-900/20">
                Enter Gateway
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>

        <div class="relative group overflow-hidden bg-zinc-900 rounded-3xl border border-zinc-800 p-8 transition-all hover:border-zinc-700 shadow-2xl">
            <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:100%_4px] pointer-events-none"></div>
            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-500 mb-2">Approved Personnel</h3>
            <p class="text-6xl font-black italic tracking-tighter text-white mb-6 group-hover:text-red-500 transition-colors duration-500">{{ $totalUsers }}</p>
            <button class="inline-flex w-full items-center justify-center gap-2 py-3 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all border border-zinc-700">
                Manage Directory
            </button>
        </div>

        <div class="relative group overflow-hidden bg-zinc-900 rounded-3xl border border-zinc-800 p-8 transition-all hover:border-red-600/50 shadow-2xl">
            <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:100%_4px] pointer-events-none"></div>
            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-500 mb-2">Upcoming Deployments</h3>
            <p class="text-6xl font-black italic tracking-tighter text-white mb-6">{{ $upcomingGames }}</p>
            <a href="{{ route('admin.view-fixtures') }}"
                class="inline-flex w-full items-center justify-center gap-2 py-3 bg-red-600 hover:bg-red-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all active:scale-95 shadow-lg shadow-red-900/20">
                Sync Schedule
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8 border-b border-zinc-900 pb-4">
            <div>
                <h2 class="text-2xl font-black uppercase tracking-tighter italic text-white">REVENUE <span class="text-red-600">LEDGER</span></h2>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-600">Financial Stream Log</p>
            </div>
            <button class="p-2 bg-zinc-900 border border-zinc-800 rounded-lg text-zinc-500 hover:text-white transition-colors hover:bg-zinc-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </button>
        </div>

        <div class="bg-zinc-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-black/50 border-b border-zinc-800">
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500">Origin Team</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-center">Type</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-right">Volume (MWK)</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500 text-center">Status</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-zinc-500">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/50">
                        @foreach ($payments as $payment)
                            <tr class="group hover:bg-red-600/5 transition-colors duration-150">
                                <td class="px-6 py-5">
                                    <p class="text-sm font-black uppercase tracking-tighter text-white group-hover:text-red-500 transition-colors">
                                        {{ $payment->team->name }}
                                    </p>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-red-500 italic">
                                        {{ $payment->payment_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right font-mono text-xs font-bold text-zinc-300">
                                    {{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $status = strtolower($payment->status);
                                        $statusConfig = [
                                            'successful' => 'text-emerald-500 bg-emerald-500/10 border-emerald-500/20',
                                            'pending' => 'text-amber-500 bg-amber-500/10 border-amber-500/20',
                                            'failed' => 'text-red-500 bg-red-500/10 border-red-500/20'
                                        ][$status] ?? 'text-zinc-500 bg-zinc-500/10 border-zinc-500/20';
                                    @endphp
                                    <span class="inline-block px-3 py-1 rounded-lg border text-[9px] font-black uppercase tracking-widest {{ $statusConfig }}">
                                        {{ $payment->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-[10px] font-black text-zinc-600 uppercase italic">
                                        {{ $payment->created_at->format('d.M.y // H:i') }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>