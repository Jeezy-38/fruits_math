<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_profiles', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('avatar')->nullable();
            $t->date('date_of_birth')->nullable();
            $t->string('preferred_language', 5)->default('en');
            $t->unsignedInteger('xp')->default(0);
            $t->unsignedInteger('stars')->default(0);
            $t->unsignedInteger('current_level')->default(1);
            $t->unsignedInteger('current_streak')->default(0);
            $t->unsignedInteger('longest_streak')->default(0);
            $t->timestamps();
        });
        Schema::create('game_worlds', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('icon')->nullable();
            $t->string('description')->nullable();
            $t->unsignedInteger('position')->default(1);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
        Schema::create('game_levels', function (Blueprint $t) {
            $t->id();
            $t->foreignId('game_world_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('icon')->nullable();
            $t->string('operation');
            $t->unsignedInteger('level_number')->unique();
            $t->unsignedInteger('difficulty')->default(1);
            $t->unsignedInteger('questions_count')->default(10);
            $t->unsignedInteger('required_score')->default(60);
            $t->unsignedInteger('xp_reward')->default(100);
            $t->boolean('is_boss')->default(false);
            $t->timestamps();
        });
        Schema::create('level_progress', function (Blueprint $t) {
            $t->id();
            $t->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $t->foreignId('game_level_id')->constrained()->cascadeOnDelete();
            $t->unsignedInteger('best_score')->default(0);
            $t->unsignedTinyInteger('stars')->default(0);
            $t->unsignedInteger('attempts')->default(0);
            $t->boolean('completed')->default(false);
            $t->timestamp('completed_at')->nullable();
            $t->timestamps();
            $t->unique(['child_profile_id', 'game_level_id']);
        });
        Schema::create('game_sessions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $t->foreignId('game_level_id')->nullable()->constrained()->nullOnDelete();
            $t->string('operation');
            $t->unsignedInteger('total_questions');
            $t->unsignedInteger('correct_answers')->default(0);
            $t->unsignedInteger('wrong_answers')->default(0);
            $t->unsignedInteger('score')->default(0);
            $t->unsignedInteger('xp_earned')->default(0);
            $t->timestamp('started_at');
            $t->timestamp('completed_at')->nullable();
            $t->timestamps();
        });
        Schema::create('game_attempts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('game_session_id')->constrained()->cascadeOnDelete();
            $t->string('operation');
            $t->json('question_data');
            $t->string('expected_answer');
            $t->string('given_answer')->nullable();
            $t->boolean('is_correct');
            $t->unsignedInteger('response_time_ms')->nullable();
            $t->timestamps();
        });
        Schema::create('achievements', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('description');
            $t->string('icon')->nullable();
            $t->string('type');
            $t->unsignedInteger('target')->default(1);
            $t->unsignedInteger('xp_reward')->default(0);
            $t->timestamps();
        });
        Schema::create('child_achievements', function (Blueprint $t) {
            $t->id();
            $t->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $t->foreignId('achievement_id')->constrained()->cascadeOnDelete();
            $t->timestamp('earned_at');
            $t->unique(['child_profile_id', 'achievement_id']);
        });
        Schema::create('classrooms', function (Blueprint $t) {
            $t->id();
            $t->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $t->string('name');
            $t->string('code')->unique();
            $t->string('grade')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
        Schema::create('classroom_student', function (Blueprint $t) {
            $t->id();
            $t->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $t->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $t->timestamps();
            $t->unique(['classroom_id', 'child_profile_id']);
        });
    }

    public function down(): void
    {
        foreach (['classroom_student', 'classrooms', 'child_achievements', 'achievements', 'game_attempts', 'game_sessions', 'level_progress', 'game_levels', 'game_worlds', 'child_profiles'] as $x) {
            Schema::dropIfExists($x);
        }
    }
};
