<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|min:3'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'blog_post_id' => $postId,
            'content' => $request->content
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
