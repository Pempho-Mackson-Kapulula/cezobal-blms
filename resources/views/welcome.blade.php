@php
    use App\Services\DashboardService;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CEZOBAL BLMS</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 dark:bg-zinc-950 text-gray-900 dark:text-gray-100 flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">

    {{-- Header / Navigation --}}
    <header class="w-full lg:max-w-4xl max-w-[335px] mb-6">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a href="{{ DashboardService::userDashboardRoute() }}"
                        class="inline-block px-5 py-1.5 dark:text-gray-200 border-gray-300 dark:border-gray-700 hover:border-red-600 dark:hover:border-red-500 border text-gray-900 dark:text-gray-100 rounded-sm text-sm leading-normal transition-colors duration-200">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-gray-200 text-gray-900 border border-transparent hover:border-gray-400 dark:hover:border-gray-600 rounded-sm text-sm leading-normal transition-colors duration-200">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-gray-200 border-gray-300 dark:border-gray-700 hover:border-red-600 dark:hover:border-red-500 border text-gray-900 dark:text-gray-100 rounded-sm text-sm leading-normal transition-colors duration-200">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    {{-- Main Hero Section --}}
    <main class="w-full lg:max-w-4xl flex-1 flex flex-col justify-center text-center">
        <h1 class="text-6xl font-bold tracking-tight sm:text-7xl text-gray-900 dark:text-gray-100">
            CEZOBAL
        </h1>
        <p class="text-xl sm:text-2xl text-red-600 font-semibold mt-2">
            Basketball League Management System
        </p>
        <p class="mt-6 text-lg leading-8 text-gray-700 dark:text-gray-300">
            The official Central Zone Basketball League Management System. Follow your teams, track player stats, manage
            matches, and stay updated on all CEZOBAL activity.
        </p>

        {{-- Call-to-Action Buttons --}}
        <div class="mt-10 flex items-center justify-center gap-x-6">
            @auth
                <a href="{{ DashboardService::userDashboardRoute() }}"
                    class="rounded-md bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-colors duration-200">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}"
                    class="rounded-md bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-colors duration-200">
                    Get Started
                </a>
                <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white hover:text-red-500 dark:hover:text-red-400 transition-colors duration-200">
                    Log in <span aria-hidden="true">→</span>
                </a>
            @endauth
        </div>
    </main>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

</html>
