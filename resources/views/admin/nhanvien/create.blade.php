<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Nhân Viên Mới</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #f4f7f6; padding: 30px; margin: 0; }
        .container { background: #fff; padding: 30px; border-radius: 8px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-top: 0; border-bottom: 2px solid #0056b3; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input[type="text"], input[type="password"], input[type="number"], select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-submit { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; width: 100%; font-size: 16px; margin-top: 10px;}
        .btn-submit:hover { background: #218838; }
        .btn-back { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #0056b3; font-weight: bold; }
    </style>
</head>
<body>

    <div class="container">
        <a href="/admin/nhanvien" class="btn-back">⬅ Quay lại danh sách</a>
        <h2>Thêm Nhân Viên Mới</h2>

        <form action="/admin/nhanvien/store" method="POST">
            @csrf <div class="form-group">
                <label>Họ và tên nhân viên</label>
                <input type="text" name="tennv" required>
            </div>

            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="number" name="sdt" required>
            </div>

            <div class="form-group">
                <label>Tài khoản đăng nhập</label>
                <input type="text" name="taikhoan" required>
            </div>

            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="matkhau" required>
            </div>

            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label>Giới tính</label>
                    <select name="gioitinh">
                        <option value="1">Nam</option>
                        <option value="0">Nữ</option>
                    </select>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label>Phân quyền</label>
                    <select name="quyen">
                        <option value="0">Nhân viên Sales</option>
                        <option value="1">Admin Quản lý</option>
                    </select>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label>Trạng thái</label>
                    <select name="trangthai">
                        <option value="1">Đang làm việc</option>
                        <option value="0">Đã khóa</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-submit">Lưu Nhân Viên</button>
        </form>
    </div>

</body>
</html>