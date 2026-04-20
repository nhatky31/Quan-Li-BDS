<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class HopDongKyGuiController extends Controller
{
   public function index()
    {
        if (!Session::has('nvid')) return redirect('/login');

        // Đổi "join" thành "leftJoin" để hợp đồng LUÔN HIỆN ra
        $danhsachHD = DB::table('hopdongkygui')
            ->leftJoin('khachhang', 'hopdongkygui.khid', '=', 'khachhang.khid')
            ->leftJoin('batdongsan', 'hopdongkygui.bdsid', '=', 'batdongsan.bdsid')
            ->select('hopdongkygui.*', 'khachhang.hoten', 'batdongsan.tenduong', 'batdongsan.quan')
            ->get();

        return view('admin.hopdongkygui.index', ['danhsachHD' => $danhsachHD]);
    }

    // 2. Mở form Thêm Hợp đồng mới
    public function create()
    {
        if (!Session::has('nvid')) return redirect('/login');

        $danhsachKH = DB::table('khachhang')->where('trangthai', 1)->get();
        // Lấy danh sách BĐS kèm tên khách hàng để Dropdown hiển thị rõ ràng
        $danhsachBDS = DB::table('batdongsan')
            ->join('khachhang', 'batdongsan.khid', '=', 'khachhang.khid')
            ->select('batdongsan.*', 'khachhang.hoten')
            ->get();

        return view('admin.hopdongkygui.create', [
            'danhsachKH' => $danhsachKH,
            'danhsachBDS' => $danhsachBDS
        ]);
    }

    // 3. Xử lý lưu Hợp đồng
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu (Chú ý điều kiện ngày tháng)
        $request->validate([
            'khid'        => 'required',
            'bdsid'       => 'required',
            'giatri'      => ['required', 'numeric', 'min:1000000'],
            'chiphidv'    => ['required', 'numeric', 'min:0'],
            'ngaybd'      => 'required|date',
            // after:ngaybd đảm bảo Ngày kết thúc phải sau Ngày bắt đầu
            'ngayketthuc' => 'required|date|after:ngaybd' 
        ], [
            'khid.required'        => 'Vui lòng chọn Khách hàng.',
            'bdsid.required'       => 'Vui lòng chọn Bất động sản.',
            'giatri.min'           => 'Giá trị hợp đồng tối thiểu 1,000,000 VNĐ.',
            'chiphidv.min'         => 'Chi phí dịch vụ không được âm.',
            'ngaybd.required'      => 'Vui lòng chọn ngày bắt đầu.',
            'ngayketthuc.after'    => 'Ngày kết thúc phải LỚN HƠN ngày bắt đầu!'
        ]);

        // Tự động tăng ID cho Hợp đồng (kgid)
        $maxId = DB::table('hopdongkygui')->max('kgid');
        $newId = $maxId ? $maxId + 1 : 1;

        // Lưu dữ liệu vào CSDL (Khớp 100% với ảnh bạn chụp)
        DB::table('hopdongkygui')->insert([
            'kgid'        => $newId,
            'khid'        => $request->input('khid'),
            'bdsid'       => $request->input('bdsid'),
            'giatri'      => $request->input('giatri'),
            'chiphidv'    => $request->input('chiphidv'),
            'ngaybd'      => $request->input('ngaybd'),
            'ngayketthuc' => $request->input('ngayketthuc'),
             'nvid' => Session::get('nvid') ,
            'trangthai'   => 1 // 1: Hợp đồng đang có hiệu lực

        ]);

        return redirect('/admin/hopdongkygui');
    }
    // In PDF Hợp đồng Ký gửi
    public function inPDF($id)
    {
        // 1. Tìm đúng cái hợp đồng khách vừa bấm
        $hd = DB::table('hopdongkygui')
            ->leftJoin('khachhang', 'hopdongkygui.khid', '=', 'khachhang.khid')
            ->leftJoin('batdongsan', 'hopdongkygui.bdsid', '=', 'batdongsan.bdsid')
            ->where('hopdongkygui.kgid', $id)
            ->select('hopdongkygui.*', 'khachhang.hoten', 'khachhang.sodienthoai', 'khachhang.diachi', 'batdongsan.tenduong', 'batdongsan.quan')
            ->first();

        // 2. Nạp dữ liệu thật vào Giao diện PDF và tải về
        $pdf = Pdf::loadView('admin.pdf.hopdong_that', ['hd' => $hd]);
        
        // stream() là xem trực tiếp trên web, nếu muốn tải về luôn thì đổi thành download()
        return $pdf->stream('Hop-Dong-Ky-Gui-'.$id.'.pdf'); 
    }
}