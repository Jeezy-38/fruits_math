<?php

namespace App\Livewire\Child;

use App\Models\Achievement;
use App\Models\GameLevel;
use App\Support\CurrentChild;
use Livewire\Component;

class ChildHome extends Component
{
    public const AVATARS = ['🧒🏾', '👧🏽', '🦁', '🐯', '🐰', '🐼', '🦊', '🐵', '🦄', '🚀', '⭐', '👑'];

    public bool $showAvatarPicker = false;

    public function toggleAvatarPicker(): void
    {
        $this->showAvatarPicker = ! $this->showAvatarPicker;
    }

    public function selectAvatar(string $avatar): void
    {
        $child = CurrentChild::get();
        abort_unless($child, 403);

        if (in_array($avatar, self::AVATARS, true)) {
            $child->avatar = $avatar;
            $child->save();
        }

        $this->showAvatarPicker = false;
    }

    public function render()
    {
        $child = CurrentChild::get();
        abort_unless($child, 403);
        $next = GameLevel::where('level_number', $child->current_level)->whereHas('world', fn ($q) => $q->where('is_active', true))->first();
        $achievements = Achievement::all();
        $earnedIds = $child->achievements()->pluck('achievements.id')->all();

        $quizzes = app(\App\Services\QuizService::class)->all();
        $hasCompletedAll = $child->hasCompletedAllGames();
        $completedCount = $child->completedGamesCount();
        $totalCount = $child->totalGamesCount();

        $completedQuizzes = \App\Models\GameSession::where('child_profile_id', $child->id)
            ->whereNull('game_level_id')
            ->where('operation', 'mixed')
            ->whereNotNull('completed_at')
            ->get()
            ->groupBy(fn ($s) => $s->settings['quiz_key'] ?? '');

        return view('livewire.child.home', compact('child', 'next', 'achievements', 'earnedIds', 'quizzes', 'hasCompletedAll', 'completedCount', 'totalCount', 'completedQuizzes'))->layout('layouts.app');
    }
}
