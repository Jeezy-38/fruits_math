<?php

namespace App\Livewire\Child;

use App\Models\GameLevel;
use App\Support\CurrentChild;
use Livewire\Component;

class ChildHome extends Component
{
    public function render()
    {
        $child = CurrentChild::get();
        abort_unless($child, 403);
        $next = GameLevel::where('level_number', $child->current_level)->whereHas('world', fn ($q) => $q->where('is_active', true))->first();

        return view('livewire.child.home', compact('child', 'next'))->layout('layouts.app');
    }
}
