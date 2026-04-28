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

    // 1. Hiển thị danh sách BĐS
    public function index(Request $request)
    {
        if (!Session::has('nvid')) return redirect('/login');

        $danhsachBDS = $this->bdsService->getDanhSach($request->all());

        return view('admin.batdongsan.index', ['danhsachBDS' => $danhsachBDS]);
    }

    // 2. Xem chi tiết BĐS
    public function show($id)
    {
        if (!Session::has('nvid')) return redirect('/login');

        $bds = $this->bdsService->getChiTiet($id);

        return view('admin.batdongsan.show', ['bds' => $bds]);
    }

    // 3. Mở form thêm mới
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

    // 4. Xử lý lưu mới
    public function store(Request $request)
    {
        $request->validate([
            'khid' => 'required',
            'dongia' => 'required|numeric|min:1000000',
            'dientich' => 'required|numeric|min:10',
        ]);

        $hinhanhData = null;
        if ($request->hasFile('hinhanh')) {
            $hinhanhData = base64_encode(file_get_contents($request->file('hinhanh')->getRealPath()));
        }

        $this->bdsService->taoMoi($request->all(), $hinhanhData);

        return redirect('/admin/batdongsan')->with('success', 'Thêm Bất động sản thành công!');
    }

    // 5. Mở form chỉnh sửa
    public function edit($id)
    {
        if (!Session::has('nvid')) return redirect('/login');

        $bds = DB::table('batdongsan')->where('bdsid', $id)->first();

        // CHẶN: Đã bán thì không cho sửa
        if (!$bds || $bds->tinhtrang == 0) {
            return redirect('/admin/batdongsan')->withErrors(['Lỗi: BĐS này đã giao dịch thành công, không thể chỉnh sửa!']);
        }

        $danhsachKH = DB::table('khachhang')->get();
        $danhsachLoai = DB::table('loaibds')->get(); 

        return view('admin.batdongsan.edit', [
            'bds' => $bds,
            'danhsachKH' => $danhsachKH,
            'danhsachLoai' => $danhsachLoai
        ]);
    }

    // 6. Cập nhật dữ liệu
    public function update(Request $request, $id)
    {
        $bds = DB::table('batdongsan')->where('bdsid', $id)->first();
        if (!$bds || $bds->tinhtrang == 0) {
            return redirect('/admin/batdongsan')->withErrors(['Lỗi bảo mật: Không thể sửa BĐS đã bán!']);
        }

        $dataUpdate = [
            'khid' => $request->khid,
            'loaiid' => $request->loaiid,
            'dientich' => $request->dientich, 
            'dongia' => $request->dongia,
            'tenduong' => $request->tenduong,
            'quan' => $request->quan
        ];

        if ($request->hasFile('hinhanh')) {
            $dataUpdate['hinhanh'] = base64_encode(file_get_contents($request->file('hinhanh')->getRealPath()));
        }

        DB::table('batdongsan')->where('bdsid', $id)->update($dataUpdate);

        return redirect('/admin/batdongsan')->with('success', 'Cập nhật thành công!');
    }

    // 7. Xử lý xóa (Có bọc Try-Catch để bắt lỗi ràng buộc từ Service)
    public function delete($id)
    {
        if (!Session::has('nvid')) return redirect('/login');
        
        try {
            $this->bdsService->xoa($id);
            return redirect('/admin/batdongsan')->with('success', 'Đã xóa Bất động sản khỏi hệ thống!');
        } catch (\Exception $e) {
            // Hiển thị lỗi đỏ nếu BĐS đã có hợp đồng
            return redirect('/admin/batdongsan')->withErrors([$e->getMessage()]);
        }
    }
}