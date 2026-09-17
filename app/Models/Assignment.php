<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['curriculum_lesson_id', 'rules', 'classroom_id', 'teacher_id', 'title', 'operation', 'difficulty', 'questions_count', 'target_score', 'due_at', 'is_active'];

    protected function casts(): array
    {
        return ['rules' => 'array', 'due_at' => 'datetime', 'is_active' => 'boolean'];
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function progress()
    {
        return $this->hasMany(AssignmentProgress::class);
    }
}
