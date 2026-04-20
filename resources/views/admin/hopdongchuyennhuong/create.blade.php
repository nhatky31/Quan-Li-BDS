@extends('admin.layout')

@section('content')
<div style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto; font-family: Arial, sans-serif;">
    <a href="/admin/hopdongchuyennhuong" style="text-decoration: none; font-weight:bold; color: #555; display: inline-block; margin-bottom: 15px;">⬅ Quay lại danh sách</a>
    <h2 style="border-bottom: 2px solid #d32f2f; padding-bottom: 10px; color: #d32f2f; margin-top: 0;">Lập Hợp Đồng Chuyển Nhượng (Mua Bán)</h2>

    <form action="/admin/hopdongchuyennhuong/store" method="POST">
        @csrf

        @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 25px; border-left: 5px solid #d9534f;">
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
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Khách hàng (Người Mua) <span style="color: red;">*</span></label>
                <select name="khid" id="khid" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                    <option value="">-- Chọn Người Mua --</option>
                    @foreach($danhsachKH as $kh)
                    <option value="{{ $kh->khid }}" {{ old('khid') == $kh->khid ? 'selected' : '' }}>{{ $kh->hoten }} (SĐT: {{ $kh->sodienthoai }})</option>
                    @endforeach
                </select>
            </div>

            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Tài sản (Chỉ hiện nhà Đang Trống) <span style="color: red;">*</span></label>
                <select name="bdsid" id="bdsid" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                    <option value="">-- Chọn Nhà/Đất --</option>
                    @foreach($danhsachBDS as $bds)
                    <option value="{{ $bds->bdsid }}" data-khid="{{ $bds->khid }}" {{ old('bdsid') == $bds->bdsid ? 'selected' : '' }}>Mã {{ $bds->bdsid }} - {{ $bds->tenduong }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; border: 1px dashed #ccc; margin-bottom: 20px;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #0056b3;">Áp dụng Hợp đồng Đặt Cọc (Nếu có):</label>
            <select name="dcid" id="dcid" onchange="tuDongChonBDS()" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 15px;">
                <option value="" data-bdsid="" data-khid="">-- Bỏ qua nếu khách mua trực tiếp, không đặt cọc trước --</option>
                @foreach($danhsachDatCoc as $dc)
                <option value="{{ $dc->dcid }}" data-bdsid="{{ $dc->bdsid }}" data-khid="{{ $dc->khid }}" {{ old('dcid') == $dc->dcid ? 'selected' : '' }}>
                    Mã DC-{{ $dc->dcid }} | Khách: {{ $dc->hoten }} | Đã cọc: {{ number_format($dc->giatri) }} đ
                </option>
                @endforeach
            </select>
            <small style="color: #666; margin-top: 8px; display: block;">
                <i>* Mẹo: Nếu chọn Hợp đồng cọc, hệ thống sẽ tự động đối chiếu giá chốt và hủy trạng thái cọc cũ.</i>
            </small>
        </div>

        <div style="display: flex; gap: 20px; margin-bottom: 20px;">
            <div style="flex: 1; position: relative;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Giá trị Chuyển Nhượng Chốt Cuối (VNĐ) <span style="color: red;">*</span></label>
                <input type="number" name="giatri" value="{{ old('giatri') }}" placeholder="Ví dụ: 2500000000" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px; box-sizing: border-box;">
            </div>

            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px;">Ngày lập hợp đồng <span style="color: red;">*</span></label>
                <input type="date" name="ngaylap" value="{{ old('ngaylap') ?? date('Y-m-d') }}" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px; box-sizing: border-box;">
            </div>
        </div>

        <button type="submit" style="background: #d32f2f; color: white; padding: 14px; border: none; width: 100%; font-weight: bold; cursor: pointer; border-radius: 4px; font-size: 16px; margin-top: 10px;">✅ Chốt Giao Dịch & Khóa BĐS</button>
    </form>
</div>

<script>
    // --- KHỐI 1: HÀM ĐỌC SỐ TIỀN THÀNH CHỮ TIẾNG VIỆT ---
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

    // --- KHỐI 2: TÍNH NĂNG TỰ ĐỘNG CHỌN BĐS VÀ KHÁCH HÀNG KHI CHỌN HỢP ĐỒNG CỌC ---
    function tuDongChonBDS() {
        var selectDC = document.getElementById('dcid');
        if(!selectDC) return; 
        
        var optionChon = selectDC.options[selectDC.selectedIndex];
        var bdsId = optionChon.getAttribute('data-bdsid');
        var khId = optionChon.getAttribute('data-khid');

        var selectBDS = document.getElementById('bdsid');
        var selectKH = document.getElementById('khid');

        if (bdsId) {
            selectBDS.value = bdsId;
            selectBDS.style.pointerEvents = 'none';
            selectBDS.style.backgroundColor = '#e9ecef';

            if(khId) {
                selectKH.value = khId;
                selectKH.style.pointerEvents = 'none';
                selectKH.style.backgroundColor = '#e9ecef';
            }
        } else {
            selectBDS.style.pointerEvents = 'auto';
            selectBDS.style.backgroundColor = '#fff';
            selectKH.style.pointerEvents = 'auto';
            selectKH.style.backgroundColor = '#fff';
            // Gọi lại sự kiện change để lọc lại nhà
            selectKH.dispatchEvent(new Event('change'));
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        
        // --- KHỐI 3: ẨN NHÀ CỦA NGƯỜI ĐANG MUA ---
        const khachHangSelect = document.getElementById('khid');
        const bdsSelect = document.getElementById('bdsid');

        if (khachHangSelect && bdsSelect) {
            khachHangSelect.addEventListener('change', function() {
                // Nếu đang dùng hợp đồng cọc thì không chạy logic này
                if (document.getElementById('dcid').value !== "") return;

                const selectedKhid = this.value; 

                for (let i = 0; i < bdsSelect.options.length; i++) {
                    let option = bdsSelect.options[i];
                    let chuSohuuId = option.getAttribute('data-khid');

                    if (!option.value) continue;

                    if (chuSohuuId === selectedKhid) {
                        option.style.display = 'none';
                        option.disabled = true;
                        
                        if (bdsSelect.value === option.value) {
                            bdsSelect.value = '';
                        }
                    } else {
                        option.style.display = '';
                        option.disabled = false;
                    }
                }
            });
            // Chạy lần đầu
            khachHangSelect.dispatchEvent(new Event('change'));
        }

        // --- KHỐI 4: HIỂN THỊ SỐ TIỀN BẰNG CHỮ ---
        const inputGiaTri = document.querySelector('input[name="giatri"]');
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
        
        formatTien();
        tuDongChonBDS();
    });
</script>
@endsection