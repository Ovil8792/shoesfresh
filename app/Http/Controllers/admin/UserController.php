<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        return view('admin.users.list');
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified user.
     */
    public function show(string $id)
    {
        return view('admin.users.show', compact('id'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(string $id)
    {
        return view('admin.users.edit', compact('id'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified user.
     */
    public function destroy(string $id)
    {
        return view('admin.users.delete', compact('id'));
    }
}

