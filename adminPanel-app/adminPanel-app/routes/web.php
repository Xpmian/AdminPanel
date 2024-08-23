<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('login');})->name('login');

Route::post("/", [LoginController::class,'login'])->name("aut.login");

Route::prefix("/admin")->group(function ()
{
    Route::get('/kullanici-ekleme-formu', function () {return view('admin.kullanici.kullanici-ekleme-formu');})->name("show");
    Route::get('/kullanici-list', [AdminController::class,'show_user_list'])->name("kullanici_list");
    Route::post('/kullanici-ekleme-formu',[AdminController::class,'register_user'])->name("register");
    Route::get('/kullanici-edit/{user:slug}', [AdminController::class, 'show_kullanici_edit'])->name('show.edit');
    Route::put('/kullanici-edit/{user}', [AdminController::class, 'register_kullanici_edit'])->name('edit.register');
    Route::get('/kullanici-sil', [AdminController::class,'show_delete_list'])->name("kullanici_sil_list");
    Route::get('/kullanici-sil/{id}', [AdminController::class,'delete_user'])->name("kullanici_sil");
    Route::delete('/kullanici-sil', [AdminController::class, 'deleteUserSelect'])->name('delete_user_select');

    Route::get('/kategori-list',[CategoryController::class,'kategori_list_show'])->name("show.kategori_list_show");
    Route::get('/kategori-ekleme-formu',[CategoryController::class,'kategori_ekleme_show'])->name("show.kategori_ekleme_formu");
    Route::post('/kategori-ekleme-formu',[CategoryController::class,'kategori_ekleme_register'])->name("register.kategori_ekleme_formu");
    Route::get('/kategori-edit/{slug}', [CategoryController::class,'show_edit_kategori'])->name("show.edit_kategori");
    Route::put('/kategori-edit/{id}', [CategoryController::class, 'edit_kategori'])->name('edit.kategori');
    Route::get('/kategori-sil',[CategoryController::class,'show_kategori_delete_list'])->name("kategori_delete_list_show");
    Route::get('/kategori-sil/{id}', [CategoryController::class,'delete_kategori'])->name("kategori_sil");
    Route::delete('/kategori-sil', [CategoryController::class, 'deleteCategorySelect'])->name('delete_category_select');

    Route::get('/urun-list',[ProductController::class,'urun_list_show'])->name("show.urun_list_show");
    Route::post('/urun-list', [ProductController::class,'filter_category'])->name("filter_category");
    Route::get('/urun-ekleme-formu', [ProductController::class,'showProductRegister'])->name("showProduct");
    Route::post('/urun-ekleme-formu',[ProductController::class,'register_product'])->name("registerProduct");
    Route::get('/urun-edit/{slug}', [ProductController::class,'show_edit_urun'])->name("show.edit_urun");
    Route::put('/urun-edit/{id}', [ProductController::class, 'edit_urun'])->name('edit.urun');
    Route::get('/urun-sil',[ProductController::class,'show_urun_delete_list'])->name("urun_delete_list_show");
    Route::get('/urun-sil/{id}', [ProductController::class,'delete_urun'])->name("urun_sil");
    Route::delete('/urun-sil', [ProductController::class, 'deleteProductSelect'])->name('delete_product_select');
    Route::get('/urun-image/{slug}', [ProductController::class, 'show_image_upload'])->name('show_image_upload');
    Route::post('/urun-image/{slug}', [ProductController::class, 'image_upload'])->name('image_upload');
    Route::get('/urun-image/{id}/sil', [ProductController::class, 'image_delete'])->name('image_delete');
});



