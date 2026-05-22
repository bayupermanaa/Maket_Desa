<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $sessionRole = session('role');
        $authRole = auth()->check() ? auth()->user()->role : null;

        $allowedRoles = ['admin_desa'];

        if (in_array($sessionRole, $allowedRoles, true) || in_array($authRole, $allowedRoles, true)) {
            return $next($request);
        }

        return redirect()->route('login.admin')
            ->with('error', 'Akses ditolak. Silakan login sebagai admin.');
    }
}
