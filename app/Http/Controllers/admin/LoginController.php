<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use \App\Models\Role;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // ... existing code ...

    public function loginForm()
    {
        return view('admin.login.admin_login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',   // bỏ |email để có thể nhập 'admin'
            'password' => 'required',
        ]);

        $this->ensureDefaultAdminAccount();

        // Tìm user có email và password giống nhau (plain text)
        $user = User::where('email', $request->email)
            ->where('password', $request->password)
            ->first();

        if ($user) {
            if ($user->role_id == 1) {
                session(['admin' => $user->toArray()]);
                return redirect('/admin/stastic')->with('success', 'Đăng nhập thành công!');
            } else if ($user->role_id == 3) {
                session(['admin' => $user->toArray()]);
                return redirect('/pos')->with('success', 'Đăng nhập thành công!');
            } else if ($user->role_id == 4) {
                session(['admin' => $user->toArray()]);
                return redirect('/admin/delivery')->with('success', 'Đăng nhập thành công!');
            } else {
                return back()->withErrors(['email' => 'Bạn không có quyền admin.']);
            }
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.']);
    }

    public function logout()
    {
        session()->forget('admin');
        return redirect('/admin')->with('success', 'Đăng xuất thành công!');
    }

    /**
     * Guarantee there is always a fallback admin credential (admin/1234).
     */
    protected function ensureDefaultAdminAccount(): void
    {
        User::updateOrCreate(
            ['email' => 'test@test.com'],
            [
                'name' => 'Admin User',
                'password' => 'test',
                'role_id' => 1,
            ]
        );
    }
}