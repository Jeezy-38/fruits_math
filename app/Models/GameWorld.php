<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameWorld extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'description', 'position', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function levels()
    {
        return $this->hasMany(GameLevel::class)->orderBy('level_number');
    }
}
