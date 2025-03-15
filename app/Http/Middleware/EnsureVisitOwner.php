<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureVisitOwner
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $visit = $request->route('visit');
        if ($visit && $visit->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }
        return $next($request);
    }
}
