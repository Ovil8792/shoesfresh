<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        if ($keyword) {
        $comments = Comment::where('name', 'like', '%' . $keyword . '%')->get();
        } else {
        $comments = Comment::all();
        }
        return view('admin.comment.index', compact('comments', 'keyword'));
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
    }

    /**
     * Display the specified resource.
     */
    public function show(comment $comment, string $id)
    {
        // cái này
        $comment = Comment::find($id);
        return view('admin.comment.detail', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comment = Comment::find($id);
        return view('admin.comment.update', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Comment $comment, Request $request, string $id)
    {
        Comment::find($id)->update([
           'status' => $request->status,
        ]);
        return redirect()->route('comment.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        Comment::destroy($id);
        return redirect()->route('comment.index');
    }
}
