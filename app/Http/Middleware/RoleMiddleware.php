<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = strtolower(Auth::user()->role);
        $allowedRoles = array_map('strtolower', $roles);

       if (!in_array($userRole, $allowedRoles)) {
    dd([
        'login_user' => Auth::user(),
        'role_user' => $userRole,
        'allowed_roles' => $allowedRoles
    ]);
}


        return $next($request);
    }
}
