<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Bất Động Sản</title>
    <style>
        body { background-color: #f4f7f6; padding: 30px; font-family: Arial; }
        .container { background: #fff; padding: 30px; border-radius: 8px; max-width: 800px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-submit { background: #28a745; color: white; padding: 10px; border: none; width: 100%; font-weight: bold; cursor: pointer;}
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/batdongsan" style="text-decoration: none; font-weight:bold;">⬅ Quay lại</a>
        <h2>Thêm Bất Động Sản Mới</h2>

        <form action="/admin/batdongsan/store" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label>Khách hàng ký gửi (*)</label>
                    <select name="khid" required>
                        <option value="">-- Chọn khách hàng --</option>
                        @foreach($danhsachKH as $kh)
                            <option value="{{ $kh->khid }}">{{ $kh->hoten }} (SĐT: {{ $kh->sodienthoai }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label>Loại BĐS (*)</label>
                    <select name="loaiid" required>
                        @foreach($danhsachLoai as $loai)
                            <option value="{{ $loai->loaiid }}">{{ $loai->tenloai }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
<div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label>Diện tích (m2)</label>
                    <input type="number" name="dientich" value="{{ old('dientich') }}" min="0" required>
                    @error('dientich') <span style="color: red; font-size: 13px;">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-group" style="flex: 1;">
                   <label>Đơn giá (VNĐ)</label>
<input type="number" name="dongia" class="form-control" required>
                    @error('dongia') <span style="color: red; font-size: 13px;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Tên đường / Vị trí</label>
                <input type="text" name="tenduong">
            </div>

            <div class="form-group">
                <label>Quận/Huyện</label>
                <input type="text" name="quan">
            </div>

            <div class="form-group">
                <label>Hình ảnh thực tế</label>
                <input type="file" name="hinhanh" accept="image/*">
            </div>

            <button type="submit" class="btn-submit">Lưu Bất Động Sản</button>
        </form>
    </div>
</body>
</html>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. HÀM ĐỌC SỐ TIỀN THÀNH CHỮ TIẾNG VIỆT ---
    const mangso = ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];
    function dochangchuc(so, daydu) {
        let chuoi = "";
        let chuc = Math.floor(so / 10);
        let donvi = so % 10;
        if (chuc > 1) {
            chuoi = " " + mangso[chuc] + " mươi";
            if (donvi == 1) chuoi += " mốt";
        } else if (chuc == 1) {
            chuoi = " mười";
            if (donvi == 1) chuoi += " một";
        } else if (daydu && donvi > 0) {
            chuoi = " lẻ";
        }
        if (donvi == 5 && chuc > 0) {
            chuoi += " lăm";
        } else if (donvi > 1 || (donvi == 1 && chuc == 0)) {
            chuoi += " " + mangso[donvi];
        }
        return chuoi;
    }
    function docblock(so, daydu) {
        let chuoi = "";
        let tram = Math.floor(so / 100);
        so = so % 100;
        if (daydu || tram > 0) {
            chuoi = " " + mangso[tram] + " trăm";
            chuoi += dochangchuc(so, true);
        } else {
            chuoi = dochangchuc(so, false);
        }
        return chuoi;
    }
    function dochangtrieu(so, daydu) {
        let chuoi = "";
        let trieu = Math.floor(so / 1000000);
        so = so % 1000000;
        if (trieu > 0) {
            chuoi = docblock(trieu, daydu) + " triệu";
            daydu = true;
        }
        let nghin = Math.floor(so / 1000);
        so = so % 1000;
        if (nghin > 0) {
            chuoi += docblock(nghin, daydu) + " nghìn";
            daydu = true;
        }
        if (so > 0) chuoi += docblock(so, daydu);
        return chuoi;
    }
    function docTienVN(so) {
        if (so == 0) return mangso[0] + " đồng";
        let chuoi = "", hauto = "";
        do {
            let ty = so % 1000000000;
            so = Math.floor(so / 1000000000);
            if (so > 0) chuoi = dochangtrieu(ty, true) + hauto + chuoi;
            else chuoi = dochangtrieu(ty, false) + hauto + chuoi;
            hauto = " tỷ";
        } while (so > 0);
        chuoi = chuoi.trim();
        if (chuoi.length > 0) chuoi = chuoi.charAt(0).toUpperCase() + chuoi.slice(1);
        return chuoi + " đồng";
    }

    // --- 2. GẮN SỰ KIỆN KHI GÕ VÀO Ô ĐƠN GIÁ ---
    const inputDonGia = document.querySelector('input[name="dongia"]');
    
    // Nếu tìm thấy ô nhập đơn giá trên trang thì mới chạy tiếp
    if (inputDonGia) {
        // Tạo một thẻ <div> để chứa dòng chữ hiển thị
        const hienThiTien = document.createElement('div');
        hienThiTien.style.color = '#d32f2f'; // Màu đỏ nổi bật
        hienThiTien.style.marginTop = '8px';
        hienThiTien.style.fontSize = '14px';
        hienThiTien.style.lineHeight = '1.4';
        
        // Gắn thẻ <div> này vào ngay bên dưới ô nhập Đơn giá
        inputDonGia.parentNode.appendChild(hienThiTien);

        // Hàm xử lý định dạng tiền
        function formatTien() {
            let giaTri = inputDonGia.value;
            if(giaTri && !isNaN(giaTri)) {
                // Thêm dấu phẩy phân cách hàng nghìn
                let formattedNumber = new Intl.NumberFormat('vi-VN').format(giaTri);
                // Đọc ra chữ
                let textVN = docTienVN(giaTri);
                
                // In ra màn hình
                hienThiTien.innerHTML = `<b>Quy đổi:</b> ${formattedNumber} VNĐ<br><i style="color:#28a745;">(Bằng chữ: ${textVN})</i>`;
            } else {
                hienThiTien.innerHTML = ""; // Rỗng thì xóa chữ đi
            }
        }

        // Lắng nghe mỗi khi người dùng gõ phím
        inputDonGia.addEventListener('input', formatTien);
        
        // Gọi 1 lần lúc vừa load trang (phòng trường hợp sửa BĐS đã có sẵn giá)
        formatTien();
    }
});
</script>