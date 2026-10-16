@extends('layouts.auth')

@section('title', 'Login | CineTrack')

@section('content')
<div class="auth-card">
    <div style="text-align:center;margin-bottom:22px">
        <h2>Choose Your Access Portal</h2>
        <div class="muted">Select the appropriate account type to continue.</div>
    </div>

    <div class="portal-grid">
        <div class="portal">
            <div class="portal-icon admin-icon">🛡️</div>
            <h2>Administrator</h2>
            <p class="muted">View all movie records, manage users, and access system-wide statistics.</p>
            <a href="{{ route('admin.login') }}" class="btn btn-admin">Admin Login</a>
        </div>

        <div class="portal">
            <div class="portal-icon user-icon">🎬</div>
            <h2>User</h2>
            <p class="muted">Manage your personal watchlist, favorites, ratings, and viewing status.</p>
            <a href="{{ route('user.login') }}" class="btn btn-user">User Login</a>
            <div style="margin-top:10px">
                <a href="{{ route('register') }}" style="font-size:13px;color:#2563eb;text-decoration:none">Create a new account</a>
            </div>
        </div>
    </div>
</div>
@endsection
