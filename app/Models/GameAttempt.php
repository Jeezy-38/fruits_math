<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameAttempt extends Model
{
    protected $fillable = ['question_number', 'game_session_id', 'operation', 'question_data', 'expected_answer', 'given_answer', 'is_correct', 'response_time_ms'];

    protected function casts(): array
    {
        return ['question_data' => 'array', 'is_correct' => 'boolean'];
    }

    public function session()
    {
        return $this->belongsTo(GameSession::class, 'game_session_id');
    }
}
