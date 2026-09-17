<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'type', 'target', 'xp_reward'];
}
