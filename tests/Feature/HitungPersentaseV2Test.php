<?php

use App\Models\DataAbsen;
use App\Models\ListKantor;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function sebarAbsenKantor(ListKantor $kantor, array $rows): void
{
    foreach ($rows as $row) {
        DataAbsen::factory()->create($row + [
            'unor_simpegnas' => $kantor->nama_kantor,
            'unor_simpegnas_id' => $kantor->id_kantor,
        ]);
    }
}

test('hitung persentase v2 menulis persentase ke baris tanggal 01', function () {
    $tahun = date('Y');
    $kantor = ListKantor::factory()->create(['nama_kantor' => 'Kantor Uji Persentase']);

    sebarAbsenKantor($kantor, [
        // 01: TK terhitung, persentase lama wajib diganti
        ['nip' => '1111111111111111', 'nama' => 'NIP A', 'date' => "{$tahun}-09-01", 'persentase' => '10', 'status' => 'HM', 'status_change' => 'TK'],
        // 02: TK pada hari libur dilewati
        ['nip' => '1111111111111111', 'nama' => 'NIP A', 'date' => "{$tahun}-09-02", 'hari_libur' => '1', 'status' => 'HM', 'status_change' => 'TK'],
        // 03: LN dilewati
        ['nip' => '1111111111111111', 'nama' => 'NIP A', 'date' => "{$tahun}-09-03", 'status' => 'LN', 'status_change' => 'TK'],
        // 04: TM1 masuk hitungan TL1
        ['nip' => '1111111111111111', 'nama' => 'NIP A', 'date' => "{$tahun}-09-04", 'status' => 'HM', 'status_script' => 'TM1'],
        // 05: CP1 masuk hitungan PSW1
        ['nip' => '1111111111111111', 'nama' => 'NIP A', 'date' => "{$tahun}-09-05", 'status' => 'HM', 'status_script' => 'CP1'],
    ]);

    $this->post('/pic/simpan-persentase-v2', [
        'namaKantor' => 'Kantor Uji Persentase',
        'bulanUntukDihitung' => '09',
    ])
        ->assertRedirect('/pic/simpan-persentase-v2')
        ->assertSessionHas('success');

    // TK*3 + TL1(1)*0.5 + PSW1(1)*0.5 = 4 -> (1 - 4/100) * 100 = 96
    expect((float) DataAbsen::where('nip', '1111111111111111')
        ->where('date', "{$tahun}-09-01")
        ->sole()
        ->persentase)->toBe(96.0);

    // baris tanggal lain tetap kosong dan jumlah baris tidak bertambah
    expect(DataAbsen::where('nip', '1111111111111111')->count())->toBe(5)
        ->and(DataAbsen::where('nip', '1111111111111111')->where('date', '!=', "{$tahun}-09-01")->pluck('persentase')->filter()->count())->toBe(0);
});

test('hitung persentase v2 melewati nip tanpa baris tanggal 01 dan kantor lain', function () {
    $tahun = date('Y');
    $kantor = ListKantor::factory()->create(['nama_kantor' => 'Kantor Uji Dua']);
    $kantorLain = ListKantor::factory()->create(['nama_kantor' => 'Kantor Uji Lain']);

    sebarAbsenKantor($kantor, [
        ['nip' => '2222222222222222', 'nama' => 'NIP B', 'date' => "{$tahun}-09-02", 'status' => 'HM', 'status_script' => 'TM1'],
    ]);

    sebarAbsenKantor($kantorLain, [
        ['nip' => '3333333333333333', 'nama' => 'NIP C', 'date' => "{$tahun}-09-01", 'status' => 'HM', 'status_script' => 'TM1'],
    ]);

    $this->post('/pic/simpan-persentase-v2', [
        'namaKantor' => 'Kantor Uji Dua',
        'bulanUntukDihitung' => '09',
    ])->assertSessionHas('success');

    expect(DataAbsen::where('nip', '2222222222222222')->count())->toBe(1)
        ->and(DataAbsen::where('nip', '2222222222222222')->value('persentase'))->toBeNull()
        ->and(DataAbsen::where('nip', '3333333333333333')->value('persentase'))->toBeNull();
});

test('hitung persentase v2 menolak kantor yang tidak ditemukan', function () {
    $this->post('/pic/simpan-persentase-v2', [
        'namaKantor' => 'Kantor Tidak Ada',
        'bulanUntukDihitung' => '09',
    ])
        ->assertRedirect('/pic/simpan-persentase-v2')
        ->assertSessionHas('error');
});

test('hitung persentase v2 menolak bulan yang tidak valid', function () {
    $this->post('/pic/simpan-persentase-v2', [
        'namaKantor' => 'Kantor Uji',
        'bulanUntukDihitung' => '13',
    ])->assertSessionHasErrors('bulanUntukDihitung');
});

test('halaman form persentase v2 terbuka', function () {
    $tahun = date('Y');
    $kantor = ListKantor::factory()->create(['nama_kantor' => 'Kantor Uji Tampilan']);

    sebarAbsenKantor($kantor, [
        ['nip' => '4444444444444444', 'nama' => 'NIP D', 'date' => "{$tahun}-09-01", 'persentase' => '96', 'status' => 'HM'],
    ]);

    $this->get('/pic/simpan-persentase-v2')
        ->assertOk()
        ->assertSee('Kantor Uji Tampilan');
});
