@extends('admin.layout')

@section('content')
<div style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); max-width: 900px; margin: 0 auto;">
    <a href="/admin/batdongsan" style="text-decoration: none; font-weight:bold; color: #555; display: inline-block; margin-bottom: 15px;">⬅ Quay lại danh sách</a>
    <h2 style="color: #ffc107; border-bottom: 2px solid #ffeeba; padding-bottom: 10px; margin-top: 0;">Cập Nhật Thông Tin Bất Động Sản (Mã: {{ $bds->bdsid }})</h2>

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/admin/batdongsan/update/{{ $bds->bdsid }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="display: flex; gap: 20px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Khách hàng ký gửi (Chủ sở hữu)</label>
                <select name="khid" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                    @foreach($danhsachKH as $kh)
                        <option value="{{ $kh->khid }}" @if($kh->khid == $bds->khid) selected @endif>
                            {{ $kh->hoten }} (SĐT: {{ $kh->sodienthoai }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Loại BĐS</label>
                <select name="loaiid" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                    @foreach($danhsachLoai as $loai)
                        <option value="{{ $loai->loaiid }}" @if($loai->loaiid == $bds->loaiid) selected @endif>
                            {{ $loai->tenloai }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 20px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Diện tích (m2) <span style="color: red;">*</span></label>
                <input type="number" step="0.1" name="dientich" value="{{ old('dientich', $bds->dientich) }}" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
            </div>
            
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Đơn giá (VNĐ) <span style="color: red;">*</span></label>
                <input type="number" name="dongia" value="{{ old('dongia', $bds->dongia) }}" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                </div>
        </div>

        <div style="display: flex; gap: 20px; margin-bottom: 15px;">
            <div style="flex: 2;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Tên đường / Vị trí chi tiết</label>
                <input type="text" name="tenduong" value="{{ old('tenduong', $bds->tenduong) }}" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
            </div>

            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Quận/Huyện</label>
                <input type="text" name="quan" value="{{ old('quan', $bds->quan) }}" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
            </div>
        </div>

        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; border: 1px dashed #ccc; margin-bottom: 20px;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Hình ảnh thực tế</label>
            @if($bds->hinhanh)
                <div style="margin-bottom: 15px;">
                    <p style="margin: 0 0 5px 0; font-size: 13px; color: #666;">Ảnh hiện tại:</p>
                   <img src="data:image/jpeg;base64,{{ $bds->hinhanh }}" width="150" height="150" style="object-fit: cover; border: 2px solid #ddd; border-radius: 8px;">
            @endif
            <p style="margin: 0 0 5px 0; font-size: 13px; color: #d32f2f; font-style: italic;">* Chỉ chọn file mới nếu bạn muốn thay đổi hình ảnh hiện tại.</p>
            <input type="file" name="hinhanh" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; background: #fff;">
        </div>

        <button type="submit" style="background: #ffc107; color: #212529; padding: 14px; border: none; width: 100%; font-weight: bold; cursor: pointer; border-radius: 4px; font-size: 16px;">💾 Lưu Thông Tin Thay Đổi</button>
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
        const inputGiaTri = document.querySelector('input[name="dongia"]');
        
        const hienThiTien = document.createElement('div');
        hienThiTien.style.color = '#d32f2f';
        hienThiTien.style.marginTop = '8px';
        hienThiTien.style.fontSize = '14px';
        hienThiTien.style.lineHeight = '1.4';
        inputGiaTri.parentNode.appendChild(hienThiTien);

        function formatTien() {
            let giaTri = inputGiaTri.value;
            if(giaTri && !isNaN(giaTri)) {
                let formattedNumber = new Intl.NumberFormat('vi-VN').format(giaTri);
                let textVN = docTienVN(giaTri);
                hienThiTien.innerHTML = `<b>Quy đổi:</b> ${formattedNumber} VNĐ<br><i style="color:#28a745;">(Bằng chữ: ${textVN})</i>`;
            } else {
                hienThiTien.innerHTML = "";
            }
        }

        inputGiaTri.addEventListener('input', formatTien);
        formatTien(); // Chạy ngay khi load form để đọc số tiền cũ
    });
</script>
@endsection