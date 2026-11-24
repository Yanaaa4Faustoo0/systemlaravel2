<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login</title>
    <style>
        body{margin:0;min-height:100vh;display:grid;place-items:center;background:linear-gradient(135deg,#faf7ff,#eee7ff);font-family:Inter,system-ui,sans-serif;color:#33264d}
        .card{width:min(420px,calc(100% - 40px));padding:30px;border-radius:22px;background:#fff;box-shadow:0 18px 45px #54378b1a}
        h1{margin-top:0}label{display:block;margin:16px 0 7px;font-weight:700}input{width:100%;box-sizing:border-box;padding:12px;border:1px solid #e5d8ff;border-radius:12px;font:inherit}button{width:100%;margin-top:22px;padding:12px;border:0;border-radius:11px;background:linear-gradient(135deg,#8b5cf6,#6d28d9);color:#fff;font-weight:800;font-size:1rem}.error{color:#ad315c;background:#fff0f4;padding:10px;border-radius:10px}.muted{color:#776b8d}.portal-switch{display:flex;gap:8px;margin-bottom:26px}.portal-switch a{flex:1;text-align:center;text-decoration:none;border-radius:12px;padding:10px 8px;background:#f1eaff;color:#6d28d9;font-size:.82rem;font-weight:800}.portal-switch a.active{background:linear-gradient(135deg,#8b5cf6,#6d28d9);color:#fff}
        body{display:grid;place-items:center}
        .card{width:min(920px,calc(100% - 32px));padding:30px;border:1px solid rgba(167,139,250,.26);border-radius:22px;background:rgba(255,255,255,.84);box-shadow:0 18px 45px rgba(84,55,139,.1);backdrop-filter:blur(12px)}
        .portal-switch{width:min(530px,100%);margin:0 auto 34px;padding:5px;border:1px solid #e5d8ff;border-radius:999px;background:rgba(255,255,255,.72);box-shadow:0 8px 24px rgba(84,55,139,.1)}
        .portal-switch a{border-radius:999px;padding:11px 16px;transition:background .2s,color .2s,box-shadow .2s,transform .2s}
        .portal-switch a:not(.active):hover{background:#dfceff;color:#5b21b6;transform:translateY(-1px)}
        .card form{max-width:420px;margin:0 auto}
        .card>p.muted,.card>h1{max-width:420px;margin-left:auto;margin-right:auto}
        body{display:block}
        .card{min-height:0;margin:34px auto}
    </style>
</head>
<body>
<main class="card">
    <div class="portal-switch"><a href="{{ route('membership.create') }}">Membership Application</a><a class="active" href="{{ route('login') }}">Admin Login</a></div>
    <h1>Admin login</h1>
    @if($errors->any())<div class="error">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('login.store') }}">@csrf<label for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus><label for="password">Password</label><input id="password" name="password" type="password" required><label><input name="remember" type="checkbox" style="width:auto"> Remember me</label><button type="submit">Sign in</button></form>
</main>
</body>
</html>
