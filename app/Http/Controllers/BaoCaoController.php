<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BaoCaoController extends Controller
{
    public function doanhThuNhanVien(Request $request)
    {
        // 1. Chặn bảo mật: Chỉ Admin (quyen = 1) mới được xem báo cáo
        if (Session::get('quyen') != 1) {
            return redirect('/admin/dashboard')->withErrors(['Lỗi: Bạn không có quyền truy cập trang Báo Cáo!']);
        }

        // 2. Lấy tháng và năm từ form lọc (Nếu chưa chọn thì lấy tháng/năm hiện tại)
        $thang = $request->thang ?? date('m');
        $nam = $request->nam ?? date('Y');

        // 3. Logic tính toán: Gom nhóm theo Nhân viên và tính tổng tiền
       $thongKe = DB::table('hopdongchuyennhuong')
            ->join('nhanvien', 'hopdongchuyennhuong.nvid', '=', 'nhanvien.nvid')
            ->join('batdongsan', 'hopdongchuyennhuong.bdsid', '=', 'batdongsan.bdsid')
            ->whereMonth('hopdongchuyennhuong.ngaylap', $thang)
            ->whereYear('hopdongchuyennhuong.ngaylap', $nam)
            ->select(
                'nhanvien.nvid', 
                'nhanvien.tennv', 
                DB::raw('COUNT(hopdongchuyennhuong.cnid) as so_hop_dong_chot'),
                DB::raw('SUM(hopdongchuyennhuong.giatri) as tong_tien_mang_ve'), // Đây là Tổng giá trị nhà
                // Tính tổng hoa hồng (nếu DB huehong rỗng thì lấy 1% giá trị nhà)
                DB::raw('SUM(COALESCE(batdongsan.huehong, hopdongchuyennhuong.giatri * 0.01)) as tong_hoa_hong') 
            )
            ->groupBy('nhanvien.nvid', 'nhanvien.tennv')
            ->orderBy('tong_tien_mang_ve', 'DESC')
            ->get();

        // 4. Trả về giao diện kèm dữ liệu
        return view('admin.baocao.doanhthu', compact('thongKe', 'thang', 'nam'));
    }
}