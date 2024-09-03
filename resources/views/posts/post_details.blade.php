@extends("layouts.app")

@section("title")
    Post Details
@endsection

@section("content")
    <div class="d-flex flex-row-reverse my-3">
        <a href="{{ route("posts.index") }}" class="btn btn-success align-self-end">Go Back</a>
    </div>

    <h1>Title: {{ $post->title }}</h1>
    <h3>Posted By: {{ $post->user->name }}</h3>
    {{-- <h5>Created At: {{ $post->created_at->diffForHumans() }}</h5> --}}
    <h5>Created At: {{ $post->human_readable_date }}</h5>
    <h5>updated At: {{ $post->updated_at->diffForHumans() }}</h5>
    <p>Description: {{ $post->description }}</p>
    @if (!empty($post->image))
        <p>Image: <img src="{{ asset("images/" . $post->image) }}" width="300" height="300" style="object-fit: contain;"></p>
    @endif

    @if (count($post->comments) > 0)
        <h2 class="text-center fw-bold">Comments</h2>

        @foreach ($post->comments as $comment)
            <figure class="text-start">
                <blockquote class="blockquote">
                    <p>{{ $comment->content }}</p>
                </blockquote>
                <figcaption class="blockquote-footer">
                    Commented by:<em title="Source Title">{{ $comment->user->name }} on {{ $comment->created_at->format("d M Y, h:i:S A") }}</em>
                </figcaption>
            </figure>
        @endforeach
    @else
        <h3 class="text-center">No comments found</h3>
    @endif

    <h1>Add Comment</h1>
    <form action="{{ route("posts.comment", $post->id) }}" method="POST">
        @csrf
        <div class="form-group my-3 w-75 align-self-center">
            <label for="content" class="form-label">Comment:</label>
            <textarea name="content" id="content" rows="3" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Add Comment</button>
    </form>
    @error("content")
        {{ message }}
    @enderror
@endsection
