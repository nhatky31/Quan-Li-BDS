<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống STU</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .text-center {
            text-align: center;
        }
        .logo-title {
            color: #0056b3;
            margin-bottom: 5px;
            font-size: 24px;
        }
        .subtitle {
            color: #666;
            margin-top: 0;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
            font-size: 14px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #0056b3;
            outline: none;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-login:hover {
            background-color: #004494;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="text-center">
            <h2 class="logo-title">STU REAL ESTATE</h2>
            <p class="subtitle">Đăng nhập hệ thống quản lý</p>
        </div>

        <!-- Bắt lỗi đăng nhập -->
        @if(Session::has('error'))
            <div class="alert-error">
                {{ Session::get('error') }}
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf <!-- Token bảo mật bắt buộc của Laravel -->
            
            <div class="form-group">
                <label>Tài khoản</label>
                <input type="text" name="taikhoan" required placeholder="Nhập tài khoản">
            </div>
            
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="matkhau" required placeholder="Nhập mật khẩu">
            </div>
            
            <button type="submit" class="btn-login">Đăng Nhập</button>
        </form>
    </div>

</body>
</html>