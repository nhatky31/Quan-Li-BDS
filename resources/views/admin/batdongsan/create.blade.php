<!DOCTYPE html>
<html>
<head>
    <title>Thêm BĐS</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial;
            background: #f3f4f6;
        }

        .modal {
            width: 500px;
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
        .modal-body select,
        textarea {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
        }

        textarea {
            height: 100px;
        }

        .row {
            display: flex;
            gap: 12px;
        }

        .col {
            flex: 1;
        }

        .modal-footer {
            padding: 18px 22px;
            display: flex;
            justify-content: space-between;
        }

        .btn-cancel {
            background: #eee;
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

<form action="/admin/batdongsan/store" method="POST">
    @csrf

    <div class="modal">

        <!-- HEADER -->
        <div class="modal-header">
            <h2>Thêm bất động sản mới</h2>
            <a href="/admin/batdongsan" class="close">×</a>
        </div>

        <!-- BODY -->
        <div class="modal-body">

            <!-- TIÊU ĐỀ -->
            <label>Tiêu đề *</label>
            <input type="text" name="masoqsdd">

            <!-- LOẠI + TRẠNG THÁI -->
            <div class="row">
                <div class="col">
                    <label>Loại *</label>
                    <select name="loaiid">
                        <option value="1">Căn hộ</option>
                        <option value="2">Nhà phố</option>
                        <option value="3">Đất nền</option>
                        <option value="4">Căn phòng</option>
                    </select>
                </div>

                <div class="col">
                    <label>Trạng thái *</label>
                    <select name="tinhtrang">
                        <option value="1">Còn trống</option>
                        <option value="2">Đã ký gửi</option>
                        <option value="3">Đã đặt cọc</option>
                        <option value="4">Đã bán</option>
                    </select>
                </div>
            </div>

            <!-- ĐỊA CHỈ -->
            <label>Địa chỉ *</label>
            <input type="text" name="diachi" placeholder="Số nhà, đường, phường, quận, TP">

            <!-- DIỆN TÍCH + GIÁ -->
            <div class="row">
                <div class="col">
                    <label>Diện tích (m²) *</label>
                    <input type="number" name="dientich">
                </div>

                <div class="col">
                    <label>Giá (VNĐ) *</label>
                    <input type="number" name="dongia">
                </div>
            </div>

            <!-- MÔ TẢ -->
            <label>Mô tả</label>
            <textarea name="mota"></textarea>

        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
            <a href="/admin/batdongsan">
                <button type="button" class="btn-cancel">Hủy</button>
            </a>

            <button type="submit" class="btn-submit">Thêm mới</button>
        </div>

    </div>

</form>

</body>
</html>