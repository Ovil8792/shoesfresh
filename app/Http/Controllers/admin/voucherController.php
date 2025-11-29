<?php
Namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = Voucher::query();

        if ($request->filled('keyword')) {
            $query->where('code', 'like', '%' . $request->keyword . '%');
        }

        $vouchers = $query->orderBy('id', 'desc')->paginate(10);
        return view('admin.voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.voucher.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:vouchers,code',
            'description' => 'nullable|string|max:255',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
        ], [
            'valid_to.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu!',
            'code.unique' => 'Mã voucher đã tồn tại, vui lòng nhập mã khác.',
        ]);
        Voucher::create([
                'code' => $request->code,
                'description' => $request->description,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'max_discount' => $request->max_discount,
                'min_order_value' => $request->min_order_value,
                'usage_limit' => $request->usage_limit,
                'used_count' => $request->used_count ?? 0,
                'valid_from' => $request->valid_from,
                'valid_to' => $request->valid_to,
            ]);
        return redirect()->route('voucher.index')->with('success', 'Thêm thành công.');
    }

    public function destroy($id)
    {
        Voucher::destroy($id);
        return redirect()->route('voucher.index')->with('success', 'Xoá thành công.');
    }
    public function show($id)
    {
        $voucher = voucher::findOrFail($id);
        return view('admin.voucher.show', compact('voucher'));
    }
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.voucher.update', compact('voucher'));
    }
    public function update(Request $request, string $id)
    {
        $voucher = Voucher::findOrFail($id);
        $request->validate([
            'code' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
        ], [
            'valid_to.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu!',
            'code.unique' => 'Mã voucher đã tồn tại, vui lòng nhập mã khác.',
        ]);
        $voucher->update([
            'code' => $request->code,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'max_discount' => $request->max_discount,
            'min_order_value' => $request->min_order_value,
            'usage_limit' => $request->usage_limit,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
        ]);
        return redirect()->route('voucher.index')->with('success', 'Cập nhật thành công.');
    }
}
?>
