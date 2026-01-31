<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Team;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',           // Required for isPending() / isApproved() logic
        'approved_at',      // Required for approval timestamp
        'approved_by',      // Required to track which admin approved
        'rejected_at',      // Required for rejection timestamp
        'rejected_by',      // Required to track which admin rejected
        'rejection_reason', // Required for the custom rejection reason
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function team(): HasOne
    {
        return $this->hasOne(Team::class, 'team_manager_id');
    }
    public function assignedGames()
    {
        return $this->hasMany(Game::class, 'statistician_id');
    }

    /* ---------------------- Approval Helper Methods ---------------------- */

    /**
     * Check if the user is approved (active)
     */
    public function isApproved(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if the user has been rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if the user is pending approval
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

}
