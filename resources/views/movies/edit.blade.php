@extends('layouts.app')

@section('title', 'Edit Movie | CineTrack')
@section('page_label', 'Edit Movie')

@section('content')
<div class="page-header">
    <div>
        <h1>Edit Movie</h1>
        <div class="subtitle">Update information for <strong>{{ $movie->title }}</strong>.</div>
    </div>
    <a href="{{ route('movies.show', $movie) }}" class="btn btn-outline">← Back to Details</a>
</div>

<div class="card">
    <form action="{{ route('movies.update', $movie) }}" method="POST">
        @csrf
        @method('PUT')
        @include('movies._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Movie</button>
            <a href="{{ route('movies.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
