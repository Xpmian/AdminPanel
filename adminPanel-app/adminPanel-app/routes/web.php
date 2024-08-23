<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('login');});
Route::get('/logoff', function () {return view('login');})->name("logoff");

Route::post("/", [LoginController::class,'login'])->name("aut.login");

Route::prefix("/admin")->group(function ()
{
    Route::get('/kullanici-ekleme-formu', function () {return view('admin.kullanici.kullanici-ekleme-formu');})->name("show");
    Route::post('/kullanici-ekleme-formu',[AdminController::class,'register_user'])->name("register");
    Route::get('/kullanici-list', [AdminController::class,'show_user_list'])->name("kullanici_list");

    Route::get('/kullanici-edit/{id}', [AdminController::class, 'show_kullanici_edit'])->name('show.edit');
    Route::put('/kullanici-edit/{id}', [AdminController::class, 'register_kullanici_edit'])->name('edit.register');
    Route::get('/kullanici-sil', [AdminController::class,'show_delete_list'])->name("kullanici_sil_list");
    Route::get('/kullanici-sil/{id}', [AdminController::class,'delete_user'])->name("kullanici_sil");

    Route::get('/kategori-ekleme-formu',[CategoryController::class,'kategori_ekleme_show'])->name("show.kategori_ekleme_formu");
    Route::post('/kategori-ekleme-formu',[CategoryController::class,'kategori_ekleme_register'])->name("register.kategori_ekleme_formu");
    Route::get('/kategori-list',[CategoryController::class,'kategori_list_show'])->name("show.kategori_list_show");
    Route::get('/kategori-sil',[CategoryController::class,'show_kategori_delete_list'])->name("kategori_delete_list_show");
    Route::get('/kategori-sil/{id}', [CategoryController::class,'delete_kategori'])->name("kategori_sil");
    Route::get('/kategori-edit/{id}', [CategoryController::class,'show_edit_kategori'])->name("show.edit_kategori");
    Route::put('/kategori-edit/{id}', [CategoryController::class, 'edit_kategori'])->name('edit.kategori');






});



