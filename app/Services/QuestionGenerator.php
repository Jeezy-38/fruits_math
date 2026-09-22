<?php

namespace App\Services;

use InvalidArgumentException;

class QuestionGenerator
{
    public const OPERATIONS = ['counting', 'addition', 'subtraction', 'multiplication', 'division', 'fractions', 'money', 'time', 'shapes', 'comparison', 'word-problems'];

    public function forRules(string $operation, int $difficulty, array $rules = []): array
    {
        if (! $rules || ! in_array($operation, ['counting', 'addition', 'subtraction', 'multiplication', 'division', 'comparison', 'word-problems'], true)) {
            return $this->generate($operation, $difficulty);
        }
        $min = (int) ($rules['min'] ?? 1);
        $max = (int) ($rules['max'] ?? 10);
        if ($min < 0 || $max < $min || $max > 100) {
            throw new InvalidArgumentException('Invalid number range.');
        }
        $left = random_int($min, $max);
        $right = random_int($min, $max);
        if ($operation === 'multiplication' || $operation === 'division') {
            $tables = $rules['tables'] ?? [2, 3, 4, 5];
            if (! $tables || array_filter($tables, fn ($n) => ! is_int($n) || $n < 1 || $n > 12)) {
                throw new InvalidArgumentException('Invalid times tables.');
            }
            $right = $tables[array_rand($tables)];

            return $operation === 'multiplication'
             ? $this->q($operation, $left, $right, $left * $right, app()->getLocale() === 'sw' ? "Vikundi $left vya $right. Jumla ni ngapi?" : "$left groups of $right. How many altogether?")
             : $this->q($operation, $left * $right, $right, $left, app()->getLocale() === 'sw' ? "Gawa matunda ".($left * $right)." sawa kwa vikapu $right." : 'Share '.($left * $right)." fruits equally between $right baskets.");
        }
        if ($operation === 'subtraction') {
            [$left,$right] = [max($left, $right), min($left, $right)];
        }
        if ($operation === 'comparison') {
            return $this->q($operation, $left, $right, $left === $right ? '=' : ($left > $right ? '>' : '<'), __('game.comparison_instruction'), ['options' => ['<', '>', '=']]);
        }
        $answer = match ($operation) {
            'counting' => $left,'subtraction' => $left - $right,default => $left + $right
        };
        $instruction = match ($operation) {
            'counting' => __('game.count_fruits'),'subtraction' => __('game.subtraction_instruction'),'word-problems' => app()->getLocale() === 'sw' ? "Asha ana matunda $left. Anapewa $right zaidi. Sasa ana mangapi?" : "Asha has $left fruits and gets $right more. How many now?",default => __('game.addition_instruction')
        };

        return $this->q($operation, $left, $right, $answer, $instruction);
    }

    public function generate(string $op, int $level = 1): array
    {
        return match ($op) {
            'counting' => $this->counting($level),'addition' => $this->addition($level),'subtraction' => $this->subtraction($level),'multiplication' => $this->multiplication($level),'division' => $this->division($level),'fractions' => $this->fractions($level),'money' => $this->money($level),'time' => $this->time($level),'shapes' => $this->shapes($level),'comparison' => $this->comparison($level),'word-problems' => $this->wordProblem($level),default => throw new InvalidArgumentException("Unsupported operation: $op")
        };
    }

    private function fruit(): string
    {
        $a = ['apple', 'banana', 'orange', 'mango', 'strawberry'];

        return $a[array_rand($a)];
    }

    private function options(int|string $answer, array $pool = []): array
    {
        if ($pool) {
            $wrong = array_values(array_filter(array_unique($pool), fn ($v) => (string) $v !== (string) $answer));
            shuffle($wrong);
            $options = array_merge([$answer], array_slice($wrong, 0, 3));
        } else {
            $options = [$answer];
            $number = (int) $answer;
            foreach ([-1, 1, -2, 2, -3, 3, 4] as $offset) {
                $candidate = $number + $offset;
                if ($candidate >= 0 && ! in_array($candidate, $options, true)) {
                    $options[] = $candidate;
                }
                if (count($options) === 4) {
                    break;
                }
            }
        }
        shuffle($options);

        return $options;
    }

    private function q($op, $l, $r, $a, $instruction, $extra = []): array
    {
        return array_merge(['operation' => $op, 'left' => $l, 'right' => $r, 'answer' => $a, 'fruit' => $this->fruit(), 'instruction' => $instruction, 'options' => is_int($a) ? $this->options($a) : []], $extra);
    }

    private function counting($level)
    {
        $a = random_int(1, $level < 4 ? 10 : 20);

        return $this->q('counting', $a, 0, $a, __('game.count_fruits'));
    }

    private function addition($level)
    {
        $m = $level < 3 ? 5 : ($level < 6 ? 10 : 20);
        $l = random_int(1, $m);
        $r = random_int(1, $m);

        return $this->q('addition', $l, $r, $l + $r, __('game.addition_instruction'));
    }

    private function subtraction($level)
    {
        $m = $level < 4 ? 10 : 20;
        $l = random_int(2, $m);
        $r = random_int(1, $l);

        return $this->q('subtraction', $l, $r, $l - $r, __('game.subtraction_instruction'));
    }

    private function multiplication($level)
    {
        $m = $level < 4 ? 5 : 12;
        $l = random_int(1, $m);
        $r = random_int(1, $m);

        return $this->q('multiplication', $l, $r, $l * $r, app()->getLocale() === 'sw' ? "Vikundi $l vya $r. Jumla ni ngapi?" : "$l groups of $r. How many altogether?");
    }

    private function division($level)
    {
        $r = random_int(2, $level < 4 ? 5 : 10);
        $a = random_int(1, $level < 4 ? 5 : 10);

        return $this->q('division', $r * $a, $r, $a, app()->getLocale() === 'sw' ? "Gawa matunda ".($r * $a)." sawa kwa vikapu $r." : 'Share '.($r * $a)." fruits equally between $r baskets.");
    }

    private function fractions($level)
    {
        $d = $level < 3 ? [2, 3, 4][array_rand([2, 3, 4])] : random_int(2, 6);
        $n = random_int(1, $d - 1);
        $a = "$n/$d";
        $pool = [];
        for ($i = 0; $i <= $d; $i++) {
            $pool[] = "$i/$d";
        }if ($d === 2) {
            $pool[] = '1/3';
        }

        return array_merge($this->q('fractions', $n, $d, $a, app()->getLocale() === 'sw' ? 'Sehemu gani imepakwa rangi?' : 'What fraction is shaded?'), ['options' => $this->options($a, $pool), 'numerator' => $n, 'denominator' => $d]);
    }

    private function money($level)
    {
        $items = [['apple', 500], ['banana', 300], ['orange', 400], ['mango', 800], ['strawberry', 600]];
        [$f,$price] = $items[array_rand($items)];
        $qty = random_int(1, $level < 3 ? 4 : 8);
        $a = $price * $qty;

        $msg = app()->getLocale() === 'sw' ? "Nunua $qty ya $f kwa TZS ".number_format($price)." kila moja. Jumla ni shilingi ngapi?" : "Buy $qty $f(s) at TZS ".number_format($price).' each. How much?';

        return array_merge($this->q('money', $qty, $price, $a, $msg), ['fruit' => $f, 'price' => $price, 'quantity' => $qty]);
    }

    private function time($level)
    {
        $h = random_int(1, 12);
        $mins = $level < 2 ? 0 : [0, 30][array_rand([0, 30])];
        $a = sprintf('%d:%02d', $h, $mins);
        $pool = [$a, sprintf('%d:%02d', ($h % 12) + 1, $mins), sprintf('%d:%02d', $h, $mins === 0 ? 30 : 0), sprintf('%d:%02d', (($h + 10) % 12) + 1, $mins)];

        return array_merge($this->q('time', $h, $mins, $a, app()->getLocale() === 'sw' ? 'Saa inaonyesha saa ngapi?' : 'What time is shown?'), ['options' => $this->options($a, $pool), 'hour' => $h, 'minute' => $mins]);
    }

    private function shapes($level)
    {
        $shapes = [['circle', 0], ['triangle', 3], ['square', 4], ['rectangle', 4], ['pentagon', 5], ['hexagon', 6]];
        [$shape,$sides] = $shapes[array_rand($shapes)];
        $pool = array_column($shapes, 0);

        return array_merge($this->q('shapes', 0, 0, $shape, app()->getLocale() === 'sw' ? 'Hili ni umbo gani?' : 'Which shape is this?'), ['options' => $this->options($shape, $pool), 'shape' => $shape, 'sides' => $sides]);
    }

    private function wordProblem($level)
    {
        $names = ['Asha', 'Juma', 'Neema', 'Baraka'];
        $name = $names[array_rand($names)];
        $a = random_int(1, $level < 3 ? 5 : 10);
        $b = random_int(1, $level < 3 ? 5 : 10);
        $fruit = $this->fruit();
        $ans = $a + $b;
        $text = app()->getLocale() === 'sw' ? "$name ana $a $fruit. Anapewa $b zaidi. Sasa ana matunda mangapi?" : "$name has $a $fruit(s) and gets $b more. How many are there now?";

        return $this->q('word-problems', $a, $b, $ans, $text, ['story_name' => $name]);
    }

    private function comparison($level)
    {
        $m = $level < 4 ? 10 : 50;
        $l = random_int(1,$m);
        $r = random_int(1,$m);
        while ($r === $l) {
            $r = random_int(1,$m);
        }$a = $l > $r ? '>' : '<';

        return array_merge($this->q('comparison',$l,$r,$a,__('game.comparison_instruction')),['options' => ['<', '>', '=']]);
    }
}
