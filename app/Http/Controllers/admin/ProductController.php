<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Search by ID
        if ($request->has('search_id') && $request->search_id) {
            $query->where('id', $request->search_id);
        }
        
        // Search by name
        if ($request->has('search_name') && $request->search_name) {
            $query->where('name', 'like', '%' . $request->search_name . '%');
        }
        
        $products = $query->get();
        $totalProducts = Product::count();
        $avgPrice = Product::avg('price');
        
        return view('admin.products.list', compact('products', 'totalProducts', 'avgPrice'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'color' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'design' => 'nullable|string|max:255',
            // Variants
            'variants' => 'nullable|array',
            'variants.*.color' => 'nullable|string|max:255',
            'variants.*.size' => 'nullable|string|max:255',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants.*.status' => 'nullable|string|max:255',
            'variants.*.design' => 'nullable|string|max:255',
        ]);

        // Handle main product image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Create main product
        $product = Product::create([
            'name' => $validated['name'],
            'product_id' => $validated['product_id'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'brand' => $validated['brand'] ?? null,
            'image' => $validated['image'] ?? null,
            'color' => $validated['color'] ?? null,
            'size' => $validated['size'] ?? null,
            'status' => $validated['status'] ?? 'active',
            'design' => $validated['design'] ?? null,
        ]);

        // Create variants if provided
        if ($request->has('variants') && is_array($request->variants)) {
            foreach ($request->variants as $index => $variant) {
                if (!empty($variant['color']) || !empty($variant['size'])) {
                    $variantData = [
                        'name' => $validated['name'],
                        'product_id' => $validated['product_id'],
                        'price' => $variant['price'] ?? $validated['price'],
                        'description' => $validated['description'] ?? null,
                        'brand' => $validated['brand'] ?? null,
                        'color' => $variant['color'] ?? null,
                        'size' => $variant['size'] ?? null,
                        'status' => $variant['status'] ?? 'active',
                        'design' => $variant['design'] ?? null,
                    ];

                    // Handle variant image upload
                    if ($request->hasFile("variants.{$index}.image")) {
                        $variantImagePath = $request->file("variants.{$index}.image")->store('products', 'public');
                        $variantData['image'] = $variantImagePath;
                    } else {
                        $variantData['image'] = $validated['image'] ?? null;
                    }

                    Product::create($variantData);
                }
            }
        }

        return redirect()->route('admin.product')->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        // Get all variants (products with same name and category)
        $variants = Product::where('name', $product->name)
            ->where('product_id', $product->product_id)
            ->where('id', '!=', $id)
            ->get();
        
        return view('admin.products.show', compact('product', 'variants'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        // Get all variants
        $variants = Product::where('name', $product->name)
            ->where('product_id', $product->product_id)
            ->where('id', '!=', $id)
            ->get();
        
        return view('admin.products.edit', compact('product', 'categories', 'variants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'color' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'design' => 'nullable|string|max:255',
            // Variants
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:products,id',
            'variants.*.color' => 'nullable|string|max:255',
            'variants.*.size' => 'nullable|string|max:255',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants.*.status' => 'nullable|string|max:255',
            'variants.*.design' => 'nullable|string|max:255',
            'variants_to_delete' => 'nullable|array',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        } else {
            $validated['image'] = $product->image;
        }

        // Update main product
        $product->update([
            'name' => $validated['name'],
            'product_id' => $validated['product_id'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'brand' => $validated['brand'] ?? null,
            'image' => $validated['image'],
            'color' => $validated['color'] ?? null,
            'size' => $validated['size'] ?? null,
            'status' => $validated['status'] ?? 'active',
            'design' => $validated['design'] ?? null,
        ]);

        // Delete variants if requested
        if ($request->has('variants_to_delete') && is_array($request->variants_to_delete)) {
            foreach ($request->variants_to_delete as $variantId) {
                $variant = Product::find($variantId);
                if ($variant && $variant->image && Storage::disk('public')->exists($variant->image)) {
                    Storage::disk('public')->delete($variant->image);
                }
                $variant->delete();
            }
        }

        // Update existing variants or create new ones
        if ($request->has('variants') && is_array($request->variants)) {
            foreach ($request->variants as $index => $variantData) {
                if (isset($variantData['id']) && $variantData['id']) {
                    // Update existing variant
                    $variant = Product::find($variantData['id']);
                    if ($variant) {
                        $updateData = [
                            'name' => $validated['name'],
                            'product_id' => $validated['product_id'],
                            'price' => $variantData['price'] ?? $validated['price'],
                            'description' => $validated['description'] ?? null,
                            'brand' => $validated['brand'] ?? null,
                            'color' => $variantData['color'] ?? null,
                            'size' => $variantData['size'] ?? null,
                            'status' => $variantData['status'] ?? 'active',
                            'design' => $variantData['design'] ?? null,
                        ];

                        // Handle variant image upload
                        if ($request->hasFile("variants.{$index}.image")) {
                            if ($variant->image && Storage::disk('public')->exists($variant->image)) {
                                Storage::disk('public')->delete($variant->image);
                            }
                            $variantImagePath = $request->file("variants.{$index}.image")->store('products', 'public');
                            $updateData['image'] = $variantImagePath;
                        }

                        $variant->update($updateData);
                    }
                } else {
                    // Create new variant
                    if (!empty($variantData['color']) || !empty($variantData['size'])) {
                        $newVariantData = [
                            'name' => $validated['name'],
                            'product_id' => $validated['product_id'],
                            'price' => $variantData['price'] ?? $validated['price'],
                            'description' => $validated['description'] ?? null,
                            'brand' => $validated['brand'] ?? null,
                            'color' => $variantData['color'] ?? null,
                            'size' => $variantData['size'] ?? null,
                            'status' => $variantData['status'] ?? 'active',
                            'design' => $variantData['design'] ?? null,
                        ];

                        // Handle variant image upload
                        if ($request->hasFile("variants.{$index}.image")) {
                            $variantImagePath = $request->file("variants.{$index}.image")->store('products', 'public');
                            $newVariantData['image'] = $variantImagePath;
                        } else {
                            $newVariantData['image'] = $validated['image'] ?? null;
                        }

                        Product::create($newVariantData);
                    }
                }
            }
        }

        return redirect()->route('admin.product')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    /**
     * Show delete confirmation page.
     */
    public function destroy(string $id)
    {
        return view('admin.products.delete', compact('id'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        
        // Delete image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        
        return redirect()->route('admin.product')->with('success', 'Sản phẩm đã được xóa thành công!');
    }
}
