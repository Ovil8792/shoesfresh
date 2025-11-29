<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendOtpMail;

class ForgotPasswordController extends Controller
{
    //
    public function showForm()
    {
        return view('client.account.forgot-password');
    }

public function handleForm(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->with('error', 'Email không tồn tại trong hệ thống.');
    }

    $otp = rand(100000, 999999);
    $user->reset_otp = $otp;
    $user->otp_expires_at = now()->addMinutes(10);
    $user->save();

    // Gửi mail OTP (tạo mới SendOtpMail)
    Mail::to($user->email)->send(new SendOtpMail($user, $otp));

    return redirect()->route('client.account.verify-otp-form')
        ->with('success', 'Mã OTP đã được gửi đến email của bạn.');
}
public function showOtpForm()
{
    return view('client.account.verify-otp');
}

public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required|digits:6'
    ]);

    $user = User::where('email', $request->email)
        ->where('reset_otp', $request->otp)
        ->where('otp_expires_at', '>', now())
        ->first();

    if (!$user) {
        return back()->with('error', 'OTP không đúng hoặc đã hết hạn.');
    }

    // Cho phép đặt lại mật khẩu mới
    return redirect()->route('client.account.reset-password-form', ['email' => $request->email]);
}
public function showResetPasswordForm(Request $request)
{
    $email = $request->query('email');
    return view('client.account.reset-password', compact('email'));
}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed'
    ]);

    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return back()->with('error', 'Không tìm thấy người dùng.');
    }

    $user->password = $request->password;
    $user->reset_otp = null;
    $user->otp_expires_at = null;
    $user->save();

    return redirect()->route('user.login')->with('success', 'Đặt lại mật khẩu thành công.');
}
}
