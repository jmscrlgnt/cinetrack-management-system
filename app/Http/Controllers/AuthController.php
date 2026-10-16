<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginChoice()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login-choice');
    }

    public function showAdminLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.admin-login');
    }

    public function showUserLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.user-login');
    }

    public function adminLogin(Request $request)
    {
        return $this->attemptRoleLogin($request, 'admin', 'This account does not have administrator access.');
    }

    public function userLogin(Request $request)
    {
        return $this->attemptRoleLogin($request, 'user', 'This account does not have user access.');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Welcome to CineTrack! Your account has been created.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'You have been logged out successfully.');
    }

    private function attemptRoleLogin(Request $request, string $role, string $roleError)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        if (Auth::user()->role !== $role) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => $roleError])
                ->onlyInput('email');
        }

        return redirect()
            ->intended(route('dashboard'))
            ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
    }
}
