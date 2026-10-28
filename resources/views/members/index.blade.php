@extends('members.layout', ['title' => 'Members'])

@section('content')
    <header class="hero">
        <div><p class="eyebrow">Membership management</p><h1>Members</h1><p class="subtitle">Register, search, and manage your membership community.</p></div>
        <a class="button" href="{{ route('members.create') }}">+ Add member</a>
    </header>

    <section class="levels-grid" style="margin-bottom:20px">
        @foreach ($levels as $level)
            <article class="level-card">
                <h3>{{ $level->name }}</h3>
                <div class="level-meta">
                    <span>₱{{ number_format($level->fee, 2) }}</span>
                    <span>{{ $level->validity_months }} months</span>
                </div>
                <p class="level-benefits">{{ $level->benefits }}</p>
            </article>
        @endforeach
    </section>

    <div class="grid" style="margin-bottom:20px">
        <div class="card stat">Total members<strong>{{ \App\Models\Member::count() }}</strong></div>
        <div class="card stat">Active members<strong>{{ \App\Models\Member::where('status', 'active')->count() }}</strong></div>
        <div class="card stat">Inactive members<strong>{{ \App\Models\Member::where('status', 'inactive')->count() }}</strong></div>
    </div>

    <section class="card">
        <form class="toolbar" method="GET" action="{{ route('members.index') }}">
            <div class="field"><label for="search">Search members</label><input id="search" name="search" value="{{ $search }}" placeholder="Name, email, or member number"></div>
            <div class="field"><label for="category">Category</label><select id="category" name="category"><option value="">All categories</option>@foreach ($categories as $option)<option value="{{ $option->name }}" @selected($category === $option->name)>{{ $option->name }}</option>@endforeach</select></div>
            <div class="field"><label for="level">Level</label><select id="level" name="level"><option value="">All levels</option>@foreach ($levels as $option)<option value="{{ $option->name }}" @selected($level === $option->name)>{{ $option->name }}</option>@endforeach</select></div>
            <button type="submit">Search</button>
            @if ($search || $category || $level)<a class="button secondary" href="{{ route('members.index') }}">Clear</a>@endif
        </form>

        @if ($members->count())
            <table>
                <thead><tr><th>Member</th><th>Category</th><th>Level</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td><strong>{{ $member->full_name }}</strong><br><span class="muted">{{ $member->member_number }}</span></td>
                        <td>{{ $member->category }}</td><td>{{ $member->level }}</td>
                        <td><span class="badge {{ $member->status === 'inactive' ? 'inactive' : '' }}">{{ $member->status }}</span></td>
                        <td><div class="actions"><a class="button small secondary" href="{{ route('members.show', $member) }}">View</a><a class="button small secondary" href="{{ route('members.edit', $member) }}">Edit</a>@if ($member->status === 'active')<form method="POST" action="{{ route('members.destroy', $member) }}" onsubmit="return confirm('Deactivate this member?')">@csrf @method('DELETE')<button class="button small danger" type="submit">Deactivate</button></form>@endif<form method="POST" action="{{ route('members.delete', $member) }}" onsubmit="return confirm('Permanently delete this member? This cannot be undone.')">@csrf @method('DELETE')<button class="button small danger" type="submit">Delete</button></form></div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="margin-top:20px">{{ $members->links() }}</div>
        @else
            <p class="empty">No members found. Register your first member to get started.</p>
        @endif
    </section>
@endsection
