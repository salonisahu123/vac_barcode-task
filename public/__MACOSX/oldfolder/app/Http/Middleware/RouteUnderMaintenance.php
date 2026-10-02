<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteUnderMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          // Check if the specific route is being accessed
         $isUnderMaintenance = false; // Set to true to enable maintenance

        if ($isUnderMaintenance) {
            return response()->view('under_maintenance'); // Redirect to maintenance page
        }
        return $next($request);
    }
}
