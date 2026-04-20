@extends('admin.layout')

@section('content')
<div style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto;">
    <a href="/admin/hopdongdatcoc" style="text-decoration: none; font-weight:bold; color: #555; display: inline-block; margin-bottom: 15px;">⬅ Quay lại danh sách</a>
    <h2 style="color: #ff9800; border-bottom: 2px solid #ffe0b2; padding-bottom: 10px; margin-top: 0;">Sửa Hợp Đồng Đặt Cọc (Mã DC-{{ $hopdong->dcid }})</h2>

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/admin/hopdongdatcoc/update/{{ $hopdong->dcid }}" method="POST">
        @csrf
        
        <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; border: 1px dashed #ccc; margin-bottom: 20px;">
            <p style="margin: 0 0 10px 0; color: #d32f2f; font-style: italic; font-size: 13px;">* Thông tin Khách hàng và Bất động sản không được phép sửa đổi để đảm bảo tính pháp lý.</p>
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #666;">Khách Hàng (Người Đặt Cọc):</label>
                <input type="text" value="{{ $hopdong->hoten }}" disabled style="width: 100%; padding: 12px; border: 1px solid #ddd; background: #e9ecef; border-radius: 5px; font-size: 15px;">
            </div>

            <div>
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #666;">Tài Sản Đặt Cọc:</label>
                <input type="text" value="Mã {{ $hopdong->bdsid }} - {{ $hopdong->tenduong }}, {{ $hopdong->quan }}" disabled style="width: 100%; padding: 12px; border: 1px solid #ddd; background: #e9ecef; border-radius: 5px; font-size: 15px;">
            </div>
        </div>

        <div style="margin-bottom: 20px; position: relative;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Số Tiền Đặt Cọc (VNĐ):</label>
            <input type="number" name="giatri" value="{{ old('giatri') ?? $hopdong->giatri }}" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 15px;">
        </div>

        <div style="display: flex; gap: 20px; margin-bottom: 30px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Ngày Lập Hợp Đồng:</label>
                <input type="date" name="ngaylap" value="{{ old('ngaylap') ?? $hopdong->ngaylap }}" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 15px;">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Ngày Hết Hạn Cọc (Hạn chót):</label>
                <input type="date" name="ngayhethan" value="{{ old('ngayhethan') ?? $hopdong->ngayhethan }}" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 15px;">
            </div>
        </div>

        <button type="submit" style="background: #ff9800; color: white; border: none; padding: 14px; width: 100%; border-radius: 5px; font-weight: bold; font-size: 16px; cursor: pointer;">✏️ Cập Nhật Thay Đổi</button>
    </form>
</div>

<script>
    // --- HÀM ĐỌC SỐ TIỀN THÀNH CHỮ TIẾNG VIỆT ---
    const mangso = ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];
    function dochangchuc(so, daydu) {
        let chuoi = ""; let chuc = Math.floor(so / 10); let donvi = so % 10;
        if (chuc > 1) { chuoi = " " + mangso[chuc] + " mươi"; if (donvi == 1) chuoi += " mốt"; }
        else if (chuc == 1) { chuoi = " mười"; if (donvi == 1) chuoi += " một"; }
        else if (daydu && donvi > 0) { chuoi = " lẻ"; }
        if (donvi == 5 && chuc > 0) { chuoi += " lăm"; }
        else if (donvi > 1 || (donvi == 1 && chuc == 0)) { chuoi += " " + mangso[donvi]; }
        return chuoi;
    }
    function docblock(so, daydu) {
        let chuoi = ""; let tram = Math.floor(so / 100); so = so % 100;
        if (daydu || tram > 0) { chuoi = " " + mangso[tram] + " trăm"; chuoi += dochangchuc(so, true); }
        else { chuoi = dochangchuc(so, false); }
        return chuoi;
    }
    function dochangtrieu(so, daydu) {
        let chuoi = ""; let trieu = Math.floor(so / 1000000); so = so % 1000000;
        if (trieu > 0) { chuoi = docblock(trieu, daydu) + " triệu"; daydu = true; }
        let nghin = Math.floor(so / 1000); so = so % 1000;
        if (nghin > 0) { chuoi += docblock(nghin, daydu) + " nghìn"; daydu = true; }
        if (so > 0) chuoi += docblock(so, daydu);
        return chuoi;
    }
    function docTienVN(so) {
        if (so == 0) return mangso[0] + " đồng";
        let chuoi = "", hauto = "";
        do {
            let ty = so % 1000000000; so = Math.floor(so / 1000000000);
            if (so > 0) chuoi = dochangtrieu(ty, true) + hauto + chuoi;
            else chuoi = dochangtrieu(ty, false) + hauto + chuoi;
            hauto = " tỷ";
        } while (so > 0);
        chuoi = chuoi.trim();
        if (chuoi.length > 0) chuoi = chuoi.charAt(0).toUpperCase() + chuoi.slice(1);
        return chuoi + " đồng";
    }

    // --- GẮN SỰ KIỆN KHI GÕ SỐ TIỀN ---
    document.addEventListener('DOMContentLoaded', function() {
        const inputGiaTri = document.querySelector('input[name="giatri"]');
        
        const hienThiTien = document.createElement('div');
        hienThiTien.style.color = '#ff9800';
        hienThiTien.style.marginTop = '8px';
        hienThiTien.style.fontSize = '14px';
        hienThiTien.style.lineHeight = '1.4';
        inputGiaTri.parentNode.appendChild(hienThiTien);

        function formatTien() {
            let giaTri = inputGiaTri.value;
            if(giaTri && !isNaN(giaTri)) {
                let formattedNumber = new Intl.NumberFormat('vi-VN').format(giaTri);
                let textVN = docTienVN(giaTri);
                hienThiTien.innerHTML = `<b>Quy đổi:</b> ${formattedNumber} VNĐ<br><i style="color:#d32f2f;">(Bằng chữ: ${textVN})</i>`;
            } else {
                hienThiTien.innerHTML = "";
            }
        }

        inputGiaTri.addEventListener('input', formatTien);
        formatTien(); // Chạy ngay khi load form để đọc số tiền cũ
    });
</script>
@endsection