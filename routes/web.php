<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PicController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// });

Route::redirect('/', '/admin');

Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/listKantorDariApiIndex', [AdminController::class, 'listKantorDariApiIndex']);
Route::get('/admin/simpanListKantorkeDB', [AdminController::class, 'simpanListKantorkeDB']);
Route::get('/admin/listKantorDariDBIndex', [AdminController::class, 'listKantorDariDBIndex']);
Route::get('/admin/lihatRekapBulananByKantor', [AdminController::class, 'lihatRekapBulananByKantor']);
Route::get('/admin/simpanRekapBulananByKantor', [AdminController::class, 'simpanRekapBulananByKantor']);

Route::get('/admin/referensi', [AdminController::class, 'referensi']);

Route::get('/pic/dashboard', [PicController::class, 'index']);
