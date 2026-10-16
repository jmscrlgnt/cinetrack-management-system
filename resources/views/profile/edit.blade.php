@extends('layouts.app')

@section('title', 'Profile | CineTrack')
@section('page_label', 'Profile & Security')

@section('content')
<div class="page-header">
    <div>
        <h1>Profile & Security</h1>
        <div class="subtitle">Update your account information and password.</div>
    </div>
</div>

<div class="grid-2">
    <section class="card">
        <h3 class="card-title">Account Information</h3>
        <div class="card-subtitle">Change your display name or email address.</div>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Account Role</label>
                <input value="{{ ucfirst($user->role) }}" disabled>
                <div class="form-help">Only an administrator can change account roles.</div>
            </div>

            <button type="submit" class="btn btn-primary">Save Profile</button>
        </form>
    </section>

    <section class="card">
        <h3 class="card-title">Change Password</h3>
        <div class="card-subtitle">Use your current password before creating a new one.</div>

        <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input id="current_password" type="password" name="current_password" required>
                @error('current_password')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input id="password" type="password" name="password" required placeholder="At least 8 characters">
                @error('password')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
    </section>
</div>
@endsection
