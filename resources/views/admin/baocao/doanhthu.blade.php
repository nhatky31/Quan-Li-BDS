@extends('admin.layout')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); font-family: Arial, sans-serif;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #0056b3; padding-bottom: 10px; margin-bottom: 20px;">
        <h2 style="color: #333; margin: 0;">📊 Báo Cáo Doanh Thu Theo Nhân Viên</h2>
        <span style="background: #0056b3; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px;">
            Tháng {{ $thang }} / Năm {{ $nam }}
        </span>
    </div>

    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #dee2e6;">
        <form action="/admin/baocao/doanhthu" method="GET" style="display: flex; gap: 20px; align-items: flex-end;">
            <div style="flex: 1;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px;">Chọn Tháng:</label>
                <select name="thang" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $thang == $i ? 'selected' : '' }}>Tháng {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div style="flex: 1;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px;">Chọn Năm:</label>
                <select name="nam" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    @for($i = 2024; $i <= date('Y'); $i++)
                        <option value="{{ $i }}" {{ $nam == $i ? 'selected' : '' }}>Năm {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div style="flex: 1;">
                <button type="submit" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 4px; font-weight: bold; cursor: pointer; width: 100%;">
                    🔍 Lọc dữ liệu
                </button>
            </div>
        </form>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr style="background-color: #0056b3; color: white;">
                <th style="padding: 15px; border: 1px solid #ddd; text-align: center; width: 80px;">Hạng</th>
                <th style="padding: 15px; border: 1px solid #ddd; text-align: left;">Nhân viên</th>
                <th style="padding: 15px; border: 1px solid #ddd; text-align: center;">Số HĐ Chốt</th>
                <th style="padding: 15px; border: 1px solid #ddd; text-align: right;">Doanh số Bán (VNĐ)</th>
                <th style="padding: 15px; border: 1px solid #ddd; text-align: right; color: #a8e6cf;">Hoa hồng NV (VNĐ)</th>
                <th style="padding: 15px; border: 1px solid #ddd; text-align: center;">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @forelse($thongKe as $key => $nv)
            @if($key == 0)
                <tr style="border-bottom: 1px solid #ddd; background-color: #fffef0;">
            @else
                <tr style="border-bottom: 1px solid #ddd; background-color: #fff;">
            @endif
                <td style="padding: 15px; text-align: center; font-weight: bold;">
                    @if($key == 0) 
                        🥇 
                    @elseif($key == 1) 
                        🥈 
                    @elseif($key == 2) 
                        🥉 
                    @else 
                        {{ $key + 1 }} 
                    @endif
                </td>
                <td style="padding: 15px;">
                    <div style="font-weight: bold; color: #0056b3;">{{ $nv->tennv }}</div>
                    <small style="color: #666;">ID: NV-{{ $nv->nvid }}</small>
                </td>
                <td style="padding: 15px; text-align: center;">
                    <span style="background: #e9ecef; padding: 5px 12px; border-radius: 15px; font-weight: bold;">
                        {{ $nv->so_hop_dong_chot }}
                    </span>
                </td>
                
                <td style="padding: 15px; text-align: right; color: #555; font-weight: bold; font-size: 15px;">
                    {{ number_format($nv->tong_tien_mang_ve) }} đ
                </td>
                
                <td style="padding: 15px; text-align: right; color: #28a745; font-weight: bold; font-size: 16px;">
                    {{ number_format($nv->tong_hoa_hong) }} đ
                </td>

                <td style="padding: 15px; text-align: center;">
                    @if($nv->tong_tien_mang_ve > 1000000000)
                        <span style="color: #28a745; font-size: 12px; font-weight: bold;">⭐ Xuất sắc</span>
                    @else
                        <span style="color: #6c757d; font-size: 12px;">Đạt mục tiêu</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 30px; text-align: center; color: #999; font-style: italic;">
                    Không có dữ liệu giao dịch trong khoảng thời gian này.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-radius: 5px; color: #856404; font-size: 13px;">
        💡 <b>Ghi chú:</b> Doanh thu và Hoa hồng được tính dựa trên các <b>Hợp đồng Chuyển nhượng</b> đã ký kết thành công trong tháng.
    </div>
</div>
@endsection