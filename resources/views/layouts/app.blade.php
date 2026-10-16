<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CineTrack')</title>
    <style>
        :root {
            --navy: #0f1f46;
            --navy-2: #162a5a;
            --blue: #2563eb;
            --blue-soft: #eaf1ff;
            --green: #16a34a;
            --amber: #d97706;
            --red: #dc2626;
            --cyan: #0891b2;
            --bg: #f4f7fb;
            --card: #ffffff;
            --line: #e2e8f0;
            --text: #172554;
            --muted: #64748b;
            --shadow: 0 10px 28px rgba(15, 31, 70, .08);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: Inter, "Segoe UI", Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        a { color: inherit; }
        button, input, select, textarea { font: inherit; }

        .app-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 245px minmax(0, 1fr);
        }

        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            background: linear-gradient(180deg, var(--navy), #0a1735);
            color: white;
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            z-index: 20;
        }

        .brand {
            display: block;
            text-decoration: none;
            padding: 0 10px 22px;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }
        .brand-name { font-weight: 800; font-size: 25px; letter-spacing: .2px; }
        .brand-sub { margin-top: 4px; font-size: 11px; opacity: .72; line-height: 1.35; }

        .nav-label {
            margin: 22px 10px 8px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.3px;
            color: rgba(255,255,255,.5);
            font-weight: 700;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px 12px;
            margin: 3px 0;
            border-radius: 9px;
            text-decoration: none;
            color: rgba(255,255,255,.82);
            font-size: 14px;
            font-weight: 650;
            transition: .16s ease;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,.12);
            color: white;
            transform: translateX(2px);
        }
        .nav-icon { width: 20px; text-align: center; }

        .sidebar-user {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid rgba(255,255,255,.12);
        }
        .sidebar-user-name { font-size: 13px; font-weight: 750; }
        .sidebar-user-email { font-size: 11px; color: rgba(255,255,255,.55); margin: 3px 0 9px; word-break: break-all; }
        .role-pill {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.12);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .6px;
        }

        .content-area { min-width: 0; }
        .topbar {
            height: 72px;
            background: white;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 15;
        }
        .topbar-title { font-weight: 800; font-size: 16px; }
        .topbar-sub { font-size: 12px; color: var(--muted); margin-top: 2px; }
        .topbar-actions { display: flex; align-items: center; gap: 10px; }

        .content { width: min(1280px, 94%); margin: 0 auto; padding: 30px 0 46px; }
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 22px;
        }
        .page-header h1 { margin: 0; font-size: clamp(25px, 3vw, 34px); letter-spacing: -.6px; }
        .subtitle { margin-top: 6px; color: var(--muted); line-height: 1.5; }

        .card {
            background: var(--card);
            border: 1px solid #edf1f7;
            border-radius: 14px;
            padding: 22px;
            box-shadow: var(--shadow);
        }
        .card-title { margin: 0 0 4px; font-size: 17px; }
        .card-subtitle { color: var(--muted); font-size: 13px; margin-bottom: 18px; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 22px;
        }
        .stat-card {
            background: white;
            border: 1px solid #edf1f7;
            border-radius: 13px;
            padding: 17px;
            box-shadow: var(--shadow);
        }
        .stat-label { color: var(--muted); font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: .5px; }
        .stat-value { margin-top: 8px; font-size: 26px; font-weight: 850; }
        .stat-hint { margin-top: 3px; color: var(--muted); font-size: 11px; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border: 0;
            border-radius: 8px;
            padding: 10px 14px;
            text-decoration: none;
            cursor: pointer;
            font-weight: 750;
            font-size: 13px;
            transition: .15s ease;
            white-space: nowrap;
        }
        .btn:hover { transform: translateY(-1px); filter: brightness(.98); }
        .btn-primary { background: var(--blue); color: white; }
        .btn-secondary { background: #64748b; color: white; }
        .btn-view { background: var(--cyan); color: white; }
        .btn-edit { background: #f59e0b; color: white; }
        .btn-delete { background: var(--red); color: white; }
        .btn-success { background: var(--green); color: white; }
        .btn-ghost { background: #eef2f7; color: var(--text); }
        .btn-outline { background: white; border: 1px solid #cbd5e1; color: var(--text); }
        .btn-sm { padding: 7px 10px; font-size: 12px; }

        .alert {
            padding: 13px 15px;
            border-radius: 9px;
            margin-bottom: 18px;
            border: 1px solid transparent;
            font-size: 14px;
        }
        .alert-success { background: #ecfdf3; color: #166534; border-color: #bbf7d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border-color: #fecaca; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { margin-bottom: 17px; }
        label { display: block; margin-bottom: 7px; font-size: 13px; font-weight: 750; color: #24345d; }
        input, select, textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 11px 12px;
            background: white;
            color: #0f172a;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #5b8def;
            box-shadow: 0 0 0 3px rgba(37,99,235,.10);
        }
        textarea { min-height: 120px; resize: vertical; }
        .field-error { color: var(--red); font-size: 12px; margin-top: 5px; }
        .form-help { color: var(--muted); font-size: 11px; margin-top: 5px; }
        .form-actions { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 4px; }
        .check-row { display: flex; align-items: center; gap: 9px; }
        .check-row input { width: auto; }
        .check-row label { margin: 0; font-weight: 650; }

        .filters {
            display: grid;
            grid-template-columns: 2fr repeat(3, minmax(130px, 1fr)) auto auto;
            gap: 10px;
            align-items: end;
            margin-bottom: 18px;
        }
        .filters .form-group { margin: 0; }

        .table-wrap { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 760px; }
        th, td { padding: 12px 11px; text-align: left; border-bottom: 1px solid #edf1f6; vertical-align: middle; }
        th { background: #f7f9fd; color: #405075; font-size: 11px; text-transform: uppercase; letter-spacing: .45px; }
        td { font-size: 13px; }
        tbody tr:hover { background: #fbfcff; }
        .actions { display: flex; flex-wrap: wrap; gap: 6px; }
        .actions form { margin: 0; }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }
        .plan { background: #e8edff; color: #3730a3; }
        .watching { background: #fff4d6; color: #92400e; }
        .completed { background: #dcfce7; color: #166534; }
        .admin-badge { background: #dbeafe; color: #1d4ed8; }
        .user-badge { background: #e2e8f0; color: #475569; }
        .favorite { color: #b45309; font-weight: 800; }

        .empty {
            text-align: center;
            padding: 52px 20px;
            color: var(--muted);
        }
        .empty strong { color: var(--text); font-size: 18px; }

        .movie-list { display: grid; gap: 10px; }
        .movie-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #edf1f6;
        }
        .movie-row:last-child { border-bottom: 0; }
        .movie-title { font-weight: 800; }
        .movie-meta { margin-top: 3px; color: var(--muted); font-size: 12px; }
        .rating { font-weight: 850; color: #b45309; }

        .detail-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .detail-item { padding: 13px 0; border-bottom: 1px solid #edf1f6; }
        .detail-label { color: var(--muted); font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: .45px; }
        .detail-value { margin-top: 5px; font-weight: 700; line-height: 1.5; }

        .pagination { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-top: 18px; color: var(--muted); font-size: 12px; }
        .pagination-links { display: flex; gap: 7px; }

        .menu-toggle { display: none; }

        @media (max-width: 1100px) {
            .stats-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .filters { grid-template-columns: 1fr 1fr 1fr; }
            .filters .search-field { grid-column: 1 / -1; }
        }

        @media (max-width: 820px) {
            .app-shell { grid-template-columns: 1fr; }
            .sidebar { position: static; height: auto; padding: 15px; }
            .brand { padding-bottom: 14px; }
            .nav-label, .sidebar-user { display: none; }
            .sidebar nav { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 10px; }
            .nav-link { margin: 0; padding: 8px 10px; font-size: 12px; }
            .topbar { position: static; height: auto; min-height: 64px; padding: 14px 18px; }
            .content { width: min(95%, 1280px); padding-top: 20px; }
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .detail-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 620px) {
            .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .form-grid, .filters { grid-template-columns: 1fr; }
            .filters .search-field { grid-column: auto; }
            .page-header { flex-direction: column; }
            .topbar-actions .user-top-info { display: none; }
            .card { padding: 17px; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="brand">
            <div class="brand-name">CineTrack</div>
            <div class="brand-sub">Movie Watchlist Management System</div>
        </a>

        <nav>
            <div class="nav-label">Main</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon">⌂</span> Dashboard
            </a>
            <a href="{{ route('movies.index') }}" class="nav-link {{ request()->routeIs('movies.index') && !request('favorites') ? 'active' : '' }}">
                <span class="nav-icon">🎬</span> {{ auth()->user()->isAdmin() ? 'All Movies' : 'My Watchlist' }}
            </a>
            <a href="{{ route('movies.create') }}" class="nav-link {{ request()->routeIs('movies.create') ? 'active' : '' }}">
                <span class="nav-icon">＋</span> Add Movie
            </a>
            <a href="{{ route('movies.index', ['favorites' => 1]) }}" class="nav-link {{ request()->routeIs('movies.index') && request('favorites') ? 'active' : '' }}">
                <span class="nav-icon">★</span> Favorites
            </a>

            @if(auth()->user()->isAdmin())
                <div class="nav-label">Administration</div>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span class="nav-icon">👥</span> User Accounts
                </a>
            @endif

            <div class="nav-label">Account</div>
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <span class="nav-icon">⚙</span> Profile & Security
            </a>
        </nav>

        <div class="sidebar-user">
            <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
            <div class="sidebar-user-email">{{ auth()->user()->email }}</div>
            <span class="role-pill">{{ strtoupper(auth()->user()->role) }}</span>
        </div>
    </aside>

    <section class="content-area">
        <header class="topbar">
            <div>
                <div class="topbar-title">@yield('page_label', 'CineTrack')</div>
                <div class="topbar-sub">Organize. Track. Enjoy.</div>
            </div>

            <div class="topbar-actions">
                <div class="user-top-info" style="text-align:right">
                    <div style="font-size:12px;font-weight:800">{{ auth()->user()->name }}</div>
                    <div style="font-size:11px;color:#64748b">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Are you sure you want to log out of CineTrack?');">
                    @csrf
                    <button class="btn btn-outline btn-sm" type="submit">Logout</button>
                </form>
            </div>
        </header>

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </section>
</div>
@stack('scripts')
</body>
</html>
