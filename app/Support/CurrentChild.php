<?php

namespace App\Support;

use App\Models\ChildProfile;

class CurrentChild
{
    public static function get(): ?ChildProfile
    {
        if (! auth()->check()) {
            return null;
        } $id = session('child_profile_id');

        return $id ? auth()->user()->children()->find($id) : null;
    }
}
