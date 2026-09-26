<?php

namespace App\Services;

use App\Models\GameSession;
use InvalidArgumentException;

class QuizService
{
    public function all(): array
    {
        $isSw = app()->getLocale() === 'sw';

        return [
            'grand-champion' => [
                'key' => 'grand-champion',
                'title' => $isSw ? 'Mtihani Mkuu wa Bingwa' : 'Grand Champion Mixed Quiz',
                'title_sw' => 'Mtihani Mkuu wa Bingwa',
                'title_en' => 'Grand Champion Mixed Quiz',
                'icon' => '🏆',
                'badge' => $isSw ? 'Kadi Zote 11 Zimeunganishwa' : 'All 11 Cards Combined',
                'description' => $isSw
                    ? 'Mtihani mkuu unaochanganya kadi zote 11 za hesabu kutoka bustanini, kisiwani na kijijini!'
                    : 'The grand mixed quiz combining all 11 fruit math cards across all worlds!',
                'operations' => ['counting', 'addition', 'subtraction', 'comparison', 'multiplication', 'division', 'fractions', 'money', 'time', 'shapes', 'word-problems'],
                'questions_count' => 11,
                'difficulty' => 2,
                'target' => 70,
                'reward' => 200,
                'stars' => 3,
                'world' => 'fruit-garden',
                'theme' => [
                    'card_bg' => 'from-amber-400 via-yellow-300 to-amber-500',
                    'border' => 'border-amber-300',
                    'glow' => 'rgba(245, 158, 11, 0.4)',
                ],
            ],
            'speed-rush' => [
                'key' => 'speed-rush',
                'title' => $isSw ? 'Kasi ya Matunda' : 'Fruit Speed Rush Quiz',
                'title_sw' => 'Kasi ya Matunda',
                'title_en' => 'Fruit Speed Rush Quiz',
                'icon' => '⚡',
                'badge' => $isSw ? 'Hesabu za Kasi' : 'Speed Math Challenge',
                'description' => $isSw
                    ? 'Jaribio la kasi kubwa linalochanganya kadi za kujumlisha, kutoa, kuzidisha, kugawa na kulinganisha!'
                    : 'Fast-paced mental challenge combining arithmetic cards for rapid-fire thinking!',
                'operations' => ['addition', 'subtraction', 'multiplication', 'division', 'comparison'],
                'questions_count' => 10,
                'difficulty' => 2,
                'target' => 60,
                'reward' => 150,
                'stars' => 3,
                'world' => 'banana-island',
                'theme' => [
                    'card_bg' => 'from-orange-400 via-amber-400 to-yellow-400',
                    'border' => 'border-orange-300',
                    'glow' => 'rgba(249, 115, 22, 0.4)',
                ],
            ],
            'real-world-logic' => [
                'key' => 'real-world-logic',
                'title' => $isSw ? 'Maisha & Mantiki' : 'Real-World & Logic Quiz',
                'title_sw' => 'Maisha & Mantiki',
                'title_en' => 'Real-World & Logic Quiz',
                'icon' => '🧠',
                'badge' => $isSw ? 'Akili & Maisha' : 'Logic & Practical Math',
                'description' => $isSw
                    ? 'Pima uwezo wako wa hesabu za maisha halisi: Saa, Pesa za Matunda, Sehemu, Maumbo na Mafumbo!'
                    : 'Apply real-world math skills: Clocks, Fruit Shop Money, Fractions, Geometry Shapes & Stories!',
                'operations' => ['time', 'money', 'fractions', 'shapes', 'word-problems'],
                'questions_count' => 10,
                'difficulty' => 2,
                'target' => 60,
                'reward' => 175,
                'stars' => 3,
                'world' => 'mango-village',
                'theme' => [
                    'card_bg' => 'from-emerald-400 via-teal-400 to-green-500',
                    'border' => 'border-emerald-300',
                    'glow' => 'rgba(16, 185, 129, 0.4)',
                ],
            ],
            'ultimate-mastery' => [
                'key' => 'ultimate-mastery',
                'title' => $isSw ? 'Uzamili Mkuu wa StreetCode' : 'StreetCode Ultimate Mastery',
                'title_sw' => 'Uzamili Mkuu wa StreetCode',
                'title_en' => 'StreetCode Ultimate Mastery',
                'icon' => '👑',
                'badge' => $isSw ? 'Kiwango cha Juu' : 'Mastery Level Exam',
                'description' => $isSw
                    ? 'Mtihani wa kiwango cha juu wa wataalamu wa hesabu za matunda! Maswali magumu zaidi ya kadi zote.'
                    : 'The supreme challenge for Fruit Math champions! Advanced multi-card master exam.',
                'operations' => ['counting', 'addition', 'subtraction', 'comparison', 'multiplication', 'division', 'fractions', 'money', 'time', 'shapes', 'word-problems'],
                'questions_count' => 12,
                'difficulty' => 3,
                'target' => 80,
                'reward' => 300,
                'stars' => 5,
                'world' => 'fruit-garden',
                'theme' => [
                    'card_bg' => 'from-purple-500 via-indigo-500 to-sky-500',
                    'border' => 'border-purple-300',
                    'glow' => 'rgba(147, 51, 234, 0.4)',
                ],
            ],
        ];
    }

    public function find(string $key): ?array
    {
        return $this->all()[$key] ?? null;
    }

    public function buildOperationQueue(array $operations, int $totalQuestions): array
    {
        $queue = [];
        $pool = $operations;
        while (count($queue) < $totalQuestions) {
            if (empty($pool)) {
                $pool = $operations;
            }
            $queue[] = array_shift($pool);
        }

        return $queue;
    }

    public function questionFor(GameSession $session, int $questionNumber): array
    {
        $queue = $session->settings['operation_queue'] ?? $session->settings['operations'] ?? ['addition'];
        $idx = max(0, $questionNumber - 1) % count($queue);
        $op = $queue[$idx];
        $difficulty = (int) ($session->settings['difficulty'] ?? 2);

        return app(QuestionGenerator::class)->generate($op, $difficulty);
    }
}
