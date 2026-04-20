<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Services\DatCocService; // Gọi Service

class HopDongDatCocController extends Controller
{
    protected $datCocService;

    public function __construct(DatCocService $datCocService)
    {
        $this->datCocService = $datCocService;
    }

    // 1. Hiển thị danh sách
    public function index()
    {
        if (!Session::has('nvid')) return redirect('/login');

        $danhsachHD = $this->datCocService->getDanhSach();

        return view('admin.hopdongdatcoc.index', ['danhsachHD' => $danhsachHD]);
    }

    // 2. Mở form thêm mới
    public function create()
    {
        if (!Session::has('nvid')) return redirect('/login');

        // Lấy KH và BĐS đang trống
        $danhsachKH = DB::table('khachhang')->where('trangthai', 1)->get();
        $danhsachBDS = DB::table('batdongsan')->where('tinhtrang', 1)->get();

        return view('admin.hopdongdatcoc.create', [
            'danhsachKH' => $danhsachKH,
            'danhsachBDS' => $danhsachBDS
        ]);
    }

    // 3. Xử lý lưu
  public function store(Request $request)
    {
        // 1. Chỉ validate những gì người dùng nhập từ Form
        $request->validate([
            'khid' => 'required',
            'bdsid' => 'required',
            'giatri' => 'required|numeric',
            'ngaylap' => 'required|date',
            'ngayhethan' => 'required|date|after_or_equal:ngaylap',
        ]);

        // 2. Gom tất cả dữ liệu từ Form vào một biến
        $data = $request->all();
        
        // 3. Nhét thêm ID nhân viên từ Session vào mảng dữ liệu này
        $data['nvid'] = Session::get('nvid');

        // 4. Gửi cục dữ liệu (bây giờ đã chứa đầy đủ cả Form và nvid) sang Service để lưu
        $this->datCocService->taoMoi($data);

        // ==========================================
        // 5. ĐÂY CHÍNH LÀ DÒNG BẠN ĐANG BỊ THIẾU
        // ==========================================
        // Điều hướng quay lại trang danh sách và báo thành công
        return redirect('/admin/hopdongdatcoc')->with('success', 'Lập Hợp đồng Đặt cọc thành công!');
    }
   public function edit($id)
    {
        if (!Session::has('nvid')) return redirect('/login');

        $hopdong = DB::table('hopdongdatcoc')
            ->join('khachhang', 'hopdongdatcoc.khid', '=', 'khachhang.khid')
            ->join('batdongsan', 'hopdongdatcoc.bdsid', '=', 'batdongsan.bdsid')
            ->where('dcid', $id)
            ->select('hopdongdatcoc.*', 'khachhang.hoten', 'batdongsan.tenduong', 'batdongsan.quan')
            ->first();

        if (!$hopdong) {
            return redirect('/admin/hopdongdatcoc')->with('error', 'Không tìm thấy hợp đồng cọc!');
        }

        // ==========================================
        // KHỐI CODE BẢO MẬT MỚI THÊM VÀO:
        // Kiểm tra xem hợp đồng còn được phép sửa không
        $homNay = date('Y-m-d');
        if ($hopdong->tinhtrang == 0 || ($hopdong->tinhtrang == 1 && $hopdong->ngayhethan < $homNay)) {
            // Nếu đã chuyển nhượng (=0) hoặc đã hết hạn -> Đuổi về trang danh sách và báo lỗi
            return redirect('/admin/hopdongdatcoc')->withErrors([
                'Lỗi bảo mật: Không thể sửa Hợp đồng đã Hoàn tất hoặc Đã hủy!'
            ]);
        }
        // ==========================================

        return view('admin.hopdongdatcoc.edit', ['hopdong' => $hopdong]);
    }
    // Xử lý cập nhật dữ liệu vào Database
    public function update(Request $request, $id)
    {
        // 1. Kiểm tra tính hợp lệ của dữ liệu
        $request->validate([
            'giatri' => 'required|numeric|min:1000000',
            'ngaylap' => 'required|date',
            'ngayhethan' => 'required|date|after_or_equal:ngaylap' // Hạn chót không được nhỏ hơn ngày lập
        ], [
            'giatri.min' => 'Tiền cọc tối thiểu phải từ 1.000.000 VNĐ.',
            'ngayhethan.after_or_equal' => 'Vô lý! Ngày hết hạn cọc không thể diễn ra trước ngày lập hợp đồng.'
        ]);

        // 2. Cập nhật vào CSDL (Chỉ cập nhật Tiền và Ngày)
        DB::table('hopdongdatcoc')->where('dcid', $id)->update([
            'giatri' => $request->giatri,
            'ngaylap' => $request->ngaylap,
            'ngayhethan' => $request->ngayhethan
        ]);

        return redirect('/admin/hopdongdatcoc')->with('success', 'Đã cập nhật lại thông tin Đặt Cọc thành công!');
    }
}