<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->status !== 'approved') {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                abort(403, 'Your account is not approved.');
            }
        }

        return $next($request);
    }
}
