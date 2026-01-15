<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index(Request $request)
    {
        $roles = Role::all();
        $query = User::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        $users = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.user.index', compact('users', 'roles'));
    }

    // Hiển thị form tạo người dùng mới
    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }

    // Lưu người dùng mới
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
            'phone'     => 'nullable|string|max:20',
            'role_id'   => 'required|exists:roles,id',
            'gender'    => 'nullable|in:male,female,other',
            'birth_date'=> 'nullable|date',
            'address'   => 'nullable|string|max:255',
            'points'    => 'nullable|integer|min:0',
            'tier'      => 'nullable|in:basic,premium',
        ], [
            'name.required' => 'Tên tài khoản không được để trống.',
            'name.max' => 'Tên tài khoản không được vượt quá 255 ký tự.',
            'email.unique' => 'Email đã tồn tại, vui lòng nhập email khác.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'role_id.required' => 'Vui lòng chọn vai trò.',
            'role_id.exists' => 'Vai trò không hợp lệ.',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'birth_date.date' => 'Ngày sinh không đúng định dạng.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'points.integer' => 'Điểm thưởng phải là số nguyên.',
            'points.min' => 'Điểm thưởng phải lớn hơn hoặc bằng 0.',
            'tier.in' => 'Cấp độ thành viên không hợp lệ.',
        ]);
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'phone'     => $request->phone,
            'gender'    => $request->gender,
            'birth_date'=> $request->birth_date,
            'address'   => $request->address,
            'points'    => $request->points ?? 0,
            'tier'      => $request->tier ?? 'basic',
            'role_id'   => $request->role_id,
        ]);

        return redirect()->route('user.index')->with('success', 'Tạo tài khoản thành công.');
    }

    // Hiển thị form chỉnh sửa người dùng
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.user.update', compact('user', 'roles'));
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:6|confirmed',
            'phone'     => 'nullable|string|max:20',
            'role_id'   => 'required|exists:roles,id',
            'gender'    => 'nullable|in:male,female,other',
            'birth_date'=> 'nullable|date',
            'address'   => 'nullable|string|max:255',
            'points'    => 'nullable|integer|min:0',
            'tier'      => 'nullable|in:basic,premium',
        ], [
            'name.required' => 'Tên tài khoản không được để trống.',
            'name.max' => 'Tên tài khoản không được vượt quá 255 ký tự.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'role_id.required' => 'Vui lòng chọn vai trò.',
            'role_id.exists' => 'Vai trò không hợp lệ.',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'birth_date.date' => 'Ngày sinh không đúng định dạng.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'points.integer' => 'Điểm thưởng phải là số nguyên.',
            'points.min' => 'Điểm thưởng phải lớn hơn hoặc bằng 0.',
            'tier.in' => 'Cấp độ thành viên không hợp lệ.',
        ]);

        $data = $request->only([
            'name', 'email', 'phone', 'gender', 'birth_date',
            'address', 'points', 'tier', 'role_id'
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'Cập nhật thành công.');
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Kiểm tra nếu là tài khoản quản trị (role_id = 1) thì không cho phép xóa
        if ($user->role_id == 1) {
            return redirect()->route('user.index')->with('error', 'Không thể xóa tài khoản có quyền quản trị.');
        }
        
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Xóa người dùng thành công.');
    }

    // Hiển thị chi tiết người dùng
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.detail', compact('user'));
    }
}
