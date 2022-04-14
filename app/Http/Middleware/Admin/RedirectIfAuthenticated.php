<?php

namespace App\Http\Middleware\Admin;

use Carbon\Carbon;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RedirectIfAuthenticated
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
        if (!Auth::guard($guard)->check() ) {
            return redirect('admin/login');
        }


        if (!Gate::forUser(Auth::guard($guard)->user())->allows('access-dashboard')) {
            Auth::guard($guard)->logout();
            // abort(403);
        }


        if ($this->guard()->user()->isClosedAccount()) {
            $this->logout($request);
        }


        // if (!Auth::guard($guard)->user()->hasPermission('access-dashboard')) {
            //     Auth::guard($guard)->logout();
            // }


            // dd(Auth::guard());

        return $next($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function logout($request)
    {
        $this->guard()->logoutCurrentDevice();

        $request->session()->flush();

        throw new AuthenticationException('Unauthenticated.', ['admin'], '/admin');
    }

    /**
     * Get the guard instance that should be used by the middleware.
     *
     * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
