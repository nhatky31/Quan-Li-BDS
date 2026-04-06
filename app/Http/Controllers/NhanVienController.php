<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class NhanVienController extends Controller
{
    public function index()
    {
        // Phải đăng nhập mới được xem
        if (!Session::has('nvid')) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập trước!');
        }
 
        $danhsachNV = DB::table('nhanvien')->get();

        return view('admin.nhanvien.index', ['danhsachNV' => $danhsachNV]);
    }
    // Hiển thị Form thêm nhân viên
    public function create()
    {
        if (!Session::has('nvid')) return redirect('/login');
        return view('admin.nhanvien.create');
    }

    // Xử lý lưu dữ liệu
    public function store(Request $request)
    {
        
        $maxId = DB::table('nhanvien')->max('nvid');
        $newId = $maxId ? $maxId + 1 : 1;

       DB::table('nhanvien')->insert([
            'nvid'      => $newId,
            'taikhoan'  => $request->input('taikhoan'),
            'matkhau'   => $request->input('matkhau'),
            'tennv'     => $request->input('tennv'),
            'sdt'       => $request->input('sdt'),
            'gioitinh'  => $request->input('gioitinh'),
            'quyen'     => DB::raw( (int) $request->input('quyen') ),
            'trangthai' => DB::raw( (int) $request->input('trangthai') ),
            'doanhthu'  => 0 
        ]);

        
        return redirect('/admin/nhanvien');
    }
    public function edit($id)
    {
        if (!Session::has('nvid')) return redirect('/login');
        
        
        $nv = DB::table('nhanvien')->where('nvid', $id)->first();
        
        return view('admin.nhanvien.edit', ['nv' => $nv]);
    }
    public function update(Request $request, $id)
    {
        DB::table('nhanvien')->where('nvid', $id)->update([
            'taikhoan'  => $request->input('taikhoan'),
            'matkhau'   => $request->input('matkhau'),
            'tennv'     => $request->input('tennv'),
            'sdt'       => $request->input('sdt'),
            'gioitinh'  => $request->input('gioitinh'),
            'quyen'     => DB::raw( (int) $request->input('quyen') ),
            'trangthai' => DB::raw( (int) $request->input('trangthai') )
        ]);

        return redirect('/admin/nhanvien');
    }
    public function delete($id)
    {
        try {
            // Thử xóa hẳn nhân viên khỏi cơ sở dữ liệu
            DB::table('nhanvien')->where('nvid', $id)->delete();
        } catch (\Exception $e) {
            // Nếu nhân viên này đã từng lập khách hàng/hợp đồng (dính khóa ngoại CSDL) thì không thể xóa hẳn.
            // Thay vào đó, ta sẽ chuyển trạng thái của họ thành 0 (Khóa tài khoản) - gọi là Xóa mềm.
            DB::table('nhanvien')->where('nvid', $id)->update([
                'trangthai' => DB::raw(0)
            ]);
        }
        
        return redirect('/admin/nhanvien');
    }
    // Chức năng xuất PDF Hợp đồng mẫu
    public function inHopDongPDF()
    {
        // 1 dữ liệu giả để test (Sau này Thành viên 3 sẽ thay bằng dữ liệu lấy từ DB)
        $duLieuHopDong = [
            'ma_hd'     => 'HD-KG-2026-001',
            'ngay_lap'  => date('d/m/Y'),
            'khach_hang'=> 'Huỳnh Nhật Ký',
            'bds'       => 'Biệt thự khu đô thị Phú Mỹ Hưng',
            'gia_tri'   => '15,000,000,000 VNĐ'
        ];

        // 2. Gọi giao diện HTML và truyền dữ liệu vào để nó vẽ thành PDF
        $pdf = Pdf::loadView('admin.pdf.hopdong_mau', $duLieuHopDong);

        // 3. Tải file về máy (Nếu muốn xem trực tiếp trên web trước khi tải, hãy đổi ->download thành ->stream)
        return $pdf->stream('hop_dong_mau.pdf');
    }
}