<?php

namespace App\Services;

use App\Models\ChildProfile;
use App\Models\GameLevel;
use App\Models\LevelProgress;

class ProgressService
{
    public function complete(ChildProfile $child, GameLevel $level, int $correct, int $total): LevelProgress
    {
        $pct = (int) round(($correct / max($total, 1)) * 100);
        $stars = $pct >= 90 ? 3 : ($pct >= 75 ? 2 : ($pct >= 60 ? 1 : 0));
        $p = LevelProgress::firstOrNew(['child_profile_id' => $child->id, 'game_level_id' => $level->id]);
        $wasCompleted = (bool) $p->completed;
        $oldStars = (int) ($p->stars ?? 0);
        $oldBest = (int) ($p->best_score ?? 0);
        $p->best_score = max($oldBest, $pct);
        $p->stars = max($oldStars, $stars);
        $p->attempts = ((int) $p->attempts) + 1;
        if ($pct >= $level->required_score) {
            $p->completed = true;
            $p->completed_at ??= now();
            $child->current_level = max($child->current_level, $level->level_number + 1);
        }
        $newStars = max(0, $p->stars - $oldStars);
        $child->stars += $newStars;
        $child->xp += (! $wasCompleted && $p->completed) ? $level->xp_reward : 0;
        $child->save();
        $p->save();

        return $p;
    }

    public function unlocked(ChildProfile $child, GameLevel $level): bool
    {
        return $level->level_number <= $child->current_level;
    }
}
