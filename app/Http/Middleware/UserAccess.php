<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {// Cek apakah pengguna memiliki akses sesuai peran yang diberikan
        if ($request->user()->role !== $role) {
            if ($request->user()->role === 'Employee') {
                // Redirect pengguna dengan peran Employee ke halaman yang sesuai
                return redirect()->route('empl-presence')->with('error', 'You are not authorized to access this page.');
            }elseif ($request->user()->role === 'Administrator'){
                // Redirect pengguna dengan peran Administrator ke halaman yang sesuai
                return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
            }
            // Jika peran pengguna bukan Employee, lanjutkan penanganan middleware
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
