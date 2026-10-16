@extends('layouts.app')

@section('title', 'User Accounts | CineTrack')
@section('page_label', 'Administration')

@section('content')
<div class="page-header">
    <div>
        <h1>User Accounts</h1>
        <div class="subtitle">Create accounts, review movie ownership, and manage CineTrack roles.</div>
    </div>
</div>

<div class="grid-2" style="align-items:start">
    <section class="card">
        <h3 class="card-title">Create Account</h3>
        <div class="card-subtitle">Administrators can create additional user or admin accounts.</div>

        @if($errors->any())
            <div class="alert alert-error">
                <strong>Please correct the following:</strong>
                <ul style="margin:7px 0 0;padding-left:18px">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label for="password">Temporary Password</label>
                <input id="password" type="password" name="password" required minlength="8">
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="user" @selected(old('role') === 'user')>User</option>
                    <option value="admin" @selected(old('role') === 'admin')>Administrator</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
    </section>

    <section class="card">
        <h3 class="card-title">Account Summary</h3>
        <div class="card-subtitle">Current registered CineTrack accounts.</div>
        <div style="font-size:38px;font-weight:850">{{ $users->total() }}</div>
        <div class="muted" style="color:#64748b;font-size:13px">Total registered accounts</div>
        <div style="margin-top:22px;font-size:13px;color:#64748b;line-height:1.6">
            <strong>Administrator:</strong> can see all movie records and manage accounts.<br>
            <strong>User:</strong> can only access movies owned by their own account.
        </div>
    </section>
</div>

<section class="card" style="margin-top:20px">
    <h3 class="card-title">Registered Users</h3>
    <div class="card-subtitle">Role changes and account deletion are protected from changes to your own active account.</div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Movies</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong>@if(auth()->id() === $user->id) <span style="font-size:11px;color:#64748b">(You)</span>@endif</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge {{ $user->role === 'admin' ? 'admin-badge' : 'user-badge' }}">{{ strtoupper($user->role) }}</span></td>
                        <td>{{ $user->movies_count }}</td>
                        <td>{{ $user->created_at?->format('M d, Y') }}</td>
                        <td>
                            @if(auth()->id() !== $user->id)
                                <div class="actions">
                                    <form method="POST" action="{{ route('admin.users.role', $user) }}" style="display:flex;gap:6px">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" style="width:auto;padding:7px 9px">
                                            <option value="user" @selected($user->role === 'user')>User</option>
                                            <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                        </select>
                                        <button type="submit" class="btn btn-outline btn-sm">Save</button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this CineTrack user account? Their movie records will become unassigned.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete btn-sm">Delete</button>
                                    </form>
                                </div>
                            @else
                                <span style="font-size:12px;color:#64748b">Current account</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <div>Showing {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} of {{ $users->total() }} accounts</div>
        <div class="pagination-links">
            @if($users->onFirstPage())
                <span class="btn btn-ghost btn-sm" style="opacity:.55">Previous</span>
            @else
                <a class="btn btn-outline btn-sm" href="{{ $users->previousPageUrl() }}">Previous</a>
            @endif
            <span class="btn btn-ghost btn-sm">Page {{ $users->currentPage() }} / {{ $users->lastPage() }}</span>
            @if($users->hasMorePages())
                <a class="btn btn-outline btn-sm" href="{{ $users->nextPageUrl() }}">Next</a>
            @else
                <span class="btn btn-ghost btn-sm" style="opacity:.55">Next</span>
            @endif
        </div>
    </div>
</section>
@endsection
