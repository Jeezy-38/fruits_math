<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameLevel extends Model
{
    protected $fillable = ['game_world_id', 'name', 'icon', 'operation', 'level_number', 'difficulty', 'questions_count', 'required_score', 'xp_reward', 'is_boss'];

    protected function casts(): array
    {
        return ['is_boss' => 'boolean'];
    }

    public function world()
    {
        return $this->belongsTo(GameWorld::class, 'game_world_id');
    }

    public function progress()
    {
        return $this->hasMany(LevelProgress::class);
    }
}
