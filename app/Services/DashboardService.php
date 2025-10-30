<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public static function userDashboardRoute(): string
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->can('access-admin-dashboard')) {
                return route('admin.dashboard');
            } elseif ($user->can('access-team-manager-dashboard')) {
                return route('team-manager.dashboard');
            } elseif ($user->can('access-statistician-dashboard')) {
                return route('statistician.dashboard');
            } elseif ($user->can('access-scorekeeper-dashboard')) {
                return route('scorekeeper.dashboard');
            }
        }
        return route('dashboard');
    }
}
