<?php

namespace App\Livewire;

use App\Models\GameLevel;
use App\Services\GameEngine;
use App\Support\CurrentChild;
use Livewire\Attributes\Locked;
use Livewire\Component;

class GameBoard extends Component
{
    #[Locked]
    public int $sessionId;

    #[Locked]
    public int $questionNumber = 1;

    public array $newAchievements = [];

    public function mount(GameLevel $level): void
    {
        $child = CurrentChild::get();
        abort_unless($child, 403);
        $session = app(GameEngine::class)->start($child, $level);
        $this->sessionId = $session->id;
    }

    public function answer(int|string $value): void
    {
        $child = CurrentChild::get();
        abort_unless($child, 403);
        app(GameEngine::class)->submit($this->sessionId, $child, $this->questionNumber, $value);
        $attempt = app(GameEngine::class)->owned($this->sessionId, $child)
            ->attempts()->where('question_number', $this->questionNumber)->first();
        if ($attempt?->is_correct) {
            $this->dispatch('fx:correct');
        } elseif ($attempt) {
            $this->dispatch('fx:wrong');
        }
    }

    public function nextQuestion(): void
    {
        $child = CurrentChild::get();
        abort_unless($child, 403);
        $earned = app(GameEngine::class)->advance($this->sessionId, $child, $this->questionNumber);
        $session = app(GameEngine::class)->owned($this->sessionId, $child);
        $this->questionNumber = $session->question_number;
        if ($earned) {
            $this->newAchievements = array_map(fn ($a) => ['name' => $a->name, 'icon' => $a->icon, 'xp_reward' => $a->xp_reward], $earned);
            $this->dispatch('fx:confetti');
        }
        if ($session->completed_at) {
            $passed = round($session->correct_answers / $session->total_questions * 100) >= $session->settings['target'];
            if ($passed) {
                $this->dispatch('fx:victory');
            }
        }
    }

    public function render()
    {
        $child = CurrentChild::get();
        abort_unless($child, 403);
        $session = app(GameEngine::class)->owned($this->sessionId, $child);
        $question = $session->current_question ?? [];
        $attempt = $session->attempts()->where('question_number', $session->question_number)->first();
        $pct = $session->total_questions > 0 ? round($session->correct_answers / $session->total_questions * 100) : 0;
        $starsEarned = $pct >= 90 ? 3 : ($pct >= 75 ? 2 : ($pct >= 60 ? 1 : 0));
        $worldSlug = $session->level?->world?->slug ?? 'fruit-garden';

        return view('livewire.game-board', [
            'title' => $session->settings['title'], 'icon' => $session->settings['icon'],
            'operation' => $session->operation, 'totalQuestions' => $session->total_questions,
            'score' => $session->attempts()->where('is_correct', true)->count() * 10,
            'correctCount' => $session->correct_answers, 'finished' => (bool) $session->completed_at,
            'passed' => $session->completed_at && $pct >= $session->settings['target'],
            'starsEarned' => $starsEarned,
            'worldSlug' => $worldSlug,
            'xpEarned' => $session->xp_earned, 'newAchievements' => $this->newAchievements, 'question' => $question,
            'left' => $question['left'] ?? 0, 'right' => $question['right'] ?? 0,
            'fruit' => $question['fruit'] ?? 'apple', 'instruction' => $question['instruction'] ?? '',
            'options' => $question['options'] ?? [], 'selectedAnswer' => $attempt?->given_answer,
            'correct' => $attempt?->is_correct, 'answer' => $attempt ? $attempt->expected_answer : null,
        ])->layout('layouts.app');
    }
}
