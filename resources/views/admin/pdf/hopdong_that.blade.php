<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 14px; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; }
        .title { font-size: 20px; font-weight: bold; margin-bottom: 10px; }
        .content { margin-top: 20px; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
        <div>Độc lập - Tự do - Hạnh phúc</div>
        <br>
        <div class="title">HỢP ĐỒNG CHUYỂN NHƯỢNG BẤT ĐỘNG SẢN</div>
        <div>Mã Hợp Đồng: HD-CN-{{ $hopdong->cnid }}</div>
    </div>

    <div class="content">
        <p>Hôm nay, ngày {{ \Carbon\Carbon::parse($hopdong->ngaylap)->format('d/m/Y') }}, tại văn phòng Công ty Bất động sản STU, chúng tôi gồm có:</p>
        
        <p><span class="bold">BÊN CHUYỂN NHƯỢNG (BÊN BÁN):</span> CÔNG TY BẤT ĐỘNG SẢN STU</p>
        <p>- Đại diện: Nguyễn Văn A (Giám đốc)</p>

        <p><span class="bold">BÊN NHẬN CHUYỂN NHƯỢNG (BÊN MUA):</span> {{ $hopdong->hoten }}</p>
        <p>- Số CMND/CCCD: {{ $hopdong->cmnd }}</p>
        <p>- Địa chỉ: {{ $hopdong->diachi_kh }}</p>

        <br>
        <p><span class="bold">ĐIỀU 1: ĐỐI TƯỢNG HỢP ĐỒNG</span></p>
        <p>Bên Bán đồng ý chuyển nhượng và Bên Mua đồng ý nhận chuyển nhượng bất động sản với thông tin như sau:</p>
        <p>- Vị trí: {{ $hopdong->tenduong }}, {{ $hopdong->quan }}</p>
        <p>- Diện tích: {{ $hopdong->dientich }} m2</p>
        <p>- Giấy chứng nhận QSDĐ số: {{ $hopdong->masoqsdd ?? '..............................' }}</p>

        <p><span class="bold">ĐIỀU 2: GIÁ TRỊ CHUYỂN NHƯỢNG VÀ PHƯƠNG THỨC THANH TOÁN</span></p>
        <p>- Tổng giá trị chuyển nhượng: <span class="bold" style="color: red;">{{ number_format($hopdong->giatri) }} VNĐ</span></p>
        <p>- Hai bên thỏa thuận thanh toán và tiến hành các thủ tục pháp lý theo quy định của pháp luật.</p>

        <br>
        <table style="width: 100%; text-align: center; margin-top: 30px;">
            <tr>
                <td style="width: 50%;"><span class="bold">ĐẠI DIỆN BÊN MUA</span><br>(Ký, ghi rõ họ tên)</td>
                <td style="width: 50%;"><span class="bold">ĐẠI DIỆN BÊN BÁN</span><br>(Ký, ghi rõ họ tên, đóng dấu)</td>
            </tr>
        </table>
    </div>
</body>
</html>