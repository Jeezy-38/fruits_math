<?php

namespace App\Livewire\Admin;

use App\Models\CurriculumLesson;
use App\Models\CurriculumTopic;
use App\Services\QuestionGenerator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Curriculum extends Component
{
    public string $topicName = '';

    public string $operation = 'addition';

    public string $icon = '🍎';

    public string $lessonName = '';

    public string $tables = '2';

    public int $topicId = 0;

    public int $difficulty = 1;

    public int $questions = 10;

    public int $requiredScore = 70;

    public int $minimum = 1;

    public int $maximum = 10;

    public function addTopic(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
        $d = $this->validate(['topicName' => 'required|min:3|max:100', 'operation' => ['required', Rule::in(QuestionGenerator::OPERATIONS)], 'icon' => 'nullable|max:20']);
        CurriculumTopic::create(['name' => $d['topicName'], 'slug' => Str::slug($d['topicName']).'-'.Str::lower(Str::random(6)), 'operation' => $d['operation'], 'icon' => $d['icon'], 'position' => CurriculumTopic::max('position') + 1]);
        $this->reset('topicName');
    }

    public function addLesson(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
        $d = $this->validate(['topicId' => 'required|exists:curriculum_topics,id', 'lessonName' => 'required|min:3|max:100', 'difficulty' => 'integer|min:1|max:10', 'questions' => 'integer|min:5|max:50', 'requiredScore' => 'integer|min:1|max:100', 'minimum' => 'integer|min:0|max:100', 'maximum' => 'integer|gte:minimum|max:100', 'tables' => ['required', 'regex:/^\s*(?:[1-9]|1[0-2])\s*(?:,\s*(?:[1-9]|1[0-2])\s*)*$/']]);
        $topic = CurriculumTopic::findOrFail($d['topicId']);
        $rules = in_array($topic->operation, ['counting', 'addition', 'subtraction', 'comparison', 'word-problems', 'multiplication', 'division'], true)
            ? ['min' => $d['minimum'], 'max' => $d['maximum'], 'tables' => array_values(array_unique(array_map('intval', explode(',', $d['tables']))))] : [];
        CurriculumLesson::create(['curriculum_topic_id' => $topic->id, 'name' => $d['lessonName'], 'slug' => Str::slug($d['lessonName']).'-'.Str::lower(Str::random(6)), 'difficulty' => $d['difficulty'], 'questions_count' => $d['questions'], 'required_score' => $d['requiredScore'], 'rules' => $rules]);
        $this->reset('lessonName');
    }

    public function render()
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        return view('livewire.admin.curriculum', ['topics' => CurriculumTopic::with('lessons')->orderBy('position')->get()])->layout('layouts.app');
    }
}
