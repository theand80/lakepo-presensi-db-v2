<?php

use App\Http\Controllers\AdminController;
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
