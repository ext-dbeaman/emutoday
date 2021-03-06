<?php

namespace Emutoday\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Emutoday\User;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if( ! cas()->isAuthenticated() )
        {
        if ($request->ajax()) {
            return response('Unauthorized.', 401);
        }
        cas()->authenticate();
        }
        $username = cas()->user() . '@emich.edu';
        $user = User::where('email', $username)->first();
        Auth::login($user, true);
        session()->put('cas_user', cas()->user() );
        return $next($request);
        // if (Auth::guard($guard)->guest()) {
        //     if ($request->ajax() || $request->wantsJson()) {
        //         return response('Unauthorized.', 401);
        //     } else {
        //         return redirect()->guest('login');
        //     }
        // }
        //
        // return $next($request);
    }
}
