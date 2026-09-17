<?php

namespace App\Livewire\Admin;

use App\Models\ChildProfile;
use App\Models\GameAttempt;
use App\Models\GameLevel;
use App\Models\GameSession;
use App\Models\GameWorld;
use App\Models\User;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
        $stats = ['learners' => ChildProfile::count(), 'parents' => User::where('role', 'parent')->count(), 'sessions' => GameSession::count(), 'questions' => GameAttempt::count(), 'worlds' => GameWorld::count(), 'levels' => GameLevel::count()];

        return view('livewire.admin.dashboard', compact('stats'))->layout('layouts.app');
    }
}
