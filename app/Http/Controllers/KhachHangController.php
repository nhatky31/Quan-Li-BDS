<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KhachHangController extends Controller
{
    // Danh sách
    public function index()
    {
        $data = DB::table('khachhang')
            ->orderBy('khid', 'desc')
            ->get();

        return view('admin.khachhang.index', compact('data'));
    }

    // Form thêm
    public function create()
    {
        return view('admin.khachhang.create');
    }

    // Lưu dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'hoten' => 'required|max:50',
            'email' => 'required|email',
            'sodienthoai' => 'required|digits_between:10,11',
            'diachi' => 'required',
            'loaikh' => 'required'
        ]);

        DB::table('khachhang')->insert([
            'hoten' => $request->hoten,
            'email' => $request->email,
            'sodienthoai' => $request->sodienthoai,
            'diachi' => $request->diachi,
            'loaikh' => (int)$request->loaikh,
            'trangthai' => 1
        ]);

        return redirect('/admin/khachhang')
            ->with('success', 'Thêm khách hàng thành công');
    }

    // Form sửa
    public function edit($id)
    {
        $data = DB::table('khachhang')->where('khid', $id)->first();
        return view('admin.khachhang.edit', compact('data'));
    }

    // Update
    public function update(Request $request, $id)
    {
        DB::table('khachhang')->where('khid', $id)->update([
            'hoten' => $request->hoten,
            'email' => $request->email,
            'sodienthoai' => $request->sodienthoai,
            'diachi' => $request->diachi,
            'loaikh' => (int)$request->loaikh
        ]);

        return redirect('/admin/khachhang');
    }

    // Xóa
    public function delete($id)
    {
        DB::table('khachhang')->where('khid', $id)->delete();
        return redirect('/admin/khachhang');
    }
}