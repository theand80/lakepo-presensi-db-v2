<?php

use App\Http\Controllers\Admin\HariKegiatanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AsnDariApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataAbsenController;
use App\Http\Controllers\DataAsnController;
use App\Http\Controllers\PenandaTanganController;
use App\Http\Controllers\PersentaseController;
use App\Http\Controllers\PicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

// Semua route admin: khusus role admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);

    // 1. admin / list kantor
    Route::get('/admin/listKantorDariApiIndex', [AdminController::class, 'listKantorDariApiIndex'])->name('lihatListKator-DariApi');
    Route::get('/admin/simpanListKantorkeDB', [AdminController::class, 'simpanListKantorkeDB']);
    Route::get('/admin/listKantorDariDBIndex', [AdminController::class, 'listKantorDariDBIndex'])->name('lihatListKator-DariDB');

    // 3. Absensi
    Route::get('/admin/lihatRekapBulananByKantor', [DataAbsenController::class, 'lihatDataAbsenDariApi'])
        ->name('lihatRekapBulananByKantor-DariApi');
    Route::get('/admin/kantorYangAkanDisimpanRekapBulananByKantor', [DataAbsenController::class, 'kantorYgAkanDisimpanDataAbsenDariApiKeDB']);
    Route::post('/admin/simpanRekapBulananByKantor', [DataAbsenController::class, 'simpanDataAbsenDariApiKeDB']);
    Route::post('/admin/lihatRekapBulananByNip', [AdminController::class, 'show'])->name('lihatRekapBulananByNip-DariDB');

    // impord data ASN dari Excel (Data ASN V1)
    Route::get('/admin/data-asn', [DataAsnController::class, 'listDataAsn']);
    Route::post('/import-excel-add-data-asn', [DataAsnController::class, 'addDataAsn']);
    Route::post('/import-excel-update-data-asn', [DataAsnController::class, 'updateDataAsn']);
    Route::delete('/import-excel-delete-all-data-asn', [DataAsnController::class, 'destroyAllDataAsn']);
    Route::post('/admin/eksport-data-asn', [DataAsnController::class, 'exportDataAsn']);

    // 2. set Jam dan Kode
    Route::get('/admin/referensi', [AdminController::class, 'referensi']);

    // hariKegiatan
    Route::get('/admin/hari-kegiatan', [HariKegiatanController::class, 'setHariKegiatan']);
    Route::post('/admin/hari-kegiatan', [HariKegiatanController::class, 'simpanSetHariKegiatan']);
    Route::delete('/admin/hari-kegiatan/{id}', [HariKegiatanController::class, 'hapusHariKegiatan']);
    Route::get('/admin/asn-kegiatan', [HariKegiatanController::class, 'ImportAsnYgMengikutiKegiatan']);

    // 4. dan 5. TARIK DATA DARI API (Data ASN V2)
    Route::get('/admin/asn-dari-api', [AsnDariApiController::class, 'simpanDataAsnDariApiKeDB']);
    Route::get('/admin/lihat-asn-dari-api', [AsnDariApiController::class, 'lihatDataAsnDariApiYangSudahKeDB']);
    Route::post('/admin/import-duk-excel-untuk-lengkapi-data-asn', [AsnDariApiController::class, 'lengkapiDataAsnDariApiKeDbMenggunakanDuk']);
    Route::delete('/admin/hapus-data-asn-dari-api-ke-db', [AsnDariApiController::class, 'hapusSemuaDataAsnDariApiKeDb']);
    Route::post('/admin/download-data-asn-dari-api-ke-db', [AsnDariApiController::class, 'downloadDataAsnDariApiKeDb']);

    // set penanda tangan
    Route::get('/admin/list-penandatangan', [PenandaTanganController::class, 'index']);
    Route::post('/admin/simpan-penandatangan', [PenandaTanganController::class, '__upsert']);

    // User
    Route::get('/admin/list-user', [UserController::class, 'index']);
    Route::post('/admin/add-user', [UserController::class, 'store']);
    Route::get('/admin/edit-user/{id}', [UserController::class, 'edit']);
    Route::put('/admin/update-user/{id}', [UserController::class, 'update']);
    Route::put('/admin/quick-set-role/{id}', [UserController::class, 'quickSetRole']);
    Route::delete('/admin/delete-user/{id}', [UserController::class, 'destroy']);
});

// Semua route pic: diakses admin, pic, dan operator (data di-scope per kantor)
Route::middleware(['auth', 'role:pic|operator|admin'])->group(function () {
    // rekap bulanan by kantor
    Route::get('/pic/dashboard/pic', [PicController::class, 'index'])->name('lihatRekapBulananByKantor-DariDB');
    Route::post('/pic/lihat-satu-kantor-saja', [PicController::class, 'lihatSatuKantorSaja']);
    Route::post('/pic/download-presensi-by-kantor-excel', [PicController::class, 'downloadPresensiRekapByKantorExcel']);
    Route::post('/pic/download-presensi-by-kantor-pdf', [PicController::class, 'downloadPresensiRekapByKantorPdf']);
    Route::get('/pic/dashboard/bpk', [PicController::class, 'bpk']);

    // persentase
    Route::get('/pic/simpan-persentase', [PersentaseController::class, 'persentase']);
    Route::post('/pic/simpan-persentase', [PersentaseController::class, '__hitungPersentase']);

    // persentase v2
    Route::get('/pic/simpan-persentase-v2', [PersentaseController::class, 'persentasev2']);
    Route::post('/pic/simpan-persentase-v2', [PersentaseController::class, '__hitungPersentasev2']);

    Route::redirect('/pic/detail', '/admin/lihatRekapBulananByNip');
});
