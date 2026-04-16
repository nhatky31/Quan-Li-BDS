<!DOCTYPE html>
<html>
<head>
    <title>Cập nhật khách hàng</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #f3f4f6;
            font-family: Arial;
        }

        .modal {
            width: 450px;
            margin: 60px auto;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .modal-header {
            padding: 18px 22px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }

        .modal-body {
            padding: 20px 22px;
        }

        .modal-body label {
            display: block;
            margin-top: 14px;
            font-weight: 500;
        }

        .modal-body input,
        .modal-body select {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
        }

        .modal-footer {
            padding: 18px 22px;
            display: flex;
            justify-content: space-between;
        }

        .btn-cancel {
            background: #f1f1f1;
            padding: 12px 28px;
            border-radius: 10px;
            border: none;
        }

        .btn-submit {
            background: linear-gradient(to right, #e0b400, #f5d142);
            padding: 12px 28px;
            border-radius: 10px;
            border: none;
            font-weight: bold;
        }

        .close {
            text-decoration: none;
            font-size: 20px;
            color: #888;
        }
    </style>
</head>

<body>

<form action="/admin/khachhang/update/{{ $data->khid }}" method="POST">
    @csrf

    <div class="modal">

        <!-- HEADER -->
        <div class="modal-header">
            <h2>Cập nhật khách hàng</h2>
            <a href="/admin/khachhang" class="close">×</a>
        </div>

        <!-- BODY -->
        <div class="modal-body">

            <label>Họ tên *</label>
            <input type="text" name="hoten" value="{{ $data->hoten }}">

            <label>Email *</label>
            <input type="email" name="email" value="{{ $data->email }}">

            <label>Số điện thoại *</label>
            <input type="text" name="sodienthoai" value="{{ $data->sodienthoai }}">

            <label>Địa chỉ *</label>
            <input type="text" name="diachi" value="{{ $data->diachi }}">

            <label>Loại khách hàng *</label>
            <select name="loaikh">
                <option value="1" {{ $data->loaikh == 1 ? 'selected' : '' }}>Người mua</option>
                <option value="0" {{ $data->loaikh == 0 ? 'selected' : '' }}>Người bán</option>
            </select>

        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <a href="/admin/khachhang">
                <button type="button" class="btn-cancel">Hủy</button>
            </a>

            <button type="submit" class="btn-submit">Cập nhật</button>
        </div>

    </div>

</form>

</body>
</html>