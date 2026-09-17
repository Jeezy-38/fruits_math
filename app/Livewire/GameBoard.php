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
    }

    public function nextQuestion(): void
    {
        $child = CurrentChild::get();
        abort_unless($child, 403);
        app(GameEngine::class)->advance($this->sessionId, $child, $this->questionNumber);
        $this->questionNumber = app(GameEngine::class)->owned($this->sessionId, $child)->question_number;
    }

    public function render()
    {
        $child = CurrentChild::get();
        abort_unless($child, 403);
        $session = app(GameEngine::class)->owned($this->sessionId, $child);
        $question = $session->current_question ?? [];
        $attempt = $session->attempts()->where('question_number', $session->question_number)->first();

        return view('livewire.game-board', [
            'title' => $session->settings['title'], 'icon' => $session->settings['icon'],
            'operation' => $session->operation, 'totalQuestions' => $session->total_questions,
            'score' => $session->attempts()->where('is_correct', true)->count() * 10,
            'correctCount' => $session->correct_answers, 'finished' => (bool) $session->completed_at,
            'passed' => $session->completed_at && round($session->correct_answers / $session->total_questions * 100) >= $session->settings['target'],
            'xpEarned' => $session->xp_earned, 'question' => $question,
            'left' => $question['left'] ?? 0, 'right' => $question['right'] ?? 0,
            'fruit' => $question['fruit'] ?? 'apple', 'instruction' => $question['instruction'] ?? '',
            'options' => $question['options'] ?? [], 'selectedAnswer' => $attempt?->given_answer,
            'correct' => $attempt?->is_correct, 'answer' => $attempt ? $attempt->expected_answer : null,
        ])->layout('layouts.app');
    }
}
