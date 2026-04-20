@extends('admin.layout')

@section('content')
<div style="background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <h2 style="color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px;">🔍 Chi tiết: {{ $bds->tenduong }}</h2>
    
    <div style="display: flex; gap: 30px; margin-top: 20px;">
        <div style="flex: 1;">
            @if($bds->hinhanh)
                <img src="data:image/jpeg;base64,{{ $bds->hinhanh }}" style="width: 100%; border-radius: 8px;">
            @else
                <div style="background: #eee; height: 300px; display: flex; align-items: center; justify-content: center;">Không có ảnh</div>
            @endif
        </div>
        <div style="flex: 1.5; font-size: 16px; line-height: 2;">
            <p><b>💰 Giá bán:</b> <span style="color: red; font-weight: bold;">{{ number_format($bds->dongia) }} VNĐ</span></p>
            <p><b>📏 Diện tích:</b> {{ $bds->dientich }} m²</p>
            <p><b>🏠 Chủ nhà:</b> {{ $bds->ten_chu_nha }} ({{ $bds->sodienthoai }})</p>
            <p><b>📍 Địa chỉ:</b> {{ $bds->tenduong }}, {{ $bds->quan }}</p>
            <p><b>📑 Tình trạng:</b> {{ $bds->tinhtrang == 1 ? 'Đang trống' : 'Đã bán' }}</p>
            <hr>
            <a href="/admin/batdongsan" style="background: #6c757d; color: white; padding: 8px 20px; text-decoration: none; border-radius: 4px;">Quay lại</a>
        </div>
    </div>
</div>
@endsection