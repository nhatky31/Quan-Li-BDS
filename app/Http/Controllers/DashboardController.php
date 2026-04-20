<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
  public function index()
{
    // Lấy thông tin người đang đăng nhập từ Session
    $nvid_dang_nhap = Session::get('nvid');
    $quyen = Session::get('quyen'); // Giả sử 1 là Admin, 0 là Nhân viên

    // Khởi tạo các biến đếm chung
    $tongBDS = DB::table('batdongsan')->count();
    $tongKH = DB::table('khachhang')->count();
    
    if ($quyen == 1) {
        // ---------------------------------------------------
        // GÓC NHÌN ADMIN: Thấy toàn bộ công ty
        // ---------------------------------------------------
        $hopDongDaBan = DB::table('hopdongchuyennhuong')->count();
        // Cộng tổng giá trị của TẤT CẢ hợp đồng chuyển nhượng
        $tongDoanhThu = DB::table('hopdongchuyennhuong')->sum('giatri'); 
        
    } else {
        // ---------------------------------------------------
        // GÓC NHÌN NHÂN VIÊN: Chỉ thấy thành tích của chính mình
        // ---------------------------------------------------
        $hopDongDaBan = DB::table('hopdongchuyennhuong')
            ->where('nvid', $nvid_dang_nhap) // Lọc đúng hợp đồng do nhân viên này lập
            ->count();
            
        // Chỉ cộng tổng tiền các hợp đồng do nhân viên này chốt
        $tongDoanhThu = DB::table('hopdongchuyennhuong')
            ->where('nvid', $nvid_dang_nhap)
            ->sum('giatri');
    }

    return view('admin.dashboard', compact('tongBDS', 'tongKH', 'hopDongDaBan', 'tongDoanhThu'));
}
}