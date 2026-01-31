<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Notifications\UserApprovedNotification;
use App\Notifications\UserRejectedNotification;

class UserApproval extends Component
{
    public array $rejectionReasons = [];
    public bool $showRejectModal = false;
    public $rejectUserId = null;

    public function mount(): void
    {
        abort_unless(Auth::user()?->can('approve-users'), 403);
    }

    /**
     * Using a Computed Property ensures $this->pendingUsers 
     * is always available and reactive.
     */
    #[Computed]
    public function pendingUsers()
    {
        return User::with('roles')
            ->where('status', 'pending')
            ->latest()
            ->get();
    }

    public function approve(int $userId): void
    {
        $user = User::where('status', 'pending')->findOrFail($userId);
        $user->update([
            'status' => 'active',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        $user->refresh(); 

        $user->notify(new UserApprovedNotification());

        unset($this->pendingUsers);

        session()->flash('message', "{$user->name} approved successfully.");
    }

    // --- Modal Logic Methods ---

    public function confirmReject(int $userId): void
    {
        $this->rejectUserId = $userId;
        $this->showRejectModal = true;
    }

    public function cancelReject(): void
    {
        $this->showRejectModal = false;
        $this->rejectUserId = null;
    }

    public function rejectConfirmed(): void
    {
        if (!$this->rejectUserId)
            return;

        $reason = $this->rejectionReasons[$this->rejectUserId] ?? '';
        $this->reject($this->rejectUserId, $reason);

        $this->cancelReject(); // Close modal and reset ID
    }

    public function reject(int $userId, string $reason = ''): void
    {
        $user = User::where('status', 'pending')->findOrFail($userId);
        $user->update(attributes: [
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejected_by' => Auth::id(),
            'rejection_reason' => $reason,
        ]);

        $user->refresh(); 

        $user->notify(new UserRejectedNotification($reason));

        unset($this->pendingUsers);

        session()->flash('message', "{$user->name} has been rejected.");
        unset($this->rejectionReasons[$userId]);
    }

    public function render()
    {
        return view('livewire.admin.user-approval');
    }
}
