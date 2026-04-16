<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatDongSanController extends Controller
{
    // Danh sách
    public function index()
    {
        $data = DB::table('batdongsan')->get();
        return view('admin.batdongsan.index', compact('data'));
    }

    // Form thêm
    public function create()
    {
        return view('admin.batdongsan.create');
    }

    // Lưu dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'dientich' => 'required|numeric',
            'dongia' => 'required|numeric'
        ]);

        $diachi = explode(',', $request->diachi);

        DB::table('batdongsan')->insert([
            'masoqsdd' => $request->masoqsdd,
            'loaiid' => $request->loaiid,
            'tinhtrang' => $request->tinhtrang,
            'dientich' => $request->dientich,
            'dongia' => $request->dongia,
            'mota' => $request->mota,

            'sonha' => $diachi[0] ?? '',
            'tenduong' => $diachi[1] ?? '',
            'phuong' => $diachi[2] ?? '',
            'quan' => $diachi[3] ?? '',
            'thanhpho' => $diachi[4] ?? ''
        ]);

        return redirect('/admin/batdongsan');
    }

    // Form sửa
    public function edit($id)
    {
        $data = DB::table('batdongsan')->where('bdsid', $id)->first();
        return view('admin.batdongsan.edit', compact('data'));
    }

    // Cập nhật
    public function update(Request $request, $id)
    {
        $diachi = explode(',', $request->diachi);

        DB::table('batdongsan')->where('bdsid', $id)->update([
            'masoqsdd' => $request->masoqsdd,
            'loaiid' => $request->loaiid,
            'tinhtrang' => $request->tinhtrang,
            'dientich' => $request->dientich,
            'dongia' => $request->dongia,
            'mota' => $request->mota,

            'sonha' => $diachi[0] ?? '',
            'tenduong' => $diachi[1] ?? '',
            'phuong' => $diachi[2] ?? '',
            'quan' => $diachi[3] ?? '',
            'thanhpho' => $diachi[4] ?? ''
        ]);

        return redirect('/admin/batdongsan');
    }

    // Xóa
    public function delete($id)
    {
        DB::table('batdongsan')->where('bdsid', $id)->delete();
        return redirect('/admin/batdongsan');
    }

    // Xem chi tiết
    public function show($id)
    {
        $bds = DB::table('batdongsan')
            ->where('bdsid', $id)
            ->first();

        return view('admin.batdongsan.show', compact('bds'));
    }
}
