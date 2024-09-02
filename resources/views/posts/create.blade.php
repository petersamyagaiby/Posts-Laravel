@extends("layouts.app")

@section("title")
    Create Post
@endsection

@section("content")
    <h1 class="text-center">Create Post</h1>
    <div class="d-flex flex-row-reverse my-3">
        <a href="{{ route("posts.index") }}" class="btn btn-success align-self-end">Go Back</a>
    </div>

    <form action="{{ route("posts.store") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old("title") }}">
            @error("title")
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old("description") }}</textarea>
            @error("description")
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="dropdown mb-3">
            <label for="user_id" class="form-label">Posted By</label>
            <select class="form-select" name="user_id" id="user_id" name="user_id">
                @foreach ($users as $user)
                    @if (Auth::user()->id == $user->id)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
            @error("user_id")
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            @error("image")
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <button class="btn btn-success">Create Post</button>
    </form>
@endsection
