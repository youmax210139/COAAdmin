<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use Carbon\Carbon;

class SetLocale
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
        $locale = Cookie::get('locale', config('app.locale'));
        Carbon::setLocale($locale);
        app()->setLocale($locale);
        return $next($request);
    }
}
