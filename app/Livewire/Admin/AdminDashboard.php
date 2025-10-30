<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')] // Or a specific admin layout if you have one
class AdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}

