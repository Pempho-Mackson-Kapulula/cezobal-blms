<div class="p-6 space-y-4">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
        Pending User Approvals
    </h1>

    @if (session()->has('message'))
        <div class="p-3 text-green-800 bg-green-100 rounded-md">
            {{ session('message') }}
        </div>
    @endif

    @forelse ($pendingUsers as $user)
        <div wire:key="{{ $user->id }}" class="flex justify-between items-center bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg shadow-sm">
            <div>
                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                <p class="text-sm text-gray-500 capitalize">
                    Requested Role: {{ $user->roles->first()?->name ?? 'No Role Assigned' }}
                </p>
            </div>
            <div class="flex gap-2">
                <button wire:click="approve({{ $user->id }})"
                    class="px-3 py-1.5 text-sm font-semibold text-white bg-green-600 rounded hover:bg-green-700">
                    Approve
                </button>
                <button wire:click="reject({{ $user->id }})"
                    class="px-3 py-1.5 text-sm font-semibold text-white bg-red-600 rounded hover:bg-red-700">
                    Reject
                </button>
            </div>
        </div>
    @empty
        <p class="text-gray-500 dark:text-gray-400">No pending users at the moment.</p>
    @endforelse
</div>
