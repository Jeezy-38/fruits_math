<?php

namespace App\Livewire;

use Livewire\Component;

class SelectPlayer extends Component
{
    public string $name = '';

    public string $language = 'en';

    public function addChild(): void
    {
        abort_unless(auth()->user()?->role === 'parent', 403);
        $data = $this->validate(['name' => 'required|string|min:2|max:60', 'language' => 'required|in:en,sw']);
        auth()->user()->children()->create(['name' => $data['name'], 'preferred_language' => $data['language'], 'avatar' => '🧒🏾']);
        $this->reset('name');
    }

    public function select(int $id)
    {
        $child = auth()->user()->children()->findOrFail($id);
        session(['child_profile_id' => $child->id, 'locale' => $child->preferred_language]);
        app()->setLocale($child->preferred_language);

        return $this->redirectRoute('child.home', navigate: true);
    }

    public function render()
    {
        return view('livewire.select-player', ['children' => auth()->user()->children()->get()])->layout('layouts.app');
    }
}
