<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = ProductDiscount::with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new discount.
     */
    public function create()
    {
        $products = Product::where('status', true)->get();
        return view('admin.discounts.create', compact('products'));
    }

    /**
     * Store a newly created discount in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percent' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check if there's an active discount for this product in the same period
        $existingDiscount = ProductDiscount::where('product_id', $validated['product_id'])
            ->where('is_active', true)
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhere(function($q) use ($validated) {
                          $q->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                      });
            })
            ->exists();

        if ($existingDiscount) {
            return back()->withInput()->with('error', 'Đã có chương trình giảm giá khác cho sản phẩm này trong khoảng thời gian này.');
        }

        try {
            ProductDiscount::create([
                'product_id' => $validated['product_id'],
                'discount_percent' => $validated['discount_percent'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'is_active' => true,
            ]);

            return redirect()->route('admin.discounts.index')
                ->with('success', 'Thêm chương trình giảm giá thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
        //
    }

    /**
     * Display the specified discount.
     */
    public function show(ProductDiscount $discount)
    {
        return view('admin.discounts.show', compact('discount'));
    }

    /**
     * Show the form for editing the specified discount.
     */
    public function edit(ProductDiscount $discount)
    {
        $products = Product::where('status', true)->get();
        return view('admin.discounts.edit', compact('discount', 'products'));
    }

    /**
     * Update the specified discount in storage.
     */
    public function update(Request $request, ProductDiscount $discount)
    {
        $validated = $request->validate([
            'discount_percent' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'sometimes|boolean',
        ]);

        // Check for overlapping discounts (excluding current discount)
        $existingDiscount = ProductDiscount::where('product_id', $discount->product_id)
            ->where('id', '!=', $discount->id)
            ->where('is_active', true)
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhere(function($q) use ($validated) {
                          $q->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                      });
            })
            ->exists();

        if ($existingDiscount) {
            return back()->withInput()->with('error', 'Đã có chương trình giảm giá khác cho sản phẩm này trong khoảng thời gian này.');
        }

        try {
            $discount->update($validated);
            return redirect()->route('admin.discounts.index')
                ->with('success', 'Cập nhật chương trình giảm giá thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified discount from storage.
     */
    public function destroy(ProductDiscount $discount)
    {
        try {
            $discount->delete();
            return redirect()->route('admin.discounts.index')
                ->with('success', 'Xóa chương trình giảm giá thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    
    /**
     * Toggle discount status
     */
    public function toggleStatus(ProductDiscount $discount)
    {
        try {
            $discount->update(['is_active' => !$discount->is_active]);
            $status = $discount->is_active ? 'kích hoạt' : 'vô hiệu hóa';
            return back()->with('success', "Đã $status chương trình giảm giá!");
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
