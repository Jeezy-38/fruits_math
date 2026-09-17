<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelProgress extends Model
{
    protected $table = 'level_progress';

    protected $fillable = ['child_profile_id', 'game_level_id', 'best_score', 'stars', 'attempts', 'completed', 'completed_at'];

    protected function casts(): array
    {
        return ['completed' => 'boolean', 'completed_at' => 'datetime'];
    }

    public function child()
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }

    public function level()
    {
        return $this->belongsTo(GameLevel::class, 'game_level_id');
    }
}
