<?php 
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Size::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $sizes = $query->orderBy('id', 'desc')->get();

        return view('admin.variant.size.index', compact('sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric|unique:sizes,value',
        ]);

        Size::create([
            'value' => $request->value,
        ]);

        return redirect()->route('product.size.index')->with('success', 'Thêm thành công');
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();
        return redirect()->route('product.size.index')->with('success', 'Xóa thành công');
    }
}