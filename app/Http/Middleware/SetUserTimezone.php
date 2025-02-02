<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SetUserTimezone
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->timezone) {
            // Set the application's timezone to the user's timezone
            config(['app.timezone' => Auth::user()->timezone]);
            date_default_timezone_set(Auth::user()->timezone);
            Carbon::setLocale(Auth::user()->timezone);
        }

        return $next($request);
    }
}
