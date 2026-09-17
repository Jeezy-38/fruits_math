<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $r)
    {
        $c = $r->validate(['email' => 'required|email', 'password' => 'required']);
        if (! Auth::attempt([...$c, 'role' => ['parent', 'admin']], $r->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
        }$r->session()->regenerate();

        return redirect()->intended($this->home(Auth::user()));
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $r)
    {
        $d = $r->validate(['name' => 'required|max:100', 'email' => 'required|email|unique:users', 'password' => ['required', 'confirmed', Password::min(8)], 'role' => 'sometimes|in:parent']);
        $u = User::create(['name' => $d['name'], 'email' => $d['email'], 'password' => Hash::make($d['password']), 'role' => 'parent']);
        Auth::login($u);
        $r->session()->regenerate();

        return redirect($this->home($u));
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function home(User $u)
    {
        return match ($u->role) {
            'admin' => route('admin.dashboard'),default => route('parent.dashboard')
        };
    }
}
