<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('login');})->name('login.form');
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

    Route::get('/kategori-list',[CategoryController::class,'showCategoryList'])->name("show.kategori_list_show");
    Route::get('/kategori-ekleme-formu',[CategoryController::class,'showCategoryCreateForm'])->name("show.kategori_ekleme_formu");
    Route::post('/kategori-ekleme-formu',[CategoryController::class,'registerCategory'])->name("register.kategori_ekleme_formu");
    Route::get('/kategori-edit/{slug}', [CategoryController::class,'showCategoryEditForm'])->name("show.edit_kategori");
    Route::put('/kategori-edit/{id}', [CategoryController::class, 'edit_kategori'])->name('edit.kategori');
    Route::get('/kategori-sil',[CategoryController::class,'showCategoryDeleteList'])->name("kategori_delete_list_show");
    Route::get('/kategori-sil/{id}', [CategoryController::class,'deleteCategory'])->name("kategori_sil");
    Route::delete('/kategori-sil', [CategoryController::class, 'deleteSelectedCategories'])->name('delete_category_select');

    Route::get('/urun-list',[ProductController::class,'showProductList'])->name("products.list");
    Route::post('/urun-list', [ProductController::class,'filterByCategory'])->name("products.filter");
    Route::get('/urun-ekleme-formu', [ProductController::class,'showProductRegisterForm'])->name("products.create.form");
    Route::post('/urun-ekleme-formu',[ProductController::class,'registerProduct'])->name("products.create");
    Route::get('/urun-edit/{slug}', [ProductController::class,'showProductEdit'])->name("products.edit.form");
    Route::put('/urun-edit/{id}', [ProductController::class, 'updateProduct'])->name('products.update');
    Route::get('/urun-sil',[ProductController::class,'showProductDeleteList'])->name("products.delete.list");
    Route::get('/urun-sil/{id}', [ProductController::class,'deleteProduct'])->name("products.delete");
    Route::delete('/urun-sil', [ProductController::class, 'deleteSelectedProducts'])->name('products.delete.selected');
    Route::get('/urun-image/{slug}', [ProductController::class, 'showImageUpload'])->name('products.image.upload.form');
    Route::post('/urun-image/{slug}', [ProductController::class, 'uploadImage'])->name('products.image.upload');
    Route::get('/urun-image/{id}/sil', [ProductController::class, 'deleteImage'])->name('products.image.delete');
});



