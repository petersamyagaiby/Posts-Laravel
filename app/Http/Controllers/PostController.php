<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth")->except("index", "show");
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trashedPosts = Post::onlyTrashed()->get();
        $posts = Post::paginate(10);
        return view("posts.index", compact("posts", "trashedPosts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $posts = Post::all()->where("user_id", Auth::id());
        // if (count($posts) >= 3)
        //     return redirect()->route("posts.index")->with("numPosts", "You can't create more than 3 posts");

        $users = User::all();
        return view("posts.create", compact("users"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InsertRequest $request)
    {
        $request->validate(
            [
                'user_id' => [
                    Rule::prohibitedIf(function () {
                        $userPosts = Post::all()->where("user_id", Auth::id());
                        return count($userPosts) >= 3;
                    })
                ],
            ],
            [
                'user_id.prohibited' => 'Cannot create more than 3 posts',
            ],
        );
        $data = $request->all();
        $image_path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_path = $image->store("posts", 'posts_images');
            $data['image'] = $image_path;
        }

        $post = Post::create($data);
        $slug = $post->slug;

        return redirect()->route("posts.index");
    }

    /**
     * Display the specified resource.
     */
    // public function show(Post $post)
    public function show(string $slug)
    {
        $post = Post::whereSlug($slug)->firstOrFail();
        return view("posts.post_details", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Post $post)
    public function edit(string $slug)
    {
        $post = Post::whereSlug($slug)->firstOrFail();
        if (!Gate::allows("update-post", $post))
            return redirect()->route("posts.index")->with("updatedPost", "You can't update this post because you aren't the post creator");

        $users = User::all();
        return view("posts.edit", compact("post", "users"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Post $post)
    {
        if (!Gate::allows("update-post", $post))
            return redirect()->route("posts.index")->with("updatedPost", "You can't update this post because you aren't the post creator");

        $data = $request->all();
        if ($request->hasFile('image')) {
            $filePath = $post->image;
            if ($filePath) {
                if (Storage::disk("posts_images")->exists($filePath))
                    Storage::disk('posts_images')->delete($post->image);
            }
            $image = $request->file('image');
            $image_path = $image->store("posts", 'posts_images');
            $data['image'] = $image_path;
        }

        $post->update($data);
        $postSlug = $post->slug;
        return redirect()->route("posts.show", compact("postSlug"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (!Gate::allows("delete-post", $post))
            return redirect()->route("posts.index")->with("deletedPost", "You can't delete this post because you aren't the post creator");

        $post->delete();
        return redirect()->route("posts.index");
    }

    public function trashed()
    {
        $posts = Post::onlyTrashed()->where("user_id", Auth::id())->paginate(10);
        return view("posts.trashed", compact("posts"));
    }

    public function restore(string $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        if (!Gate::allows("delete-post", $post))
            return redirect()->route("posts.index")->with("deletedPost", "You can't delete this post because you aren't the post creator");

        $post->restore();
        if (Post::onlyTrashed()->count() > 0)
            return redirect()->route("posts.trashed");
        else
            return redirect()->route("posts.index");
    }

    public function forceDelete(string $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        if (!Gate::allows("delete-post", $post))
            return redirect()->route("posts.index")->with("deletedPost", "You can't delete this post because you aren't the post creator");

        $filePath = $post->image;
        if ($filePath) {
            if (Storage::disk("posts_images")->exists($filePath))
                Storage::disk('posts_images')->delete($post->image);
        }
        $post->forceDelete();
        if (Post::onlyTrashed()->count() > 0)
            return redirect()->route("posts.trashed");
        else
            return redirect()->route("posts.index");
    }
}
