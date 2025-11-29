<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;


class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $query = Brand::query();
        if (request()->filled('keyword')) {
            $query->where('name', 'like', '%' . request()->keyword . '%');
        }
        $brands = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.brand.index', compact('brands'));
    }
    public function store(Request $request)
    {
        //
        $imagePath = null;
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('uploads/brands/'), $imageName);
            $imagePath = 'uploads/brands/' . $imageName;
        }

        Brand::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'logo' => $imagePath,
        ]);
        return redirect()->route('brand.index')->with('success', 'Thêm thành công');
    }

    public function destroy(String $id)
    {
        //
        $brand = Brand::findOrFail($id);
        // Xoá bản ghi thương hiệu
        if ($brand->products()->count() > 0) {
            return redirect()->route('brand.index')->with('error', 'Không thể xoá thương hiệu vì có sản phẩm liên kết');
        } else {
            $brand->delete();
            return redirect()->route('brand.index')->with('success', 'Xoá thành công');
        }
    }
}
