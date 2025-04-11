<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BlogPost;
use App\Models\Category;


class BlogPostController extends Controller
{
    // Show all blog posts
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = BlogPost::with('category', 'likes', 'comments');

        // Check if category filter is applied
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $posts = $query->withCount('likes', 'comments')->latest()->paginate(10);



        return view('blog.index', compact('posts', 'categories'));
    }


    // Show create post form
    public function create()
    {
        $categories = Category::all();
        return view('blog.create', compact('categories'));
    }

    // Store new blog post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'category_id' => 'required|exists:categories,id',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog_images', 'public');
        }

        BlogPost::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'image' => $imagePath ?? null,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    // View single blog post
    public function show(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        $backUrl = $request->query('back_url', route('home')); // fallback to home if not passed

        return view('blog.show', compact('post', 'backUrl'));
    }


    // Show edit form
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $categories = Category::all();
        $previousUrl = url()->previous();
        return view('blog.edit', compact('post', 'categories', 'previousUrl'));
    }

    // Update the blog post
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:10'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog_images', 'public');
        }

        $post = BlogPost::findOrFail($id);
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'image' => $imagePath ?? $post->image
        ]);

        return redirect()->route('blog.myPosts')->with('success', 'Post updated successfully!');
    }

    // Delete the blog post
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();

        return redirect()->route('blog.myPosts')->with('success', 'Post deleted successfully!');
    }

    public function myPosts()
    {
        $posts = BlogPost::where('user_id', Auth::id())->with('category')->latest()->paginate(10);
        return view('blog.my_posts', compact('posts'));
    }
}
