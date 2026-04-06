<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hợp Đồng Ký Gửi</title>
    <style>
        /* dùng font DejaVu Sans để không bị lỗi tiếng Việt */
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .content {
            margin-top: 20px;
        }
        .row {
            margin-bottom: 10px;
        }
        .bold {
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            width: 100%;
        }
        .signature {
            width: 50%;
            float: left;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <h3>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h3>
        <h4>Độc lập - Tự do - Hạnh phúc</h4>
        <hr style="width: 30%;">
        <br>
        <div class="title">HỢP ĐỒNG KÝ GỬI BẤT ĐỘNG SẢN</div>
        <div>Mã Hợp Đồng: {{ $ma_hd }}</div>
    </div>

    <div class="content">
        <p>Hôm nay, ngày {{ $ngay_lap }}, chúng tôi gồm có:</p>
        
        <div class="row">
            <span class="bold">BÊN KÝ GỬI (BÊN A):</span> {{ $khach_hang }}
        </div>
        <div class="row">
            <span class="bold">BÊN NHẬN KÝ GỬI (BÊN B):</span> CÔNG TY BẤT ĐỘNG SẢN STU
        </div>

        <p class="bold">Hai bên thỏa thuận ký kết hợp đồng với các điều khoản sau:</p>
        <div class="row">
            - Tài sản ký gửi: {{ $bds }}
        </div>
        <div class="row">
            - Giá trị thỏa thuận: {{ $gia_tri }}
        </div>
        <p>Bên B có trách nhiệm tìm kiếm khách hàng và thực hiện các thủ tục giao dịch cho Bên A theo đúng quy định của pháp luật.</p>
    </div>

    <div class="footer">
        <div class="signature">
            ĐẠI DIỆN BÊN A<br>
            <span style="font-weight: normal; font-style: italic;">(Ký và ghi rõ họ tên)</span>
        </div>
        <div class="signature">
            ĐẠI DIỆN BÊN B<br>
            <span style="font-weight: normal; font-style: italic;">(Ký và ghi rõ họ tên)</span>
        </div>
    </div>

</body>
</html>