<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Check verification status for ustad role
        if ($user->role === 'ustad' && !$user->isVerified()) {
            abort(403, 'Akun Anda sedang menunggu verifikasi oleh admin. Silakan hubungi admin untuk mendapatkan akses penuh.');
        }

        return $next($request);
    }
}