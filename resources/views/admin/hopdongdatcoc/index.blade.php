@extends('admin.layout')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="color: #333; margin: 0;">Danh Sách Hợp Đồng Đặt Cọc</h2>
        <a href="/admin/hopdongdatcoc/create" style="background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold;">+ Lập HĐ Đặt Cọc</a> 
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr>
                <th style="background-color: #ffc107; color: #333; border: 1px solid #ddd; padding: 12px; text-align: left;">Mã HĐ</th>
                <th style="background-color: #ffc107; color: #333; border: 1px solid #ddd; padding: 12px; text-align: left;">Khách hàng</th>
                <th style="background-color: #ffc107; color: #333; border: 1px solid #ddd; padding: 12px; text-align: left;">Tài sản (BĐS)</th>
                <th style="background-color: #ffc107; color: #333; border: 1px solid #ddd; padding: 12px; text-align: left;">Tiền cọc</th>
                <th style="background-color: #ffc107; color: #333; border: 1px solid #ddd; padding: 12px; text-align: left;">Hạn chót</th>
                <th style="background-color: #ffc107; color: #333; border: 1px solid #ddd; padding: 12px; text-align: left;">Tình trạng</th>
                <th style="background-color: #ffc107; color: #333; border: 1px solid #ddd; padding: 12px; text-align: center;">Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($danhsachHD as $hd)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 12px;"><b>DC-{{ $hd->dcid }}</b></td>
                <td style="padding: 12px;">{{ $hd->hoten }}</td>
                <td style="padding: 12px;">{{ $hd->tenduong }}</td>
                <td style="padding: 12px; color: red; font-weight: bold;">{{ number_format($hd->giatri) }} đ</td>
                <td style="padding: 12px;">{{ \Carbon\Carbon::parse($hd->ngayhethan)->format('d/m/Y') }}</td>
                <td style="padding: 12px;">
                    @php
                        // Lấy ngày hôm nay để so sánh
                        $homNay = date('Y-m-d'); 
                    @endphp

                    @if($hd->tinhtrang == 0)
                        <span style="background: #28a745; color: white; padding: 5px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; display: inline-block;">
                            ✔️ Chuyển nhượng (Đã thanh toán)
                        </span>
                        
                    @elseif($hd->tinhtrang == 1 && $hd->ngayhethan < $homNay)
                        <span style="background: #dc3545; color: white; padding: 5px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; display: inline-block;">
                            ❌ Đã hủy (Quá hạn thanh toán)
                        </span>
                        
                    @else
                        <span style="background: #17a2b8; color: white; padding: 5px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; display: inline-block;">
                            ⏳ Còn hiệu lực
                        </span>
                    @endif
                </td>
                <td style="padding: 12px; text-align: center;">
    @php
        $homNay = date('Y-m-d');
    @endphp
    
    @if($hd->tinhtrang == 1 && $hd->ngayhethan >= $homNay)
        <a href="/admin/hopdongdatcoc/edit/{{ $hd->dcid }}" style="background: #ffc107; color: #333; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">✏️ Sửa</a>
    @else
        <span style="color: #999; font-size: 13px; font-style: italic; background: #f1f1f1; padding: 4px 8px; border-radius: 4px;">🔒 Đã khóa</span>
    @endif
</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection