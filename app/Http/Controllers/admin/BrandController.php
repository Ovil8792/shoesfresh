<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return view('admin.brands.list');
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        // handle create
    }

    public function show(string $id)
    {
        return view('admin.brands.show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.brands.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // handle update
    }

    public function destroy(string $id)
    {
        return view('admin.brands.delete', compact('id'));
    }
}


