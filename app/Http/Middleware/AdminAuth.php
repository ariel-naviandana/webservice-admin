<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        $isLoggedIn = Session::has('user_id');
        $isAdmin = Session::get('user_role') === 'admin';

        // Allow access to login routes
        if (in_array($request->route()->getName(), ['login_form', 'login_process'])) {
            if ($isLoggedIn && $isAdmin) {
                return redirect()->route('home.index');
            }
            return $next($request);
        }

        // Redirect to login if not logged in or not admin
        if (!$isLoggedIn || !$isAdmin) {
            return redirect()->route('login_form')->with('message', 'Silakan login sebagai admin.');
        }

        return $next($request);
    }
}
