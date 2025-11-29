<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    $query = BlogCategory::query();

    if ($request->filled('keyword')) {
        $query->where('name', 'like', '%' . $request->keyword . '%');
    }

    $blogCategories = $query->orderBy('id', 'desc')->get();

    return view('admin.blogCategory.index', compact('blogCategories'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_categories,slug',
        ]);
        BlogCategory::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);
        return redirect()->route('blog_category.index')->with('success', 'Thêm thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blogCategory = BlogCategory::findOrFail($id);
        return view('admin.blogCategory.update', compact('blogCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_categories,slug,' . $id,
        ]);
        $blogCategory = BlogCategory::findOrFail($id);
        $blogCategory->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
        ]);
        return redirect()->route('blog_category.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $blogCategory = BlogCategory::findOrFail($id);
        $blogCategory->delete();
        return redirect()->route('blog_category.index')->with('success', 'Xóa thành công');
    }
}
