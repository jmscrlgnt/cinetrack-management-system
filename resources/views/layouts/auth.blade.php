<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CineTrack')</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            color: #172554;
            background:
                radial-gradient(circle at 15% 15%, rgba(37,99,235,.11), transparent 28%),
                radial-gradient(circle at 85% 85%, rgba(15,31,70,.10), transparent 30%),
                #f4f7fb;
            display: grid;
            place-items: center;
            padding: 28px 18px;
        }
        .auth-shell { width: min(980px, 100%); }
        .brand { text-align: center; margin-bottom: 28px; }
        .brand h1 { margin: 0; font-size: 38px; letter-spacing: -.7px; color: #0f1f46; }
        .brand p { margin: 7px 0 0; color: #64748b; }
        .auth-card {
            background: white;
            border: 1px solid #edf1f7;
            border-radius: 18px;
            box-shadow: 0 16px 44px rgba(15,31,70,.12);
            padding: 30px;
        }
        .auth-card.narrow { width: min(470px, 100%); margin: auto; }
        .portal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .portal {
            padding: 30px;
            border: 1px solid #e6ebf3;
            border-radius: 14px;
            text-align: center;
            transition: .18s ease;
        }
        .portal:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(15,31,70,.08); }
        .portal-icon {
            width: 62px; height: 62px; border-radius: 50%; margin: 0 auto 15px;
            display: grid; place-items: center; font-size: 27px;
        }
        .admin-icon { background: #dbeafe; }
        .user-icon { background: #dcfce7; }
        h2 { margin: 0 0 7px; }
        .muted { color: #64748b; line-height: 1.55; }
        .role-badge { display:inline-block; font-size:11px; font-weight:800; padding:5px 9px; border-radius:999px; margin-bottom:14px; }
        .role-admin { background:#dbeafe;color:#1d4ed8; }
        .role-user { background:#dcfce7;color:#166534; }
        .form-group { margin-bottom: 16px; }
        label { display:block; font-size:13px; font-weight:750; margin-bottom:7px; }
        input {
            width: 100%; padding: 11px 12px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none;
        }
        input:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.10); }
        .check-row { display:flex; align-items:center; gap:8px; margin: 4px 0 17px; color:#64748b; font-size:13px; }
        .check-row input { width:auto; }
        .btn {
            display:inline-flex; align-items:center; justify-content:center; width:100%; border:0; border-radius:8px;
            padding:11px 14px; text-decoration:none; font-weight:800; cursor:pointer;
        }
        .btn-admin { background:#2563eb;color:white; }
        .btn-user { background:#16a34a;color:white; }
        .btn-neutral { background:#0f1f46;color:white; }
        .btn-outline { background:white;color:#172554;border:1px solid #cbd5e1; }
        .alert { padding:12px 14px; border-radius:8px; margin-bottom:16px; font-size:13px; }
        .alert-error { background:#fef2f2;color:#991b1b;border:1px solid #fecaca; }
        .alert-success { background:#ecfdf3;color:#166534;border:1px solid #bbf7d0; }
        .field-error { color:#dc2626;font-size:12px;margin-top:5px; }
        .back { text-align:center; margin-top:17px; font-size:13px; }
        .back a { color:#64748b; text-decoration:none; }
        .auth-footer { text-align:center; margin-top:18px; color:#94a3b8; font-size:11px; }
        .split-actions { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
        @media(max-width:700px){ .portal-grid{grid-template-columns:1fr}.auth-card{padding:22px}.split-actions{grid-template-columns:1fr} }
    </style>
</head>
<body>
<div class="auth-shell">
    <div class="brand">
        <h1>CineTrack</h1>
        <p>Movie Watchlist Management System</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="max-width:470px;margin:0 auto 16px">{{ session('success') }}</div>
    @endif

    @yield('content')

    <div class="auth-footer">CineTrack • Laravel MVC Application</div>
</div>
</body>
</html>
