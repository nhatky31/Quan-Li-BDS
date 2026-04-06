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

    // Giao diện trang chủ Admin
    public function dashboard()
    {
        // Kiểm tra xem có Session chưa (đã đăng nhập chưa)
        if (!Session::has('nvid')) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập trước!');
        }

        return view('admin.dashboard');
    }

    // Xử lý Đăng xuất
    public function logout()
    {
        Session::flush(); // Xóa sạch Session
        return redirect('/login');
    }
}