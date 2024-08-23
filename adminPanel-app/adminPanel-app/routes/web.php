<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('login');});

Route::post("/", [LoginController::class,'Login'])->name("aut.login");

Route::get('/welcome', function () {return view('welcome');});



