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

Route::get('/admin/lihatRekapBulananByKantor', [AdminController::class, 'lihatDataAbsenDariApi']);
Route::get('/admin/simpanRekapBulananByKantor', [AdminController::class, 'simpanDataAbsenDariApiKeDB']);
//Route::get('/admin/simpanRekapBulananByKantor', [AdminController::class, 'lihatDataAbsenDariDB']);


// impord dari Excel
Route::get('/admin/data-asn', [AdminController::class, 'listDataAsn']);


Route::get('/admin/referensi', [AdminController::class, 'referensi']);

// ------------
Route::get('/pic/dashboard/pic', [PicController::class, 'index']);
Route::get('/pic/detail', [PicController::class, 'show']);
Route::get('/pic/dashboard/bpk', [PicController::class, 'bpk']);
