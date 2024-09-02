@extends("layouts.app")

@section("title")
    All Posts
@endsection

@section("content")
    @if (session("numPosts"))
        <div class="alert alert-danger my-3">{{ session("numPosts") }} </div>
    @endif

    <h1 class="my-3">All Posts</h1>
    @if (count($trashedPosts) > 0)
        <div class="d-flex flex-row-reverse my-3">
            <a href="{{ route("posts.trashed") }}" class="btn btn-warning align-self-end">Trashed Posts</a>
        </div>
    @endif

    @if (session("deletedPost"))
        <div class="alert alert-danger my-3">{{ session("deletedPost") }} </div>
    @endif

    @if (session("updatedPost"))
        <div class="alert alert-danger my-3">{{ session("updatedPost") }} </div>
    @endif

    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Posted By</th>
                <th scope="col">Created At</th>
                <th scope="col">Slug</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->created_at->diffForHumans() }}</td>
                    <td>{{ $post->slug }}</td>
                    <td>
                        <a href="{{ route("posts.show", $post->slug) }}" class="btn btn-success">Details</a>
                        @auth
                            @can("update-post", $post)
                                <a href="{{ route("posts.edit", $post->slug) }}" class="btn btn-primary">Edit</a>
                            @endcan
                            @can("delete-post", $post)
                                <a class="btn btn-danger" type="submit" data-bs-toggle="modal" data-bs-target="#deleteAlert/{{ $post->id }}" role="button">Delete</a>
                            @endcan
                        @endauth
                    </td>
                </tr>

                <div class="modal fade" id="deleteAlert/{{ $post->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are You Shure you want to delete this post?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <form action="{{ route("posts.destroy", $post) }}" method="post" class="d-inline">
                                    @csrf
                                    @method("DELETE")
                                    <input type="submit" class="btn btn-danger" value="Confirm">
                                </form>
                            </div>
                        </div>
                    </div>
            @endforeach
        </tbody>
    </table>
    {{ $posts->onEachSide(3)->links() }}
@endsection
