@extends("layouts.app")

@section("title")
    All Users
@endsection

@section("content")
    @if (session("success"))
        <div class="alert alert-success">{{ session("success") }}</div>
    @endif
    <h1 class="my-3">All Users</h1>
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route("users.show", $user) }}" class="btn btn-success">Details</a>
                        <a href="{{ route("users.edit", $user) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route("users.destroy", $user) }}" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->onEachSide(2)->links() }}
@endsection
