<?php

namespace App\Livewire\Child;

use App\Models\GameWorld;
use App\Support\CurrentChild;
use Livewire\Component;

class WorldMap extends Component
{
    public function render()
    {
        $child = CurrentChild::get();
        abort_unless($child, 403);
        $worlds = GameWorld::where('is_active', true)->with(['levels.progress' => fn ($q) => $q->where('child_profile_id', $child->id)])->orderBy('position')->get();

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

        return view('livewire.child.world-map', compact('child', 'worlds', 'quizzes', 'hasCompletedAll', 'completedCount', 'totalCount', 'completedQuizzes'))->layout('layouts.app');
    }
}
