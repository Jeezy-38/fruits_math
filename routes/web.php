<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Curriculum;
use App\Livewire\Child\ChildHome;
use App\Livewire\Child\WorldMap;
use App\Livewire\Dashboard;
use App\Livewire\GameBoard;
use App\Livewire\Parent\LearningHistory;
use App\Livewire\Parent\ParentDashboard;
use App\Livewire\SelectPlayer;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('home');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/language/{locale}', LanguageController::class)->name('language');
Route::post('/demo-login', function () {
    abort_unless(app()->environment('local') && config('fruit.demo_enabled'), 404);
    $user = User::where('email', 'parent@fruitmath.test')->where('role', 'parent')->firstOrFail();
    auth()->login($user);
    request()->session()->regenerate();

    return redirect()->route('players');
})->middleware('guest')->name('demo.login');
Route::middleware(['auth', 'role:parent'])->group(function () {
    Route::get('/parent', ParentDashboard::class)->name('parent.dashboard');
    Route::get('/parent/children/{child}/history', LearningHistory::class)->whereNumber('child')->name('parent.history');
    Route::get('/players', SelectPlayer::class)->name('players');
    Route::get('/child', ChildHome::class)->name('child.home');
    Route::get('/map', WorldMap::class)->name('world.map');
    Route::get('/level/{level}', GameBoard::class)->name('game.level');
});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', AdminDashboard::class)->name('admin.dashboard');
    
    Route::get('/admin/curriculum', Curriculum::class)->name('admin.curriculum');
});
