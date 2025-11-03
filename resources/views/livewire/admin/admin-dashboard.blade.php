<div class="p-4 sm:p-6 lg:p-8 space-y-8 bg-zinc-950 min-h-screen text-zinc-100">

    <!-- Dashboard/Admin Header Section -->
    <div class="flex h-full w-full flex-1 flex-col gap-6">

        <!-- Header -->
        <header class="mb-4 border-b-4 border-red-600 pb-3">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-red-500 tracking-tight">
                Basketball League Admin Center
            </h1>
            <p class="text-lg text-zinc-400 mt-1">
                Manage players, teams, and real-time game status.
            </p>
        </header>

        <!-- Metric Cards -->
        <div class="grid auto-rows-min gap-6 md:grid-cols-2 lg:grid-cols-3">

            <!-- Pending Team Approvals Card -->
            <div class="bg-zinc-900 p-6 rounded-xl shadow-lg border border-zinc-800/80 flex flex-col justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-red-400">Pending Users</p>
                    <p class="mt-2 text-5xl font-bold text-red-500">{{ $pendingUsers }}</p>
                    <p class="text-sm text-zinc-400">User accounts pending approval</p>
                </div>
                <a href="{{ route('admin.user-approvals') }}"
                    class="mt-4 w-full block rounded-lg bg-red-600 hover:bg-red-700 px-4 py-2 text-sm font-semibold text-white text-center transition duration-200">
                    Review User Requests
                </a>

            </div>

            <!-- Total Registered Users Card -->
            <div class="bg-zinc-900 p-6 rounded-xl shadow-lg border border-zinc-800/80 flex flex-col justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-red-400">Registered Users</p>
                    <p class="mt-2 text-5xl font-bold text-green-500">{{ $totalUsers }}</p>
                    <p class="text-sm text-zinc-400">Approved users (managers, statisticians, scorekeepers)</p>
                </div>
                <button
                    class="mt-4 w-full rounded-lg bg-red-600 hover:bg-red-700 px-4 py-2 text-sm font-semibold text-white transition duration-200">
                    View Users
                </button>
            </div>

            <!-- Upcoming Games Card -->
            <div class="bg-zinc-900 p-6 rounded-xl shadow-lg border border-zinc-800/80">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-red-400">Number of Upcoming Games</p>
                    <p class="mt-2 text-5xl font-bold text-green-500">{{ $upcomingGames }}</p>
                </div>
                <p class="text-sm text-zinc-400">View all scheduled games</p>
                <a href="{{ route('admin.view-fixtures') }}"
                    class="mt-4 w-full block rounded-lg bg-red-600 hover:bg-red-700 px-4 py-2 text-sm font-semibold text-white text-center transition duration-200">
                    Review League Fixtures
                </a>

            </div>

        </div>


    </div>

    <!-- Payment History Table Section Header -->
    <div class="border-b-4 border-red-600 pb-3 pt-6">
        <h2 class="text-3xl font-extrabold text-red-500 tracking-tight">
            Recent Payments
        </h2>
        <p class="text-zinc-400 mt-1 text-md">View recently processed payments</p>
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto rounded-xl shadow-2xl border border-zinc-800/80">


        <table class="min-w-full divide-y divide-zinc-700/50">
            <thead class="bg-zinc-800 sticky top-0 z-10">
                <tr>
                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-400">Team</th>
                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-400">Payment Type
                    </th>
                    <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wider text-red-400">Amount</th>
                    <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-red-400">Status
                    </th>
                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-400">Date</th>
                </tr>
            </thead>
            <tbody class="bg-zinc-900 divide-y divide-zinc-800/50">
                @foreach ($payments as $payment)
                    <tr class="transition duration-300 ease-in-out hover:bg-zinc-800">
                        <!-- Team Name -->
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-zinc-300 font-medium">
                            {{ $payment->team->name }}
                        </td>
                        <!-- Payment Type -->
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-red-300 font-semibold capitalize">
                            {{ ucfirst($payment->payment_type) }}
                        </td>
                        <!-- Amount (Right-aligned for currency) -->
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-zinc-200 font-mono text-right">
                            {{ number_format($payment->amount, 2) }} MWK
                        </td>
                        <!-- Status Badge (Themed) -->
                        <td class="px-5 py-4 whitespace-nowrap text-center">
                            <?php
                            $status = strtolower($payment->status);
                            $class = '';
                            if ($status === 'successful') {
                                $class = 'bg-green-900/50 text-green-300 border border-green-700';
                            } elseif ($status === 'pending') {
                                $class = 'bg-amber-900/50 text-amber-500 border border-amber-700';
                            } elseif ($status === 'failed') {
                                $class = 'bg-red-900/50 text-red-400 border border-red-700';
                            } else {
                                $class = 'bg-zinc-800 text-zinc-400 border border-zinc-700';
                            }
                            ?>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider {{ $class }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <!-- Date -->
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-zinc-400">
                            {{ $payment->created_at->format('d M Y') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</div>
