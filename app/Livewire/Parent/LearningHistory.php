<?php

namespace App\Livewire\Parent;

use App\Models\ChildProfile;
use Livewire\Component;
use Livewire\WithPagination;

class LearningHistory extends Component
{
    use WithPagination;

    public ChildProfile $child;

    public function mount(ChildProfile $child): void
    {
        $this->child = auth()->user()->children()->findOrFail($child->id);
    }

    public function render()
    {
        abort_unless(auth()->user()?->role === 'parent' && $this->child->user_id === auth()->id(), 403);
        $sessions = $this->child->sessions()->with(['attempts' => fn ($query) => $query->orderBy('id')])->latest('started_at')->paginate(10);

        return view('livewire.parent.learning-history', compact('sessions'))->layout('layouts.app');
    }
}
