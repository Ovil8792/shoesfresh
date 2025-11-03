<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        return view('admin.orders.list');
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified order.
     */
    public function show(string $id)
    {
        return view('admin.orders.show', compact('id'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(string $id)
    {
        return view('admin.orders.edit', compact('id'));
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified order.
     */
    public function destroy(string $id)
    {
        return view('admin.orders.delete', compact('id'));
    }
}

