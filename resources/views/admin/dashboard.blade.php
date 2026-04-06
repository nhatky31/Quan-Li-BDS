<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị STU</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f4f7f6;
            margin: 0;
            padding: 40px;
        }
        .dashboard-container {
            background-color: #ffffff;
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-top: 0;
        }
        .welcome-text {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }
        .highlight {
            color: #0056b3;
            font-weight: bold;
        }
        .btn-logout {
            display: inline-block;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
        }
        .btn-logout:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h1>Chào mừng đến với hệ thống Quản Trị Bất Động Sản!</h1>
        <p class="welcome-text">
            Xin chào nhân viên: <span class="highlight">{{ Session::get('tennv') }}</span>
        </p>
        
        <a href="/logout" class="btn-logout">Đăng xuất</a>
    </div>

</body>
</html>