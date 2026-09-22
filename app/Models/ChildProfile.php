<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildProfile extends Model
{
    protected $fillable = ['user_id', 'name', 'avatar', 'date_of_birth', 'preferred_language', 'xp', 'stars', 'current_level', 'current_streak', 'longest_streak'];

    protected function casts(): array
    {
        return ['date_of_birth' => 'date'];
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function progress()
    {
        return $this->hasMany(LevelProgress::class);
    }

    public function sessions()
    {
        return $this->hasMany(GameSession::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'child_achievements')->withPivot('earned_at');
    }
}
