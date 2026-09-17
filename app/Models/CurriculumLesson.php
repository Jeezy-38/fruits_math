<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurriculumLesson extends Model
{
    protected $fillable = ['curriculum_topic_id', 'name', 'slug', 'difficulty', 'rules', 'questions_count', 'required_score', 'xp_reward', 'is_active'];

    protected function casts(): array
    {
        return ['rules' => 'array', 'is_active' => 'boolean'];
    }

    public function topic()
    {
        return $this->belongsTo(CurriculumTopic::class, 'curriculum_topic_id');
    }
}
