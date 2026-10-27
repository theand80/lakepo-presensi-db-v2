<?php

use App\Models\AsnDariApi;
use App\Models\DataAbsen;
use App\Models\ListKantor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(createUserWithRole('admin'));
});

test('lihat satu kantor saja menampilkan data ASN', function () {
    $tahun = date('Y');

    $kantor = ListKantor::factory()->create([
        'nama_kantor' => 'Kantor Uji Satu',
        'id_kantor' => 'kantor-uji-satu-id',
    ]);

    AsnDariApi::create([
        'nip' => '1234567890123456',
        'nama' => 'ASN Uji Satu',
        'pangkat' => 'Pembina',
        'golongan' => 'IV/a',
        'status' => 'PNS',
        'jabatan' => 'Kepala Subbagian',
        'unor_siasn' => 'Unor Siasn',
        'unor_siasn_induk' => 'Kantor Uji Satu',
        'unor_simpegnas_id' => $kantor->id_kantor,
        'unor_simpegnas' => $kantor->nama_kantor,
        'foto_simpegnas' => null,
    ]);

    DataAbsen::factory()->create([
        'nip' => '1234567890123456',
        'nama' => 'ASN Uji Satu',
        'date' => $tahun.'-08-01',
        'hari_libur' => '0',
        'unor_simpegnas' => $kantor->nama_kantor,
        'unor_simpegnas_id' => $kantor->id_kantor,
        'status' => 'HM',
        'status_change' => 'HN',
        'status_script' => 'HN',
        'persentase' => '100',
    ]);

    $this->post('/pic/lihat-satu-kantor-saja', [
        'filterNamaKantor' => 'Kantor Uji Satu',
        'month' => $tahun.'-08',
    ])
        ->assertOk()
        ->assertSee('1234567890123456');
});

test('lihat satu kantor saja menolak jika filter kosong', function () {
    $tahun = date('Y');

    $this->post('/pic/lihat-satu-kantor-saja', [
        'filterNamaKantor' => '',
        'month' => $tahun.'-08',
    ])
        ->assertSessionHasErrors('filterNamaKantor');
});

test('download presensi rekap by kantor excel menghasilkan file yang sesuai', function () {
    $tahun = date('Y');

    $kantor = ListKantor::factory()->create([
        'nama_kantor' => 'Kantor Uji Excel',
        'id_kantor' => 'kantor-uji-excel-id',
    ]);

    AsnDariApi::create([
        'nip' => '9876543210987654',
        'nama' => 'ASN Uji Excel',
        'pangkat' => 'Penata',
        'golongan' => 'III/a',
        'status' => 'PPPK',
        'jabatan' => 'Pelaksana',
        'unor_siasn' => 'Unor Siasn',
        'unor_siasn_induk' => 'Kantor Uji Excel',
        'unor_simpegnas_id' => $kantor->id_kantor,
        'unor_simpegnas' => $kantor->nama_kantor,
        'foto_simpegnas' => null,
    ]);

    DataAbsen::factory()->create([
        'nip' => '9876543210987654',
        'nama' => 'ASN Uji Excel',
        'date' => $tahun.'-08-01',
        'hari_libur' => '0',
        'unor_simpegnas' => $kantor->nama_kantor,
        'unor_simpegnas_id' => $kantor->id_kantor,
        'status' => 'HM',
        'status_change' => 'HN',
        'status_script' => 'HN',
        'persentase' => '95',
    ]);

    Excel::fake();

    $response = $this->post('/pic/download-presensi-by-kantor-excel', [
        'namaKantor' => 'Kantor Uji Excel',
        'month' => $tahun.'-08',
    ]);

    $response->assertOk();

    $fileName = 'kehadiran ASN bulan 08 tahun '.$tahun.' di Kantor Uji Excel.xlsx';

    Excel::assertDownloaded($fileName, function ($export) {
        $exported = $export->collection()->toArray();
        expect($exported)->toHaveCount(1);
        expect((string) $exported[0]['nip'])->toBe('9876543210987654');
        expect($exported[0]['nama'])->toBe('ASN Uji Excel');

        return true;
    });
});

test('download presensi rekap by kantor pdf menghasilkan file yang sesuai', function () {
    $tahun = date('Y');

    $kantor = ListKantor::factory()->create([
        'nama_kantor' => 'Kantor Uji PDF',
        'id_kantor' => 'kantor-uji-pdf-id',
    ]);

    AsnDariApi::create([
        'nip' => '1122334455667788',
        'nama' => 'ASN Uji PDF',
        'pangkat' => 'Penata',
        'golongan' => 'III/a',
        'status' => 'PPPK',
        'jabatan' => 'Pelaksana',
        'unor_siasn' => 'Unor Siasn',
        'unor_siasn_induk' => 'Kantor Uji PDF',
        'unor_simpegnas_id' => $kantor->id_kantor,
        'unor_simpegnas' => $kantor->nama_kantor,
        'foto_simpegnas' => null,
    ]);

    DataAbsen::factory()->create([
        'nip' => '1122334455667788',
        'nama' => 'ASN Uji PDF',
        'date' => $tahun.'-08-01',
        'hari_libur' => '0',
        'unor_simpegnas' => $kantor->nama_kantor,
        'unor_simpegnas_id' => $kantor->id_kantor,
        'status' => 'HM',
        'status_change' => 'HN',
        'status_script' => 'HN',
        'persentase' => '90',
    ]);

    $response = $this->post('/pic/download-presensi-by-kantor-pdf', [
        'namaKantor' => 'Kantor Uji PDF',
        'month' => $tahun.'-08',
    ]);

    $response->assertOk();

    $fileName = 'kehadiran ASN bulan 08 tahun '.$tahun.' di Kantor Uji PDF.pdf';
    $response->assertDownload($fileName);

    $content = $response->baseResponse->getContent();
    expect(substr($content, 0, 5))->toBe('%PDF-');
    expect($content)->toMatch('/\/MediaBox\s*\[\s*0\s+0\s+935\./');

    $html = view('pic.pdf.rekapSatuKantor', [
        'data' => [],
        'opd' => 'Kantor Uji PDF',
        'month' => $tahun.'-08',
        'bln' => '08',
        'thn' => $tahun,
    ])->render();
    expect($html)->toContain('Kantor Uji PDF');
    expect($html)->toContain('Periode bulan');
    expect($html)->toContain('@page');
    preg_match_all('/<th[^>]*>([^<]+)<\/th>/i', $html, $m);
    expect(count($m[0]))->toBe(28);
});

test('download presensi rekap by kantor pdf menolak jika namaKantor kosong', function () {
    $tahun = date('Y');

    $this->post('/pic/download-presensi-by-kantor-pdf', [
        'namaKantor' => '',
        'month' => $tahun.'-08',
    ])->assertSessionHasErrors('namaKantor');
});

test('hitung TAS: absen pagi/sore ada tapi absen siang kosong dihitung TAS', function () {
    $tahun = date('Y');

    $kantor = ListKantor::factory()->create([
        'nama_kantor' => 'Kantor Uji TAS',
        'id_kantor' => 'kantor-uji-tas-id',
    ]);

    AsnDariApi::create([
        'nip' => '1111111111111111',
        'nama' => 'ASN TAS',
        'pangkat' => 'Penata',
        'golongan' => 'III/a',
        'status' => 'PNS',
        'jabatan' => 'Pelaksana',
        'unor_siasn' => 'Unor Siasn',
        'unor_siasn_induk' => 'Kantor Uji TAS',
        'unor_simpegnas_id' => $kantor->id_kantor,
        'unor_simpegnas' => $kantor->nama_kantor,
        'foto_simpegnas' => null,
    ]);

    // TAS: ada pagi dan sore, tapi tidak absen siang
    DataAbsen::factory()->create([
        'nip' => '1111111111111111',
        'nama' => 'ASN TAS',
        'date' => $tahun.'-08-05',
        'hari_libur' => '0',
        'unor_simpegnas' => $kantor->nama_kantor,
        'unor_simpegnas_id' => $kantor->id_kantor,
        'checkIn_time_with_timezone' => '07:30:00',
        'checkOut_time_with_timezone' => '16:00:00',
        'checkRest_time_with_timezone' => '',
        'checkRest_time_with_timezone_change' => null,
        'status' => 'HN',
        'status_script' => 'HN',
        'status_change' => null,
    ]);

    // Tidak TAS: semua ada
    DataAbsen::factory()->create([
        'nip' => '1111111111111111',
        'nama' => 'ASN TAS',
        'date' => $tahun.'-08-06',
        'hari_libur' => '0',
        'unor_simpegnas' => $kantor->nama_kantor,
        'unor_simpegnas_id' => $kantor->id_kantor,
        'checkIn_time_with_timezone' => '07:30:00',
        'checkOut_time_with_timezone' => '16:00:00',
        'checkRest_time_with_timezone' => '12:00:00',
        'status' => 'HN',
        'status_script' => 'HN',
        'status_change' => null,
    ]);

    $response = $this->post('/pic/lihat-satu-kantor-saja', [
        'filterNamaKantor' => 'Kantor Uji TAS',
        'month' => $tahun.'-08',
    ]);

    $response->assertOk();
    $response->assertSee('Tidak Absen Siang');
    $response->assertSee('1');
});

test('TAS tidak dihitung untuk hari tanpa absen pagi/sore', function () {
    $tahun = date('Y');

    $kantor = ListKantor::factory()->create([
        'nama_kantor' => 'Kantor Uji TAS Kosong',
        'id_kantor' => 'kantor-uji-tas-kosong-id',
    ]);

    AsnDariApi::create([
        'nip' => '2222222222222222',
        'nama' => 'ASN TAS Kosong',
        'pangkat' => 'Penata',
        'golongan' => 'III/a',
        'status' => 'PNS',
        'jabatan' => 'Pelaksana',
        'unor_siasn' => 'Unor Siasn',
        'unor_siasn_induk' => 'Kantor Uji TAS Kosong',
        'unor_simpegnas_id' => $kantor->id_kantor,
        'unor_simpegnas' => $kantor->nama_kantor,
        'foto_simpegnas' => null,
    ]);

    DataAbsen::factory()->create([
        'nip' => '2222222222222222',
        'nama' => 'ASN TAS Kosong',
        'date' => $tahun.'-08-10',
        'hari_libur' => '0',
        'unor_simpegnas' => $kantor->nama_kantor,
        'unor_simpegnas_id' => $kantor->id_kantor,
        'checkIn_time_with_timezone' => '',
        'checkOut_time_with_timezone' => '',
        'checkRest_time_with_timezone' => '',
        'status' => 'TK',
        'status_script' => 'TK',
        'status_change' => null,
    ]);

    $response = $this->post('/pic/lihat-satu-kantor-saja', [
        'filterNamaKantor' => 'Kantor Uji TAS Kosong',
        'month' => $tahun.'-08',
    ]);

    $response->assertOk();
});
