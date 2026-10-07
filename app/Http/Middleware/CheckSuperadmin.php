<?php

namespace App\Http\Middleware;

use Closure;

class CheckSuperadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'Superadmin') {
            return $next($request);
        }

        return redirect('/home')->withErrors(['error' => 'Akses ditolak! Halaman ini khusus untuk Superadmin.']);
    }
}
