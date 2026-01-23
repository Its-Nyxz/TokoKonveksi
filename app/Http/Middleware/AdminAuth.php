<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session('admin')) {
            return redirect('home/login')->with([
                'swal_type' => 'warning',
                'swal_title' => 'Akses Ditolak',
                'swal_text' => 'Silakan login sebagai admin'
            ]);
        }
        return $next($request);
    }
}
