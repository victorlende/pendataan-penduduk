<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MasyarakatMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('masyarakat.login');
        }

        if (auth()->user()->role !== 'masyarakat') {
            abort(403, 'Akses ditolak. Hanya masyarakat yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
