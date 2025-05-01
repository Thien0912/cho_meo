<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    public function publicIndex()
    {
        $posts = Post::all();
        return view('post', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Post::create($validated);

        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post->update($validated);

        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post deleted successfully.');
    }

    public function toggleLike(Request $request, Post $post)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Vui lòng đăng nhập để thích bài viết.'], 401);
        }

        $user = Auth::user();
        $existingLike = Like::where('user_id', $user->id)->where('post_id', $post->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $post->decrement('likes');
            $liked = false;
        } else {
            Like::create(['user_id' => $user->id, 'post_id' => $post->id]);
            $post->increment('likes');
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'likes' => $post->likes,
            'liked' => $liked,
        ], 200);
    }
}