<?php

namespace App\Services;

use App\Models\ChildProfile;
use App\Models\GameAttempt;

class ChildAnalyticsService
{
    public function summary(ChildProfile $c): array
    {
        $q = GameAttempt::whereHas('session', fn ($x) => $x->where('child_profile_id', $c->id));
        $total = (clone $q)->count();
        $correct = (clone $q)->where('is_correct', true)->count();

        return ['questions' => $total, 'correct' => $correct, 'accuracy' => $total ? round($correct / $total * 100) : 0, 'stars' => $c->stars, 'xp' => $c->xp, 'streak' => $c->current_streak];
    }

    public function operations(ChildProfile $c)
    {
        return GameAttempt::whereHas('session', fn ($x) => $x->where('child_profile_id', $c->id))->get()->groupBy('operation')->map(fn ($g) => ['total' => $g->count(), 'accuracy' => round($g->where('is_correct', true)->count() / max(1, $g->count()) * 100)])->sortBy('accuracy');
    }
}
