<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Membership Management' }}</title>
    <style>
        :root { --violet-50:#faf7ff; --violet-100:#f1eaff; --violet-200:#e5d8ff; --violet-400:#a78bfa; --violet-500:#8b5cf6; --violet-700:#6d28d9; --ink:#33264d; --muted:#776b8d; --white:#fff; }
        * { box-sizing:border-box; }
        body { margin:0; min-height:100vh; background:linear-gradient(135deg,#faf7ff,#eee7ff); color:var(--ink); font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif; }
        a { color:var(--violet-700); text-decoration:none; }
        .page { width:min(1120px,calc(100% - 32px)); margin:auto; padding:34px 0 60px; }
        .nav { display:flex; justify-content:flex-end; align-items:center; gap:16px; margin-bottom:46px; }
        .nav-links { display:flex; gap:8px; font-size:.9rem; font-weight:700; }
        .nav-links a { border-radius:12px; background:#e4e1e9; color:#756d80; padding:9px 13px; transition:background .2s, color .2s, box-shadow .2s; }
        .nav-links a:hover { background:#f5f3f8; color:var(--violet-700); }
        .nav-links a.active { background:#fff; color:var(--violet-700); box-shadow:0 4px 12px rgba(84,55,139,.14); }
        .eyebrow { margin:0 0 9px; color:var(--violet-700); font-size:.76rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }
        h1 { margin:0 0 10px; font-size:clamp(2rem,5vw,3.4rem); letter-spacing:-.055em; line-height:1; }
        h2 { margin:0 0 18px; font-size:1.25rem; }
        h3 { margin:0 0 8px; }
        .subtitle { margin:0; color:var(--muted); }
        .hero { display:flex; justify-content:space-between; align-items:end; gap:18px; margin-bottom:28px; }
        .card { border:1px solid rgba(167,139,250,.26); border-radius:22px; background:rgba(255,255,255,.82); box-shadow:0 18px 45px rgba(84,55,139,.10); padding:24px; backdrop-filter:blur(12px); }
        .grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; }
        .stat { color:var(--muted); font-size:.82rem; font-weight:700; }
        .stat strong { display:block; color:var(--ink); font-size:1.8rem; margin-top:5px; }
        .levels-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; }
        .level-card { border:1px solid rgba(167,139,250,.24); border-radius:18px; padding:18px; box-shadow:0 10px 24px rgba(84,55,139,.08); }
        .level-card:nth-child(1) { background:#f8f3ff; }
        .level-card:nth-child(2) { background:#f1e8ff; }
        .level-card:nth-child(3) { background:#e9dcff; }
        .level-card:nth-child(4) { background:#dfceff; }
        .level-card h3 { margin-bottom:12px; color:var(--violet-700); }
        .level-meta { display:flex; justify-content:space-between; gap:10px; margin-bottom:12px; font-size:.8rem; font-weight:800; }
        .level-meta span:last-child { color:var(--violet-700); }
        .level-benefits { margin:0; color:var(--muted); font-size:.83rem; line-height:1.45; }
        .toolbar { display:flex; flex-wrap:wrap; gap:10px; align-items:end; margin-bottom:20px; }
        .toolbar .field { flex:1 1 190px; }
        label { display:block; margin:0 0 7px; color:#514367; font-size:.84rem; font-weight:700; }
        input, textarea, select { width:100%; border:1px solid var(--violet-200); border-radius:12px; background:var(--violet-50); color:var(--ink); font:inherit; outline:0; padding:11px 12px; }
        textarea { min-height:100px; resize:vertical; }
        input:focus,textarea:focus,select:focus { border-color:var(--violet-400); background:var(--white); box-shadow:0 0 0 4px rgba(167,139,250,.18); }
        button,.button { display:inline-flex; align-items:center; justify-content:center; border:0; border-radius:11px; background:linear-gradient(135deg,var(--violet-500),var(--violet-700)); color:#fff; cursor:pointer; font:inherit; font-weight:800; padding:11px 16px; }
        .button.secondary { background:var(--violet-100); color:var(--violet-700); }
        .button.danger { background:#fff0f4; color:#ad315c; }
        .button.small { padding:8px 11px; font-size:.82rem; }
        .notice,.error { border-radius:11px; margin:0 0 18px; padding:11px 13px; font-size:.9rem; }
        .notice { background:#eee7ff; color:var(--violet-700); }
        .error { background:#fff0f4; color:#ad315c; }
        table { width:100%; border-collapse:collapse; }
        th,td { border-bottom:1px solid #eee8f8; padding:14px 8px; text-align:left; vertical-align:middle; }
        th { color:var(--muted); font-size:.74rem; letter-spacing:.08em; text-transform:uppercase; }
        td { font-size:.92rem; }
        .muted { color:var(--muted); }
        .badge { display:inline-block; border-radius:999px; background:var(--violet-100); color:var(--violet-700); font-size:.74rem; font-weight:800; padding:5px 9px; text-transform:capitalize; }
        .badge.inactive { background:#f3edf2; color:#826d80; }
        .actions { display:flex; flex-wrap:wrap; gap:6px; }
        .empty { border:1px dashed var(--violet-200); border-radius:14px; color:var(--muted); padding:28px; text-align:center; }
        .form-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:18px; }
        .full { grid-column:1/-1; }
        .form-actions { display:flex; gap:10px; margin-top:22px; }
        .profile { display:grid; grid-template-columns:repeat(2,1fr); gap:18px; }
        .profile-item { border-bottom:1px solid #eee8f8; padding-bottom:12px; }
        .profile-item span { display:block; color:var(--muted); font-size:.78rem; margin-bottom:5px; }
        @media (max-width:900px) { .levels-grid { grid-template-columns:repeat(2,1fr); } }
        @media (max-width:700px) { .nav,.hero { align-items:flex-start; flex-direction:column; } .grid,.levels-grid,.form-grid,.profile { grid-template-columns:1fr; } .full { grid-column:auto; } .card { padding:18px; overflow-x:auto; } table { min-width:650px; } }
    </style>
</head>
<body>
<main class="page">
    <nav class="nav">
        <div class="nav-links"><a class="{{ request()->routeIs('members.*') ? 'active' : '' }}" href="{{ route('members.index') }}">Members</a><a class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}" href="{{ route('tasks.index') }}">Tasks</a></div>
    </nav>
    @if (session('success')) <p class="notice">{{ session('success') }}</p> @endif
    @if ($errors->any())
        <div class="error"><strong>Please check the form:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    @yield('content')
</main>
</body>
</html>
