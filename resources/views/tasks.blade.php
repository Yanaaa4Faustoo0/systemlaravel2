<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <style>
        :root {
            color-scheme: light;
            --violet-50: #faf7ff;
            --violet-100: #f1eaff;
            --violet-200: #e5d8ff;
            --violet-400: #a78bfa;
            --violet-500: #8b5cf6;
            --violet-700: #6d28d9;
            --ink: #33264d;
            --muted: #776b8d;
            --white: #ffffff;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #faf7ff 0%, #f4efff 52%, #eee7ff 100%);
            color: var(--ink);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .page {
            width: min(920px, calc(100% - 32px));
            margin: 0 auto;
            padding: 56px 0;
        }

        .hero { margin-bottom: 28px; }

        .nav {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 16px;
            margin-bottom: 46px;
        }

        .nav-links { display: flex; gap: 8px; font-size: .9rem; font-weight: 700; }
        .nav-links a { border-radius: 12px; background: #e4e1e9; color: #756d80; padding: 9px 13px; text-decoration: none; transition: background .2s, color .2s, box-shadow .2s; }
        .nav-links a:hover { background: #f5f3f8; color: var(--violet-700); }
        .nav-links a.active { background: #fff; color: var(--violet-700); box-shadow: 0 4px 12px rgba(84,55,139,.14); }

        .eyebrow {
            margin: 0 0 10px;
            color: var(--violet-700);
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        h1, h2, h3 { margin-top: 0; }

        h1 {
            margin-bottom: 10px;
            font-size: clamp(2.2rem, 6vw, 4rem);
            letter-spacing: -.055em;
            line-height: 1;
        }

        .subtitle { margin: 0; color: var(--muted); font-size: 1.05rem; }

        .layout {
            display: grid;
            grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
            gap: 22px;
            align-items: start;
        }

        .card {
            border: 1px solid rgba(167, 139, 250, .26);
            border-radius: 24px;
            background: rgba(255, 255, 255, .78);
            box-shadow: 0 18px 45px rgba(84, 55, 139, .10);
            padding: 26px;
            backdrop-filter: blur(12px);
        }

        .card h2 { margin-bottom: 20px; font-size: 1.25rem; }

        label {
            display: block;
            margin: 16px 0 8px;
            color: #514367;
            font-size: .88rem;
            font-weight: 700;
        }

        label:first-of-type { margin-top: 0; }

        input, textarea {
            width: 100%;
            border: 1px solid var(--violet-200);
            border-radius: 13px;
            background: var(--violet-50);
            color: var(--ink);
            font: inherit;
            outline: none;
            padding: 12px 14px;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }

        textarea { min-height: 116px; resize: vertical; }

        input:focus, textarea:focus {
            border-color: var(--violet-400);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(167, 139, 250, .18);
        }

        button {
            width: 100%;
            margin-top: 20px;
            border: 0;
            border-radius: 13px;
            background: linear-gradient(135deg, var(--violet-500), var(--violet-700));
            color: var(--white);
            cursor: pointer;
            font: inherit;
            font-weight: 800;
            padding: 13px 18px;
            box-shadow: 0 10px 20px rgba(109, 40, 217, .22);
            transition: transform .2s, box-shadow .2s;
        }

        button:hover { transform: translateY(-2px); box-shadow: 0 14px 25px rgba(109, 40, 217, .28); }

        .notice, .error { border-radius: 12px; margin: 0 0 18px; padding: 12px 14px; font-size: .92rem; }
        .notice { background: #eee7ff; color: var(--violet-700); }
        .error { margin-top: 8px; margin-bottom: 0; background: #fff0f4; color: #ad315c; }

        .tasks-header { display: flex; justify-content: space-between; align-items: center; gap: 12px; }
        .count { border-radius: 999px; background: var(--violet-100); color: var(--violet-700); font-size: .8rem; font-weight: 800; padding: 6px 10px; }

        .task {
            border: 1px solid rgba(167, 139, 250, .22);
            border-radius: 17px;
            background: rgba(250, 247, 255, .82);
            margin-top: 14px;
            padding: 17px;
        }

        .task h3 { margin-bottom: 7px; font-size: 1rem; }
        .task p { margin: 6px 0 0; color: var(--muted); line-height: 1.5; }
        .status { color: var(--violet-700) !important; font-size: .82rem; font-weight: 800; }
        .empty { border: 1px dashed var(--violet-200); border-radius: 16px; color: var(--muted); margin: 0; padding: 26px 18px; text-align: center; }

        @media (max-width: 700px) {
            .page { padding: 34px 0; }
            .layout { grid-template-columns: 1fr; }
            .card { padding: 21px; }
            .nav { align-items: flex-start; flex-direction: column; }
        }
    </style>
</head>
<body>
<main class="page">
    <nav class="nav">
        <div class="nav-links">
            <a class="{{ request()->routeIs('members.*') ? 'active' : '' }}" href="{{ route('members.index') }}">Members</a>
            <a class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}" href="{{ route('tasks.index') }}">Tasks</a>
        </div>
    </nav>

    <header class="hero">
        <p class="eyebrow">Personal workspace</p>
        <h1>My Tasks</h1>
        <p class="subtitle">A calm place to keep track of what matters.</p>
    </header>

    <div class="layout">
        <section class="card">
            <h2>Add a new task</h2>

            @if (session('success'))
                <p class="notice">{{ session('success') }}</p>
            @endif

            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf

                <label for="task_title">Task title</label>
                <input type="text" id="task_title" name="task_title" placeholder="e.g. Plan weekend errands" value="{{ old('task_title') }}">
                @error('task_title')
                    <p class="error">{{ $message }}</p>
                @enderror

                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Add a little context...">{{ old('description') }}</textarea>

                <button type="submit">Add task</button>
            </form>
        </section>

        <section class="card">
            <div class="tasks-header">
                <h2>Saved tasks</h2>
                <span class="count">{{ $tasks->count() }}</span>
            </div>

            @forelse ($tasks as $task)
                <article class="task">
                    <h3>{{ $task->task_title }}</h3>
                    <p>{{ $task->description ?: 'No description provided.' }}</p>
                    <p class="status">{{ $task->completed ? '✓ Completed' : '○ Not completed' }}</p>
                </article>
            @empty
                <p class="empty">No tasks yet. Add your first one to get started.</p>
            @endforelse
        </section>
    </div>
</main>
</body>
</html>
