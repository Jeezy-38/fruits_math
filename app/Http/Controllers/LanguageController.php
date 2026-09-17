<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function __invoke(Request $r, string $locale)
    {
        abort_unless(in_array($locale, ['en', 'sw']), 404);
        session(['locale' => $locale]);
        if (auth()->check() && session('child_profile_id')) {
            auth()->user()->children()->whereKey(session('child_profile_id'))->update(['preferred_language' => $locale]);
        }

return back();
    }
}
