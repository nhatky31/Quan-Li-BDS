<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\BatDongSanController;
use App\Http\Controllers\HopDongKyGuiController;
use App\Http\Controllers\HopDongChuyenNhuongController;
use App\Http\Controllers\HopDongDatCocController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BaoCaoController;



// Giao diện và xử lý Đăng nhập
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'processLogin']);

// Giao diện trang chủ Quản trị
Route::get('/admin/dashboard', [DashboardController::class, 'index']);

// Xử lý Đăng xuất
Route::get('/logout', [AuthController::class, 'logout']);

// Lệnh này bắt buộc hệ thống tự động nhảy sang trang login khi vừa vào web
Route::get('/', function () {
    return redirect('/login');
});
//gd nv
Route::get('/admin/nhanvien', [NhanVienController::class, 'index']);
//form nhanvien
Route::get('/admin/nhanvien/create', [NhanVienController::class, 'create']);
Route::post('/admin/nhanvien/store', [NhanVienController::class, 'store']);
Route::get('/admin/nhanvien/edit/{id}', [NhanVienController::class, 'edit']);
Route::post('/admin/nhanvien/update/{id}', [NhanVienController::class, 'update']);
Route::get('/admin/nhanvien/delete/{id}', [NhanVienController::class, 'delete']);
// Đường dẫn để in thử Hợp đồng ra PDF
Route::get('/admin/hopdongkygui/in-pdf/{id}', [HopDongKyGuiController::class, 'inPDF']);


Route::get('/admin/khachhang', [KhachHangController::class, 'index']);
Route::get('/admin/khachhang/create', [KhachHangController::class, 'create']);
Route::post('/admin/khachhang/store', [KhachHangController::class, 'store']);
Route::get('/admin/khachhang/edit/{id}', [KhachHangController::class, 'edit']);
Route::post('/admin/khachhang/update/{id}', [KhachHangController::class, 'update']);
Route::get('/admin/khachhang/delete/{id}', [KhachHangController::class, 'delete']);


Route::get('/admin/batdongsan', [BatDongSanController::class, 'index']);
Route::get('/admin/batdongsan/create', [BatDongSanController::class, 'create']);
Route::post('/admin/batdongsan/store', [BatDongSanController::class, 'store']);
Route::get('/admin/baocao/doanhthu', [BaoCaoController::class, 'doanhThuNhanVien']);

Route::get('/admin/batdongsan/edit/{id}', [BatDongSanController::class, 'edit']);
Route::post('/admin/batdongsan/update/{id}', [BatDongSanController::class, 'update']);
Route::get('/admin/batdongsan/delete/{id}', [BatDongSanController::class, 'delete']);   
Route::get('/admin/batdongsan/show/{id}', [BatDongSanController::class, 'show']);

Route::get('/admin/hopdongkygui', [HopDongKyGuiController::class, 'index']);
Route::get('/admin/hopdongkygui/create', [HopDongKyGuiController::class, 'create']);
Route::post('/admin/hopdongkygui/store', [HopDongKyGuiController::class, 'store']);

Route::get('/admin/hopdongchuyennhuong', [HopDongChuyenNhuongController::class, 'index']);
Route::get('/admin/hopdongchuyennhuong/create', [HopDongChuyenNhuongController::class, 'create']);
Route::post('/admin/hopdongchuyennhuong/store', [HopDongChuyenNhuongController::class, 'store']);
Route::get('/admin/hopdongchuyennhuong/print/{id}', [App\Http\Controllers\HopDongChuyenNhuongController::class, 'printPDF']);
Route::get('/admin/hopdongchuyennhuong/edit/{id}', [HopDongChuyenNhuongController::class, 'edit']);
Route::post('/admin/hopdongchuyennhuong/update/{id}', [HopDongChuyenNhuongController::class, 'update']);

Route::get('/admin/hopdongdatcoc', [HopDongDatCocController::class, 'index']);
Route::get('/admin/hopdongdatcoc/create', [HopDongDatCocController::class, 'create']);
Route::post('/admin/hopdongdatcoc/store', [HopDongDatCocController::class, 'store']);
Route::get('/admin/hopdongdatcoc/edit/{id}', [HopDongDatCocController::class, 'edit']);
Route::post('/admin/hopdongdatcoc/update/{id}', [HopDongDatCocController::class, 'update']);