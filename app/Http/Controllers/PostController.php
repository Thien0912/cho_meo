<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }
        $posts = Post::all(); // Lấy tất cả bài đăng
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create'); // Trả về view tạo bài đăng mới
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        // Lưu bài đăng mới
        Post::create($validated);

        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post')); // Xem chi tiết bài đăng
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post')); // Form chỉnh sửa bài đăng
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        // Cập nhật bài đăng
        $post->update($validated);

        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete(); // Xóa bài đăng

        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post deleted successfully.');
    }
}
