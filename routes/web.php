<?php

use App\Http\Controllers\Admin\HariKegiatanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AsnDariApiController;
use App\Http\Controllers\DataAbsenController;
use App\Http\Controllers\DataAsnController;
use App\Http\Controllers\PenandaTanganController;
use App\Http\Controllers\PersentaseController;
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

// 1. admin / list kantor
Route::get('/admin/listKantorDariApiIndex', [AdminController::class, 'listKantorDariApiIndex'])->name('lihatListKator-DariApi');
Route::get('/admin/simpanListKantorkeDB', [AdminController::class, 'simpanListKantorkeDB']);
Route::get('/admin/listKantorDariDBIndex', [AdminController::class, 'listKantorDariDBIndex'])->name('lihatListKator-DariDB');

// 3. Absensi
Route::get('/admin/lihatRekapBulananByKantor', [DataAbsenController::class, 'lihatDataAbsenDariApi'])
    ->name('lihatRekapBulananByKantor-DariApi'); // masih dd
Route::get('/admin/kantorYangAkanDisimpanRekapBulananByKantor', [DataAbsenController::class, 'kantorYgAkanDisimpanDataAbsenDariApiKeDB']);
Route::post('/admin/simpanRekapBulananByKantor', [DataAbsenController::class, 'simpanDataAbsenDariApiKeDB']);
// Route::get('/admin/lihatDataAbsenDariDB', [AdminController::class, 'lihatDataAbsenDariDB']);

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

// ------------
// 3. rekap bulanan by kantor
Route::get('/pic/dashboard/pic', [PicController::class, 'index'])->name('lihatRekapBulananByKantor-DariDB');
Route::post('/pic/lihat-satu-kantor-saja', [PicController::class, 'lihatSatuKantorSaja']);
Route::post('/pic/download-presensi-by-kantor-excel', [PicController::class, 'downloadPresensiRekapByKantorExcel']);
Route::post('/pic/download-presensi-by-kantor-pdf', [PicController::class, 'downloadPresensiRekapByKantorPdf']);

// set penanda tangan
Route::post('/admin/list-penandatangan', [PenandaTanganController::class, 'index']);



// persentase
Route::get('/pic/simpan-persentase', [PersentaseController::class, 'persentase']);
Route::post('/pic/simpan-persentase', [PersentaseController::class, '__hitungPersentase']);

// 6. persentase v2
Route::get('/pic/simpan-persentase-v2', [PersentaseController::class, 'persentasev2']);
Route::post('/pic/simpan-persentase-v2', [PersentaseController::class, '__hitungPersentasev2']);

Route::redirect('/pic/detail', '/admin/lihatRekapBulananByNip');
// Route::get('/pic/detail', [PicController::class, 'show']);

Route::get('/pic/dashboard/bpk', [PicController::class, 'bpk']);

// 4. dan 5.
// TARIK DATA DARI API (Data ASN V2)
// tarik data semua asn dari simpegnasm simpan beserta nama kantor dan id kantorya
Route::get('/admin/asn-dari-api', [AsnDariApiController::class, 'simpanDataAsnDariApiKeDB']);
//
Route::get('/admin/lihat-asn-dari-api', [AsnDariApiController::class, 'lihatDataAsnDariApiYangSudahKeDB']);
Route::post('/admin/import-duk-excel-untuk-lengkapi-data-asn', [AsnDariApiController::class, 'lengkapiDataAsnDariApiKeDbMenggunakanDuk']);
Route::delete('/admin/hapus-data-asn-dari-api-ke-db', [AsnDariApiController::class, 'hapusSemuaDataAsnDariApiKeDb']);
Route::post('/admin/download-data-asn-dari-api-ke-db', [AsnDariApiController::class, 'downloadDataAsnDariApiKeDb']);
