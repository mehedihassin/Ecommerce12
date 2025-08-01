<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {
            if (Auth::user()->usertype == 'admin') {
                return $next($request); 
            } else {
                return redirect()->route('login')->with('error', 'You do not have admin access.');
            }
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }
    }
}
