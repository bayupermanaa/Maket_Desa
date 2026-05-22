<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureKepalaDesaRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $sessionRole = session('role');
        $authRole = auth()->check() ? auth()->user()->role : null;

        if ($sessionRole === 'kepala_desa' || $authRole === 'kepala_desa') {
            return $next($request);
        }

        return redirect()->route('login.kepala-desa')
            ->with('error', 'Akses ditolak. Silakan login sebagai kepala desa.');
    }
}
