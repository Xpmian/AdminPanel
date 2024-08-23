<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return redirect()->route('login.form');});
Route::get('/login', function () {return view('login');})->name('login.form');
Route::post('/logout', [LoginController::class, 'logoff'])->name('login.off');
Route::post("/login", [LoginController::class,'login'])->name("aut.login");

Route::prefix("/admin")->group(function ()
{
    Route::get('/kullanici-list', [AdminController::class,'showUserList'])->name("users.list");
    Route::get('/kullanici-ekleme-formu', [AdminController::class,'showUsersCreateForm'])->name("users.create.form");
    Route::post('/kullanici-ekleme-formu',[AdminController::class,'registerUser'])->name("users.create");
    Route::get('/kullanici-edit/{user:slug}', [AdminController::class, 'showUserEditForm'])->name('users.edit.form');
    Route::put('/kullanici-edit/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::get('/kullanici-sil', [AdminController::class,'showUserDeleteList'])->name("users.delete.list");
    Route::get('/kullanici-sil/{id}', [AdminController::class,'deleteUser'])->name("users.delete");
    Route::delete('/kullanici-sil', [AdminController::class, 'deleteSelectedUsers'])->name('users.delete.selected');

    Route::get('/kategori-list',[CategoryController::class,'showCategoryList'])->name("categories.list");
    Route::get('/kategori-ekleme-formu',[CategoryController::class,'showCategoryCreateForm'])->name("categories.create.form");
    Route::post('/kategori-ekleme-formu',[CategoryController::class,'registerCategory'])->name("categories.create");
    Route::get('/kategori-edit/{slug}', [CategoryController::class,'showCategoryEditForm'])->name("categories.edit.form");
    Route::put('/kategori-edit/{id}', [CategoryController::class, 'updateCategory'])->name('categories.update');
    Route::get('/kategori-sil',[CategoryController::class,'showCategoryDeleteList'])->name("categories.delete.list");
    Route::get('/kategori-sil/{id}', [CategoryController::class,'deleteCategory'])->name("categories.delete");
    Route::delete('/kategori-sil', [CategoryController::class, 'deleteSelectedCategories'])->name('categories.delete.selected');

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



