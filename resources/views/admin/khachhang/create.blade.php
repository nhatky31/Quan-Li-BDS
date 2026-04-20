<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Khách Hàng Mới</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #f4f7f6; padding: 30px; margin: 0; }
        .container { background: #fff; padding: 30px; border-radius: 8px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-top: 0; border-bottom: 2px solid #0056b3; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        /* Đã đổi type number thành text để giữ số 0 ở đầu */
        input[type="text"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-submit { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; width: 100%; font-size: 16px; margin-top: 10px;}
        .btn-back { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #0056b3; font-weight: bold; }
        /* CSS cho dòng báo lỗi màu đỏ */
        .error-message { color: red; font-size: 13px; margin-top: 5px; display: block; font-style: italic; }
        .input-error { border: 1px solid red !important; background-color: #ffe6e6; }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/khachhang" class="btn-back">⬅ Quay lại danh sách</a>
        <h2>Thêm Khách Hàng Mới</h2>

        <form action="/admin/khachhang/store" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Họ và tên khách hàng (*)</label>
                <input type="text" name="hoten" value="{{ old('hoten') }}" class="@error('hoten') input-error @enderror" required>
                @error('hoten') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Số điện thoại (*)</label>
                <input type="text" name="sodienthoai" value="{{ old('sodienthoai') }}" pattern="[0-9]*" class="@error('sodienthoai') input-error @enderror" required>
                @error('sodienthoai') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Số CMND/CCCD</label>
                <input type="text" name="cmnd" value="{{ old('cmnd') }}" pattern="[0-9]*" class="@error('cmnd') input-error @enderror">
                @error('cmnd') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Địa chỉ liên hệ</label>
                <input type="text" name="diachi" value="{{ old('diachi') }}">
            </div>

            <button type="submit" class="btn-submit">Lưu Khách Hàng</button>
        </form>
    </div>
</body>
</html>