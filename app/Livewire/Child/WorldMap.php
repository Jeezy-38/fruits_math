<?php

namespace App\Livewire\Child;

use App\Models\GameWorld;
use App\Support\CurrentChild;
use Livewire\Component;

class WorldMap extends Component
{
    public function render()
    {
        $child = CurrentChild::get();
        abort_unless($child, 403);
        $worlds = GameWorld::where('is_active', true)->with(['levels.progress' => fn ($q) => $q->where('child_profile_id', $child->id)])->orderBy('position')->get();

        return view('livewire.child.world-map', compact('child', 'worlds'))->layout('layouts.app');
    }
}
