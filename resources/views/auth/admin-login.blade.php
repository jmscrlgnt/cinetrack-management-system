@extends('layouts.auth')

@section('title', 'Administrator Login | CineTrack')

@section('content')
<div class="auth-card narrow">
    <span class="role-badge role-admin">ADMINISTRATOR PORTAL</span>
    <h2>Welcome Back</h2>
    <p class="muted" style="margin-top:5px;margin-bottom:20px">Sign in using an authorized administrator account.</p>

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@cinetrack.test">
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

        <button type="submit" class="btn btn-admin">Login as Administrator</button>
    </form>

    <div class="back"><a href="{{ route('login') }}">← Back to Portal Selection</a></div>
</div>
@endsection
