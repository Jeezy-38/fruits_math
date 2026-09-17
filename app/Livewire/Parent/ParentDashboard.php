<?php

namespace App\Livewire\Parent;

use App\Services\ChildAnalyticsService;
use Livewire\Component;

class ParentDashboard extends Component
{
    public function render()
    {
        abort_unless(auth()->user()?->role === 'parent', 403);
        $children = auth()->user()->children()->get()->map(function ($c) {
            $c->analytics = app(ChildAnalyticsService::class)->summary($c);

            return $c;
        });

        return view('livewire.parent.dashboard', compact('children'))->layout('layouts.app');
    }
}
