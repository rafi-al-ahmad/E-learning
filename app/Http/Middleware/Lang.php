<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Lang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // dd(request()->cookie('language'));
        if ((request()->cookie('language'))) {
            App::setLocale(request()->cookie('language'));
        }
        // dd(Language::getAllLanguagesNames());
        // trans()
        return $next($request);
    }
}
