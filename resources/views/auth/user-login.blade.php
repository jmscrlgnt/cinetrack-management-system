@extends('layouts.auth')

@section('title', 'User Login | CineTrack')

@section('content')
<div class="auth-card narrow">
    <span class="role-badge role-user">USER PORTAL</span>
    <h2>Welcome to CineTrack</h2>
    <p class="muted" style="margin-top:5px;margin-bottom:20px">Sign in to continue managing your personal movie watchlist.</p>

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('user.login.submit') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="user@cinetrack.test">
            @error('email')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required placeholder="Enter password">
            @error('password')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <label class="check-row">
            <input type="checkbox" name="remember" value="1"> Remember me
        </label>

        <button type="submit" class="btn btn-user">Login as User</button>
    </form>

    <div class="split-actions" style="margin-top:10px">
        <a href="{{ route('register') }}" class="btn btn-outline">Create Account</a>
        <a href="{{ route('login') }}" class="btn btn-outline">Portal Selection</a>
    </div>
</div>
@endsection
