@extends('admin.layout')

@section('content')

    <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="color: #333; margin: 0;">Danh Sách Bất Động Sản</h2>
            <a href="/admin/batdongsan/create" style="background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold;">+ Thêm BĐS</a> 
        </div>
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Hình ảnh</th>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Chủ sở hữu</th>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Vị trí</th>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Diện tích</th>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Đơn giá</th>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Tình trạng</th>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Tác vụ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($danhsachBDS as $bds)
                <tr style="border-bottom: 1px solid #ddd;">
                    
                    <td style="border: 1px solid #ddd; padding: 12px;">
                        @if($bds->hinhanh)
                          <img src="data:image/jpeg;base64,{{ $bds->hinhanh }}" width="80" height="80" style="object-fit: cover; border-radius: 4px; border: 1px solid #ccc;">
                        @else
                            <span style="color: #999; font-style: italic;">Không có ảnh</span>
                        @endif
                    </td>
                    
                    <td style="border: 1px solid #ddd; padding: 12px;"><b>{{ $bds->hoten }}</b></td>
                    <td style="border: 1px solid #ddd; padding: 12px;">{{ $bds->tenduong }}, {{ $bds->quan }}</td>
                    <td style="border: 1px solid #ddd; padding: 12px;">{{ $bds->dientich }} m²</td>
                    <td style="border: 1px solid #ddd; padding: 12px; color: red; font-weight: bold;">{{ number_format($bds->dongia) }} VNĐ</td>
                    
                    <td style="border: 1px solid #ddd; padding: 12px;">
                        @if($bds->tinhtrang == 1)
                            <span style="color: green; font-weight: bold;">Đang trống</span>
                        @else
                            <span style="color: gray; font-weight: bold;">Đã bán</span>
                        @endif
                    </td>
                    
                    <td style="border: 1px solid #ddd; padding: 12px;">
                        <a href="/admin/batdongsan/show/{{ $bds->bdsid }}" style="color: #17a2b8; font-weight: bold; text-decoration: none; margin-right: 10px;">👁️ Xem</a>
                        
                        @if($bds->tinhtrang == 1)
                            <a href="/admin/batdongsan/edit/{{ $bds->bdsid }}" style="color: #ffc107; font-weight: bold; text-decoration: none; margin-right: 10px;">Sửa</a>
                            <a href="/admin/batdongsan/delete/{{ $bds->bdsid }}" style="color: #dc3545; font-weight: bold; text-decoration: none;" onclick="return confirm('Bạn có chắc chắn muốn xóa BĐS này?')">Xóa</a>
                        @else
                            <span style="color: #999; font-size: 13px; font-style: italic; background: #e9ecef; padding: 4px 8px; border-radius: 4px; display: inline-block; margin-top: 5px;">🔒 Đã khóa</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection