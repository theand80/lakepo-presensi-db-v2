<?php

namespace App\Http\Controllers;

use App\Models\DataAbsen;
use App\Models\ListKantor;
use App\Models\Persentase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersentaseController extends Controller
{
    //
    // persentase
    public function persentase()
    {
        //
        return view('admin.persentase.setPersentase');
    }

    // ini dipanggil dari route
    public function __hitungPersentase(Request $request)
    {
        $request->validate([
            'namaKantor'            => 'required|string',
            'bulanUntukDihitung'    => 'required|date',
        ]);
        
        $selectedKantor = $request->input('namaKantor', '');
        $selectedMonth = $request->input('bulanUntukDihitung', date('Y-m'));

        // dd($request);
        // 
        $unor_simpegnas_id = 'c9956f8f-77ea-4bbf-a22a-182b6ac9823e'; //bkpsdm
        // $unor_simpegnas_id = 'fd7277d4-c35d-4de5-a479-1adad7cfceed'; // penanaman modal kantor

        // $tgl = '2026-08';
        $tgl = $selectedMonth;
        $data = $this->__dataYangDitampilkan($unor_simpegnas_id, $tgl); // diatas

        $bln = substr($tgl, 5, 2);//dari 2026-08 jadi 08
        // dd($data);

        DB::transaction(function () use ($data, $bln) {
            $dataToUpsert = [];
            foreach ($data as $item) {

                // hitung perentasenya
                $persentases = ($item['rekap']['TK']*3) 
                    + ($item['rekap']['TL1']*0.5) + ($item['rekap']['TL2']*1) 
                    + ($item['rekap']['TL3']*1.25) + ($item['rekap']['TL4']*1.5)
                    + ($item['rekap']['PSW1']*0.5) + ($item['rekap']['PSW2']*1) 
                    + ($item['rekap']['PSW3']*1.25) + ($item['rekap']['PSW4']*1.5)
                ;

                // $persentase = (1- ($persentases/100));
                // $persentase = 100 - $persentases;
                // $persentase = round(1 - ($persentases / 100), 2);
                $persentase = round((1 - ($persentases / 100)) * 100, 2);

                $dataToUpsert[] = [
                    'nip' => $item['nip'],
                    'nama' => $item['nama'],
                    $bln => $persentase,
                ];
            }

            // dd($dataToUpsert);

            if (!empty($dataToUpsert)) {
                Persentase::upsert(
                    $dataToUpsert,
                    ['nip'], // Kunci unik gabungan di DB tetap pakai 'date'
                    [
                        'nama',
                        'nip',
                        $bln
                    ]
                );

            }
        });

        return redirect('/pic/simpan-persentase')->with('success', 'Hitung Persentase bulan '.$bln.' berhasil dilakukan.');
        // return 'coba persentase sukses';

    }

    // persentase v2
    public function persentasev2()
    {
        // $unorSimpegnas = DataAbsen::select('unor_simpegnas')->distinct()->get();
        // $data = $unorSimpegnas;

        // return view('admin.persentase.setPersentasev2', compact('data'));

        $tahun = date('Y');

        // tanggal 01 tiap bulan pada tahun berjalan
        // memakai whereIn supaya bisa memakai index dan tidak memakai fungsi pada kolom date (varchar)
        $tanggalTanggal01 = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $tanggalTanggal01[] = sprintf('%s-%02d-01', $tahun, $bulan);
        }

        // Ambil semua data tanggal 01 pada tahun berjalan
        $dataAbsen = DataAbsen::select(
                'unor_simpegnas',
                'date',
                'persentase'
            )
            ->whereIn('date', $tanggalTanggal01)
            ->get();

        // Kelompokkan berdasarkan kantor / unor_simpegnas
        $data = $dataAbsen
            ->groupBy('unor_simpegnas')
            ->map(function ($rows, $unorSimpegnas) {

                $item = [
                    'unor_simpegnas' => $unorSimpegnas,
                ];

                // Default semua bulan = belum dihitung
                // | 0 = Hitung
                // | 1 = Hitung Ulang
                for ($bulan = 1; $bulan <= 12; $bulan++) {
                    $item["bulan_$bulan"] = 0;
                }


                // Cek persentase masing-masing bulan
                foreach ($rows as $row) {

                    // Hanya dianggap sudah dihitung
                    // jika persentase tidak NULL
                    if ($row->persentase !== null) {

                        $bulan = date('n', strtotime($row->date));

                        $item["bulan_$bulan"] = 1;
                    }
                }

                return $item;
            })
            ->values();

        return view(
            'admin.persentase.setPersentasev2', compact('data')
        );
    }

    // ini dipanggil dari route
    public function __hitungPersentasev2(Request $request)
    {
        $request->validate([
            'namaKantor'            => 'required|string', //DIKES - PKM PARUGA - Pustu Posprim Kel. Dara
            'bulanUntukDihitung' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12',
        ]);

        $selectedKantor = $request->input('namaKantor', '');
        $bln = $request->input('bulanUntukDihitung', date('m'));

        $kantor = ListKantor::select('id_kantor')
            ->where('nama_kantor', $selectedKantor)
            ->first();

        if (! $kantor) {
            return redirect('/pic/simpan-persentase-v2')
                ->with('error', 'Kantor '.$selectedKantor.' tidak ditemukan.');
        }

        $tahun = date('Y');
        $tanggal01 = $tahun.'-'.$bln.'-01';

        // jumlahkan kode absen per NIP, hanya kolom yang dipakai untuk hitung
        // hasilnya sama dengan rekap tampilan, tapi tidak memuat data ASN / field tampilan
        $kodeAbsen = PicController::kodeAbsen();
        $jumlahKodePerNip = [];
        $namaPerNip = [];
        $adaBarisTanggal01 = [];

        DataAbsen::query()
            ->select(['id', 'nip', 'nama', 'date', 'hari_libur', 'status', 'status_change', 'status_script'])
            ->where('unor_simpegnas_id', $kantor->id_kantor)
            ->whereLike('date', $tahun.'-'.$bln.'%')
            ->chunkById(2000, function (Collection $records) use (&$jumlahKodePerNip, &$namaPerNip, &$adaBarisTanggal01, $kodeAbsen, $tanggal01) {
                foreach ($records as $record) {
                    $nip = $record->nip;

                    $jumlahKodePerNip[$nip] ??= array_fill_keys($kodeAbsen, 0);
                    $namaPerNip[$nip] ??= $record->nama;

                    // persentase disimpan di baris tanggal 01
                    if ($record->date === $tanggal01) {
                        $adaBarisTanggal01[$nip] = true;
                    }

                    // hitung isi kolom status change dan atau status_script, jika hari libur, hitungan dilewati
                    $st = $record->status_change ?: $record->status_script ?? '';
                    if ($st === 'TK' && $record->hari_libur == 1) {
                        continue;
                    }
                    // aktifkan jika ingin pakai LN dilewati
                    if ($record->status == 'LN') {
                        continue;
                    }
                    if (isset($jumlahKodePerNip[$nip][$st])) {
                        $jumlahKodePerNip[$nip][$st]++;
                    }
                }
            });

        $picController = new PicController();
        $dataToUpdate = [];

        foreach ($jumlahKodePerNip as $nip => $jumlahKode) {
            // jika NIP tidak punya baris tanggal 01, tidak ada yang diupdate (sama seperti update per baris lama)
            if (! isset($adaBarisTanggal01[$nip])) {
                continue;
            }

            $rekapTerjumlah = $picController->__jumlahkanBeberapaKode([
                'nip'   => $nip,
                'nama'  => $namaPerNip[$nip],
                'rekap' => $jumlahKode,
            ]);

            $persentases = ($jumlahKode['TK'] * 3)
                + ($rekapTerjumlah['TL1'] * 0.5)
                + ($rekapTerjumlah['TL2'] * 1)
                + ($rekapTerjumlah['TL3'] * 1.25)
                + ($rekapTerjumlah['TL4'] * 1.5)
                + ($rekapTerjumlah['PSW1'] * 0.5)
                + ($rekapTerjumlah['PSW2'] * 1)
                + ($rekapTerjumlah['PSW3'] * 1.25)
                + ($rekapTerjumlah['PSW4'] * 1.5);

            $persentase = round((1 - ($persentases / 100)) * 100, 2);

            $dataToUpdate[] = [
                'nip'        => $nip,
                'persentase' => $persentase,
            ];
        }

        // tulis persentase ke baris tanggal 01 per chunk
        // memakai UPDATE ... CASE, bukan upsert, karena kolom NOT NULL lain (checkIn_*)
        // tidak ada nilai defaultnya sehingga proses INSERT akan ditolak MySQL strict mode
        if (! empty($dataToUpdate)) {
            DB::transaction(function () use ($dataToUpdate, $tanggal01) {
                foreach (array_chunk($dataToUpdate, 500) as $chunk) {
                    $caseSql = [];
                    $caseParams = [];
                    $nipParams = [];

                    foreach ($chunk as $row) {
                        $caseSql[] = 'WHEN ? THEN ?';
                        $caseParams[] = $row['nip'];
                        $caseParams[] = $row['persentase'];
                        $nipParams[] = $row['nip'];
                    }

                    $inPlaceholders = implode(',', array_fill(0, count($nipParams), '?'));

                    $sql = 'UPDATE data_absens SET persentase = CASE nip '.implode(' ', $caseSql)
                        .' ELSE persentase END WHERE date = ? AND nip IN ('.$inPlaceholders.')';

                    DB::update($sql, array_merge($caseParams, [$tanggal01], $nipParams));
                }
            });
        }

        return redirect('/pic/simpan-persentase-v2')->with('success', 'Hitung Persentase bulan '.$bln.' pada kantor '.$selectedKantor.' berhasil dilakukan.');

    }
}
