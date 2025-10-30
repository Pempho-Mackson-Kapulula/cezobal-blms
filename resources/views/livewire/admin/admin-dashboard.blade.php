<!-- START OF LIVEWIRE COMPONENT TEMPLATE CONTENT -->
<div class="flex h-full w-full flex-1 flex-col gap-6">
    <!-- Header -->
    <header class="mb-4">
        <h1 class="text-4xl font-extrabold text-white tracking-tight">
            Basketball League Admin Center
        </h1>
        <p class="text-lg text-gray-400 mt-1">
            Manage players, teams, and real-time game status.
        </p>
    </header>

    <!-- Grid Row 1 (Metric Cards) -->
    <div class="grid auto-rows-min gap-6 md:grid-cols-2 lg:grid-cols-3">

        <!-- Card 1: Pending Team Approvals (Red Accent - High Priority) -->
        <div
            class="relative overflow-hidden rounded-xl bg-zinc-800 border-2 border-primary-red shadow-xl shadow-red-900/20 transition duration-300 hover:shadow-red-900/50">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <svg class="size-8 text-primary-red" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M11.5 7.9c.7 0 1.2.5 1.2 1.2s-.5 1.2-1.2 1.2h-1c-.7 0-1.2-.5-1.2-1.2s.5-1.2 1.2-1.2h1zM11.5 13.5c.7 0 1.2.5 1.2 1.2s-.5 1.2-1.2 1.2h-1c-.7 0-1.2-.5-1.2-1.2s.5-1.2 1.2-1.2h1zM17 12c0 2.8-2.2 5-5 5s-5-2.2-5-5 2.2-5 5-5 5 2.2 5 5zM12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2z" />
                    </svg>
                    <span class="text-sm font-medium text-primary-red uppercase">Approval Queue</span>
                </div>
                <!-- Live data placeholder -->
                <p class="mt-2 text-5xl font-bold text-white">5</p>
                <p class="text-sm text-gray-400">New Team Applications Pending Review</p>
                <button onclick="livewireAction('reviewTeams')"
                    class="mt-4 w-full rounded-lg bg-primary-red px-4 py-2 text-sm font-semibold text-white shadow-md shadow-red-700/50 transition duration-150 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500/50">
                    Review Teams
                </button>
            </div>
        </div>

        <!-- Card 2: Total Registered Players -->
        <div
            class="relative overflow-hidden rounded-xl bg-zinc-800 border border-zinc-700 shadow-md transition duration-300 hover:border-white/50">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <svg class="size-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                    <span class="text-sm font-medium text-gray-400 uppercase">Total Roster Size</span>
                </div>
                <!-- Live data placeholder -->
                <p class="mt-2 text-5xl font-bold text-white">1,350</p>
                <p class="text-sm text-gray-400">Players across all divisions</p>
                <button onclick="livewireAction('viewRoster')"
                    class="mt-4 w-full rounded-lg bg-gray-700 px-4 py-2 text-sm font-semibold text-white transition duration-150 hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-white/50">
                    View Player Roster
                </button>
            </div>
        </div>

        <!-- Card 3: Live Games in Progress -->
        <div
            class="relative overflow-hidden rounded-xl bg-zinc-800 border border-zinc-700 shadow-md transition duration-300 hover:border-white/50">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <svg class="size-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                    </svg>
                    <span class="text-sm font-medium text-gray-400 uppercase">Real-Time Scoring</span>
                </div>
                <!-- Live data placeholder -->
                <p class="mt-2 text-5xl font-bold text-white">3</p>
                <p class="text-sm text-gray-400">Games currently being scored live</p>
                <button onclick="livewireAction('monitorGames')"
                    class="mt-4 w-full rounded-lg bg-gray-700 px-4 py-2 text-sm font-semibold text-white transition duration-150 hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-white/50">
                    Monitor Games
                </button>
            </div>
        </div>
    </div>

    <!-- Large Area Row 2 (Upcoming Schedule & Moderation Log) -->
    <div
        class="relative h-full min-h-[400px] flex-1 overflow-hidden rounded-xl bg-zinc-800 border border-zinc-700 shadow-lg">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-white mb-4 border-b border-zinc-700 pb-3">League Moderation & Key
                Events</h2>
            <div class="space-y-4 max-h-[calc(100vh-350px)] overflow-y-auto pr-2">
                <!-- Event 1 (Red Accent - Suspension/Warning) -->
                <div class="flex items-start space-x-3 p-3 rounded-lg bg-red-900/10 border border-primary-red/50">
                    <svg class="size-5 text-primary-red mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M12 22C6.48 22 2 17.52 2 12S6.48 2 12 2s10 4.48 10 10-4.48 10-10 10zm-1-15H9v6h2V7zm0 8h2v2h-2v-2z" />
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white">Player Suspension Issued</p>
                        <p class="text-xs text-gray-400">Player **J. Smith** (The Raptors) suspended for 1 game due to
                            technical fouls. <span class="text-primary-red font-semibold">(Moderation)</span></p>
                    </div>
                </div>

                <!-- Event 2 (White Accent - Upcoming Game) -->
                <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-zinc-700/50 transition duration-150">
                    <svg class="size-5 text-white mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M17 12c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm0 8c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zM12 2v2h2V2h-2zm-2 19h2v2h-2v-2zm-6.19-2.73l1.41-1.41 1.41 1.41-1.41 1.41-1.41-1.41zM20.24 5.39l-1.41 1.41-1.41-1.41 1.41-1.41 1.41 1.41zM4 10v2h2v-2H4zm18 0v2h2v-2h-2zm-2 10h2v2h-2v-2zM2 20h2v2H2v-2z" />
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white">Upcoming Match</p>
                        <p class="text-xs text-gray-400">The Vipers vs. The Grizzlies on 10/29 at 7:00 PM (Court 3).
                            <span class="text-gray-200 font-semibold">(Schedule)</span></p>
                    </div>
                </div>

                <!-- Event 3 (White Accent - Team Update) -->
                <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-zinc-700/50 transition duration-150">
                    <svg class="size-5 text-white mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM4 18V6h5.17l2 2H20v10H4z" />
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white">Team Roster Change</p>
                        <p class="text-xs text-gray-400">The Hurricanes submitted an official roster adjustment for Week
                            5. (Team ID: HUR-901)</p>
                    </div>
                </div>

                <!-- Event 4 (Red Accent - Unpaid Fees) -->
                <div class="flex items-start space-x-3 p-3 rounded-lg bg-red-900/10 border border-primary-red/50">
                    <svg class="size-5 text-primary-red mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-1 8h2V7h-2v2zm0 4h2v-2h-2v2zm0 4h2v-4h-2v4z" />
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white">Payment Warning</p>
                        <p class="text-xs text-gray-400">Team **The Hawks** has outstanding league fees. Deadline is
                            Friday. <span class="text-primary-red font-semibold">(Finance)</span></p>
                    </div>
                </div>

                <!-- Placeholder for historical data -->
                <div
                    class="relative w-full aspect-[4/1] flex items-center justify-center p-6 border-2 border-dashed border-zinc-700 rounded-xl mt-6">
                    <p class="text-gray-500 italic">... Season Statistics and Heatmaps will load here ...</p>
                </div>

            </div>
        </div>
    </div>
</div>
