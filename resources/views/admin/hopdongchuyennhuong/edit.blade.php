@extends('admin.layout')

@section('content')
<div style="background: #f4f7f6; padding: 30px; font-family: Arial;">
    <div style="background: #fff; padding: 30px; border-radius: 8px; max-width: 800px; margin: 0 auto; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <a href="/admin/hopdongchuyennhuong" style="text-decoration: none; font-weight:bold; color: #555; display: inline-block; margin-bottom: 15px;">⬅ Quay lại danh sách</a>
        <h2 style="border-bottom: 2px solid #ffc107; padding-bottom: 10px; color: #d39e00; margin-top: 0;">Sửa Hợp Đồng Chuyển Nhượng (Mã: CN-{{ $hopdong->cnid }})</h2>

        <form action="/admin/hopdongchuyennhuong/update/{{ $hopdong->cnid }}" method="POST">
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

            <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; border: 1px solid #dee2e6; margin-bottom: 20px;">
                <h4 style="margin-top: 0; color: #495057;">Thông tin Giao dịch (Không thể thay đổi)</h4>
                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1;">
                        <label style="font-weight: bold; color: #6c757d; font-size: 14px;">Khách hàng (Người Mua)</label>
                        <input type="text" value="{{ $hopdong->hoten }}" disabled style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; background: #e9ecef; color: #495057;">
                    </div>
                    <div style="flex: 1;">
                        <label style="font-weight: bold; color: #6c757d; font-size: 14px;">Tài sản (BĐS)</label>
                        <input type="text" value="Mã {{ $hopdong->bdsid }} - {{ $hopdong->tenduong }}, {{ $hopdong->quan }}" disabled style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; background: #e9ecef; color: #495057;">
                    </div>
                </div>
                @if($hopdong->dcid)
                <div style="margin-top: 10px;">
                    <label style="font-weight: bold; color: #6c757d; font-size: 14px;">Áp dụng từ Hợp đồng Đặt Cọc</label>
                    <input type="text" value="Mã DC-{{ $hopdong->dcid }}" disabled style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; background: #e9ecef; color: #495057;">
                </div>
                @endif
            </div>

            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div style="flex: 1; position: relative;">
                    <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Giá trị Chuyển Nhượng Chốt Cuối (VNĐ) <span style="color: red;">*</span></label>
                    <input type="number" name="giatri" value="{{ old('giatri') ?? $hopdong->giatri }}" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                    </div>

                <div style="flex: 1;">
                    <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Ngày lập hợp đồng <span style="color: red;">*</span></label>
                    <input type="date" name="ngaylap" value="{{ old('ngaylap') ?? $hopdong->ngaylap }}" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
                </div>
            </div>

            <button type="submit" style="background: #ffc107; color: #212529; padding: 14px; border: none; width: 100%; font-weight: bold; cursor: pointer; border-radius: 4px; font-size: 16px;">Cập Nhật Hợp Đồng</button>
        </form>
    </div>
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


    // --- KHỐI 2: TÍNH NĂNG TỰ ĐỘNG CHỌN BĐS VÀ KHÁCH HÀNG (Dành cho trang Create) ---
    function tuDongChonBDS() {
        var selectDC = document.getElementById('dcid');
        if(!selectDC) return; // Nếu đang ở trang Edit (không có ô dcid) thì bỏ qua
        
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
        }
    }


    // --- KHỐI 3: GẮN SỰ KIỆN KHI GÕ SỐ TIỀN ---
    document.addEventListener('DOMContentLoaded', function() {
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
                // Định dạng số có dấu phẩy
                let formattedNumber = new Intl.NumberFormat('vi-VN').format(giaTri);
                // Đọc chữ tiếng Việt
                let textVN = docTienVN(giaTri);
                
                // Hiển thị kết quả tuyệt đẹp
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