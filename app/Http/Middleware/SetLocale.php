<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $r, Closure $next)
    {
        app()->setLocale(session('locale', config('app.locale', 'en')));

        return $next($r);
    }
}
