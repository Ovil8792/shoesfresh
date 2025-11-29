<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Size;
use App\Models\Brand;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('images', 'category');

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $products = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.product.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        $brands = Brand::all();
        return view('admin.product.create', compact('categories', 'sizes', 'colors', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // upload image
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products/'), $imageName);
                $imagePath = 'uploads/products/' . $imageName;
            }

            // Kiểm tra biến thể
            $hasValidVariant = false;
            if ($request->has('variants')) {
                foreach ($request->variants as $variant) {
                    if (!empty($variant['size_id']) && !empty($variant['color_id'])) {
                        $hasValidVariant = true;
                        break;
                    }
                }
            }
            if (!$hasValidVariant) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Bạn phải thêm ít nhất một biến thể sản phẩm!');
            }

            // Thêm mới sản phẩm
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;

            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            $product = Product::create([
                'name'        => $request->name,
                'category_id' => $request->category_id,
                'brand_id'    => $request->brand_id,
                'slug'        => $slug,
                'price'       => $request->price,
                'description' => $request->description,
                'status'      => $request->status,
                'thumbnail'   => $imagePath,
            ]);

            // Thêm vào bảng product_images
            if ($imagePath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => $imagePath,
                ]);
            }
            // Thêm biến thể sản phẩm
            foreach ($request->variants as $variant) {
                if (empty($variant['size_id']) || empty($variant['color_id']))
                    continue;
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size_id' => $variant['size_id'],
                    'color_id' => $variant['color_id'],
                    'price' => $variant['price'],
                    'stock' => $variant['stock'],
                    'sku' => 'SP' . $product->id . $variant['size_id'] . $variant['color_id'],
                ]);
            }
            DB::commit();
            return redirect()->route('product.index')->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Đã xảy ra lỗi!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $variant = ProductVariant::where('product_id', $id)->first();
        return view('admin.product.detail', compact('product', 'variant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $brands = Brand::all();
        $sizes = Size::all();
        $colors = Color::all();
        return view('admin.product.update', compact('product', 'categories', 'brands', 'sizes', 'colors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $imagePath = $product->thumbnail;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('uploads/products/'), $imageName);
                $imagePath = 'uploads/products/' . $imageName;
                // Xóa ảnh cũ nếu có
                if ($product->thumbnail && file_exists(public_path($product->thumbnail))) {
                    unlink(public_path($product->thumbnail));
                }
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => $imagePath,
                ]);
            }
            // Thêm sản phẩm
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;

            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            // Cập nhật thông tin sản phẩm
            $product->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'slug' => $slug,
                'price' => $request->price,
                'description' => $request->description,
                'status' => $request->status,
                'thumbnail' => $imagePath,
            ]);
            // Cập nhật biến thể sản phẩm
            if ($request->has('variants')) {
                $inputVariants = collect($request->variants)->unique(function ($item) {
                    return $item['size_id'] . '-' . $item['color_id'];
                });
                $oldVariants = ProductVariant::where('product_id', $product->id)->get();

                // Lưu lại các id biến thể đã xử lý
                $variantIds = [];

                foreach ($inputVariants as $variant) {
                    if (empty($variant['size_id']) || empty($variant['color_id']))
                        continue;

                    // Tìm biến thể cũ theo size_id và color_id
                    $old = $oldVariants->first(function ($item) use ($variant) {
                        return $item->size_id == $variant['size_id'] && $item->color_id == $variant['color_id'];
                    });

                    if ($old) {
                        // Cập nhật nếu đã có
                        $old->update([
                            'price' => $variant['price'],
                            'stock' => $variant['stock'],
                        ]);
                        $variantIds[] = $old->id;
                    } else {
                        // Thêm mới nếu chưa có
                        $new = ProductVariant::create([
                            'product_id' => $product->id,
                            'size_id' => $variant['size_id'],
                            'color_id' => $variant['color_id'],
                            'price' => $variant['price'],
                            'stock' => $variant['stock'],
                            'sku' => 'SP' . $product->id . $variant['size_id'] . $variant['color_id'],
                        ]);
                        $variantIds[] = $new->id;
                    }
                }

                // Xóa các biến thể không còn trong request
                if (!empty($variantIds)) {
                    ProductVariant::where('product_id', $product->id)
                        ->whereNotIn('id', $variantIds)
                        ->delete();
                } else {
                    // Nếu không có biến thể nào gửi lên, xóa hết biến thể cũ
                    ProductVariant::where('product_id', $product->id)->delete();
                }
            }

            DB::commit();
            return redirect()->route('product.index')->with('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            // Xóa ảnh đại diện
            if ($product->thumbnail && file_exists(public_path($product->thumbnail))) {
                unlink(public_path($product->thumbnail));
            }
            // Xóa ảnh phụ
            foreach ($product->images as $img) {
                if ($img->image && file_exists(public_path($img->image))) {
                    unlink(public_path($img->image));
                }
                $img->delete();
            }
            // Xóa biến thể
            ProductVariant::where('product_id', $product->id)->delete();
            // Xóa sản phẩm
            $product->delete();
            return redirect()->route('product.index')->with('success', 'Xóa sản phẩm thành công');
        }
        return redirect()->route('product.index')->with('error', 'Sản phẩm không tồn tại');
    }
}
