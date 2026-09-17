<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assignments', function (Blueprint $t) {
            $t->foreignId('curriculum_lesson_id')->nullable()->constrained()->nullOnDelete();
            $t->json('rules')->nullable();
        });
        Schema::table('game_sessions', function (Blueprint $t) {
            $t->foreignId('assignment_id')->nullable()->constrained()->nullOnDelete();
            $t->json('settings')->nullable();
            $t->json('current_question')->nullable();
            $t->unsignedInteger('question_number')->default(1);
        });
        Schema::table('game_attempts', function (Blueprint $t) {
            $t->unsignedInteger('question_number')->nullable();
            $t->unique(['game_session_id', 'question_number']);
        });
    }

    public function down(): void
    {
        Schema::table('game_attempts', function (Blueprint $t) {
            $t->dropUnique(['game_session_id', 'question_number']);
            $t->dropColumn('question_number');
        });
        Schema::table('game_sessions', function (Blueprint $t) {
            $t->dropConstrainedForeignId('assignment_id');
            $t->dropColumn(['settings', 'current_question', 'question_number']);
        });
        Schema::table('assignments', function (Blueprint $t) {
            $t->dropConstrainedForeignId('curriculum_lesson_id');
            $t->dropColumn('rules');
        });
    }
};
