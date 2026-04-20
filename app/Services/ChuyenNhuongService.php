<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ChuyenNhuongService
{
    public function getDanhSach()
    {
        return DB::table('hopdongchuyennhuong')
            ->leftJoin('khachhang', 'hopdongchuyennhuong.khid', '=', 'khachhang.khid')
            ->leftJoin('batdongsan', 'hopdongchuyennhuong.bdsid', '=', 'batdongsan.bdsid')
            ->select(
                'hopdongchuyennhuong.*', 
                'khachhang.hoten', 
                'batdongsan.tenduong', 
                'batdongsan.quan'
            )
            ->get();
    }

    public function getDanhSachDatCocChuaBan()
    {
        return DB::table('hopdongdatcoc')
            ->join('khachhang', 'hopdongdatcoc.khid', '=', 'khachhang.khid')
            ->where('hopdongdatcoc.tinhtrang', 1) 
            ->select('hopdongdatcoc.*', 'khachhang.hoten') 
            ->get();
    }

    public function taoHopDongMoi($data)
    {
        $maxId = DB::table('hopdongchuyennhuong')->max('cnid');
        $newId = $maxId ? $maxId + 1 : 1;

        // 1. Lưu vào bảng chuyển nhượng (ĐÃ BỔ SUNG NVID)
        DB::table('hopdongchuyennhuong')->insert([
            'cnid'      => $newId,
            'khid'      => $data['khid'],
            'bdsid'     => $data['bdsid'],
            'dcid'      => isset($data['dcid']) ? $data['dcid'] : null, 
            'giatri'    => $data['giatri'],
            'ngaylap'   => $data['ngaylap'],
            'trangthai' => 1,
            // ĐÂY CHÍNH LÀ DÒNG QUYẾT ĐỊNH DOANH THU CỦA NHÂN VIÊN:
            'nvid'      => $data['nvid'] 
        ]);

        // 2. Khóa BĐS (Đổi tình trạng Bất động sản thành Đã Bán)
        DB::table('batdongsan')->where('bdsid', $data['bdsid'])->update(['tinhtrang' => 0]);
        
        // 3. Cập nhật Hợp đồng Đặt Cọc (Đổi tình trạng thành Đã chuyển nhượng)
        if (isset($data['dcid']) && $data['dcid'] != null) {
            DB::table('hopdongdatcoc')->where('dcid', $data['dcid'])->update(['tinhtrang' => 0]);
        }

        return true; 
    }

    public function getChiTietHopDong($id)
    {
        return DB::table('hopdongchuyennhuong')
            ->leftJoin('khachhang', 'hopdongchuyennhuong.khid', '=', 'khachhang.khid')
            ->leftJoin('batdongsan', 'hopdongchuyennhuong.bdsid', '=', 'batdongsan.bdsid')
            ->where('hopdongchuyennhuong.cnid', $id)
            ->select(
                'hopdongchuyennhuong.*', 
                'khachhang.hoten', 
                'khachhang.cmnd', 
                'khachhang.diachi as diachi_kh',
                'batdongsan.tenduong', 
                'batdongsan.quan', 
                'batdongsan.dientich', 
                'batdongsan.masoqsdd'
            )
            ->first();
    }
}