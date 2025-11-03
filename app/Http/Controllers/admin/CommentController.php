<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of comments.
     */
    public function index()
    {
        return view('admin.comments.list');
    }

    /**
     * Show the form for creating a new comment.
     */
    public function create()
    {
        return view('admin.comments.create');
    }

    /**
     * Store a newly created comment.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified comment.
     */
    public function show(string $id)
    {
        return view('admin.comments.show', compact('id'));
    }

    /**
     * Show the form for editing the specified comment.
     */
    public function edit(string $id)
    {
        return view('admin.comments.edit', compact('id'));
    }

    /**
     * Update the specified comment.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(string $id)
    {
        return view('admin.comments.delete', compact('id'));
    }
}

