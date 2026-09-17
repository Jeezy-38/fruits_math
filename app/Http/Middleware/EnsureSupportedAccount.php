<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSupportedAccount
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && ! in_array($request->user()->role, ['parent', 'admin'], true)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['email' => 'This account type is no longer supported.']);
        }

        return $next($request);
    }
}
