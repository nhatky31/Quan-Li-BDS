<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Hiển thị giao diện đăng nhập
    public function showLoginForm()
    {
        // Nếu đã đăng nhập rồi thì chặn không cho vào form login nữa
        if (Session::has('nvid')) {
            return redirect('/admin/dashboard');
        }
        return view('login');
    }

    // Xử lý dữ liệu khi bấm nút Đăng nhập
    public function processLogin(Request $request)
    {
        // 1. Lấy dữ liệu từ form
        $taikhoan = $request->input('taikhoan');
        $matkhau = $request->input('matkhau');

        // 2. Tìm trong Database xem có nhân viên này không
        $user = DB::table('nhanvien')
            ->where('taikhoan', $taikhoan)
            ->where('matkhau', $matkhau)
            ->first();

        // 3. Kiểm tra kết quả
        if ($user) {
            // Kiểm tra nhân viên có bị khóa không (trangthai = 1 là hoạt động)
            if ($user->trangthai == 1) {
                // Lưu vào Session giống hệt cách làm PHP thuần
                Session::put('nvid', $user->nvid);
                Session::put('tennv', $user->tennv);
                Session::put('quyen', $user->quyen);

                return redirect('/admin/dashboard');
            } else {
                return back()->with('error', 'Tài khoản của bạn đã bị khóa!');
            }
        } else {
            return back()->with('error', 'Tài khoản hoặc mật khẩu không đúng!');
        }
    }

   public function dashboard()
    {
        // Nhớ thêm dòng use Illuminate\Support\Facades\DB; ở đầu file nếu chưa có
        if (!Session::has('nvid')) return redirect('/login');

        // Đếm số lượng thật từ Database
        $tongKhachHang = DB::table('khachhang')->count();
        $tongBDS = DB::table('batdongsan')->where('tinhtrang', 1)->count(); // Chỉ đếm nhà đang trống
        $tongHD = DB::table('hopdongchuyennhuong')->count();

        // Ném dữ liệu sang Giao diện
        return view('admin.dashboard', [
            'tongKhachHang' => $tongKhachHang,
            'tongBDS' => $tongBDS,
            'tongHD' => $tongHD
        ]);
    }
    public function logout()
    {
        // Xóa "thẻ nhân viên" (nvid) khỏi bộ nhớ Session
        Session::forget('nvid');
        
        // (Tùy chọn) Nếu muốn xóa sạch sành sanh mọi dữ liệu phiên làm việc thì dùng:
        // Session::flush();

        // Đá người dùng về lại trang Đăng nhập
        return redirect('/login');
    }
}