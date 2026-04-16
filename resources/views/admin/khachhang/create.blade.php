<!DOCTYPE html>
<html>
<head>
    <title>Thêm khách hàng</title>

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

        /* HEADER */
        .modal-header {
            padding: 18px 22px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            font-size: 20px;
            margin: 0;
        }

        .close {
            font-size: 20px;
            text-decoration: none;
            color: #888;
        }

        /* BODY */
        .modal-body {
            padding: 20px 22px;
        }

        .modal-body label {
            display: block;
            margin-top: 14px;
            font-weight: 500;
            color: #333;
        }

        .modal-body input,
        .modal-body select {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            outline: none;
            font-size: 14px;
        }

        .modal-body input:focus,
        .modal-body select:focus {
            border-color: #e0b400;
        }

        /* FOOTER */
        .modal-footer {
            padding: 18px 22px;
            display: flex;
            justify-content: space-between;
        }

        /* BUTTON */
        .btn-cancel {
            background: #f1f1f1;
            border: none;
            padding: 12px 28px;
            border-radius: 10px;
            color: #555;
        }

        .btn-submit {
            background: linear-gradient(to right, #e0b400, #f5d142);
            border: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: bold;
            color: black;
        }
    </style>
</head>

<body>

<form action="/admin/khachhang/store" method="POST">
    @csrf

    <div class="modal">

        <!-- HEADER -->
        <div class="modal-header">
            <h2>Thêm khách hàng mới</h2>
            <a href="/admin/khachhang" class="close">×</a>
        </div>

        <!-- BODY -->
        <div class="modal-body">

            <label>Họ tên *</label>
            <input type="text" name="hoten">

            <label>Email *</label>
            <input type="email" name="email">

            <label>Số điện thoại *</label>
            <input type="text" name="sodienthoai">

            <label>Địa chỉ *</label>
            <input type="text" name="diachi">

            <label>Loại khách hàng *</label>
            <select name="loaikh">
                <option value="1">Người mua</option>
                <option value="0">Người bán</option>
            </select>

        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <a href="/admin/khachhang">
                <button type="button" class="btn-cancel">Hủy</button>
            </a>

            <button type="submit" class="btn-submit">Thêm mới</button>
        </div>

    </div>
</form>

</body>
</html>