<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        return view('admin.sizes.list');
    }

    public function create()
    {
        return view('admin.sizes.create');
    }

    public function store(Request $request)
    {
        // handle create
    }

    public function show(string $id)
    {
        return view('admin.sizes.show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.sizes.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // handle update
    }

    public function destroy(string $id)
    {
        return view('admin.sizes.delete', compact('id'));
    }
}


