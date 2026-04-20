<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Services\ChuyenNhuongService; 
use Barryvdh\DomPDF\Facade\Pdf; 

class HopDongChuyenNhuongController extends Controller
{
    protected $chuyenNhuongService;

    public function __construct(ChuyenNhuongService $chuyenNhuongService)
    {
        $this->chuyenNhuongService = $chuyenNhuongService;
    }

    public function index()
    {
        if (!Session::has('nvid')) return redirect('/login');

        $danhsachHD = $this->chuyenNhuongService->getDanhSach();

        return view('admin.hopdongchuyennhuong.index', ['danhsachHD' => $danhsachHD]);
    }

    public function create()
    {
        if (!Session::has('nvid')) return redirect('/login');

        $danhsachKH = DB::table('khachhang')->get();
        // Chỉ lấy BĐS đang trống (tinhtrang = 1)
        $danhsachBDS = DB::table('batdongsan')->where('tinhtrang', 1)->get();
        $danhsachDatCoc = $this->chuyenNhuongService->getDanhSachDatCocChuaBan();

        return view('admin.hopdongchuyennhuong.create', [
            'danhsachDatCoc' => $danhsachDatCoc,
            'danhsachKH' => $danhsachKH,
            'danhsachBDS' => $danhsachBDS
        ]);
    }

    public function store(Request $request)
    {
        // 1. Kiểm tra định dạng cơ bản
        $request->validate([
            'khid' => 'required',
            'bdsid' => 'required',
            'giatri' => 'required|numeric|min:1000000' 
        ], [
            'giatri.min' => 'Giá trị chuyển nhượng phải từ 1,000,000 VNĐ trở lên.'
        ]);

        // KIỂM TRA TRANH CHẤP GIAO DỊCH
        $dangCoCoc = DB::table('hopdongdatcoc')
            ->where('bdsid', $request->bdsid)
            ->where('tinhtrang', 1) 
            ->first();

        if ($dangCoCoc) {
            if ($request->khid != $dangCoCoc->khid) {
                return back()->withErrors([
                    'bdsid' => 'Căn hộ này đã được khách hàng ' . 
                               DB::table('khachhang')->where('khid', $dangCoCoc->khid)->value('hoten') . 
                               ' đặt cọc. Không thể bán cho người khác!'
                ])->withInput();
            }
        }

        // 2. Kiểm tra giá trị so với tiền cọc
        if ($request->has('dcid') && $request->dcid != '') {
            $hopDongCoc = DB::table('hopdongdatcoc')->where('dcid', $request->dcid)->first();
            
            if ($hopDongCoc) {
                if ($request->giatri < $hopDongCoc->giatri) {
                    return back()->withErrors([
                        'giatri' => 'Giá chốt chuyển nhượng không được nhỏ hơn số tiền khách đã đặt cọc (' . number_format($hopDongCoc->giatri) . ' đ).'
                    ])->withInput();
                }
            }
        }

        // 3. Ghi nhận thêm nvid vào request trước khi gửi qua Service
        $data = $request->all();
        $data['nvid'] = Session::get('nvid');

        // LƯU HỢP ĐỒNG CHUYỂN NHƯỢNG VÀO CSDL
        $this->chuyenNhuongService->taoHopDongMoi($data);

        // =================================================================
        // 4. RÀNG BUỘC TỰ ĐỘNG (BẠN ĐANG THIẾU ĐOẠN NÀY)
        // =================================================================
        // 4.1 Khóa căn nhà lại (Đổi tình trạng thành Đã bán = 0)
        DB::table('batdongsan')->where('bdsid', $request->bdsid)->update(['tinhtrang' => 0]);

        // 4.2 Đóng Hợp đồng Ký gửi của căn nhà này (Thành công = 0)
        DB::table('hopdongkygui')->where('bdsid', $request->bdsid)->where('trangthai', 1)->update(['trangthai' => 0]);

        // 4.3 CỘNG HOA HỒNG VÀO TÀI KHOẢN NHÂN VIÊN
        // Tìm BĐS vừa bán để lấy mức Huê hồng
        $bds = DB::table('batdongsan')->where('bdsid', $request->bdsid)->first();
        
        // Nếu trong DB có nhập huê hồng thì lấy, nếu để trống thì mặc định cho nhân viên 1% giá trị hợp đồng
        $tienHoaHong = $bds->huehong ?? ($request->giatri * 0.01); 

        // Cộng dồn tiền hoa hồng vào cột 'doanhthu' của nhân viên đang đăng nhập
        DB::table('nhanvien')
            ->where('nvid', Session::get('nvid'))
            ->increment('doanhthu', $tienHoaHong);
        // =================================================================
        return redirect('/admin/hopdongchuyennhuong')->with('success', 'Thêm hợp đồng thành công!');
    }

    public function printPDF($id)
    {
        if (!Session::has('nvid')) return redirect('/login');

        $hopdong = $this->chuyenNhuongService->getChiTietHopDong($id);

        if (!$hopdong) {
            return redirect('/admin/hopdongchuyennhuong')->with('error', 'Không tìm thấy hợp đồng');
        }

        $pdf = Pdf::loadView('admin.pdf.hopdong_that', ['hopdong' => $hopdong]);
        return $pdf->stream('HopDong_ChuyenNhuong_'.$id.'.pdf'); 
    }

    public function edit($id)
    {
        if (!Session::has('nvid')) return redirect('/login');

        $hopdong = DB::table('hopdongchuyennhuong')
            ->join('khachhang', 'hopdongchuyennhuong.khid', '=', 'khachhang.khid')
            ->join('batdongsan', 'hopdongchuyennhuong.bdsid', '=', 'batdongsan.bdsid')
            ->where('cnid', $id)
            ->select('hopdongchuyennhuong.*', 'khachhang.hoten', 'batdongsan.tenduong', 'batdongsan.quan')
            ->first();

        if (!$hopdong) {
            return redirect('/admin/hopdongchuyennhuong')->with('error', 'Hợp đồng không tồn tại!');
        }

        return view('admin.hopdongchuyennhuong.edit', ['hopdong' => $hopdong]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'giatri' => 'required|numeric|min:1000000',
            'ngaylap' => 'required|date'
        ]);

        // SỬA LỖI: Dùng update thay vì insert và thêm điều kiện where
        DB::table('hopdongchuyennhuong')
            ->where('cnid', $id)
            ->update([
                'giatri' => $request->giatri,
                'ngaylap' => $request->ngaylap,
                'trangthai' => $request->trangthai ?? 1,
                // Ghi nhận nhân viên cuối cùng chỉnh sửa
                'nvid' => Session::get('nvid') 
            ]);

        return redirect('/admin/hopdongchuyennhuong')->with('success', 'Đã cập nhật lại thông tin Hợp đồng!');
    }
}