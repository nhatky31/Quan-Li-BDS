@extends('admin.layout')

@section('content')
<div style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto; font-family: Arial, sans-serif;">
    <a href="/admin/hopdongkygui" style="text-decoration: none; font-weight:bold; color: #555; display: inline-block; margin-bottom: 15px;">⬅ Quay lại danh sách</a>
    <h2 style="border-bottom: 2px solid #007bff; padding-bottom: 10px; color: #0056b3; margin-top: 0;">Lập Hợp Đồng Ký Gửi Mới</h2>

    <form action="/admin/hopdongkygui/store" method="POST">
        @csrf
        
        @if ($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 5px solid #d9534f;">
                <b style="font-size: 16px;">⚠️ Có lỗi xảy ra:</b>
                <ul style="margin-bottom: 0; margin-top: 10px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="display: flex; gap: 20px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Khách hàng (Bên A) <span style="color: red;">*</span></label>
                <select name="khid" id="khid" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                    <option value="">-- Chọn Khách Hàng --</option>
                    @foreach($danhsachKH as $kh)
                        <option value="{{ $kh->khid }}" {{ old('khid') == $kh->khid ? 'selected' : '' }}>
                            {{ $kh->hoten }} (SĐT: {{ $kh->sodienthoai }})
                        </option>
                    @endforeach
                </select>
            </div>

           <div style="flex: 1;">
    <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Tài sản Ký gửi (Bất Động Sản) <span style="color: red;">*</span></label>
    <select name="bdsid" id="bdsid" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
        <option value="">-- Chọn Bất Động Sản --</option>
        
        @foreach($danhsachBDS as $bds)
            @if($bds->tinhtrang == 1)
                <option value="{{ $bds->bdsid }}" data-khid="{{ $bds->khid }}" {{ old('bdsid') == $bds->bdsid ? 'selected' : '' }}>
                    Mã {{ $bds->bdsid }} - {{ $bds->tenduong }}
                </option>
            @else
                <option value="{{ $bds->bdsid }}" data-khid="{{ $bds->khid }}" disabled style="color: #999; background: #f4f4f4; font-style: italic;">
                    Mã {{ $bds->bdsid }} - {{ $bds->tenduong }} (🚫 Đã bán)
                </option>
            @endif
        @endforeach
        
    </select>
</div>
        </div>

       <div style="display: flex; gap: 20px; margin-bottom: 20px;">
            <div style="flex: 1; position: relative;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Giá trị thỏa thuận (VNĐ) <span style="color: red;">*</span></label>
                <input type="number" id="giatri_input" name="giatri" value="{{ old('giatri') }}" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;" placeholder="VD: 2000000000">
            </div>
            
            <div style="flex: 1; position: relative;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Chi phí dịch vụ/Hoa hồng <span style="color: red;">*</span></label>
                <div style="display: flex; gap: 10px;">
                    <input type="number" step="0.1" id="phantram_input" placeholder="%" style="width: 25%; padding: 12px; border: 1px solid #007bff; border-radius: 4px; font-size: 15px; font-weight: bold; color: #007bff;" title="Nhập phần trăm hoa hồng">
                    
                    <input type="number" id="chiphidv_input" name="chiphidv" value="{{ old('chiphidv') }}" required style="width: 75%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;" placeholder="Thành tiền (VNĐ)">
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 20px; margin-bottom: 30px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Ngày bắt đầu <span style="color: red;">*</span></label>
                <input type="date" name="ngaybd" value="{{ old('ngaybd') ?? date('Y-m-d') }}" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Ngày kết thúc <span style="color: red;">*</span></label>
                <input type="date" name="ngayketthuc" value="{{ old('ngayketthuc') }}" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
            </div>
        </div>

        <button type="submit" style="background: #007bff; color: white; padding: 14px; border: none; width: 100%; font-weight: bold; cursor: pointer; border-radius: 4px; font-size: 16px; transition: 0.3s;">
            ✅ Lưu Hợp Đồng Ký Gửi
        </button>
    </form>
</div>

<script>
    // --- KHỐI 1: HÀM LỌC BẤT ĐỘNG SẢN THEO KHÁCH HÀNG ---
    document.addEventListener("DOMContentLoaded", function() {
        var khSelect = document.getElementById('khid');
        var bdsSelect = document.getElementById('bdsid');
        
        var allBdsOptions = Array.from(bdsSelect.options);

        function locBatDongSan() {
            var selectedKhId = khSelect.value;
            bdsSelect.innerHTML = '';

            if (selectedKhId === "") {
                var defaultOpt = document.createElement('option');
                defaultOpt.value = "";
                defaultOpt.text = "-- Vui lòng chọn Khách hàng trước --";
                bdsSelect.appendChild(defaultOpt);
                return;
            }

            var count = 0;
            bdsSelect.appendChild(allBdsOptions[0]);

            for (var i = 1; i < allBdsOptions.length; i++) {
                var opt = allBdsOptions[i];
                if (opt.getAttribute('data-khid') === selectedKhId) {
                    bdsSelect.appendChild(opt);
                    count++;
                }
            }

            if (count === 0) {
                bdsSelect.innerHTML = '';
                var noDataOpt = document.createElement('option');
                noDataOpt.value = "";
                noDataOpt.text = "❌ Khách hàng này chưa có tài sản nào!";
                bdsSelect.appendChild(noDataOpt);
            }
        }

        khSelect.addEventListener('change', locBatDongSan);
        locBatDongSan(); 
    });

    // --- KHỐI 2: HÀM ĐỌC SỐ TIỀN THÀNH CHỮ ---
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

    // Gắn sự kiện cho ô Giá Trị và Tính toán
    document.addEventListener('DOMContentLoaded', function() {
        function attachCurrencyFormatter(inputName, textColor) {
            const inputField = document.querySelector(`input[name="${inputName}"]`);
            if(!inputField) return;

            const displayDiv = document.createElement('div');
            displayDiv.style.color = textColor;
            displayDiv.style.marginTop = '8px';
            displayDiv.style.fontSize = '14px';
            displayDiv.style.lineHeight = '1.4';
            inputField.parentNode.appendChild(displayDiv);

            function formatAndRead() {
                let val = inputField.value;
                if(val && !isNaN(val)) {
                    let formatted = new Intl.NumberFormat('vi-VN').format(val);
                    let text = docTienVN(val);
                    displayDiv.innerHTML = `<b>Quy đổi:</b> ${formatted} VNĐ<br><i style="color:#28a745;">(Bằng chữ: ${text})</i>`;
                } else {
                    displayDiv.innerHTML = "";
                }
            }

            inputField.addEventListener('input', formatAndRead);
            formatAndRead();
        }

        attachCurrencyFormatter('giatri', '#007bff');
        attachCurrencyFormatter('chiphidv', '#dc3545');

        // ==========================================
        // KHỐI 3: TỰ ĐỘNG TÍNH TIỀN TỪ PHẦN TRĂM (%)
        // ==========================================
        const giaTriEl = document.getElementById('giatri_input');
        const phanTramEl = document.getElementById('phantram_input');
        const chiPhiEl = document.getElementById('chiphidv_input');

        function tinhHoaHong() {
            let giaTri = parseFloat(giaTriEl.value);
            let phanTram = parseFloat(phanTramEl.value);

            if (!isNaN(giaTri) && !isNaN(phanTram) && giaTri > 0) {
                let thanhTien = (giaTri * phanTram) / 100;
                chiPhiEl.value = thanhTien;
                
                // Kích hoạt cập nhật số thành chữ
                chiPhiEl.dispatchEvent(new Event('input'));
            }
        }

        phanTramEl.addEventListener('input', tinhHoaHong);
        giaTriEl.addEventListener('input', tinhHoaHong);
    });
</script>
@endsection