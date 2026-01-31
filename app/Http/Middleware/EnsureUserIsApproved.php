<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Not logged in
        if (!$user) {
            return redirect()->route('login');
        }

        // Rejected users → redirect to rejection page
        if ($user->isRejected()) {
            Auth::logout();
            return redirect()->route('approval.rejected');
        }

        // Pending users → redirect to pending page
        if (!$user->isApproved()) {
            Auth::logout();
            return redirect()->route('approval.pending');
        }

        return $next($request);
    }
}
