@extends('layouts.app')

@section('title', $movie->title . ' | CineTrack')
@section('page_label', 'Movie Details')

@section('content')
<div class="page-header">
    <div>
        <h1>{{ $movie->title }}</h1>
        <div class="subtitle">Complete watchlist information and available actions.</div>
    </div>

    <div class="actions">
        <form action="{{ route('movies.favorite', $movie) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn {{ $movie->is_favorite ? 'btn-success' : 'btn-outline' }}">
                {{ $movie->is_favorite ? '★ Favorite' : '☆ Add to Favorites' }}
            </button>
        </form>
        <a href="{{ route('movies.edit', $movie) }}" class="btn btn-edit">Edit</a>
        <a href="{{ route('movies.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">Movie Title</div>
            <div class="detail-value">{{ $movie->title }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Genre</div>
            <div class="detail-value">{{ $movie->genre }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Release Year</div>
            <div class="detail-value">{{ $movie->release_year }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Watch Status</div>
            <div class="detail-value">
                <span class="badge {{ $movie->status === 'Completed' ? 'completed' : ($movie->status === 'Watching' ? 'watching' : 'plan') }}">{{ $movie->status }}</span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Rating</div>
            <div class="detail-value">{{ $movie->rating !== null ? number_format((float)$movie->rating, 1) . '/10' : 'Not Rated' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Favorite</div>
            <div class="detail-value">{{ $movie->is_favorite ? 'Yes ★' : 'No' }}</div>
        </div>
        @if(auth()->user()->isAdmin())
            <div class="detail-item">
                <div class="detail-label">Owner</div>
                <div class="detail-value">{{ $movie->user?->name ?? 'Unassigned' }}<br><span style="font-size:12px;color:#64748b">{{ $movie->user?->email }}</span></div>
            </div>
        @endif
        <div class="detail-item" style="grid-column:1/-1">
            <div class="detail-label">Notes</div>
            <div class="detail-value">{{ $movie->notes ?: 'No notes provided.' }}</div>
        </div>
    </div>

    <div class="form-actions" style="margin-top:20px">
        <form action="{{ route('movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this movie?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-delete">Delete Movie</button>
        </form>
    </div>
</div>
@endsection
