@extends('admin.master')

@section('title', 'All Roles | ' . env('APP_NAME'))

@section('content')
<!-- Page Heading -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create New Role</h1>
    <a class="btn btn-dark" href="{{ route('admin.roles.index') }}">All Roles</a>
</div>

@include('admin.parts.errors')

<form action="{{ route('admin.roles.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" placeholder="Name" />
</div>

<div class="mb-3">
    <label>Abilities</label>
    <br>

    @foreach ($abilities as $item)
        <label><input name="abilites_ids[]" type="checkbox" value="{{ $item->id }}"> {{ $item->name }}</label> <br>
    @endforeach
</div>

<button class="btn btn-success px-5">Save</button>
</form>
@stop
