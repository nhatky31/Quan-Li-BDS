<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KhachHangController extends Controller
{
    // 1. Hiển thị danh sách khách hàng
   public function index()
    {
        if (!Session::has('nvid')) return redirect('/login');

        $danhsachKH = DB::table('khachhang')->get();

        return view('admin.khachhang.index', ['danhsachKH' => $danhsachKH]);
    }

    // 2. Mở form Thêm mới
    public function create()
    {
        if (!Session::has('nvid')) return redirect('/login');
        return view('admin.khachhang.create');
    }

    // 3. Xử lý lưu dữ liệu vào Database
    public function store(Request $request)
    {
        // --- CHỐT CHẶN KIỂM TRA DỮ LIỆU (VALIDATION) ---
      $request->validate([
            'hoten'       => ['required', 'string', 'max:255'],
            // Thêm luật unique:tên_bảng,tên_cột để chống trùng lặp SDT và CMND
            'sodienthoai' => ['required', 'regex:/^0[0-9]{9,10}$/', 'unique:khachhang,sodienthoai'], 
            'cmnd'        => ['nullable', 'regex:/^([0-9]{9}|[0-9]{12})$/', 'unique:khachhang,cmnd'], 
            'diachi'      => ['nullable', 'string', 'max:255']
        ], [
            // Thông báo lỗi tiếng Việt
            'hoten.required'       => 'Vui lòng không bỏ trống Họ và tên.',
            'sodienthoai.required' => 'Vui lòng không bỏ trống Số điện thoại.',
            'sodienthoai.regex'    => 'Số điện thoại phải bắt đầu bằng số 0 và bao gồm 10 hoặc 11 chữ số.',
            'sodienthoai.unique'   => 'Số điện thoại này đã được đăng ký cho một khách hàng khác!', // Cảnh báo trùng SDT
            'cmnd.regex'           => 'CMND/CCCD phải bao gồm đúng 9 hoặc 12 chữ số.',
            'cmnd.unique'          => 'Số CMND/CCCD này đã tồn tại trong hệ thống!', // Cảnh báo trùng CCCD
        ]);
       
        // Tự động tăng ID
        $maxId = DB::table('khachhang')->max('khid');
        $newId = $maxId ? $maxId + 1 : 1;

        // Lưu vào CSDL
        DB::table('khachhang')->insert([
            'khid'        => $newId,
            'nvid'        => Session::get('nvid'), 
            'hoten'       => $request->input('hoten'),
            'sodienthoai' => $request->input('sodienthoai'),
            'cmnd'        => $request->input('cmnd'),
            'diachi'      => $request->input('diachi'),
            'trangthai'   => 1 
        ]);

        return redirect('/admin/khachhang');
    }
    // 4. Mở form Sửa
    public function edit($id)
    {
        if (!Session::has('nvid')) return redirect('/login');
        
        // Lấy thông tin khách hàng theo khid
        $kh = DB::table('khachhang')->where('khid', $id)->first();
        
        return view('admin.khachhang.edit', ['kh' => $kh]);
    }

    // 5. Xử lý cập nhật
    public function update(Request $request, $id)
    {
        // Kiểm tra dữ liệu (Lưu ý: Phải cho phép trùng SĐT/CMND của CHÍNH khách hàng này)
        $request->validate([
            'hoten'       => ['required', 'string', 'max:255'],
            'sodienthoai' => ['required', 'regex:/^0[0-9]{9,10}$/', 'unique:khachhang,sodienthoai,'.$id.',khid'], 
            'cmnd'        => ['nullable', 'regex:/^([0-9]{9}|[0-9]{12})$/', 'unique:khachhang,cmnd,'.$id.',khid'], 
            'diachi'      => ['nullable', 'string', 'max:255']
        ], [
            'hoten.required'       => 'Vui lòng không bỏ trống Họ và tên.',
            'sodienthoai.required' => 'Vui lòng không bỏ trống Số điện thoại.',
            'sodienthoai.regex'    => 'Số điện thoại phải bắt đầu bằng 0 và có 10-11 số.',
            'sodienthoai.unique'   => 'Số điện thoại này đã thuộc về khách hàng khác!',
            'cmnd.regex'           => 'CMND/CCCD phải có đúng 9 hoặc 12 số.',
            'cmnd.unique'          => 'Số CMND/CCCD này đã bị trùng!',
        ]);

        DB::table('khachhang')->where('khid', $id)->update([
            'hoten'       => $request->input('hoten'),
            'sodienthoai' => $request->input('sodienthoai'),
            'cmnd'        => $request->input('cmnd'),
            'diachi'      => $request->input('diachi')
        ]);

        return redirect('/admin/khachhang');
    }

    // 6. Xử lý Xóa mềm (Chỉ đổi trạng thái)
    public function delete($id)
    {
        // Chuyển trạng thái về 0 (Ngừng giao dịch) thay vì xóa hẳn
        DB::table('khachhang')->where('khid', $id)->update([
            'trangthai' => 0
        ]);
        
        return redirect('/admin/khachhang');
    }
}