<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\ChildProfile;
use App\Models\GameWorld;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment(['local', 'testing'])) {
            $parent = User::firstOrCreate(['email' => 'parent@fruitmath.test'], ['name' => 'Demo Parent', 'password' => Hash::make('password'), 'role' => 'parent']);
            ChildProfile::firstOrCreate(['user_id' => $parent->id, 'name' => 'Amani'], ['avatar' => '🧒🏾', 'preferred_language' => 'en', 'current_level' => 1]);
            User::firstOrCreate(['email' => 'admin@fruitmath.test'], ['name' => 'Demo Admin', 'password' => Hash::make('password'), 'role' => 'admin']);
        }
        $worlds = [
            ['Fruit Garden', 'fruit-garden', '🌳', 'Start with numbers and simple operations.', 1, [['Counting', '🍎', 'counting'], ['Addition', '➕', 'addition'], ['Subtraction', '➖', 'subtraction'], ['Comparison', '⚖️', 'comparison']]],
            ['Banana Island', 'banana-island', '🍌', 'Learn groups, sharing and fractions.', 2, [['Multiplication', '✖️', 'multiplication'], ['Division', '➗', 'division'], ['Fractions', '🍉', 'fractions']]],
            ['Mango Village', 'mango-village', '🥭', 'Use maths in everyday life.', 3, [['Fruit Shop', '💰', 'money'], ['Time', '🕐', 'time'], ['Shapes', '🔺', 'shapes'], ['Word Problems', '📖', 'word-problems']]],
        ];
        $n = 1;
        foreach ($worlds as [$name,$slug,$icon,$desc,$pos,$levels]) {
            $w = GameWorld::updateOrCreate(['slug' => $slug], ['name' => $name, 'icon' => $icon, 'description' => $desc, 'position' => $pos, 'is_active' => true]);
            foreach ($levels as [$ln,$li,$op]) {
                $w->levels()->updateOrCreate(['level_number' => $n], ['name' => $ln, 'icon' => $li, 'operation' => $op, 'difficulty' => max(1, $pos), 'questions_count' => 10, 'required_score' => 60, 'xp_reward' => 100 + ($pos * 25)]);
                $n++;
            }
        }
        foreach ([['Apple Starter', 'apple-starter', 'Complete your first level', '🍎', 'levels', 1, 50], ['Star Collector', 'star-collector', 'Collect 25 stars', '⭐', 'stars', 25, 100], ['Math Explorer', 'math-explorer', 'Reach level 5', '🗺️', 'levels', 5, 150]] as $a) {
            Achievement::updateOrCreate(['slug' => $a[1]], array_combine(['name', 'slug', 'description', 'icon', 'type', 'target', 'xp_reward'], $a));
        }
    }
}
