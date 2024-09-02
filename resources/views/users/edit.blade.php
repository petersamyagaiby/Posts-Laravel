@extends("layouts.app")

@section("title")
    Edit Post
@endsection

@section("content")
    <h1 class="text-center">Edit User Account</h1>
    <div class="d-flex flex-row-reverse my-3">
        <a href="{{ route("users.index") }}" class="btn btn-success align-self-end">Go Back</a>
    </div>

    <form action="{{ route("users.update", $user) }}" method="POST">
        @csrf
        @method("PUT")
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
            @error("name")
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
            @error("email")
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <button class="btn btn-success">Edit Account</button>
    </form>
@endsection
