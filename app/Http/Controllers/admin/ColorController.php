<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        return view('admin.colors.list');
    }

    public function create()
    {
        return view('admin.colors.create');
    }

    public function store(Request $request)
    {
        // handle create
    }

    public function show(string $id)
    {
        return view('admin.colors.show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.colors.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // handle update
    }

    public function destroy(string $id)
    {
        return view('admin.colors.delete', compact('id'));
    }
}


