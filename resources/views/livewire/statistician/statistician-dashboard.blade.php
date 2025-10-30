<!-- START OF STATISTICIANS DASHBOARD CONTENT -->
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header -->
        <header class="mb-4">
            <h1 class="text-4xl font-extrabold text-white tracking-tight">
                Statisticians' Performance Center
            </h1>
            <p class="text-lg text-gray-400 mt-1">
                Analyze key metrics, player efficiencies, and track performance anomalies.
            </p>
        </header>

        <!-- Grid Row 1 (Metric Cards) -->
        <div class="grid auto-rows-min gap-6 md:grid-cols-2 lg:grid-cols-3">

            <!-- Card 1: League EFG% (Effective Field Goal Percentage) - Teal Accent -->
            <div class="relative overflow-hidden rounded-xl bg-zinc-800 border-2 border-primary-stat shadow-xl shadow-teal-900/20 transition duration-300 hover:shadow-teal-900/50">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <!-- Bar Chart Icon -->
                        <svg class="size-8 text-primary-stat" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                        </svg>
                        <span class="text-sm font-medium text-primary-stat uppercase">League-Wide EFG%</span>
                    </div>
                    <!-- Live data placeholder -->
                    <p class="mt-2 text-5xl font-bold text-white">51.3<span class="text-xl font-medium">%</span></p>
                    <p class="text-sm text-gray-400">League Average Effective Field Goal Percentage</p>
                    <button onclick="livewireAction('viewAdvancedMetrics')" class="mt-4 w-full rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-md shadow-teal-700/50 transition duration-150 hover:bg-teal-700 focus:outline-none focus:ring-4 focus:ring-teal-500/50">
                        View Advanced Metrics
                    </button>
                </div>
            </div>

            <!-- Card 2: Top Scorer PPG -->
            <div class="relative overflow-hidden rounded-xl bg-zinc-800 border border-zinc-700 shadow-md transition duration-300 hover:border-white/50">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <!-- Player Icon (Same as original but repurposed) -->
                        <svg class="size-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-400 uppercase">Top Scorer PPG</span>
                    </div>
                    <!-- Live data placeholder -->
                    <p class="mt-2 text-5xl font-bold text-white">33.8</p>
                    <p class="text-sm text-gray-400">Leading Player Points Per Game</p>
                    <button onclick="livewireAction('analyzeTopPlayers')" class="mt-4 w-full rounded-lg bg-gray-700 px-4 py-2 text-sm font-semibold text-white transition duration-150 hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-white/50">
                        Analyze Top Players
                    </button>
                </div>
            </div>

            <!-- Card 3: Average Winning Margin -->
            <div class="relative overflow-hidden rounded-xl bg-zinc-800 border border-zinc-700 shadow-md transition duration-300 hover:border-white/50">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <!-- Star/Trophy Icon -->
                        <svg class="size-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 17.27l6.18 3.73-1.64-7.03 5.46-4.73-7.19-.61L12 2 8.19 8.63l-7.19.61 5.46 4.73-1.64 7.03L12 17.27z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-400 uppercase">Avg. Winning Margin</span>
                    </div>
                    <!-- Live data placeholder -->
                    <p class="mt-2 text-5xl font-bold text-white">7.2</p>
                    <p class="text-sm text-gray-400">Average Points Differential (W/L)</p>
                    <button onclick="livewireAction('reviewMarginStats')" class="mt-4 w-full rounded-lg bg-gray-700 px-4 py-2 text-sm font-semibold text-white transition duration-150 hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-white/50">
                        Review Margin Stats
                    </button>
                </div>
            </div>
        </div>

        <!-- Large Area Row 2 (Performance Anomalies & Milestones) -->
        <div class="relative h-full min-h-[400px] flex-1 overflow-hidden rounded-xl bg-zinc-800 border border-zinc-700 shadow-lg">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-white mb-4 border-b border-zinc-700 pb-3">Performance Anomalies & Milestones</h2>
                <div class="space-y-4 max-h-[calc(100vh-350px)] overflow-y-auto pr-2">
                    <!-- Event 1 (Red Accent - Anomaly: Low Assist Rate) -->
                    <div class="flex items-start space-x-3 p-3 rounded-lg bg-red-900/10 border border-warning-red/50">
                        <!-- Warning/Alert Icon -->
                        <svg class="size-5 text-warning-red mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.48 22 2 17.52 2 12S6.48 2 12 2s10 4.48 10 10-4.48 10-10 10zm-1-15H9v6h2V7zm0 8h2v2h-2v-2z" /></svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">Low Passing Efficiency Warning</p>
                            <p class="text-xs text-gray-400">Team **The Hawks** recorded a Season-Low Assist/Turnover Ratio (0.81) in their last match. <span class="text-warning-red font-semibold">(Anomaly)</span></p>
                        </div>
                    </div>

                    <!-- Event 2 (Teal Accent - Milestone: Triple-Double) -->
                    <div class="flex items-start space-x-3 p-3 rounded-lg bg-teal-900/10 border border-primary-stat/50">
                        <!-- Trophy Icon (Repurposed for achievement) -->
                        <svg class="size-5 text-primary-stat mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11 20H6V4h5V2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h5v-2zm1-13h9v2h-9zm0 4h9v2h-9zm0 4h9v2h-9z" /></svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">Player Achievement: Triple-Double</p>
                            <p class="text-xs text-gray-400">Player **L. James** (The Vipers) achieved 10+ points, rebounds, and assists on 10/28. <span class="text-primary-stat font-semibold">(Milestone)</span></p>
                        </div>
                    </div>

                    <!-- Event 3 (White Accent - Trend: Streak) -->
                    <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-zinc-700/50 transition duration-150">
                        <!-- Trending Icon -->
                        <svg class="size-5 text-white mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M16 6.04l-1.42 1.42 4.45 4.45L15 16.32l1.41 1.41 6.04-6.04-6.45-6.04zM4 22h14v-2H4v2z" /></svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">Team Performance Trend</p>
                            <p class="text-xs text-gray-400">The Grizzlies have maintained a 4-game win streak, with an average margin of +12.5. (Trend Analysis)</p>
                        </div>
                    </div>

                    <!-- Event 4 (Red Accent - Anomaly: High Fouls) -->
                    <div class="flex items-start space-x-3 p-3 rounded-lg bg-red-900/10 border border-warning-red/50">
                        <!-- Shield/Defense Icon (Repurposed for violation) -->
                        <svg class="size-5 text-warning-red mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-1 8h2V7h-2v2zm0 4h2v-2h-2v2zm0 4h2v-4h-2v4z" /></svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">Defensive Discipline Concern</p>
                            <p class="text-xs text-gray-400">Team **The Raptors** committed 30+ total fouls in the last two games, leading to excess free throws. <span class="text-warning-red font-semibold">(Discipline)</span></p>
                        </div>
                    </div>

                    <!-- Placeholder for historical data / charts -->
                    <div class="relative w-full aspect-[4/1] flex items-center justify-center p-6 border-2 border-dashed border-zinc-700 rounded-xl mt-6">
                        <p class="text-gray-500 italic">... Detailed Player Efficiency Ratings (PER) and Shot Charts will load here ...</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- END OF STATISTICIANS DASHBOARD CONTENT -->