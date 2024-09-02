@extends("layouts.app")

@section("title")
    Create User
@endsection

@section("content")
    <h1 class="text-center">Create New User Account</h1>
    <div class="d-flex flex-row-reverse my-3">
        <a href="{{ route("users.index") }}" class="btn btn-success align-self-end">Go Back</a>
    </div>

    <form action="{{ route("users.store") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old("name") }}">
            @error("name")
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old("email") }}">
            @error("email")
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
            @error("password")
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <button class="btn btn-success">Create Account</button>
    </form>
@endsection
