@extends('members.layout', ['title' => 'Categories'])
@section('content')
<header class="hero"><div><p class="eyebrow">Membership catalog</p><h1>Categories</h1><p class="subtitle">Manage the member categories available during registration.</p></div></header>
<section class="card"><h2>Add category</h2><form class="toolbar" method="POST" action="{{ route('categories.store') }}">@csrf<div class="field"><label>Name</label><input name="name" required></div><div class="field"><label>Description</label><input name="description"></div><button type="submit">Add category</button></form></section>
<section class="card" style="margin-top:20px"><table><thead><tr><th>Name</th><th>Description</th><th>Actions</th></tr></thead><tbody>@foreach($categories as $category)<tr><td>{{ $category->name }}</td><td>{{ $category->description }}</td><td><form method="POST" action="{{ route('categories.destroy',$category) }}" onsubmit="return confirm('Delete this category?')">@csrf @method('DELETE')<button class="button small danger">Delete</button></form></td></tr>@endforeach</tbody></table></section>
@endsection
