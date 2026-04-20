@extends('admin.layout')

@section('content')
<div style="padding: 20px;">
    <h2 style="color: #2c3e50; margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 10px;">📊 TỔNG QUAN HỆ THỐNG</h2>

    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        
        <div style="flex: 1; min-width: 200px; background: linear-gradient(135deg, #3498db, #2980b9); color: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">🏢 TỔNG BẤT ĐỘNG SẢN</div>
            <div style="font-size: 35px; font-weight: bold;">{{ $tongBDS }} <span style="font-size: 16px; font-weight: normal;">căn</span></div>
        </div>

        <div style="flex: 1; min-width: 200px; background: linear-gradient(135deg, #2ecc71, #27ae60); color: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">👥 KHÁCH HÀNG</div>
            <div style="font-size: 35px; font-weight: bold;">{{ $tongKH }} <span style="font-size: 16px; font-weight: normal;">người</span></div>
        </div>

        <div style="flex: 1; min-width: 200px; background: linear-gradient(135deg, #f39c12, #d35400); color: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">📝 HỢP ĐỒNG ĐÃ BÁN</div>
            <div style="font-size: 35px; font-weight: bold;">{{ $hopDongDaBan }} <span style="font-size: 16px; font-weight: normal;">giao dịch</span></div>
        </div>

        <div style="flex: 1; min-width: 250px; background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">💰 TỔNG DOANH THU</div>
            <div style="font-size: 35px; font-weight: bold;">{{ number_format($tongDoanhThu) }} <span style="font-size: 16px; font-weight: normal;">VNĐ</span></div>
        </div>

    </div>

    <div style="margin-top: 40px; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <h3 style="color: #333;">✨ Chào mừng đến với Hệ thống Quản lý Bất động sản</h3>
        <p style="color: #666; line-height: 1.6;">Hệ thống giúp quản lý nguồn cung nhà đất, khách hàng tiềm năng và thực hiện các nghiệp vụ lập hợp đồng ký gửi, đặt cọc, chuyển nhượng một cách chuyên nghiệp và nhanh chóng.</p>
    </div>
</div>
@endsection