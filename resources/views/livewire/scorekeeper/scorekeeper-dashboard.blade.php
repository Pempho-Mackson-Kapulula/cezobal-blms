 <!-- START OF SCOREKEEPER DASHBOARD CONTENT -->
 <div class="flex h-full w-full flex-1 flex-col gap-6">
     <!-- Header -->
     <header class="mb-4">
         <h1 class="text-4xl font-extrabold text-white tracking-tight">
             Live Game Scoring Console
         </h1>
         <p class="text-lg text-gray-400 mt-1">
             Currently Scoring: **The Falcons vs. The Vipers**
         </p>
     </header>

     <!-- Grid Row 1 (Core Game Metrics) -->
     <div class="grid auto-rows-min gap-6 md:grid-cols-2 lg:grid-cols-3">

         <!-- Card 1: Game Clock/Status - Orange Accent (Active) -->
         <div
             class="relative overflow-hidden rounded-xl bg-zinc-800 border-2 border-primary-score shadow-xl shadow-orange-900/20 transition duration-300 hover:shadow-orange-900/50">
             <div class="p-6">
                 <div class="flex items-center justify-between">
                     <!-- Clock Icon -->
                     <svg class="size-8 text-primary-score" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor">
                         <path
                             d="M15 1H9v2h6V1zm-4 13h2V8h-2v6zm8.03-6.19l1.42-1.42c-.43-.51-.9-.98-1.41-1.41l-1.42 1.42A8.962 8.962 0 0 0 12 4c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-1.07-.19-2.09-.52-3.04zM12 20c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z" />
                     </svg>
                     <span class="text-sm font-medium text-primary-score uppercase">Game Status</span>
                 </div>
                 <!-- Live data placeholder -->
                 <p class="mt-2 text-5xl font-bold text-white">4th QTR</p>
                 <p class="text-sm text-gray-400">Time Remaining: **2:15**</p>
                 <button onclick="gameAction('toggleClock')"
                     class="mt-4 w-full rounded-lg bg-primary-score px-4 py-2 text-sm font-semibold text-white shadow-md shadow-orange-700/50 transition duration-150 hover:bg-orange-700 focus:outline-none focus:ring-4 focus:ring-orange-500/50">
                     Pause/Start Clock
                 </button>
             </div>
         </div>

         <!-- Card 2: Team A Score (The Falcons) -->
         <div
             class="relative overflow-hidden rounded-xl bg-zinc-800 border border-zinc-700 shadow-md transition duration-300 hover:border-white/50">
             <div class="p-6">
                 <div class="flex items-center justify-between">
                     <!-- Basketball Icon -->
                     <svg class="size-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor">
                         <path
                             d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM7.5 13.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm9 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm-4.5 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z" />
                     </svg>
                     <span class="text-sm font-medium text-gray-400 uppercase">The Falcons (Home)</span>
                 </div>
                 <!-- Live data placeholder -->
                 <p class="mt-2 text-5xl font-bold text-white">98</p>
                 <p class="text-sm text-gray-400">Current Score</p>
                 <div class="flex space-x-2 mt-4">
                     <button onclick="gameAction('score:falcons:1')"
                         class="flex-1 rounded-lg bg-gray-700 px-3 py-2 text-sm font-semibold text-white transition duration-150 hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-white/50">+1</button>
                     <button onclick="gameAction('score:falcons:2')"
                         class="flex-1 rounded-lg bg-gray-700 px-3 py-2 text-sm font-semibold text-white transition duration-150 hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-white/50">+2</button>
                     <button onclick="gameAction('score:falcons:3')"
                         class="flex-1 rounded-lg bg-gray-700 px-3 py-2 text-sm font-semibold text-white transition duration-150 hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-white/50">+3</button>
                 </div>
             </div>
         </div>

         <!-- Card 3: Team B Score (The Vipers) -->
         <div
             class="relative overflow-hidden rounded-xl bg-zinc-800 border border-zinc-700 shadow-md transition duration-300 hover:border-white/50">
             <div class="p-6">
                 <div class="flex items-center justify-between">
                     <!-- Basketball Icon -->
                     <svg class="size-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor">
                         <path
                             d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM7.5 13.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm9 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm-4.5 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z" />
                     </svg>
                     <span class="text-sm font-medium text-gray-400 uppercase">The Vipers (Away)</span>
                 </div>
                 <!-- Live data placeholder -->
                 <p class="mt-2 text-5xl font-bold text-white">101</p>
                 <p class="text-sm text-gray-400">Current Score</p>
                 <div class="flex space-x-2 mt-4">
                     <button onclick="gameAction('score:vipers:1')"
                         class="flex-1 rounded-lg bg-gray-700 px-3 py-2 text-sm font-semibold text-white transition duration-150 hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-white/50">+1</button>
                     <button onclick="gameAction('score:vipers:2')"
                         class="flex-1 rounded-lg bg-gray-700 px-3 py-2 text-sm font-semibold text-white transition duration-150 hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-white/50">+2</button>
                     <button onclick="gameAction('score:vipers:3')"
                         class="flex-1 rounded-lg bg-gray-700 px-3 py-2 text-sm font-semibold text-white transition duration-150 hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-white/50">+3</button>
                 </div>
             </div>
         </div>
     </div>

     <!-- Large Area Row 2 (Live Action Log and Key Controls) -->
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

         <!-- Col 1/2: Live Action Log -->
         <div
             class="lg:col-span-2 relative h-full min-h-[400px] flex-1 overflow-hidden rounded-xl bg-zinc-800 border border-zinc-700 shadow-lg">
             <div class="p-6">
                 <h2 class="text-xl font-semibold text-white mb-4 border-b border-zinc-700 pb-3">Live Game Action Log
                 </h2>
                 <div class="space-y-3 max-h-[400px] lg:max-h-[calc(100vh-350px)] overflow-y-auto pr-2 text-xs">
                     <!-- Action 1: Vipers Score (Orange Accent) -->
                     <div
                         class="flex items-start space-x-3 p-2 rounded-lg bg-orange-900/10 border-l-4 border-primary-score">
                         <span class="text-primary-score font-mono">02:15</span>
                         <div class="flex-1">
                             <p class="font-medium text-white">Vipers: **3-Pointer** by J. Smith (Assist: M. Johnson)
                             </p>
                             <p class="text-gray-400">Score now Vipers 101 - Falcons 98</p>
                         </div>
                     </div>

                     <!-- Action 2: Falcons Timeout (White Accent) -->
                     <div
                         class="flex items-start space-x-3 p-2 rounded-lg hover:bg-zinc-700/50 transition duration-150 border-l-4 border-gray-500">
                         <span class="text-gray-400 font-mono">02:45</span>
                         <div class="flex-1">
                             <p class="font-medium text-white">Falcons: **Timeout Called** (Full)</p>
                             <p class="text-gray-400">Game Paused.</p>
                         </div>
                     </div>

                     <!-- Action 3: Foul on Vipers (Red Accent) -->
                     <div class="flex items-start space-x-3 p-2 rounded-lg bg-red-900/10 border-l-4 border-red-600">
                         <span class="text-red-400 font-mono">03:30</span>
                         <div class="flex-1">
                             <p class="font-medium text-white">Vipers: **Personal Foul** on Player #14, D. Lee</p>
                             <p class="text-gray-400">Team Foul count: Vipers (4) - Falcons (3)</p>
                         </div>
                     </div>

                     <!-- Action 4: Substitution -->
                     <div
                         class="flex items-start space-x-3 p-2 rounded-lg hover:bg-zinc-700/50 transition duration-150 border-l-4 border-gray-500">
                         <span class="text-gray-400 font-mono">04:00</span>
                         <div class="flex-1">
                             <p class="font-medium text-white">Falcons: Substitution - J. Doe IN for T. Ray</p>
                         </div>
                     </div>

                     <!-- Placeholder to indicate the log continues -->
                     <div class="text-center py-4 text-gray-500 italic border-t border-zinc-700 mt-4">
                         ... Historical actions earlier in the 4th Quarter ...
                     </div>
                 </div>
             </div>
         </div>

         <!-- Col 3: Key Controls and Timeouts -->
         <div
             class="lg:col-span-1 relative h-full flex-1 overflow-hidden rounded-xl bg-zinc-800 border border-zinc-700 shadow-lg">
             <div class="p-6 space-y-6">
                 <h2 class="text-xl font-semibold text-white mb-4 border-b border-zinc-700 pb-3">Game Controls</h2>

                 <!-- Timeouts Section -->
                 <div>
                     <p class="text-lg font-medium text-white mb-2">Timeouts Remaining</p>
                     <div class="grid grid-cols-2 gap-4">
                         <div class="p-3 rounded-lg bg-zinc-700">
                             <p class="text-sm font-semibold text-gray-300">The Falcons (Home)</p>
                             <p class="text-3xl font-bold text-white">2</p>
                             <button onclick="gameAction('timeout:falcons')"
                                 class="mt-2 w-full text-xs font-semibold text-white bg-orange-600 hover:bg-orange-700 py-1.5 rounded-md transition">Call
                                 Timeout</button>
                         </div>
                         <div class="p-3 rounded-lg bg-zinc-700">
                             <p class="text-sm font-semibold text-gray-300">The Vipers (Away)</p>
                             <p class="text-3xl font-bold text-white">1</p>
                             <button onclick="gameAction('timeout:vipers')"
                                 class="mt-2 w-full text-xs font-semibold text-white bg-orange-600 hover:bg-orange-700 py-1.5 rounded-md transition">Call
                                 Timeout</button>
                         </div>
                     </div>
                 </div>

                 <!-- End Period Control -->
                 <div class="border-t border-zinc-700 pt-6">
                     <p class="text-lg font-medium text-white mb-2">End Period</p>
                     <button onclick="gameAction('endPeriod')"
                         class="w-full rounded-lg bg-gray-600 px-4 py-3 text-sm font-semibold text-white transition duration-150 hover:bg-gray-500 focus:outline-none focus:ring-4 focus:ring-white/50">
                         Advance to Next Period
                     </button>
                 </div>

                 <!-- Finalize Game Control -->
                 <div class="pt-2">
                     <p class="text-lg font-medium text-white mb-2 text-red-400">Finalization</p>
                     <button onclick="gameAction('finalizeGame')"
                         class="w-full rounded-lg bg-red-700 px-4 py-3 text-sm font-semibold text-white shadow-md shadow-red-900/50 transition duration-150 hover:bg-red-600 focus:outline-none focus:ring-4 focus:ring-red-500/50">
                         Finalize Score & End Game
                     </button>
                 </div>

             </div>
         </div>
     </div>

 </div>
 <!-- END OF SCOREKEEPER DASHBOARD CONTENT -->
