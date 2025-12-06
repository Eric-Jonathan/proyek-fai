<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // cek apakah session user ada
        $user = Session::get('user');

        if (!$user) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        // cek role
        if ($user['role'] !== $role) {
            return back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
