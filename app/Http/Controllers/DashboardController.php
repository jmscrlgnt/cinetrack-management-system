<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $baseQuery = Movie::visibleTo($user);

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'plan' => (clone $baseQuery)->where('status', 'Plan to Watch')->count(),
            'watching' => (clone $baseQuery)->where('status', 'Watching')->count(),
            'completed' => (clone $baseQuery)->where('status', 'Completed')->count(),
            'favorites' => (clone $baseQuery)->where('is_favorite', true)->count(),
            'average_rating' => round((float) ((clone $baseQuery)->whereNotNull('rating')->avg('rating') ?? 0), 1),
        ];

        $recentMovies = Movie::visibleTo($user)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $topRated = Movie::visibleTo($user)
            ->with('user')
            ->whereNotNull('rating')
            ->orderByDesc('rating')
            ->take(5)
            ->get();

        $userCount = $user->isAdmin() ? User::count() : null;

        return view('dashboard.index', compact('stats', 'recentMovies', 'topRated', 'userCount'));
    }
}
