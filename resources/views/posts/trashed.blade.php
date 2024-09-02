@extends("layouts.app")

@section("title")
    All Posts
@endsection

@section("content")
    <h1 class="my-3">Trashed Posts</h1>

    <div class="d-flex flex-row-reverse my-3">
        <a href="{{ route("posts.index") }}" class="btn btn-success align-self-end">Go Back</a>
    </div>

    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Posted By</th>
                <th scope="col">Deleted At</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->deleted_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route("posts.restore", $post->id) }}" class="btn btn-success">Restore</a>
                        <a class="btn btn-danger" type="submit" data-bs-toggle="modal" data-bs-target="#forceDelete/{{ $post->id }}" role="button">Delete</a>
                    </td>
                </tr>

                <div class="modal fade" id="forceDelete/{{ $post->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <form action="{{ route("posts.forceDelete", $post->id) }}" method="post" class="d-inline">
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
