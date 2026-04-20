<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DatCocService
{
    // Lấy danh sách HĐ Đặt cọc (Kèm tên khách hàng và tên đường BĐS)
    public function getDanhSach()
    {
        return DB::table('hopdongdatcoc')
            ->leftJoin('khachhang', 'hopdongdatcoc.khid', '=', 'khachhang.khid')
            ->leftJoin('batdongsan', 'hopdongdatcoc.bdsid', '=', 'batdongsan.bdsid')
            ->select('hopdongdatcoc.*', 'khachhang.hoten', 'batdongsan.tenduong')
            ->get();
    }

    // Lưu hợp đồng Đặt cọc mới
    public function taoMoi($data)
    {
        $maxId = DB::table('hopdongdatcoc')->max('dcid');
        $newId = $maxId ? $maxId + 1 : 1;

        return DB::table('hopdongdatcoc')->insert([
            'dcid'        => $newId,
            'khid'        => $data['khid'],
            'bdsid'       => $data['bdsid'],
            'giatri'      => $data['giatri'],
            'ngaylap'     => $data['ngaylap'],
            'ngayhethan'  => $data['ngayhethan'],
            'tinhtrang'   => 1, // 1: Đang có hiệu lực
            'trangthai'   => 1
        ]);
    }

    // Xóa hợp đồng
    public function xoa($id)
    {
        return DB::table('hopdongdatcoc')->where('dcid', $id)->delete();
    }
}