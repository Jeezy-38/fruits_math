<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyStreak extends Model
{
    protected $fillable = ['child_profile_id', 'activity_date', 'questions_answered', 'xp_earned'];

    protected function casts(): array
    {
        return ['activity_date' => 'date'];
    }
}
