<?php

namespace App\Livewire\TeamManager;

use Livewire\Component;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class TeamPayments extends Component
{
    use WithPagination;

    public $payment_type;
    public $amount;
    
    // Filtering properties
    public $search = '';
    public $dateFilter = ''; // options: today, week, month, year

    protected $rules = [
        'payment_type' => 'required|in:registration,transfer,fine',
        'amount' => 'required|numeric|min:500'
    ];

    public function getRecentPaymentsProperty()
    {
        $team = Auth::user()->team;
        if (!$team) return collect();

        $query = Payment::where('team_id', $team->id);

        // Search by Reference
        if ($this->search) {
            $query->where('tx_ref', 'like', '%' . strtoupper($this->search) . '%');
        }

        // Date Filtering
        if ($this->dateFilter) {
            $query->where('created_at', '>=', match($this->dateFilter) {
                'today' => now()->startOfDay(),
                'week'  => now()->subDays(7),
                'month' => now()->subMonth(),
                'year'  => now()->subYear(),
            });
        }

        return $query->latest()->get();
    }

    public function cancelPayment($paymentId)
    {
        $team = Auth::user()->team;
        $payment = Payment::where('id', $paymentId)->where('team_id', $team->id)->where('status', 'pending')->first();

        if ($payment) {
            $payment->delete();
            session()->flash('message', 'Transaction removed.');
        }
    }

    public function submit()
    {
        $this->validate();
        $team = Auth::user()->team;

        if (!$team) {
            session()->flash('error', 'Team not found.');
            return;
        }

        $payment = Payment::create([
            'team_id' => $team->id,
            'payment_type' => $this->payment_type,
            'amount' => $this->amount,
            'tx_ref' => strtoupper(uniqid('CEZO_')),
            'status' => 'pending'
        ]);

        return redirect()->route('checkout', ['payment' => $payment->id]);
    }

    public function render()
    {
        return view('livewire.team-manager.team-payments', [
            'history' => $this->recentPayments
        ]);
    }
}