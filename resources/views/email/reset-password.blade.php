@php use App\Models\User; @endphp
@php
    /**
* @var User $user
 * @var string $resetLink
 */
@endphp
    <!-- resources/views/emails/reset_password_email.blade.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu Cầu Đặt Lại Mật Khẩu</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #007BFF;
            padding: 20px 0;
            text-align: center;
            color: #fff;
        }
        .content {
            background: #fff;
            padding: 20px;
            border-radius: 4px;
            margin-top: 20px;
        }
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <div>Yêu Cầu Đặt Lại Mật Khẩu</div>
    </header>
    <div class="content">
        <p>Xin chào, {{$user->name}}</p>
        <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Để đặt lại mật khẩu, vui lòng nhấn vào liên kết bên dưới:</p>
        <p><a href="{{ $resetLink }}">Đặt Lại Mật Khẩu</a></p>
        <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.</p>
    </div>
</div>
<footer>
    &copy; {{ date('Y') }} BSM. Bảo lưu mọi quyền.
</footer>
</body>
</html>

