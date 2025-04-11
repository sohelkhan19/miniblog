<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($id)
    {
        $post = BlogPost::findOrFail($id);
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to like a post.');
        }

        $existing = Like::where('blog_post_id', $post->id)
                        ->where('user_id', $user->id)
                        ->first();

        if ($existing) {
            $existing->delete(); // unlike
        } else {
            Like::create([
                'user_id' => $user->id,
                'blog_post_id' => $post->id
            ]);
        }

        return back();
    }
}
