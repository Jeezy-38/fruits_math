<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurriculumTopic extends Model
{
    protected $fillable = ['name', 'slug', 'operation', 'icon', 'min_age', 'max_age', 'position', 'is_active'];

    public function lessons()
    {
        return $this->hasMany(CurriculumLesson::class);
    }
}
