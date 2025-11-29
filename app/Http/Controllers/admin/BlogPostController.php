<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogPostTag;
class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $BlogCategory = BlogCategory::all();
        $blogPosts = \App\Models\BlogPost::all();
        return view('admin.blogPost.index', compact('blogPosts', 'BlogCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $BlogCategory = BlogCategory::all();
        return view('admin.blogPost.create', compact('BlogCategory', ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if (empty($data['published_at'])) {
        $data['published_at'] = now();
    }
        BlogPost::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'thumbnail' => $request->thumbnail,
            'status' => $request->status,
            'published_at' => $data['published_at'],
            'created_at' => $data['published_at'] ?? now(),
            'updated_at' => $data['published_at'] ?? now(),
            'blog_category_id' => $request->blog_category_id,
        ]);

        return redirect()->route('blog_post.index')->with('success', 'Đăng bài thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blogPost = BlogPost::findOrFail($id);
        return view('admin.blogPost.detail', compact('blogPost', ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blogPost = BlogPost::findOrFail($id);
        $BlogCategory = BlogCategory::all();
        return view('admin.blogPost.update', compact('blogPost', 'BlogCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        if (empty($data['updated_at'])) {
        $data['updated_at'] = now();
    }
        $blogPost = BlogPost::findOrFail($id);
        $blogPost->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'thumbnail' => $request->thumbnail,
            'status' => $request->status,
            'blog_category_id' => $request->blog_category_id,
            'updated_at' => $data['updated_at'],
        ]);

        return redirect()->route('blog_post.index')->with('success', 'Cập nhật bài viết thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blogPost = BlogPost::findOrFail($id);
        $blogPost->delete();
        return redirect()->route('blog_post.index')->with('success', 'Xóa bài viết thành công.');
    }
}
