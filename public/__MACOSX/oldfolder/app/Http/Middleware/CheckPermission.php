<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
 public function handle(Request $request, Closure $next, ...$permissions)
{
    $user = Auth::user();

    if (!$user) {
        return response()->view('errors.no-access', [], 403);
    }

    if ($user->user_type === 'admin') {
        return $next($request);
    }

    foreach ($permissions as $permission) {
        if (hasPermission($permission)) {
            return $next($request);
        }
    }

    // 👇 HERE IS THE MAGIC
    return response()->view('errors.no-access', [], 403);
}
    
    
}