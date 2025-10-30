<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UserApproval extends Component
{
    public function approve($userId)
    {
        $user = User::findOrFail($userId);
        $user->status = 'active';
        $user->save();

        session()->flash('message', "{$user->name} has been approved successfully.");
        $this->dispatch('refresh-component'); // Dispatch event to refresh component
    }

    public function reject($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        session()->flash('message', "{$user->name} has been rejected and removed.");
        $this->dispatch('refresh-component'); // Dispatch event to refresh component
    }

    public function render()
    {
        $pendingUsers = User::where('status', 'pending')->with('roles')->get();

        return view('livewire.admin.user-approval', [
            'pendingUsers' => $pendingUsers,
        ]);
    }
}
