<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            if ($role === 'admin') {
                return redirect()->route('admin.login');
            }
            return redirect()->route('mobile.login');
        }

        return $next($request);
    }
}
