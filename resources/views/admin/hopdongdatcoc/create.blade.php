@extends('admin.layout')

@section('content')
<div style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto;">
    <h2 style="color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 25px;">💰 Lập Hợp Đồng Đặt Cọc</h2>

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/admin/hopdongdatcoc/store" method="POST">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Khách Hàng (Người Đặt Cọc):</label>
            <select name="khid" id="khid" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 15px;">
                <option value="">-- Chọn Khách Hàng --</option>
                @foreach($danhsachKH as $kh)
                    <option value="{{ $kh->khid }}">{{ $kh->hoten }} (SĐT: {{ $kh->sodienthoai }})</option>
                @endforeach
            </select>
        </div>

       
           
           <div style="margin-bottom: 20px;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Tài Sản (Bất Động Sản Đang Trống):</label>
            <select name="bdsid" id="bdsid" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                <option value="">-- Chọn Bất Động Sản --</option>
                @foreach($danhsachBDS as $bds)
                    <option value="{{ $bds->bdsid }}" data-khid="{{ $bds->khid }}">
                        {{ $bds->tenduong }}, {{ $bds->quan }} (Giá: {{ number_format($bds->dongia) }} đ)
                    </option>
                @endforeach
            </select>
        
        </div>

        <div style="margin-bottom: 20px;">
            <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Số Tiền Đặt Cọc (VNĐ):</label>
            <input type="number" name="giatri" required min="1000000" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 15px;" placeholder="Ví dụ: 50000000">
            <small style="color: #666; margin-top: 5px; display: block;">* Nhập số tiền, không chứa dấu phẩy hoặc chấm.</small>
        </div>

        <div style="display: flex; gap: 20px; margin-bottom: 30px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Ngày Lập Hợp Đồng:</label>
                <input type="date" name="ngaylap" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 15px;" value="{{ date('Y-m-d') }}">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #333;">Ngày Hết Hạn Cọc:</label>
                <input type="date" name="ngayhethan" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 15px;">
            </div>
        </div>

        <div style="text-align: right; border-top: 1px solid #eee; padding-top: 20px;">
            <a href="/admin/hopdongdatcoc" style="background: #6c757d; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; margin-right: 15px; font-weight: bold;">⬅ Quay Lại</a>
            <button type="submit" style="background: #28a745; color: white; border: none; padding: 12px 25px; border-radius: 5px; font-weight: bold; font-size: 16px; cursor: pointer;">💾 Lưu Hợp Đồng</button>
        </div>
    </form>
</div>

<script>
    // --- PHẦN 1: HÀM ĐỌC SỐ TIỀN THÀNH CHỮ TIẾNG VIỆT ---
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

    // --- PHẦN 2: THỰC THI JAVASCRIPT KHI TRANG TẢI XONG ---
    document.addEventListener('DOMContentLoaded', function() {
        
        // 2.1 Xử lý ẩn hiện nhà của người đang đặt cọc
        const khachHangSelect = document.getElementById('khid');
        const bdsSelect = document.getElementById('bdsid');

        khachHangSelect.addEventListener('change', function() {
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

        // Kích hoạt ngay lần đầu lỡ trình duyệt lưu cache tên khách hàng cũ
        khachHangSelect.dispatchEvent(new Event('change'));

        // 2.2 Xử lý hiển thị số tiền chữ
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
    });
</script>
@endsection