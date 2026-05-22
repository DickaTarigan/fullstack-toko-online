<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        // Langkah 1: Pastikan user sudah login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Langkah 2: Cek apakah role user ada di daftar yang diizinkan
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Akses ditolak. Role Anda tidak memiliki izin untuk halaman ini.');
        }

        // Langkah 3: Semua pemeriksaan lolos — teruskan ke controller
        return $next($request);
    }
}