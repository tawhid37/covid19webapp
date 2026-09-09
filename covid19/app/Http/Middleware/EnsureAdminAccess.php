<?php

namespace App\Http\Middleware;

use Closure;

class EnsureAdminAccess
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
        if (! $request->session()->has('admin_authenticated')) {
            return redirect('/adminpass');
        }

        return $next($request);
    }
}
