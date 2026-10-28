@extends('members.layout', ['title' => 'Add Member'])

@section('content')
    <header class="hero"><div><p class="eyebrow">Member registration</p><h1>Add member</h1><p class="subtitle">Create a new membership profile.</p></div><a class="button secondary" href="{{ route('members.index') }}">Back to members</a></header>
    <section class="card"><form method="POST" action="{{ route('members.store') }}">@csrf @include('members._form')<div class="form-actions"><button type="submit">Register member</button><a class="button secondary" href="{{ route('members.index') }}">Cancel</a></div></form></section>
@endsection
