<p>Xin chào {{ $user->name ?? $user->email }},</p>
<p>Mã OTP đặt lại mật khẩu của bạn là: <b>{{ $otp }}</b></p>
<p>Mã này có hiệu lực trong 10 phút.</p>
<p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>