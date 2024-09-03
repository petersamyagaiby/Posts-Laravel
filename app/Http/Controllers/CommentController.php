<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    // public function storeComment(Request $request, string $id)
    public function storeComment(Request $request, Post $post)
    {
        $data = $request->all();
        $request->validate([
            'content' => 'required|string'
        ], [
            'content.required' => 'content cannot be empty',
        ]);

        $comment = new Comment([
            'content' => $data['content'],
            'user_id' => Auth::id(),
        ]);

        $post->comments()->save($comment);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
