<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('client.account.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->password === $request->password) {
            session(['user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ]]);
            return redirect()->route('home.index');
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng']);
    }

    public function logout()
    {
        session()->forget('user');

        return redirect()->route('home.index');
    }
    public function showProfile()
    {
        $usersession = session('user');
        $user = User::find($usersession['id']);
        return view('client.account.profile', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        $userArr = session('user');
        $user = User::find($userArr['id']);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
        ];

        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = $request->password; // You should use bcrypt for hashing in production
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            
            // Store the new avatar
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        } elseif ($request->has('remove_avatar') && $user->avatar) {
            // Remove avatar if requested
            if (Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            $data['avatar'] = null;
        }

        $user->update($data);

        // Update session
        $userData = $user->toArray();
        if (isset($data['avatar'])) {
            $userData['avatar'] = $data['avatar'];
        }
        session(['user' => $userData]);

        return redirect()->route('user.profile.show')->with('success', 'Cập nhật thông tin thành công!');
    }
    public function editProfile()
    {
        $user = session('user');
        return view('client.account.edit', compact('user'));
    }
    public function showRegisterForm()
    {
        return view('client.account.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'birth_date' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'password' => 'required|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'password' => $request->password,
            'role_id' => 2,
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($data);

        $sessionData = $user->only(['id', 'name', 'email', 'phone', 'address', 'gender', 'birth_date']);
        if (isset($data['avatar'])) {
            $sessionData['avatar'] = $data['avatar'];
        }

        session(['user' => $sessionData]);

        return redirect()->route('home.index')->with('success', 'Đăng ký thành công!');
    }
}
