<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function home(){
        $cat = Category::get();
        return view('client.home',compact('cat'));
    }
    

    public function products(){
        $prod = Product::get();
        $cat = Category::get();
        return view('client.product.list',compact('prod','cat'));
    }
    /**
     * Display a listing of the resource.
     */
    public function cart()
    {
        return view('client.product.cart');
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
    public function productDetail($id)
    {
        
        $product = Product::findOrFail($id);
        $product["category_name"]=Category::findOrFail($product->product_id)->name;
    
        return view('client.product.product',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
