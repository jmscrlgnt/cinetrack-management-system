@extends('layouts.app')

@section('title', (request('favorites') ? 'Favorites' : 'Movies') . ' | CineTrack')
@section('page_label', request('favorites') ? 'Favorites' : (auth()->user()->isAdmin() ? 'All Movies' : 'My Watchlist'))

@section('content')
<div class="page-header">
    <div>
        <h1>{{ request('favorites') ? 'Favorites' : (auth()->user()->isAdmin() ? 'All Movie Records' : 'My Watchlist') }}</h1>
        <div class="subtitle">
            {{ auth()->user()->isAdmin()
                ? 'Search, filter, review, and manage movie records across all CineTrack users.'
                : 'Search, filter, and manage movies saved to your personal account.' }}
        </div>
    </div>
    <a href="{{ route('movies.create') }}" class="btn btn-primary">＋ Add Movie</a>
</div>

<div class="card" style="margin-bottom:20px">
    <form method="GET" action="{{ route('movies.index') }}" class="filters">
        @if(request('favorites'))
            <input type="hidden" name="favorites" value="1">
        @endif

        <div class="form-group search-field">
            <label for="search">Search</label>
            <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Title, genre, or status...">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="">All Statuses</option>
                <option value="Plan to Watch" @selected(request('status') === 'Plan to Watch')>Plan to Watch</option>
                <option value="Watching" @selected(request('status') === 'Watching')>Watching</option>
                <option value="Completed" @selected(request('status') === 'Completed')>Completed</option>
            </select>
        </div>

        <div class="form-group">
            <label for="genre">Genre</label>
            <select id="genre" name="genre">
                <option value="">All Genres</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre }}" @selected(request('genre') === $genre)>{{ $genre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="year">Year</label>
            <select id="year" name="year">
                <option value="">All Years</option>
                @foreach($years as $year)
                    <option value="{{ $year }}" @selected((string)request('year') === (string)$year)>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ request('favorites') ? route('movies.index', ['favorites' => 1]) : route('movies.index') }}" class="btn btn-outline">Reset</a>
    </form>
</div>

<div class="card">
    @if($movies->count())
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Movie</th>
                        <th>Genre</th>
                        <th>Year</th>
                        <th>Status</th>
                        <th>Rating</th>
                        @if(auth()->user()->isAdmin())<th>Owner</th>@endif
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movies as $movie)
                        <tr>
                            <td>
                                <strong>@if($movie->is_favorite)<span class="favorite">★</span>@endif {{ $movie->title }}</strong>
                            </td>
                            <td>{{ $movie->genre }}</td>
                            <td>{{ $movie->release_year }}</td>
                            <td>
                                <span class="badge {{ $movie->status === 'Completed' ? 'completed' : ($movie->status === 'Watching' ? 'watching' : 'plan') }}">{{ $movie->status }}</span>
                            </td>
                            <td>{{ $movie->rating !== null ? number_format((float)$movie->rating, 1) . '/10' : '—' }}</td>
                            @if(auth()->user()->isAdmin())
                                <td>{{ $movie->user?->name ?? 'Unassigned' }}</td>
                            @endif
                            <td>
                                <div class="actions">
                                    <a href="{{ route('movies.show', $movie) }}" class="btn btn-view btn-sm">View</a>
                                    <a href="{{ route('movies.edit', $movie) }}" class="btn btn-edit btn-sm">Edit</a>
                                    <form action="{{ route('movies.favorite', $movie) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-ghost btn-sm">{{ $movie->is_favorite ? '★' : '☆' }}</button>
                                    </form>
                                    <form action="{{ route('movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this movie?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <div>Showing {{ $movies->firstItem() }}–{{ $movies->lastItem() }} of {{ $movies->total() }} record{{ $movies->total() === 1 ? '' : 's' }}</div>
            <div class="pagination-links">
                @if($movies->onFirstPage())
                    <span class="btn btn-ghost btn-sm" style="opacity:.55">Previous</span>
                @else
                    <a class="btn btn-outline btn-sm" href="{{ $movies->previousPageUrl() }}">Previous</a>
                @endif

                <span class="btn btn-ghost btn-sm">Page {{ $movies->currentPage() }} / {{ $movies->lastPage() }}</span>

                @if($movies->hasMorePages())
                    <a class="btn btn-outline btn-sm" href="{{ $movies->nextPageUrl() }}">Next</a>
                @else
                    <span class="btn btn-ghost btn-sm" style="opacity:.55">Next</span>
                @endif
            </div>
        </div>
    @else
        <div class="empty">
            <strong>{{ request()->hasAny(['search','status','genre','year','favorites']) ? 'No matching movies found.' : 'No movie records yet.' }}</strong>
            <p>{{ request()->hasAny(['search','status','genre','year','favorites']) ? 'Try changing the search or filters.' : 'Add your first movie to begin using CineTrack.' }}</p>
            @unless(request()->hasAny(['search','status','genre','year','favorites']))
                <a href="{{ route('movies.create') }}" class="btn btn-primary">＋ Add First Movie</a>
            @endunless
        </div>
    @endif
</div>
@endsection
