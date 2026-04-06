<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Nhân Viên</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #f4f7f6; padding: 30px; margin: 0; }
        .container { background: #fff; padding: 30px; border-radius: 8px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-top: 0; border-bottom: 2px solid #ffc107; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input[type="text"], input[type="password"], input[type="number"], select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-submit { background: #ffc107; color: #333; padding: 10px 20px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; width: 100%; font-size: 16px; margin-top: 10px;}
        .btn-submit:hover { background: #e0a800; }
        .btn-back { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #0056b3; font-weight: bold; }
    </style>
</head>
<body>

    <div class="container">
        <a href="/admin/nhanvien" class="btn-back">⬅ Quay lại danh sách</a>
        <h2>Sửa Thông Tin: {{ $nv->tennv }}</h2>

        <form action="/admin/nhanvien/update/{{ $nv->nvid }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Họ và tên nhân viên</label>
                <input type="text" name="tennv" value="{{ $nv->tennv }}" required>
            </div>

            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="number" name="sdt" value="{{ $nv->sdt }}" required>
            </div>

            <div class="form-group">
                <label>Tài khoản đăng nhập</label>
                <input type="text" name="taikhoan" value="{{ $nv->taikhoan }}" required>
            </div>

            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="matkhau" value="{{ $nv->matkhau }}" required>
            </div>

            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label>Giới tính</label>
                    <select name="gioitinh">
                        <option value="1" {{ $nv->gioitinh == 1 ? 'selected' : '' }}>Nam</option>
                        <option value="0" {{ $nv->gioitinh == 0 ? 'selected' : '' }}>Nữ</option>
                    </select>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label>Phân quyền</label>
                    <select name="quyen">
                        <option value="0" {{ $nv->quyen == 0 ? 'selected' : '' }}>Nhân viên Sales</option>
                        <option value="1" {{ $nv->quyen == 1 ? 'selected' : '' }}>Admin Quản lý</option>
                    </select>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label>Trạng thái</label>
                    <select name="trangthai">
                        <option value="1" {{ $nv->trangthai == 1 ? 'selected' : '' }}>Đang làm việc</option>
                        <option value="0" {{ $nv->trangthai == 0 ? 'selected' : '' }}>Đã khóa</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-submit">Cập Nhật Thay Đổi</button>
        </form>
    </div>

</body>
</html>