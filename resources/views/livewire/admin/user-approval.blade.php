<div class="p-4 sm:p-6 lg:p-8 space-y-8 bg-zinc-950 min-h-screen text-zinc-100">

    <!-- Header Section -->
    <div class="border-b-4 border-red-600 pb-3">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-red-500 tracking-tight">
            Pending User Approvals
        </h1>
        <p class="text-zinc-400 mt-1 text-lg">Review and manage new user accounts requesting access and roles.</p>
    </div>

    <div class="max-w-3xl mx-auto space-y-4">
        
        <!-- Session Messages -->
        @if (session()->has('message'))
            <div class="p-4 bg-green-900/50 border border-green-500 text-green-300 rounded-xl shadow-md">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="p-4 bg-red-900/50 border border-red-500 text-red-300 rounded-xl shadow-md">
                {{ session('error') }}
            </div>
        @endif

        @forelse ($pendingUsers as $user)
            <!-- User Approval Card -->
            <div wire:key="{{ $user->id }}" class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-zinc-900 p-5 rounded-xl shadow-2xl border border-zinc-800/80 transition duration-300 hover:border-red-500/50">
                
                <!-- User Details -->
                <div class="space-y-1 mb-4 sm:mb-0">
                    <p class="font-bold text-xl text-zinc-100">{{ $user->name }}</p>
                    <p class="text-sm text-zinc-400 font-mono">{{ $user->email }}</p>
                    <p class="text-sm text-red-400 font-medium capitalize mt-1">
                        Requested Role: {{ $user->roles->first()?->name ?? 'No Role Assigned' }}
                    </p>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-3">
                    <button wire:click="approve({{ $user->id }})"
                        class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700
                               transition duration-200 ease-in-out shadow-md shadow-green-900/50
                               transform hover:scale-[1.05]">
                        Approve
                    </button>
                    <button wire:click="reject({{ $user->id }})"
                        class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700
                               transition duration-200 ease-in-out shadow-md shadow-red-900/50
                               transform hover:scale-[1.05]">
                        Reject
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center text-zinc-500 py-12 bg-zinc-900 rounded-xl shadow-2xl border border-zinc-800/80">
                <svg class="mx-auto h-12 w-12 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01"></path></svg>
                <h3 class="mt-2 text-lg font-medium text-zinc-300">All Clear!</h3>
                <p class="mt-1 text-sm text-zinc-500">
                    No pending users at the moment.
                </p>
            </div>
        @endforelse
    </div>