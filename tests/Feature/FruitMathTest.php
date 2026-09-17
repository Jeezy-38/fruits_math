<?php

namespace Tests\Feature;

use App\Livewire\Admin\Curriculum;
use App\Livewire\GameBoard;
use App\Livewire\SelectPlayer;
use App\Models\ChildProfile;
use App\Models\CurriculumLesson;
use App\Models\CurriculumTopic;
use App\Models\DailyStreak;
use App\Models\GameLevel;
use App\Models\GameSession;
use App\Models\User;
use App\Services\GameEngine;
use App\Services\QuestionGenerator;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Livewire\Livewire;

class FruitMathTest extends TestCase
{
    use RefreshDatabase;

    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed();
    }

    private function parentUser(): User
    {
        return User::where('role', 'parent')->firstOrFail();
    }

    private function child(): ChildProfile
    {
        return $this->parentUser()->children()->firstOrFail();
    }

    private function loginParent(): void
    {
        $this->actingAs($this->parentUser());
        session(['child_profile_id' => $this->child()->id]);
    }

    private function complete(GameSession $session, bool $correct = true): void
    {
        $engine = app(GameEngine::class);
        $child = $this->child();
        for ($n = 1; $n <= $session->total_questions; $n++) {
            $session->refresh();
            $q = $session->current_question;
            $answer = $correct ? $q['answer'] : collect($q['options'])->first(fn ($v) => (string) $v !== (string) $q['answer']);
            $engine->submit($session->id, $child, $n, $answer);
            $engine->advance($session->id, $child, $n);
        }
    }

    public function test_public_and_authenticated_pages_render(): void
    {
        foreach (['/', '/login', '/register'] as $url) {
            $this->get($url)->assertOk();
        }
        $this->loginParent();
        foreach (['/parent', '/players', '/child', '/map', '/level/1'] as $url) {
            $this->get($url)->assertOk();
        }
        $this->actingAs(User::where('role', 'admin')->first());
        $this->get('/admin')->assertOk();
        $this->get('/admin/curriculum')->assertOk();
    }

    public function test_questions_always_offer_exactly_one_correct_answer(): void
    {
        $generator = app(QuestionGenerator::class);
        foreach (QuestionGenerator::OPERATIONS as $operation) {
            for ($i = 0; $i < 80; $i++) {
                $question = $generator->generate($operation, ($i % 10) + 1);
                $options = array_map('strval', $question['options']);
                $this->assertCount(1, array_filter($options, fn ($v) => $v === (string) $question['answer']), $operation);
                $this->assertCount(count($options), array_unique($options));
                $this->assertGreaterThanOrEqual(3, count($options));
            }
        }
    }

    public function test_curriculum_rules_control_questions(): void
    {
        foreach (['multiplication', 'division'] as $operation) {
            for ($i = 0; $i < 30; $i++) {
                $q = app(QuestionGenerator::class)->forRules($operation, 8, ['tables' => [2], 'min' => 3, 'max' => 5]);
                $this->assertSame(2, $q['right']);
                $value = $operation === 'division' ? $q['answer'] : $q['left'];
                $this->assertGreaterThanOrEqual(3, $value);
                $this->assertLessThanOrEqual(5, $value);
            }
        }
    }

    public function test_duplicate_answers_completion_and_replays_do_not_duplicate_rewards(): void
    {
        $engine = app(GameEngine::class);
        $child = $this->child();
        $session = $engine->start($child, GameLevel::first());
        $answer = $session->current_question['answer'];
        $engine->submit($session->id, $child, 1, $answer);
        $engine->submit($session->id, $child, 1, $answer);
        $this->assertSame(1, $session->attempts()->count());
        $this->complete($session);
        $xp = $child->fresh()->xp;
        $engine->advance($session->id, $child, $session->total_questions);
        $this->assertSame($xp, $child->fresh()->xp);
        $this->assertSame(1, $child->progress()->first()->attempts);
        $replay = $engine->start($child->fresh(), GameLevel::first());
        $this->complete($replay);
        $this->assertSame($xp, $child->fresh()->xp);
        $this->assertSame(2, $child->progress()->first()->attempts);
        $this->assertSame(1, $child->fresh()->current_streak);
        $this->assertSame(20, DailyStreak::first()->questions_answered);
    }

    public function test_failed_games_do_not_unlock_or_reward(): void
    {
        $session = app(GameEngine::class)->start($this->child(), GameLevel::first());
        $this->complete($session, false);
        $this->assertSame(0, $this->child()->xp);
        $this->assertSame(1, $this->child()->current_level);
        $this->assertFalse($this->child()->progress()->first()->completed);
    }

    public function test_question_cannot_be_skipped_or_advanced_by_stale_request(): void
    {
        $engine = app(GameEngine::class);
        $child = $this->child();
        $s = $engine->start($child, GameLevel::first());
        $engine->advance($s->id, $child, 1);
        $this->assertSame(1, $s->fresh()->question_number);
        $engine->submit($s->id, $child, 1, $s->current_question['answer']);
        $engine->advance($s->id, $child, 1);
        $engine->advance($s->id, $child, 1);
        $this->assertSame(2, $s->fresh()->question_number);
        $this->assertNull($s->fresh()->completed_at);
    }

    public function test_parent_cannot_select_another_parents_child(): void
    {
        $other = User::create(['name' => 'Other Parent', 'email' => 'other@test.test', 'password' => 'password', 'role' => 'parent']);
        $this->actingAs($other);
        $this->expectException(ModelNotFoundException::class);
        Livewire::test(SelectPlayer::class)->call('select', $this->child()->id);
    }

    public function test_livewire_answers_are_server_owned_and_session_is_locked(): void
    {
        $this->loginParent();
        $component = Livewire::test(GameBoard::class, ['level' => GameLevel::first()]);
        $session = GameSession::findOrFail($component->get('sessionId'));
        $this->assertSame(['sessionId', 'questionNumber'], array_keys($component->snapshot['data']));
        $component->call('answer', $session->current_question['answer'])->assertSee('Excellent')->call('nextQuestion')->assertSet('questionNumber', 2);
        $this->expectException(CannotUpdateLockedPropertyException::class);
        $component->set('sessionId', 999);
    }

    public function test_new_parent_can_register_and_create_child(): void
    {
        $this->post('/register', ['name' => 'New Parent', 'email' => 'new@test.test', 'password' => 'newpassword', 'password_confirmation' => 'newpassword'])->assertRedirect('/parent');
        Livewire::test(SelectPlayer::class)->set('name', 'Neema')->set('language', 'sw')->call('addChild')->assertHasNoErrors()->assertSee('Neema');
        $this->assertDatabaseHas('child_profiles', ['name' => 'Neema', 'user_id' => auth()->id(), 'preferred_language' => 'sw']);
    }

    public function test_demo_login_is_disabled_and_locale_persists(): void
    {
        $this->post('/demo-login')->assertNotFound();
        $this->get('/language/sw')->assertRedirect();
        $this->get('/')->assertSee('lang="sw"', false);
    }

    public function test_every_game_renders_and_clock_fraction_visuals_match(): void
    {
        $this->loginParent();
        $this->child()->update(['current_level' => 20]);
        foreach (GameLevel::all() as $level) {
            $response = $this->get('/level/'.$level->id)->assertOk();
            if ($level->operation === 'time') {
                $response->assertSee('Analogue clock:')->assertSee('<svg', false);
            }
            if ($level->operation === 'fractions') {
                $response->assertSee('equal parts shaded');
            }
        }
    }

    public function test_admin_can_create_validated_times_table_lesson(): void
    {
        $this->actingAs(User::where('role', 'admin')->first());
        $component = Livewire::test(Curriculum::class)->set('topicName', 'Times tables')->set('operation', 'multiplication')->call('addTopic')->assertHasNoErrors();
        $topic = CurriculumTopic::firstOrFail();
        $component->set('topicId', $topic->id)->set('lessonName', 'Multiply by two')->set('tables', '2')->call('addLesson')->assertHasNoErrors();
        $this->assertSame([2], CurriculumLesson::firstOrFail()->rules['tables']);
        $component->set('lessonName', 'Invalid table')->set('tables', '0,99')->call('addLesson')->assertHasErrors('tables');
    }

    public function test_teacher_features_are_removed_from_routes_and_screens(): void
    {
        $this->get('/register')->assertOk()->assertDontSee('Teacher')->assertDontSee('name="role"', false);
        $this->assertDatabaseMissing('users', ['role' => 'teacher']);
        $this->loginParent();
        foreach (['/teacher', '/teacher/classrooms/1/assignments', '/child/join-classroom', '/assignment/1'] as $url) {
            $this->get($url)->assertNotFound();
        }
        $this->get('/child')->assertOk()->assertDontSee('Join Classroom')->assertDontSee('My assignments');
        $this->get('/admin')->assertForbidden();
        $this->get('/level/5')->assertForbidden();
        $this->actingAs(User::where('role', 'admin')->first());
        $this->get('/admin')->assertOk()->assertSee('parents')->assertDontSee('teachers');
    }

    public function test_registration_rejects_teacher_and_admin_roles(): void
    {
        foreach (['teacher', 'admin'] as $role) {
            $this->post('/register', ['name' => 'Test', 'email' => $role.'@example.test', 'password' => 'newpassword', 'password_confirmation' => 'newpassword', 'role' => $role])->assertSessionHasErrors('role');
            $this->assertDatabaseMissing('users', ['email' => $role.'@example.test']);
        }
    }

    public function test_legacy_teacher_cannot_login_and_existing_session_is_revoked(): void
    {
        $teacher = User::create(['name' => 'Legacy teacher', 'email' => 'legacy@example.test', 'password' => 'password', 'role' => 'teacher']);
        $this->post('/login', ['email' => $teacher->email, 'password' => 'password'])->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->actingAs($teacher)->get('/')->assertRedirect('/login');
        $this->assertGuest();
        $this->assertDatabaseHas('users', ['id' => $teacher->id, 'role' => 'teacher']);
    }

    public function test_parent_and_admin_can_still_login(): void
    {
        foreach (['parent', 'admin'] as $role) {
            $this->post('/login', ['email' => $role.'@fruitmath.test', 'password' => 'password'])->assertRedirect('/'.$role);
            $this->assertAuthenticatedAs(User::where('role', $role)->first());
            $this->post('/logout');
        }
    }

    public function test_parent_can_review_saved_answers_and_incomplete_games(): void
    {
        $this->loginParent();
        $session = app(GameEngine::class)->start($this->child(), GameLevel::first());
        $answer = $session->current_question['answer'];
        app(GameEngine::class)->submit($session->id, $this->child(), 1, $answer);
        $this->get('/parent')->assertSee(route('parent.history', $this->child()));
        $this->get(route('parent.history', $this->child()))->assertOk()->assertSee('Haujakamilika')->assertSee('Jibu la mtoto')->assertSee('✓ Sahihi');
        $this->complete($session);
        $this->get(route('parent.history', $this->child()))->assertOk()->assertSee('Umekamilika')->assertSee('100');
    }

    public function test_parent_history_is_private_and_handles_empty_history(): void
    {
        $this->loginParent();
        $this->get(route('parent.history', $this->child()))->assertOk()->assertSee('bado hajaanza mchezo');
        $other = User::create(['name' => 'Other', 'email' => 'history@example.test', 'password' => 'password', 'role' => 'parent']);
        $this->actingAs($other)->get(route('parent.history', $this->child()))->assertNotFound();
        $this->actingAs(User::where('role', 'admin')->first())->get(route('parent.history', $this->child()))->assertForbidden();
    }
}
