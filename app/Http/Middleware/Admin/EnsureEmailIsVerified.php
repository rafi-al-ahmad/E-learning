<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Redirect;

class EnsureEmailIsVerified
{

    protected $guard = 'admin';


    protected $redirectToRoute = 'admin.verification.notice';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if (
            !$request->user($this->guard) ||
            ($request->user($this->guard) instanceof MustVerifyEmail &&
                !$request->user($this->guard)->hasVerifiedEmail())
        ) {
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : Redirect::route($redirectToRoute ?: 'admin.verification.notice');
        }

        return $next($request);
    }
}
