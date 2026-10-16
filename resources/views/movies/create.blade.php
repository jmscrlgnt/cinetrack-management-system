@extends('layouts.app')

@section('title', 'Add Movie | CineTrack')
@section('page_label', 'Add Movie')

@section('content')
<div class="page-header">
    <div>
        <h1>Add Movie</h1>
        <div class="subtitle">Create a new movie record in {{ auth()->user()->isAdmin() ? 'CineTrack' : 'your personal watchlist' }}.</div>
    </div>
    <a href="{{ route('movies.index') }}" class="btn btn-outline">← Back to Movies</a>
</div>

<div class="card">
    <form action="{{ route('movies.store') }}" method="POST">
        @csrf
        @include('movies._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Movie</button>
            <a href="{{ route('movies.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
