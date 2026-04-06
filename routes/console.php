<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//trang đăng nhập và dashboard quản trị
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);

Route::get('/admin/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/', function () {
    return redirect('/login');
});