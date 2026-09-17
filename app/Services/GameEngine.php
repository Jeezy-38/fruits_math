<?php

namespace App\Services;

use App\Models\ChildProfile;
use App\Models\DailyStreak;
use App\Models\GameLevel;
use App\Models\GameSession;
use Illuminate\Support\Facades\DB;

class GameEngine
{
    public function start(ChildProfile $child, GameLevel $level): GameSession
    {
        abort_unless($level->world?->is_active && $level->level_number <= $child->current_level, 403);
        $settings = ['title' => $level->name, 'icon' => $level->icon, 'difficulty' => $level->difficulty, 'rules' => [], 'target' => $level->required_score, 'reward' => $level->xp_reward];
        $operation = $level->operation;
        $total = $level->questions_count;
        abort_unless($total > 0 && $total <= 50, 422);

        return GameSession::create([
            'child_profile_id' => $child->id, 'game_level_id' => $level->id,
            'operation' => $operation, 'total_questions' => $total,
            'settings' => $settings, 'question_number' => 1, 'started_at' => now(),
            'current_question' => app(QuestionGenerator::class)->forRules($operation, $settings['difficulty'], $settings['rules']),
        ]);
    }

    public function owned(int $id, ChildProfile $child): GameSession
    {
        return GameSession::whereNull('assignment_id')->where('child_profile_id', $child->id)->findOrFail($id);
    }

    public function submit(int $id, ChildProfile $child, int $number, int|string $answer): void
    {
        DB::transaction(function () use ($id, $child, $number, $answer) {
            $session = GameSession::whereNull('assignment_id')->where('child_profile_id', $child->id)->lockForUpdate()->findOrFail($id);
            if ($session->completed_at || $session->question_number !== $number || $session->attempts()->where('question_number', $number)->exists()) {
                return;
            }
            $question = $session->current_question;
            abort_unless(in_array((string) $answer, array_map('strval', $question['options']), true), 422);
            $session->attempts()->create([
                'question_number' => $number, 'operation' => $session->operation, 'question_data' => $question,
                'expected_answer' => (string) $question['answer'], 'given_answer' => (string) $answer,
                'is_correct' => (string) $answer === (string) $question['answer'],
            ]);
        });
    }

    public function advance(int $id, ChildProfile $child, int $number): void
    {
        DB::transaction(function () use ($id, $child, $number) {
            $session = GameSession::whereNull('assignment_id')->where('child_profile_id', $child->id)->lockForUpdate()->findOrFail($id);
            if ($session->completed_at || $session->question_number !== $number || ! $session->attempts()->where('question_number', $number)->exists()) {
                return;
            }
            if ($number < $session->total_questions) {
                $session->update(['question_number' => $number + 1, 'current_question' => app(QuestionGenerator::class)->forRules($session->operation, $session->settings['difficulty'], $session->settings['rules'])]);

                return;
            }
            // All scoring and rewards come from persisted, first-answer attempts.
            $learner = ChildProfile::lockForUpdate()->findOrFail($child->id);
            $correct = $session->attempts()->where('is_correct', true)->count();
            $percent = (int) round($correct / $session->total_questions * 100);
            $earned = 0;
            if ($session->game_level_id) {
                $before = $learner->xp;
                app(ProgressService::class)->complete($learner, GameLevel::findOrFail($session->game_level_id), $correct, $session->total_questions);
                $earned = $learner->xp - $before;
            }
            $this->recordActivity($learner, $session->total_questions, $earned);
            $session->update(['correct_answers' => $correct, 'wrong_answers' => $session->total_questions - $correct, 'score' => $correct * 10, 'xp_earned' => $earned, 'completed_at' => now(), 'current_question' => null]);
        });
    }

    private function recordActivity(ChildProfile $child, int $questions, int $xp): void
    {
        $today = now()->toDateString();
        $activity = DailyStreak::where('child_profile_id', $child->id)->whereDate('activity_date', $today)->first() ?? new DailyStreak(['child_profile_id' => $child->id, 'activity_date' => $today]);
        if (! $activity->exists) {
            $yesterday = DailyStreak::where('child_profile_id', $child->id)->whereDate('activity_date', now()->subDay()->toDateString())->exists();
            $child->current_streak = $yesterday ? $child->current_streak + 1 : 1;
            $child->longest_streak = max($child->longest_streak, $child->current_streak);
            $child->save();
        }
        $activity->questions_answered = (int) $activity->questions_answered + $questions;
        $activity->xp_earned = (int) $activity->xp_earned + $xp;
        $activity->save();
    }
}
