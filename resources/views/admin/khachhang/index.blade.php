<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Khách hàng</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #f4f7f6; padding: 30px; margin: 0; }
        .container { background: #fff; padding: 25px; border-radius: 8px; max-width: 1000px; margin: 0 auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        h2 { color: #333; margin: 0; }
        .nav-links a { text-decoration: none; margin-right: 15px; color: #0056b3; font-weight: bold; }
        .btn-add { background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #0056b3; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="nav-links">
                <a href="/admin/dashboard">⬅ Về Trang chủ</a>
            </div>
        </div>

        <div class="header" style="margin-top: 30px;">
            <h2>Danh sách Khách hàng</h2>
            <a href="/admin/khachhang/create" class="btn-add">+ Thêm Khách Hàng</a> 
        </div>

        <table>
            <thead>
                <tr>
                    <th>Mã KH</th>
                    <th>Tên Khách Hàng</th>
                    <th>Số điện thoại</th>
                    <th>CCCD</th>
                    <th>Địa chỉ</th>
                    <th>Tác vụ</th>
                </tr>
            </thead>
            <tbody>
              @foreach($danhsachKH as $kh)
                <tr>
                    <td>{{ $kh->khid }}</td>
                    <td><b>{{ $kh->hoten }}</b></td>
                    <td>{{ $kh->sodienthoai }}</td>
                    <td>{{ $kh->cmnd }}</td>
                    <td>{{ $kh->diachi }}</td>
                    <td class="action-links">
                        <a href="/admin/khachhang/edit/{{ $kh->khid }}" class="edit" style="color: #ffc107; font-weight: bold; text-decoration: none; margin-right: 10px;">Sửa</a>
                        
                        <a href="/admin/khachhang/delete/{{ $kh->khid }}" class="delete" style="color: #dc3545; font-weight: bold; text-decoration: none;" onclick="return confirm('Bạn có chắc chắn muốn ngừng giao dịch với khách hàng này?')">Xóa</a>
                    </td>
                </tr>
                
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>