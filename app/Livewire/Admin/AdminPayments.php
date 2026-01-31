<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Payment;
use App\Models\Setting; // Ensure you have a Setting model/table

class AdminPayments extends Component
{
    public $payments;

    // Form fields for the categories
    public $reg_fee;
    public $match_fee;

    public function mount()
    {
        $this->loadData();

        // Load existing values from a settings table or default to 0
        $this->reg_fee = Setting::where('key', 'registration_fee')->value('value') ?? 0;
        $this->match_fee = Setting::where('key', 'match_fee')->value('value') ?? 0;
    }

    public function loadData()
    {
        $this->payments = Payment::with('team')->orderBy('created_at', 'desc')->get();
    }

    public function updateAmount($key, $value)
    {
        // Validate that the input is numeric
        if (!is_numeric($value))
            return;

        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        session()->flash('message', 'Global fee updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.admin-payments');
    }
}
