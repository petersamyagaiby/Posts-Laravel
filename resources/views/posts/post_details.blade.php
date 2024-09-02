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
@endsection
