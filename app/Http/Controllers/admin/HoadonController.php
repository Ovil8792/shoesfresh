<?php

namespace App\Http\Controllers\admin;

use App\Models\Hoadon;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Trangthaihoadon;
use App\Models\Pttt;
use Illuminate\Http\Request;

class HoadonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hoadons = Hoadon::all();
        $trangthaihoadons = Trangthaihoadon::all();
        return view('admin.hoadon.hoadon', compact('hoadons', 'trangthaihoadons'));
    }

    /**
     * Show the information of a resource.
     */
    public function detail($id)
    {
        $hoadon = Hoadon::find($id);
        $trangthaihoadons = Trangthaihoadon::all();
        $phuongthucthanhtoans = Pttt::all();
        $products = Product::all();
        return view('admin.hoadon.hdct', compact('hoadon', 'trangthaihoadons', 'phuongthucthanhtoans', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $hoadon = Hoadon::findOrFail($id);

        $validated = $request->validate([
            'trangthaihoadon_id' => ['required','integer'],
            'phuongthucthanhtoan_id' => ['required','integer'],
            'sanpham_id' => ['required','integer'],
            'soluong' => ['required','integer','min:1'],
            'tongtien' => ['nullable','numeric','min:0'],
        ]);

        $hoadon->trangthaihoadon_id = $validated['trangthaihoadon_id'];
        $hoadon->phuongthucthanhtoan_id = $validated['phuongthucthanhtoan_id'];
        $hoadon->sanpham_id = $validated['sanpham_id'];
        $hoadon->soluong = $validated['soluong'];
        if (array_key_exists('tongtien', $validated)) {
            $hoadon->tongtien = $validated['tongtien'];
        }
        $hoadon->save();

        return redirect()->route('admin.hoadon.detail', $hoadon->id)
            ->with('success', 'Cập nhật hóa đơn thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hoadon = Hoadon::find($id);
        $hoadon->deleteQuietly();
        return redirect()->route('admin.hoadon')->with('success', 'Hóa đơn đã được xóa thành công');
    }
}
