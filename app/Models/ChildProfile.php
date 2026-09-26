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

    public function totalGamesCount(): int
    {
        return GameLevel::whereHas('world', fn ($q) => $q->where('is_active', true))->count();
    }

    public function completedGamesCount(): int
    {
        return $this->progress()->where('completed', true)->count();
    }

    public function hasCompletedAllGames(): bool
    {
        $total = $this->totalGamesCount();
        if ($total === 0) {
            return false;
        }

        return $this->current_level > $total || $this->completedGamesCount() >= $total;
    }
}
