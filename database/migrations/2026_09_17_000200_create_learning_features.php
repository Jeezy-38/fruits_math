<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $t->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $t->string('title');
            $t->string('operation');
            $t->unsignedInteger('difficulty')->default(1);
            $t->unsignedInteger('questions_count')->default(10);
            $t->unsignedInteger('target_score')->default(70);
            $t->timestamp('due_at')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
        Schema::create('assignment_progress', function (Blueprint $t) {
            $t->id();
            $t->foreignId('assignment_id')->constrained()->cascadeOnDelete();
            $t->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $t->unsignedInteger('best_score')->default(0);
            $t->unsignedInteger('attempts')->default(0);
            $t->boolean('completed')->default(false);
            $t->timestamp('completed_at')->nullable();
            $t->timestamps();
            $t->unique(['assignment_id', 'child_profile_id']);
        });
        Schema::create('daily_streaks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $t->date('activity_date');
            $t->unsignedInteger('questions_answered')->default(0);
            $t->unsignedInteger('xp_earned')->default(0);
            $t->timestamps();
            $t->unique(['child_profile_id', 'activity_date']);
        });
        Schema::create('curriculum_topics', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('operation');
            $t->string('icon')->nullable();
            $t->unsignedTinyInteger('min_age')->nullable();
            $t->unsignedTinyInteger('max_age')->nullable();
            $t->unsignedInteger('position')->default(1);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
        Schema::create('curriculum_lessons', function (Blueprint $t) {
            $t->id();
            $t->foreignId('curriculum_topic_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('slug')->unique();
            $t->unsignedInteger('difficulty')->default(1);
            $t->json('rules')->nullable();
            $t->unsignedInteger('questions_count')->default(10);
            $t->unsignedInteger('required_score')->default(70);
            $t->unsignedInteger('xp_reward')->default(100);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['curriculum_lessons', 'curriculum_topics', 'daily_streaks', 'assignment_progress', 'assignments'] as $x) {
            Schema::dropIfExists($x);
        }
    }
};
