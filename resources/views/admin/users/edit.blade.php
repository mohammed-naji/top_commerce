@extends('admin.master')

@section('title', 'Edit User | ' . env('APP_NAME'))

@section('content')
<!-- Page Heading -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit User <span class="text-danger">{{ $user->name }}</span></h1>
    <a class="btn btn-dark" href="{{ route('admin.users.index') }}">All Users</a>
</div>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('put')
<div class="mb-3">
    <label>Role</label>
    <select name="role_id" class="form-control">
        <option value="" disabled selected>--Select--</option>
        @foreach ($roles as $item)
            <option {{ $user->role_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
    </select>
</div>
<button class="btn btn-info px-5">Edit</button>
</form>
@stop


@section('scripts')

<script>
document.querySelector('#img-item').onclick = function() {
    document.querySelector('#img-input').click();
}

document.getElementById('img-input').onchange = function (evt) {
    var tgt = evt.target || window.event.srcElement,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            document.getElementById('img-item').src = fr.result;
        }
        fr.readAsDataURL(files[0]);
    }

    // Not supported
    else {
        // fallback -- perhaps submit the input to an iframe and temporarily store
        // them on the server until the user's session ends.
    }
}
</script>

@stop
