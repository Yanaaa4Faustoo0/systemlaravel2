@extends('members.layout', ['title' => 'Edit Member'])

@section('content')
    <header class="hero"><div><p class="eyebrow">Member profile</p><h1>Edit member</h1><p class="subtitle">Update {{ $member->full_name }}'s information.</p></div><a class="button secondary" href="{{ route('members.show', $member) }}">Back to profile</a></header>
    <section class="card"><form method="POST" action="{{ route('members.update', $member) }}">@csrf @method('PUT') @include('members._form')<div class="form-actions"><button type="submit">Save changes</button><a class="button secondary" href="{{ route('members.show', $member) }}">Cancel</a></div></form></section>
@endsection
