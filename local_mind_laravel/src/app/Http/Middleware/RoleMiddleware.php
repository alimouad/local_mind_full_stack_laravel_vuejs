<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
            if (auth()->user()?->role !== $role) {
                
                return redirect()->route('home');
            }

        return $next($request);
    }
    
}
