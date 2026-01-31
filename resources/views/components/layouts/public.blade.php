<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="bg-zinc-950 text-zinc-100 antialiased">
    <!-- Public Navigation -->
    <nav class="border-b border-zinc-800 bg-zinc-900/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" wire:navigate
                class="font-black text-2xl text-red-600 tracking-tighter hover:opacity-80 transition">
                CEZOBAL
            </a>

            <!-- Main Links -->
            <div class="hidden md:flex gap-8 text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400">
                <a href="{{ route('public-schedules') }}" wire:navigate
                    class="{{ request()->routeIs('public-schedules') ? 'text-red-500' : 'hover:text-white' }} transition">
                    Schedules
                </a>

                <a href="{{ route('public-teams-page') }}" wire:navigate
                    class="{{ request()->routeIs('public-teams-page') ? 'text-red-500' : 'hover:text-white' }} transition">Teams</a>
                <a href="{{ route('public-standings') }}" wire:navigate
                    class="{{ request()->routeIs('public-standings') ? 'text-red-500' : 'hover:text-white' }} transition">
                    Standings
                </a>
                <!-- Stats Dropdown -->
                <div x-data="{ open: false }" class="relative" @mouseenter="open = true" @mouseleave="open = false">
                    <button
                        class="flex items-center gap-1 transition {{ request()->routeIs('public-stats.*') ? 'text-red-500' : 'hover:text-white' }}">
                        STATS
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition
                        class="absolute left-0 mt-0 w-48 bg-zinc-900 border border-zinc-800 rounded-xl shadow-2xl py-2 z-50">
                        <a href="{{ route('public-stats-players') }}" wire:navigate
                            class="block px-4 py-3 hover:bg-zinc-800 hover:text-red-500 transition">Player Leaders</a>
                        <a href="{{ route('public-stats-teams') }}" wire:navigate
                            class="block px-4 py-3 hover:bg-zinc-800 hover:text-red-500 transition">Team Statistics</a>
                    </div>
                </div>


            </div>

            <!-- Auth Actions -->
            <div class="flex items-center gap-4 border-l border-zinc-800 pl-6">
                @auth
                    <a href="{{ \App\Services\DashboardService::userDashboardRoute() }}"
                        class="text-[10px] font-black uppercase tracking-widest text-white bg-red-600 px-4 py-2 rounded shadow-lg shadow-red-900/20 hover:bg-red-500 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-[10px] font-black uppercase tracking-widest text-zinc-400 hover:text-white transition">
                        Log In
                    </a>
                    <a href="{{ route('register') }}"
                        class="hidden sm:block text-[10px] font-black uppercase tracking-widest text-white border border-zinc-700 px-4 py-2 rounded hover:border-red-600 transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>


    <!-- Content Slot -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        {{ $slot }}
    </main>

    <footer class="border-t border-zinc-900 py-12 text-center text-zinc-600 text-xs uppercase tracking-widest">
        &copy; 2026 League Management System
    </footer>
</body>

</html>
