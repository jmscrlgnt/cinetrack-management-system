<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Movie::visibleTo($user)->with('user');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('genre', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        if ($request->filled('year')) {
            $query->where('release_year', $request->year);
        }

        if ($request->boolean('favorites')) {
            $query->where('is_favorite', true);
        }

        $movies = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $genres = Movie::visibleTo($user)
            ->whereNotNull('genre')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');

        $years = Movie::visibleTo($user)
            ->distinct()
            ->orderByDesc('release_year')
            ->pluck('release_year');

        return view('movies.index', compact('movies', 'genres', 'years'));
    }

    public function create()
    {
        return view('movies.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateMovie($request);
        $validated['user_id'] = $request->user()->id;
        $validated['is_favorite'] = $request->boolean('is_favorite');

        Movie::create($validated);

        return redirect()
            ->route('movies.index')
            ->with('success', 'Movie added successfully.');
    }

    public function show(Movie $movie)
    {
        $this->ensureAccess($movie);
        $movie->load('user');

        return view('movies.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        $this->ensureAccess($movie);

        return view('movies.edit', compact('movie'));
    }

    public function update(Request $request, Movie $movie)
    {
        $this->ensureAccess($movie);

        $validated = $this->validateMovie($request);
        $validated['is_favorite'] = $request->boolean('is_favorite');

        $movie->update($validated);

        return redirect()
            ->route('movies.index')
            ->with('success', 'Movie updated successfully.');
    }

    public function destroy(Movie $movie)
    {
        $this->ensureAccess($movie);
        $movie->delete();

        return redirect()
            ->route('movies.index')
            ->with('success', 'Movie deleted successfully.');
    }

    public function toggleFavorite(Movie $movie)
    {
        $this->ensureAccess($movie);

        $movie->update([
            'is_favorite' => !$movie->is_favorite,
        ]);

        return back()->with(
            'success',
            $movie->is_favorite ? 'Movie added to favorites.' : 'Movie removed from favorites.'
        );
    }

    private function validateMovie(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:150',
            'genre' => 'required|string|max:80',
            'release_year' => 'required|integer|min:1900|max:' . (now()->year + 1),
            'status' => 'required|in:Plan to Watch,Watching,Completed',
            'rating' => 'nullable|numeric|min:0|max:10',
            'notes' => 'nullable|string|max:1000',
        ]);
    }

    private function ensureAccess(Movie $movie): void
    {
        $user = Auth::user();

        if (!$user->isAdmin() && $movie->user_id !== $user->id) {
            abort(403, 'You do not have permission to access this movie.');
        }
    }
}
