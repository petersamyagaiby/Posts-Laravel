@extends("layouts.app")

@section("title")
    User Info
@endsection

@section("content")
    <h1>User's Info</h1>
    <div class="d-flex flex-row-reverse my-3">
        <a href="{{ route("users.index") }}" class="btn btn-success align-self-end">Go Back</a>
    </div>

    <h2>Full Name: {{ $user->name }}</h2>
    <h3>Email Address: {{ $user->email }}</h3>
@endsection
