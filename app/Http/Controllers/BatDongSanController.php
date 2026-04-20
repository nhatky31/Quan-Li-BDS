<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Services\BatDongSanService;

class BatDongSanController extends Controller
{
    protected $bdsService;

    public function __construct(BatDongSanService $bdsService)
    {
        $this->bdsService = $bdsService;
    }

    public function index(Request $request)
    {
        if (!Session::has('nvid')) return redirect('/login');

        // Gọi Service (Bước 3 sơ đồ)
        $danhsachBDS = $this->bdsService->getDanhSach($request->all());

        return view('admin.batdongsan.index', ['danhsachBDS' => $danhsachBDS]);
    }

    public function show($id)
    {
        if (!Session::has('nvid')) return redirect('/login');

        // Gọi Service (Bước 55 sơ đồ)
        $bds = $this->bdsService->getChiTiet($id);

        return view('admin.batdongsan.show', ['bds' => $bds]);
    }

    public function create()
    {
        if (!Session::has('nvid')) return redirect('/login');
        
        $danhsachKH = DB::table('khachhang')->where('trangthai', 1)->get();
        $danhsachLoai = DB::table('loaibds')->get();

        return view('admin.batdongsan.create', [
            'danhsachKH' => $danhsachKH,
            'danhsachLoai' => $danhsachLoai
        ]);
    }

    public function store(Request $request)
    {
        // Validation giữ nguyên logic của bạn
        $request->validate([
            'khid' => 'required',
            'dongia' => 'required|numeric|min:1000000',
            'dientich' => 'required|numeric|min:10',
        ]);

        $hinhanhData = null;
        if ($request->hasFile('hinhanh')) {
            $hinhanhData = base64_encode(file_get_contents($request->file('hinhanh')->getRealPath()));
        }

        // Gọi Service lưu (Bước 19 sơ đồ)
        $this->bdsService->taoMoi($request->all(), $hinhanhData);

        return redirect('/admin/batdongsan');
    }

    public function delete($id)
    {
        if (!Session::has('nvid')) return redirect('/login');
        $this->bdsService->xoa($id);
        return redirect('/admin/batdongsan');
    }
   public function edit($id)
    {
        // 1. Lấy thông tin BĐS hiện tại
        $bds = DB::table('batdongsan')->where('bdsid', $id)->first();

        // LOGIC BẢO MẬT: Đã bán (tinhtrang = 0) thì đuổi ra ngoài
        if (!$bds || $bds->tinhtrang == 0) {
            return redirect('/admin/batdongsan')->withErrors(['Lỗi bảo mật: Bất động sản này đã giao dịch, không thể sửa đổi!']);
        }

        // 2. Lấy thêm Danh sách Khách hàng và Loại BĐS để đổ vào ô Dropdown (Select)
        $danhsachKH = DB::table('khachhang')->get();
        
        // *Lưu ý: Bạn kiểm tra lại xem bảng loại BĐS trong Database của bạn tên là 'loaibds' hay 'loai' để sửa cho đúng nhé, ở đây mình tạm để là 'loaibds'
        $danhsachLoai = DB::table('loaibds')->get(); 

        // 3. Gửi tất cả 3 biến này sang View
        return view('admin.batdongsan.edit', [
            'bds' => $bds,
            'danhsachKH' => $danhsachKH,
            'danhsachLoai' => $danhsachLoai
        ]);
    }
    // Lưu thông tin Sửa
   public function update(Request $request, $id)
    {
        // 1. Kiểm tra lại lần nữa cho chắc (phòng người dùng cố tình đổi link)
        $bds = DB::table('batdongsan')->where('bdsid', $id)->first();
        if (!$bds || $bds->tinhtrang == 0) {
            return redirect('/admin/batdongsan')->withErrors(['Lỗi bảo mật: Bất động sản này đã giao dịch, không thể sửa đổi!']);
        }

        // 2. Gom tất cả dữ liệu từ Form (Đã bổ sung đầy đủ Diện tích, Loại, Khách hàng...)
        $dataUpdate = [
            'khid' => $request->khid,
            'loaiid' => $request->loaiid,
            'dientich' => $request->dientich, 
            'dongia' => $request->dongia,
            'tenduong' => $request->tenduong,
            'quan' => $request->quan
        ];

        // 3. Xử lý Hình ảnh (Đã sửa lại thành chuẩn Base64 an toàn)
        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            // Dùng hàm base64_encode BỌC BÊN NGOÀI để biến ảnh thành chuỗi chữ
            $dataUpdate['hinhanh'] = base64_encode(file_get_contents($file->getRealPath()));
        }

        // 4. Lưu toàn bộ vào Database
        DB::table('batdongsan')->where('bdsid', $id)->update($dataUpdate);

        return redirect('/admin/batdongsan')->with('success', 'Đã cập nhật Bất động sản thành công!');
    }
}