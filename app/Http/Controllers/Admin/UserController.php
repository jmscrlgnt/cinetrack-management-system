<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('movies')
            ->orderBy('role')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
        ]);

        User::create($validated);

        return back()->with('success', 'Account created successfully.');
    }

    public function updateRole(Request $request, User $user)
    {
        if ($request->user()->is($user)) {
            return back()->with('error', 'You cannot change your own role while logged in.');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        $user->update($validated);

        return back()->with('success', 'User role updated successfully.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($request->user()->is($user)) {
            return back()->with('error', 'You cannot delete your own account while logged in.');
        }

        $user->delete();

        return back()->with('success', 'User account deleted successfully.');
    }
}
