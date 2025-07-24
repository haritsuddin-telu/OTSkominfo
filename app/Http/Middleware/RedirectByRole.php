<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectByRole
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin') && $request->route()->getName() !== 'dashboard') {
                return redirect()->route('dashboard');
            }
            if ($user->hasRole('pegawai') && $request->route()->getName() !== 'ots.form') {
                return redirect()->route('ots.form');
            }
        }
        return $next($request);
    }
}
