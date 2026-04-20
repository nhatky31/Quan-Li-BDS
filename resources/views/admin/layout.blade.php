<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Bất Động Sản</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Arial, sans-serif; }
        body { display: flex; background-color: #f4f7f6; height: 100vh; overflow: hidden; }
        
        /* ========================================== */
        /* THANH MENU BÊN TRÁI (SIDEBAR) - TONE VÀNG  */
        /* ========================================== */
        .sidebar { 
            width: 260px; 
            background-color: #FFD700; /* Nền vàng Gold sang trọng */
            display: flex; 
            flex-direction: column; 
            box-shadow: 2px 0 15px rgba(0,0,0,0.15);
            z-index: 20;
        }
        
        .sidebar h2 { 
            text-align: center; 
            padding: 25px 20px; 
            background: #1A252F; /* Xanh Navy đậm làm nền Logo */
            color: #FFD700; /* Chữ Logo màu vàng */
            margin-bottom: 0; 
            font-size: 22px; 
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-bottom: 3px solid #E5C100;
        }
        
        .sidebar a { 
            padding: 16px 25px; 
            text-decoration: none; 
            color: #1A252F; /* Chữ màu Xanh Đen */
            font-size: 15px; 
            font-weight: 600;
            border-bottom: 1px solid rgba(0,0,0,0.08); /* Kẻ phân cách mờ giữa các ô */
            border-left: 5px solid transparent; 
            transition: all 0.3s ease; 
            display: block;
        }
        
        /* Hiệu ứng Rê chuột (Hover) tuyệt đẹp */
        .sidebar a:hover { 
            background-color: #1A252F; /* Đổi nền thành Xanh Đen */
            color: #FFD700; /* Đổi chữ thành Vàng */
            padding-left: 32px; /* Thụt lề vào trong tạo cảm giác bấm */
            border-left: 5px solid #fff; /* Vạch trắng bên trái */
        }
        
        /* ========================================== */
        /* KHU VỰC NỘI DUNG CHÍNH LÀM VIỆC            */
        /* ========================================== */
        .main-content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; }
        
        /* Thanh Header ngang phía trên */
        .header { 
            background: #fff; 
            padding: 15px 30px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.05); 
            z-index: 10; 
        }
        .header .user-info { font-weight: bold; color: #333; font-size: 15px; }
        
        /* Nút Đăng xuất */
        .btn-logout { 
            background: #e74c3c; 
            color: white; 
            padding: 8px 16px; 
            text-decoration: none; 
            border-radius: 5px; 
            font-size: 14px; 
            font-weight: bold; 
            transition: 0.3s;
        }
        .btn-logout:hover { background: #c0392b; box-shadow: 0 2px 8px rgba(231, 76, 60, 0.4); }

        /* Vùng chứa các form, table... của hệ thống */
        .content-area { padding: 30px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>STU REAL ESTATE</h2>
        
        <a href="/admin/dashboard">🏠 Trang Chủ (Dashboard)</a>
        <a href="/admin/batdongsan">🏢 Quản lý Bất Động Sản</a>
        <a href="/admin/khachhang">👥 Quản lý Khách Hàng</a>
        
        @if(Session::get('quyen') == 1)
            <a href="/admin/nhanvien">💼 Quản lý Nhân Viên</a>
            <a href="/admin/baocao/doanhthu">📊 Báo cáo doanh thu</a>
        @endif
        
        <div style="height: 15px; background-color: #FFD700; border-bottom: 1px solid rgba(0,0,0,0.08);"></div>
        
        <a href="/admin/hopdongkygui">📝 HĐ Ký Gửi (Nguồn vào)</a>
        <a href="/admin/hopdongdatcoc">💰 HĐ Đặt Cọc (Giữ chỗ)</a>
        <a href="/admin/hopdongchuyennhuong">🤝 HĐ Chuyển Nhượng (Bán)</a>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="user-info">
                👋 Xin chào, <span style="color: #d32f2f;">{{ Session::get('nvid') ? 'Nhân viên ID: '.Session::get('nvid') : 'Quản trị viên' }}</span>
            </div>
            <a href="/logout" class="btn-logout">🚪 Đăng xuất</a>
        </div>

        <div class="content-area">
            @yield('content')
        </div>
    </div>

</body>
</html>