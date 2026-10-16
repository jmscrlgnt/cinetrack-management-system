@extends('layouts.auth')

@section('title', 'Register | CineTrack')

@section('content')
<div class="auth-card narrow">
    <span class="role-badge role-user">NEW USER</span>
    <h2>Create Your CineTrack Account</h2>
    <p class="muted" style="margin-top:5px;margin-bottom:20px">Your account will have its own private movie watchlist.</p>

    @if($errors->any())
        <div class="alert alert-error">
            <strong>Please correct the following:</strong>
            <ul style="margin:7px 0 0;padding-left:18px">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <div class="form-group">
            <label for="name">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Your name">
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required placeholder="At least 8 characters">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Repeat password">
        </div>
        <button type="submit" class="btn btn-user">Create User Account</button>
    </form>

    <div class="back"><a href="{{ route('user.login') }}">Already registered? Sign in</a></div>
</div>
@endsection
