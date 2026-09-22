<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\ChildProfile;
use Illuminate\Support\Facades\DB;

class AchievementService
{
    /**
     * Check the child's current stats against every achievement definition and
     * award any that newly qualify. Returns the achievements just earned so the
     * caller can celebrate them (e.g. show a badge on the finish screen).
     *
     * @return \App\Models\Achievement[]
     */
    public function checkAndAward(ChildProfile $child): array
    {
        $earnedIds = DB::table('child_achievements')->where('child_profile_id', $child->id)->pluck('achievement_id');

        $metrics = [
            'levels' => $child->progress()->where('completed', true)->count(),
            'stars' => $child->stars,
        ];

        $newlyEarned = [];
        foreach (Achievement::whereNotIn('id', $earnedIds)->get() as $achievement) {
            $value = $metrics[$achievement->type] ?? null;
            if ($value === null || $value < $achievement->target) {
                continue;
            }
            DB::table('child_achievements')->insert([
                'child_profile_id' => $child->id,
                'achievement_id' => $achievement->id,
                'earned_at' => now(),
            ]);
            $child->xp += $achievement->xp_reward;
            $newlyEarned[] = $achievement;
        }

        if ($newlyEarned) {
            $child->save();
        }

        return $newlyEarned;
    }
}
