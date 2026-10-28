@extends('members.layout', ['title' => $member->full_name])

@section('content')
    <header class="hero"><div><p class="eyebrow">Member profile</p><h1>{{ $member->full_name }}</h1><p class="subtitle">{{ $member->member_number }} · Joined {{ $member->joined_at->format('F j, Y') }}</p></div><div class="actions"><a class="button secondary" href="{{ route('members.index') }}">All members</a><a class="button" href="{{ route('members.edit', $member) }}">Edit profile</a></div></header>
    <section class="card">
        <div class="profile">
            <div class="profile-item"><span>Status</span><strong><span class="badge {{ $member->status === 'inactive' ? 'inactive' : '' }}">{{ $member->status }}</span></strong></div>
            <div class="profile-item"><span>Membership</span><strong>{{ $member->category }} · {{ $member->level }}</strong></div>
            @if ($levelDetails)
                <div class="profile-item"><span>Level fee</span><strong>₱{{ number_format($levelDetails->fee, 2) }}</strong></div>
                <div class="profile-item"><span>Validity</span><strong>{{ $levelDetails->validity_months }} months</strong></div>
                <div class="profile-item full"><span>Benefits</span><strong>{{ $levelDetails->benefits }}</strong></div>
            @endif
            <div class="profile-item"><span>Email</span><strong>{{ $member->email ?: 'Not provided' }}</strong></div>
            <div class="profile-item"><span>Phone</span><strong>{{ $member->phone ?: 'Not provided' }}</strong></div>
            <div class="profile-item full"><span>Address</span><strong>{{ $member->address ?: 'Not provided' }}</strong></div>
        </div>
        <div class="form-actions">
            <form method="POST" action="{{ route('members.delete', $member) }}" onsubmit="return confirm('Permanently delete this member? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button class="button danger" type="submit">Delete member</button>
            </form>
        </div>
    </section>
@endsection
