<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\BatDongSanController;


// Giao diện và xử lý Đăng nhập
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'processLogin']);

// Giao diện trang chủ Quản trị
Route::get('/admin/dashboard', [AuthController::class, 'dashboard']);

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
Route::get('/admin/hopdong/in-pdf', [NhanVienController::class, 'inHopDongPDF']);

//CURD Khách Hàng
Route::get('/admin/khachhang', [KhachHangController::class, 'index']);
Route::get('/admin/khachhang/create', [KhachHangController::class, 'create']);
Route::post('/admin/khachhang/store', [KhachHangController::class, 'store']);
Route::get('/admin/khachhang/edit/{id}', [KhachHangController::class, 'edit']);
Route::post('/admin/khachhang/update/{id}', [KhachHangController::class, 'update']);
Route::post('/admin/khachhang/delete/{id}', [KhachHangController::class, 'delete']);

// CURD Bất Động Sản
Route::get('/admin/batdongsan', [BatDongSanController::class, 'index']);
Route::get('/admin/batdongsan/create', [BatDongSanController::class, 'create']);
Route::post('/admin/batdongsan/store', [BatDongSanController::class, 'store']);
Route::get('/admin/batdongsan/edit/{id}', [BatDongSanController::class, 'edit']);
Route::post('/admin/batdongsan/update/{id}', [BatDongSanController::class, 'update']);
Route::post('/admin/batdongsan/delete/{id}', [BatDongSanController::class, 'delete']);
Route::get('/admin/batdongsan/show/{id}', [BatDongSanController::class, 'show']);