<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class BatDongSanService
{
    // Lấy danh sách kèm bộ lọc (Bước 3 trong sơ đồ)
    public function getDanhSach($filters)
    {
        $query = DB::table('batdongsan')
            ->join('khachhang', 'batdongsan.khid', '=', 'khachhang.khid')
            ->select('batdongsan.*', 'khachhang.hoten');

        if (!empty($filters['khu_vuc'])) {
            $tukhoa = $filters['khu_vuc'];
            $query->where(function($q) use ($tukhoa) {
                $q->where('batdongsan.quan', 'like', '%' . $tukhoa . '%')
                  ->orWhere('batdongsan.tenduong', 'like', '%' . $tukhoa . '%');
            });
        }

        if (!empty($filters['gia_max'])) {
            $query->where('batdongsan.dongia', '<=', $filters['gia_max']);
        }

        return $query->get();
    }

    // Lấy chi tiết 1 BĐS (Bước 55, 56 trong sơ đồ)
    public function getChiTiet($id)
    {
        return DB::table('batdongsan')
            ->join('khachhang', 'batdongsan.khid', '=', 'khachhang.khid')
            ->where('batdongsan.bdsid', $id)
            ->select('batdongsan.*', 'khachhang.hoten as ten_chu_nha', 'khachhang.sodienthoai')
            ->first();
    }

    // Lưu BĐS mới (Bước 19 trong sơ đồ)
    public function taoMoi($data, $hinhanhData)
    {
        $maxId = DB::table('batdongsan')->max('bdsid');
        $newId = $maxId ? $maxId + 1 : 1;

        return DB::table('batdongsan')->insert([
            'bdsid'     => $newId,
            'khid'      => $data['khid'],
            'loaiid'    => $data['loaiid'],
            'dientich'  => $data['dientich'],
            'dongia'    => $data['dongia'],
            'tenduong'  => $data['tenduong'],
            'quan'      => $data['quan'],
            'hinhanh'   => $hinhanhData,
            'tinhtrang' => 1
        ]);
    }

  public function xoa($id)
    {
        // 1. Kiểm tra xem BĐS này có dính dáng đến BẤT KỲ hợp đồng nào không
        $checkKyGui = DB::table('hopdongkygui')->where('bdsid', $id)->exists();
        $checkDatCoc = DB::table('hopdongdatcoc')->where('bdsid', $id)->exists();
        $checkChuyenNhuong = DB::table('hopdongchuyennhuong')->where('bdsid', $id)->exists();

        // 2. Nếu có dính một trong 3 loại hợp đồng -> Ném lỗi ra ngoài
        if ($checkKyGui || $checkDatCoc || $checkChuyenNhuong) {
            // Quăng Exception để Controller bắt được và báo lỗi ra màn hình
            throw new \Exception('Không thể xóa Bất động sản này vì đã phát sinh Hợp đồng (Ký gửi/Cọc/Bán).');
        }

        // 3. Nếu an toàn -> Mới thực hiện lệnh xóa
        return DB::table('batdongsan')->where('bdsid', $id)->delete();
    }
}