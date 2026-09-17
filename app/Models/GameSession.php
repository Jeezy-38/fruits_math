<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    protected $fillable = ['assignment_id', 'settings', 'current_question', 'question_number', 'child_profile_id', 'game_level_id', 'operation', 'total_questions', 'correct_answers', 'wrong_answers', 'score', 'xp_earned', 'started_at', 'completed_at'];

    protected function casts(): array
    {
        return ['settings' => 'array', 'current_question' => 'array', 'started_at' => 'datetime', 'completed_at' => 'datetime'];
    }

    public function attempts()
    {
        return $this->hasMany(GameAttempt::class);
    }

    public function child()
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }
}
