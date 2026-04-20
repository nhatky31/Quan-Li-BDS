@extends('admin.layout')

@section('content')
<div style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.08); font-family: 'Segoe UI', Arial, sans-serif;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2 style="color: #2c3e50; margin: 0; font-size: 24px;">📝 Danh Sách Hợp Đồng Ký Gửi</h2>
            <p style="color: #7f8c8d; margin-top: 5px; font-size: 14px;">Quản lý các nguồn hàng bất động sản ký gửi từ khách hàng [cite: 1, 46]</p>
        </div>
        <a href="/admin/hopdongkygui/create" style="background: linear-gradient(135deg, #28a745, #218838); color: white; padding: 12px 20px; text-decoration: none; border-radius: 8px; font-weight: bold; box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3); transition: 0.3s; display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 18px;">+</span> Lập Hợp Đồng Mới
        </a>
    </div>

    <div style="overflow-x: auto; border-radius: 10px; border: 1px solid #e1e8ed;">
        <table style="width: 100%; border-collapse: collapse; background: white;">
            <thead>
                <tr style="background-color: #0056b3; color: white;">
                    <th style="padding: 15px; text-align: left; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Mã HĐ</th>
                    <th style="padding: 15px; text-align: left; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Khách hàng (Bên A)</th>
                    <th style="padding: 15px; text-align: left; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Tài sản (BĐS)</th>
                    <th style="padding: 15px; text-align: right; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Giá trị</th>
                    <th style="padding: 15px; text-align: right; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Hoa hồng</th>
                    <th style="padding: 15px; text-align: center; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Thời hạn</th>
                    <th style="padding: 15px; text-align: center; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Trạng thái</th>
                    <th style="padding: 15px; text-align: center; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Tác vụ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($danhsachHD as $hd)
                <tr style="border-bottom: 1px solid #edf2f7; transition: 0.2s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                    <td style="padding: 15px; font-weight: bold; color: #34495e;">KG-{{ $hd->kgid }}</td>
                    
                    <td style="padding: 15px;">
                        <div style="font-weight: 600; color: #2c3e50;">{{ $hd->hoten }}</div>
                    </td>
                    
                    <td style="padding: 15px; color: #576574; font-size: 14px;">
                        {{ $hd->tenduong }}, {{ $hd->quan }}
                    </td>
                    
                    <td style="padding: 15px; text-align: right; font-weight: bold; color: #d32f2f;">
                        {{ number_format($hd->giatri) }} đ
                    </td>
                    
                    <td style="padding: 15px; text-align: right; font-weight: bold; color: #28a745;">
                        {{ number_format($hd->chiphidv) }} đ
                    </td>
                    
                    <td style="padding: 15px; text-align: center; font-size: 13px; color: #636e72; line-height: 1.4;">
                        {{ date('d/m/Y', strtotime($hd->ngaybd)) }} <br>đến<br> {{ date('d/m/Y', strtotime($hd->ngayketthuc)) }}
                    </td>
                    
                   <td style="padding: 15px; text-align: center;">
                        @php
                            // Lấy ngày hiện tại và ngày kết thúc (chỉ tính ngày, bỏ qua giờ phút để chính xác)
                            $ngayHienTai = strtotime(date('Y-m-d'));
                            $ngayKetThuc = strtotime($hd->ngayketthuc);
                        @endphp

                        @if($hd->trangthai == 0)
                            <span style="background: #cce5ff; color: #004085; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; white-space: nowrap;">✓ Đã giao dịch</span>
                        
                        @elseif($hd->trangthai == 1 && $ngayKetThuc < $ngayHienTai)
                            <span style="background: #f8d7da; color: #721c24; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; white-space: nowrap;">✕ Quá hạn</span>
                        
                        @else
                            <span style="background: #d4edda; color: #155724; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; white-space: nowrap;">● Đang hiệu lực</span>
                        @endif
                    </td>
                    
                    <td style="padding: 15px; text-align: center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="/admin/hopdongkygui/print/{{ $hd->kgid }}" style="background: #6f42c1; color: white; padding: 6px 12px; text-decoration: none; border-radius: 6px; font-size: 12px; font-weight: bold; transition: 0.3s;">🖨️ In PDF</a>
                            <a href="/admin/hopdongkygui/show/{{ $hd->kgid }}" style="background: #17a2b8; color: white; padding: 6px 12px; text-decoration: none; border-radius: 6px; font-size: 12px; font-weight: bold;">👁️ Xem</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 30px; text-align: center; color: #95a5a6; font-style: italic;">
                        Chưa có hợp đồng ký gửi nào được ghi nhận.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px; display: flex; justify-content: flex-end; font-size: 13px; color: #95a5a6;">
        <span>Tổng cộng: <b>{{ count($danhsachHD) }}</b> hợp đồng ký gửi </span>
    </div>
</div>
@endsection