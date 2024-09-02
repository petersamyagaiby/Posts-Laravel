<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth:sanctum")->except("index", "show");
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::all();
        return PostResource::collection($post);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post_validator = Validator::make(
            $request->all(),
            [
                "title" => [
                    "required",
                    "min:3",
                    "max:255",
                    Rule::unique("posts", "title"),
                ],
                "description" => [
                    "required",
                    "min:10",
                    "max:255",
                ],
                "image" => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]
        );

        if ($post_validator->fails()) {
            // return "error";
            return response()->json(
                [
                    "message" => "Validation error",
                    "errors" => $post_validator->errors()
                ],
                422
            );
        }

        $data = $request->all();
        $userId = Auth::id();
        if (Post::where("user_id", $userId)->count() >= 3) {
            return response()->json(["message" => "Cannot create more than 3 posts"], 422);
        }
        $image_path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_path = $image->store("posts", 'posts_images');
            $data['image'] = $image_path;
        }

        $post = Post::create($data);
        $slug = $post->slug;

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post_validator = Validator::make(
            $request->all(),
            [
                "title" => [
                    "required",
                    "min:3",
                    "max:255",
                    Rule::unique("posts", "title")->ignore($post),
                ],
                "description" => [
                    "required",
                    "min:10",
                    "max:255",
                ],
                "image" => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]
        );

        if ($post_validator->fails()) {
            return response()->json(
                [
                    "message" => "Validation error",
                    "errors" => $post_validator->errors()
                ],
                422
            );
        }

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

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $filePath = $post->image;
        if ($filePath) {
            if (Storage::disk("posts_images")->exists($filePath))
                Storage::disk('posts_images')->delete($post->image);
        }
        $post->delete();
        return response()->json(["deleted" => "Deleted Successfully"], 204);
    }
}
