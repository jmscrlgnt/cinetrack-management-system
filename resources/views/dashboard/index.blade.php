@extends('layouts.app')

@section('title', 'Dashboard | CineTrack')
@section('page_label', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1>{{ auth()->user()->isAdmin() ? 'System Dashboard' : 'My Dashboard' }}</h1>
        <div class="subtitle">
            {{ auth()->user()->isAdmin()
                ? 'Monitor CineTrack activity, users, and movie records.'
                : 'A quick overview of your personal watchlist progress.' }}
        </div>
    </div>
    <a href="{{ route('movies.create') }}" class="btn btn-primary">＋ Add Movie</a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Movies</div>
        <div class="stat-value">{{ $stats['total'] }}</div>
        <div class="stat-hint">All visible records</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Plan to Watch</div>
        <div class="stat-value">{{ $stats['plan'] }}</div>
        <div class="stat-hint">Saved for later</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Watching</div>
        <div class="stat-value">{{ $stats['watching'] }}</div>
        <div class="stat-hint">Currently in progress</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Completed</div>
        <div class="stat-value">{{ $stats['completed'] }}</div>
        <div class="stat-hint">Finished titles</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Favorites</div>
        <div class="stat-value">{{ $stats['favorites'] }}</div>
        <div class="stat-hint">Marked favorites</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Avg. Rating</div>
        <div class="stat-value">{{ number_format($stats['average_rating'], 1) }}</div>
        <div class="stat-hint">Out of 10</div>
    </div>
</div>

@if(auth()->user()->isAdmin())
    <div class="card" style="margin-bottom:20px">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:15px;flex-wrap:wrap">
            <div>
                <h3 class="card-title">Administrator Overview</h3>
                <div class="card-subtitle" style="margin-bottom:0">CineTrack currently has <strong>{{ $userCount }}</strong> registered account{{ $userCount === 1 ? '' : 's' }}.</div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Manage User Accounts</a>
        </div>
    </div>
@endif

<div class="grid-2">
    <section class="card">
        <h3 class="card-title">Recently Added</h3>
        <div class="card-subtitle">Latest movies added to {{ auth()->user()->isAdmin() ? 'the system' : 'your watchlist' }}.</div>

        @if($recentMovies->count())
            <div class="movie-list">
                @foreach($recentMovies as $movie)
                    <div class="movie-row">
                        <div>
                            <div class="movie-title">
                                @if($movie->is_favorite)<span class="favorite">★</span>@endif
                                {{ $movie->title }}
                            </div>
                            <div class="movie-meta">
                                {{ $movie->genre }} • {{ $movie->release_year }}
                                @if(auth()->user()->isAdmin())
                                    • {{ $movie->user?->name ?? 'Unassigned' }}
                                @endif
                            </div>
                        </div>
                        <a class="btn btn-ghost btn-sm" href="{{ route('movies.show', $movie) }}">View</a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty"><strong>No movies yet.</strong><br>Add your first movie to begin.</div>
        @endif
    </section>

    <section class="card">
        <h3 class="card-title">Top Rated</h3>
        <div class="card-subtitle">Highest-rated movies in the current view.</div>

        @if($topRated->count())
            <div class="movie-list">
                @foreach($topRated as $movie)
                    <div class="movie-row">
                        <div>
                            <div class="movie-title">{{ $movie->title }}</div>
                            <div class="movie-meta">{{ $movie->genre }} • {{ $movie->status }}</div>
                        </div>
                        <div class="rating">{{ number_format((float)$movie->rating, 1) }}/10</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty"><strong>No rated movies yet.</strong><br>Add ratings to see your top titles.</div>
        @endif
    </section>
</div>
@endsection
