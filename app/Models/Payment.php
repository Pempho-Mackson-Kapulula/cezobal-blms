<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Mass-assignable fields
    protected $fillable = [
        'team_id',
        'payment_type',
        'amount',
        'tx_ref',
        'status',
        'currency',
    ];

    /**
     * The team this payment belongs to
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Helper to check if payment was successful
     */
    public function isSuccessful()
    {
        return $this->status === 'successful';
    }

    /**
     * Helper to get a readable payment type
     */
    public function paymentTypeLabel()
    {
        return ucfirst($this->payment_type);

    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'successful');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('payment_type', $type);
    }

}
