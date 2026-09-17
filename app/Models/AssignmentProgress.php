<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentProgress extends Model
{
    public function child()
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }

    protected $table = 'assignment_progress';

    protected $fillable = ['assignment_id', 'child_profile_id', 'best_score', 'attempts', 'completed', 'completed_at'];

    protected function casts(): array
    {
        return ['completed' => 'boolean', 'completed_at' => 'datetime'];
    }
}
