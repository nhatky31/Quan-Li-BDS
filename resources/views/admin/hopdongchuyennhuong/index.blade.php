@extends('admin.layout')

@section('content')
<div style="background: #fff; padding: 25px; border-radius: 8px; max-width: 100%; margin: 0 auto; box-shadow: 0 4px 15px rgba(0,0,0,0.05); font-family: Arial, sans-serif;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px;">
        <h2 style="color: #d32f2f; margin: 0;">Danh Sách Hợp Đồng Chuyển Nhượng</h2>
        <a href="/admin/hopdongchuyennhuong/create" style="background: #28a745; color: white; padding: 10px 18px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s; box-shadow: 0 2px 5px rgba(40,167,69,0.3);">
            + Lập HĐ Chuyển Nhượng
        </a> 
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr>
                    <th style="background-color: #d32f2f; color: white; border: 1px solid #ddd; padding: 15px; text-align: left; white-space: nowrap;">Mã HĐ</th>
                    <th style="background-color: #d32f2f; color: white; border: 1px solid #ddd; padding: 15px; text-align: left;">Người Mua</th>
                    <th style="background-color: #d32f2f; color: white; border: 1px solid #ddd; padding: 15px; text-align: left;">Tài sản (BĐS)</th>
                    <th style="background-color: #d32f2f; color: white; border: 1px solid #ddd; padding: 15px; text-align: right;">Giá Chốt</th>
                    <th style="background-color: #d32f2f; color: white; border: 1px solid #ddd; padding: 15px; text-align: center;">Ngày Lập</th>
                    <th style="background-color: #d32f2f; color: white; border: 1px solid #ddd; padding: 15px; text-align: center;">Pháp lý</th>
                    <th style="background-color: #d32f2f; color: white; border: 1px solid #ddd; padding: 15px; text-align: center; white-space: nowrap;">Tác vụ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($danhsachHD as $hd)
                <tr style="transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                    <td style="border: 1px solid #ddd; padding: 15px; color: #333;"><b>CN-{{ $hd->cnid }}</b></td>
                    <td style="border: 1px solid #ddd; padding: 15px; color: #0056b3;"><b>{{ $hd->hoten }}</b></td>
                    <td style="border: 1px solid #ddd; padding: 15px; color: #555;">{{ $hd->tenduong }}, {{ $hd->quan }}</td>
                    <td style="border: 1px solid #ddd; padding: 15px; color: #d32f2f; font-weight: bold; text-align: right;">{{ number_format($hd->giatri) }} đ</td>
                    <td style="border: 1px solid #ddd; padding: 15px; text-align: center;">{{ \Carbon\Carbon::parse($hd->ngaylap)->format('d/m/Y') }}</td>
                    <td style="border: 1px solid #ddd; padding: 15px; text-align: center;">
                        <span style="background: #17a2b8; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; white-space: nowrap;">✓ Đã Công Chứng</span>
                    </td>
                    <td style="border: 1px solid #ddd; padding: 15px; text-align: center; white-space: nowrap;">
                        <a href="/admin/hopdongchuyennhuong/edit/{{ $hd->cnid }}" style="background: #ffc107; color: #333; padding: 8px 12px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px; margin-right: 5px;">✏️ Sửa</a>
                        <a href="/admin/hopdongchuyennhuong/print/{{ $hd->cnid }}" target="_blank" style="background: #28a745; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px; display: inline-block;">🖨️ In Hợp Đồng</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 30px; text-align: center; color: #999; font-style: italic; border: 1px solid #ddd;">Chưa có hợp đồng chuyển nhượng nào được lập.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection