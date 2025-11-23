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
     * Display products by category slug.
     */
    public function productsByCategory(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $prod = Product::where('product_id', $category->id)->get();

        return view('client.product.list', [
            'prod' => $prod,
            'categoryFilter' => $category,
        ]);
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
        
        $product = Product::with('category')->findOrFail($id);
        $product["category_name"] = optional($product->category)->name;
    
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
