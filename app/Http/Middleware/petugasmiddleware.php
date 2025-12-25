<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PetugasMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() && !auth()->guard('sanctum')->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 401);
            }
            return redirect()->route('admin.login');
        }

        $user = auth()->user() ?? auth()->guard('sanctum')->user();

        if ($user->role !== 'petugas') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya petugas yang dapat mengakses endpoint ini.',
                ], 403);
            }
            abort(403, 'Akses ditolak. Hanya petugas yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
