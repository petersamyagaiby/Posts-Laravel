@extends("layouts.app")

@section("title")
    Edit Post
@endsection

@section("content")
    <h1 class="text-center">Edit Post</h1>

    <div class="d-flex flex-row-reverse my-3">
        <a href="{{ route("posts.index") }}" class="btn btn-success align-self-end">Go Back</a>
    </div>

    <form action="{{ route("posts.update", ["post" => $post]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PUT")

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="test" class="form-control" id="title" value="{{ $post->title }}" name="title">
            @error("title")
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="3" name="description">{{ $post->description }}</textarea>
            @error("description")
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="dropdown mb-3">
            <label for="user_id" class="col-sm-2 col-form-label">Posted By</label>
            <select class="form-select" id="user_id" name="user_id">

                @foreach ($users as $user)
                    @if ($user->id == $post->user_id)
                        <option selected value="{{ $user->id }}">{{ $user->name }}</option>
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
            @if (!empty($post->image))
                <img src="{{ asset("images/" . $post->image) }}" width="200" height="200" style="object-fit: contain;">
            @endif
            @error("image")
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <button class="btn btn-success">Update</button>
    </form>
@endsection
