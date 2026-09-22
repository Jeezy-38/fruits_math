<?php

namespace App\Livewire\Child;

use App\Models\Achievement;
use App\Models\GameLevel;
use App\Support\CurrentChild;
use Livewire\Component;

class ChildHome extends Component
{
    public const AVATARS = ['🧒🏾', '👧🏽', '🦁', '🐯', '🐰', '🐼', '🦊', '🐵', '🦄', '🚀', '⭐', '👑'];

    public bool $showAvatarPicker = false;

    public function toggleAvatarPicker(): void
    {
        $this->showAvatarPicker = ! $this->showAvatarPicker;
    }

    public function selectAvatar(string $avatar): void
    {
        $child = CurrentChild::get();
        abort_unless($child, 403);

        if (in_array($avatar, self::AVATARS, true)) {
            $child->avatar = $avatar;
            $child->save();
        }

        $this->showAvatarPicker = false;
    }

    public function render()
    {
        $child = CurrentChild::get();
        abort_unless($child, 403);
        $next = GameLevel::where('level_number', $child->current_level)->whereHas('world', fn ($q) => $q->where('is_active', true))->first();
        $achievements = Achievement::all();
        $earnedIds = $child->achievements()->pluck('achievements.id')->all();

        return view('livewire.child.home', compact('child', 'next', 'achievements', 'earnedIds'))->layout('layouts.app');
    }
}
