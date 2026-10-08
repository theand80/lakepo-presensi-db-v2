<?php

namespace App\Http\Controllers;

use App\Exports\downloadPresensiRekapByKantorExcelExport;
use App\Models\AsnDariApi;
use App\Models\DataAbsen;
use App\Models\DataAsn;
use App\Models\ListKantor;
use App\Models\Persentase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // index: rekap dari data DB hasil import_api
    public function index()
    {
        // dd(empty($request->all()));
        // if (empty($request->all())) {

        // kantor yang ada di data absen
        // di data absen, kolom unor_simpegnas, cari yang sama di AsnDariApi kolom unor_simpegnas,
        // jika sama, ambil kolom unor_siasn_induk, munculkan di list
        // $listKantor = AsnDariApi::select('unor_siasn_induk')->whereIn('unor_simpegnas', $unorSimpegnas)->distinct()->pluck('unor_siasn_induk')->values();

        $unorSimpegnas = DataAbsen::select('unor_simpegnas')->distinct()->get();
        // $listKantor = AsnDariApi::select('unor_siasn_induk', 'unor_simpegnas')->whereIn('unor_simpegnas', $unorSimpegnas)->distinct()->pluck('unor_siasn_induk')->values();

        $listKantor = AsnDariApi::select('unor_siasn_induk', 'unor_simpegnas')
            ->whereIn('unor_simpegnas', $unorSimpegnas)
            ->distinct()
            ->pluck('unor_siasn_induk')
            ->unique()
            ->values();

        // dd($unorSimpegnas);
        // dd($listKantor);

        $selectedMonth = date('Y-m');

        $data = [];

        $selectedKantor = null;

        return view('pic.rekap', compact('data', 'listKantor', 'selectedMonth', 'selectedKantor'));
        // }

        // dd($request);

    }

    public function lihatSatuKantorSaja(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'filterNamaKantor' => 'required|string',
            'month' => 'required|date',
        ]);

        $selectedMonth = $request->input('month', date('Y-m'));
        $selectedKantor = $request->input('filterNamaKantor', '');

        $data = $this->__rekapSatuKantor($selectedKantor, $selectedMonth);

        // $persentases = Persentase::get();

        // $persentaseByNip = $persentases->keyBy('nip');
        // $data = collect($data)->map(
        //     function ($item) use ($persentaseByNip, ) {
        //         $persentase = $persentaseByNip->get($item['nip']);
        //         if ($persentase) {
        //             $item['persentase'] = $persentase->{'08'};
        //         }
        //         return $item;
        //     }
        // )
        // ->sortByDesc(function ($item) {
        //         return $item['persentase'] ?? 0;
        //     })
        // ->values()->toArray();

        // List Kantor
        $unorSimpegnas = DataAbsen::select('unor_simpegnas')->distinct()->get();
        $listKantor = AsnDariApi::select('unor_siasn_induk', 'unor_simpegnas')
            ->whereIn('unor_simpegnas', $unorSimpegnas)
            ->distinct()
            ->pluck('unor_siasn_induk')
            ->unique()
            ->values();

        return view('pic.rekapSatuKantorSiasnSaja', compact('data', 'listKantor', 'selectedMonth', 'selectedKantor'));
    }

    public function __rekapSatuKantor(string $selectedKantor, string $tgl): array
    {
        $kantorYgDicariDatanya = AsnDariApi::where('unor_siasn_induk', $selectedKantor)->select('unor_simpegnas')->distinct()->get();
        $listKantor = ListKantor::get();

        $hasil = [];
        foreach ($kantorYgDicariDatanya as $data) {
            $id = collect($listKantor)->firstWhere('nama_kantor', $data['unor_simpegnas']);
            if ($id !== null) {
                $hasil[] = $id;
            }
        }

        $data = [];
        foreach ($hasil as $id_kantor) {
            $data[] = $this->__dataYangDitampilkan($id_kantor, $tgl);
        }

        return collect($data)->flatten(1)->values()->toArray();
    }

    /**
     * Daftar kode status absen yang dikenali saat rekap.
     *
     * @return array<int, string>
     */
    public static function kodeAbsen(): array
    {
        return [
            'HN',
            'DL',
            'TB',
            'CT',
            'CM',
            'CB',
            'CS',
            'CAP',
            'CTLN',
            'CH',
            'TK',
            'TAS',
            'TM1',
            'TM2',
            'TM3',
            'TM4',
            'CP1',
            'CP2',
            'CP3',
            'CP4',
            'TAK',
            //
            'PGN',
            'PLN',
            //
            'TAD-PLN',
            'PGN-TAP',
            //
            'TM1-PLN',
            'TM2-PLN',
            'TM3-PLN',
            'TM4-PLN',
            //
            'PGN-CP1',
            'PGN-CP2',
            'PGN-CP3',
            'PGN-CP4',
            //
            'TAD-CP1',
            'TAD-CP2',
            'TAD-CP3',
            'TAD-CP4',
            //
            'TM1-TAP',
            'TM2-TAP',
            'TM3-TAP',
            'TM4-TAP',
            //
            'TM1-CP1',
            'TM2-CP1',
            'TM3-CP1',
            'TM4-CP1',
            //
            'TM1-CP2',
            'TM2-CP2',
            'TM3-CP2',
            'TM4-CP2',
            //
            'TM1-CP3',
            'TM2-CP3',
            'TM3-CP3',
            'TM4-CP3',
            //
            'TM1-CP4',
            'TM2-CP4',
            'TM3-CP4',
            'TM4-CP4',
        ];
    }

    // dipanggil di index -> diatas, lihatSatuKantorSaja -> diatas dan dari __hitungPersentase -> dibawah
    public function __dataYangDitampilkan($unor_simpegnas_id, $tgl)
    {
        // dd($tgl);
        // dd($unor_simpegnas_id->id_kantor);

        $records = DataAbsen::where('unor_simpegnas_id', $unor_simpegnas_id->id_kantor)->whereLike('date', $tgl.'%')->get()
            ->groupBy('nip');

        // Ambil data ASN dan jadikan NIP sebagai key
        $dataAsn = AsnDariApi::select('nip', 'pangkat', 'golongan', 'status', 'jabatan')->get()->keyBy('nip');

        // $nipList = $records->keys()->toArray();

        // dd($records);
        // dd($records['197009131999021001'][0]['nama']);

        $kodeAbsen = self::kodeAbsen();

        $data = [];

        foreach ($records as $nip => $group) {

            // Cari data ASN berdasarkan NIP
            $asn = $dataAsn->get($nip);

            //  Ambil record tanggal 01
            // | Jika $tgl = 2026-08 | maka tanggal yang dicari: 2026-08-01
            $tanggal01 = $tgl.'-01';
            $recordTanggal01 = $group->first(function ($record) use ($tanggal01) {
                return $record->date == $tanggal01;
            });

            // Ambil persentase dari tanggal 01, Jika belum ada atau NULL, maka NULL.
            $persentase = $recordTanggal01?->persentase;

            $rekap = [
                'nip' => $nip,
                'nama' => $group[0]['nama'],

                'golongan' => $asn->golongan ?? '',
                'pangkat' => $asn->pangkat ?? '',
                'jabatan' => $asn->jabatan ?? '-',
                'status' => $asn->status ?? '-',
                'kantor' => $group[0]->unor_simpegnas ?? '-',
                'persentase' => $persentase,
                'rekap' => array_fill_keys($kodeAbsen, 0),
            ];

            // hitung isi kolom status change dan atau status_script, jika hari libur, hitungan dilewati
            foreach ($group as $record) {
                $st = $record->status_change ?: $record->status_script ?? '';
                if ($st === 'TK' && $record->hari_libur == 1) {
                    continue;
                }
                // aktifkan jika ingin pakai LN dilewati
                if ($record->status == 'LN') {
                    continue;
                }
                if (isset($rekap['rekap'][$st])) {
                    $rekap['rekap'][$st]++;
                }
            }

            // jumlahkan beberapa kode, cukup sekali per NIP karena hasilnya hanya bergantung pada jumlah kode
            [
                'TL1' => $rekap['rekap']['TL1'],
                'TL2' => $rekap['rekap']['TL2'],
                'TL3' => $rekap['rekap']['TL3'],
                'TL4' => $rekap['rekap']['TL4'],
                'PSW1' => $rekap['rekap']['PSW1'],
                'PSW2' => $rekap['rekap']['PSW2'],
                'PSW3' => $rekap['rekap']['PSW3'],
                'PSW4' => $rekap['rekap']['PSW4'],
                'H' => $rekap['hadir'],
            ] = $this->__jumlahkanBeberapaKode($rekap); // dibawah

            $data[] = $rekap;
        }

        usort($data, function ($a, $b) {

            $persentaseA = $a['persentase'];
            $persentaseB = $b['persentase'];

            // Keduanya NULL
            if ($persentaseA === null && $persentaseB === null) {
                return 0;
            }
            // A NULL → A ke bawah
            if ($persentaseA === null) {
                return 1;
            }
            // B NULL → B ke bawah
            if ($persentaseB === null) {
                return -1;
            }

            // Persentase terbesar di atas
            return $persentaseB <=> $persentaseA;
        });

        return $data;
    }

    // dipanggil dari __dataYangDitampilkan diatas dan dari PersentaseController
    /**
     * Jumlahkan kode absen mentah menjadi TL1-TL4 dan PSW1-PSW4.
     *
     * @param  array<string, mixed>  $rekap
     * @return array<string, mixed>
     */
    public function __jumlahkanBeberapaKode(array $rekap): array
    {
        // dd($rekap);
        //
        $rekap['rekap']['TL1'] = $rekap['rekap']['TM1'] + $rekap['rekap']['TM1-CP1']
            + $rekap['rekap']['TM1-CP2'] + $rekap['rekap']['TM1-CP3'] + $rekap['rekap']['TM1-CP4']
            + $rekap['rekap']['TM1-PLN'] + $rekap['rekap']['TM1-TAP'];

        $rekap['rekap']['TL2'] = $rekap['rekap']['TM2'] + $rekap['rekap']['TM2-CP1']
            + $rekap['rekap']['TM2-CP2'] + $rekap['rekap']['TM2-CP3'] + $rekap['rekap']['TM2-CP4']
            + $rekap['rekap']['TM2-PLN'] + $rekap['rekap']['TM2-TAP'];

        $rekap['rekap']['TL3'] = $rekap['rekap']['TM3'] + $rekap['rekap']['TM3-CP1']
            + $rekap['rekap']['TM3-CP2'] + $rekap['rekap']['TM3-CP3'] + $rekap['rekap']['TM3-CP4']
            + $rekap['rekap']['TM3-PLN'] + $rekap['rekap']['TM3-TAP'];

        $rekap['rekap']['TL4'] = $rekap['rekap']['TM4'] + $rekap['rekap']['TM4-CP1']
            + $rekap['rekap']['TM4-CP2'] + $rekap['rekap']['TM4-CP3'] + $rekap['rekap']['TM4-CP4']
            + $rekap['rekap']['TM4-PLN'] + $rekap['rekap']['TM4-TAP']
            + $rekap['rekap']['TAD-CP1'] + $rekap['rekap']['TAD-CP2'] + $rekap['rekap']['TAD-CP3']
            + $rekap['rekap']['TAD-CP4'] + $rekap['rekap']['TAD-PLN'];

        $rekap['rekap']['PSW1'] = $rekap['rekap']['CP1'] + $rekap['rekap']['TM1-CP1']
            + $rekap['rekap']['TM2-CP1'] + $rekap['rekap']['TM3-CP1'] + $rekap['rekap']['TM4-CP1']
            + $rekap['rekap']['PGN-CP1'] + $rekap['rekap']['TAD-CP1'];

        $rekap['rekap']['PSW2'] = $rekap['rekap']['CP2'] + $rekap['rekap']['TM1-CP2']
            + $rekap['rekap']['TM2-CP2'] + $rekap['rekap']['TM3-CP2'] + $rekap['rekap']['TM4-CP2']
            + $rekap['rekap']['PGN-CP2'] + $rekap['rekap']['TAD-CP2'];

        $rekap['rekap']['PSW3'] = $rekap['rekap']['CP3'] + $rekap['rekap']['TM1-CP3']
            + $rekap['rekap']['TM2-CP3'] + $rekap['rekap']['TM3-CP3'] + $rekap['rekap']['TM4-CP3']
            + $rekap['rekap']['PGN-CP3'] + $rekap['rekap']['TAD-CP3'];

        $rekap['rekap']['PSW4'] = $rekap['rekap']['CP4'] + $rekap['rekap']['TM1-CP4']
            + $rekap['rekap']['TM2-CP4'] + $rekap['rekap']['TM3-CP4'] + $rekap['rekap']['TM4-CP4']
            + $rekap['rekap']['PGN-CP4'] + $rekap['rekap']['TAD-CP4']
            + $rekap['rekap']['TM1-TAP'] + $rekap['rekap']['TM2-TAP'] + $rekap['rekap']['TM3-TAP']
            + $rekap['rekap']['TM4-TAP'] + $rekap['rekap']['PGN-TAP'];

        $rekap['hadir'] = $rekap['rekap']['HN']
            + $rekap['rekap']['TM1'] + $rekap['rekap']['TM2'] + $rekap['rekap']['TM3'] + $rekap['rekap']['TM4']
            + $rekap['rekap']['CP1'] + $rekap['rekap']['CP2'] + $rekap['rekap']['CP3'] + $rekap['rekap']['CP4']
            + $rekap['rekap']['TM1-CP1'] + $rekap['rekap']['TM1-CP2'] + $rekap['rekap']['TM1-CP3'] + $rekap['rekap']['TM1-CP4']
            + $rekap['rekap']['TM2-CP1'] + $rekap['rekap']['TM2-CP2'] + $rekap['rekap']['TM2-CP3'] + $rekap['rekap']['TM2-CP4']
            + $rekap['rekap']['TM3-CP1'] + $rekap['rekap']['TM3-CP2'] + $rekap['rekap']['TM3-CP3'] + $rekap['rekap']['TM3-CP4']
            + $rekap['rekap']['TM4-CP1'] + $rekap['rekap']['TM4-CP2'] + $rekap['rekap']['TM4-CP3'] + $rekap['rekap']['TM4-CP4']
            + $rekap['rekap']['TM1-PLN'] + $rekap['rekap']['TM1-TAP']
            + $rekap['rekap']['TM2-PLN'] + $rekap['rekap']['TM2-TAP']
            + $rekap['rekap']['TM3-PLN'] + $rekap['rekap']['TM3-TAP']
            + $rekap['rekap']['TM4-PLN'] + $rekap['rekap']['TM4-TAP']

            + $rekap['rekap']['PGN-CP1'] + $rekap['rekap']['TAD-CP1']
            + $rekap['rekap']['PGN-CP2'] + $rekap['rekap']['TAD-CP2']
            + $rekap['rekap']['PGN-CP3'] + $rekap['rekap']['TAD-CP3']
            + $rekap['rekap']['PGN-CP4'] + $rekap['rekap']['TAD-CP4'];

        return [
            'TL1' => $rekap['rekap']['TL1'],
            'TL2' => $rekap['rekap']['TL2'],
            'TL3' => $rekap['rekap']['TL3'],
            'TL4' => $rekap['rekap']['TL4'],
            'PSW1' => $rekap['rekap']['PSW1'],
            'PSW2' => $rekap['rekap']['PSW2'],
            'PSW3' => $rekap['rekap']['PSW3'],
            'PSW4' => $rekap['rekap']['PSW4'],
            'H' => $rekap['hadir'],
        ];
    }

    public function downloadPresensiRekapByKantorExcel(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'namaKantor' => 'required|string',
            'month' => 'required|date',
        ]);

        $opd = $request->input('namaKantor', ''); // "Badan Kepegawaian dan Pengembangan Sumber Daya Manusia"
        $month = $request->input('month', date('Y-m')); // "2026-08"
        $bln = substr($month, 5, 2); // 08
        $thn = substr($month, 0, 4); // 08

        //
        $filename = 'kehadiran ASN bulan '.$bln.' tahun '.$thn.' di '.str_replace('/', '-', $opd).'.xlsx';
        $data = $this->__rekapSatuKantor($opd, $month);

        return Excel::download(new downloadPresensiRekapByKantorExcelExport($data, $opd, $month), $filename);

    }

    public function bpk(Request $request)
    {
        return view('pic.bpk');
    }

    /**
     * Display the specified resource.
     */
    // rakapByNip
    public function show()
    {
        // \Carbon\Carbon::setLocale('id');

        // $asn = DataAsn::where('nip', $nip)->first()
        //     ?: new DataAsn([
        //         'nip'              => $nip,
        //         'pangkat'          => '',
        //         'golongan'         => '',
        //         'jabatan'          => '-',
        //         'status'           => '-',
        //         'unor_siasn_induk' => '-',
        //     ]);

        // $records = DataAbsen::where('nip', $nip)
        //     ->where('date', 'like', $bulan . '%')
        //     ->orderBy('date')
        //     ->get();

        // $presensi = [];
        // foreach ($records as $rec) {
        //     $presensi[] = [
        //         'id'        => $rec->id,
        //         'tgl'       => $rec->date,
        //         'jam_pagi'  => $rec->checkIn_time_with_timezone_change ?: $rec->checkIn_time_with_timezone,
        //         'jam_siang' => $rec->checkRest_time_with_timezone_change ?: $rec->checkRest_time_with_timezone,
        //         'jam_sore'  => $rec->checkOut_time_with_timezone_change ?: $rec->checkOut_time_with_timezone,
        //         'pagi'      => $rec->checkIn_status_change ?: $rec->checkIn_status,
        //         'siang'     => $rec->checkRest_status_change ?: $rec->checkRest_status,
        //         'sore'      => $rec->checkOut_status_change ?: $rec->checkOut_status,
        //         'keterangan' => $rec->status_change ?: $rec->status ?? '-',
        //         'change_applied' => (bool) ($rec->status_change
        //             || $rec->checkIn_status_change
        //             || $rec->checkIn_time_with_timezone_change
        //             || $rec->checkRest_status_change
        //             || $rec->checkRest_time_with_timezone_change
        //             || $rec->checkOut_status_change
        //             || $rec->checkOut_time_with_timezone_change),
        //         'change'    => [
        //             'status_change'                          => $rec->status_change,
        //             'checkIn_status_change'                  => $rec->checkIn_status_change,
        //             'checkIn_time_with_timezone_change'      => $rec->checkIn_time_with_timezone_change,
        //             'checkRest_status_change'                => $rec->checkRest_status_change,
        //             'checkRest_time_with_timezone_change'    => $rec->checkRest_time_with_timezone_change,
        //             'checkOut_status_change'                 => $rec->checkOut_status_change,
        //             'checkOut_time_with_timezone_change'     => $rec->checkOut_time_with_timezone_change,
        //         ],
        //     ];
        // }

        // $data = [
        //     'nip'      => $nip,
        //     'nama'     => $records->first()->nama ?? $asn->nama,
        //     'presensi' => $presensi,
        // ];

        // $totalHari  = count($presensi);
        // $totalHadir = $records->filter(fn($r) => in_array($r->status_change ?: $r->status, ['H', 'HN']))->count();

        // return view('pic.detail_RekapByNip', compact('asn', 'data', 'bulan', 'persen', 'totalHari', 'totalHadir'));
        return view('pic.detail_RekapByNip');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = DataAbsen::findOrFail($id);

        $data = $request->validate([
            'status_change' => 'nullable|string|max:10',
            'checkIn_status_change' => 'nullable|string|max:10',
            'checkIn_time_with_timezone_change' => 'nullable|string|max:19',
            'checkRest_status_change' => 'nullable|string|max:10',
            'checkRest_time_with_timezone_change' => 'nullable|string|max:19',
            'checkOut_status_change' => 'nullable|string|max:10',
            'checkOut_time_with_timezone_change' => 'nullable|string|max:19',
        ]);

        foreach (['checkIn_time_with_timezone_change', 'checkRest_time_with_timezone_change', 'checkOut_time_with_timezone_change'] as $field) {
            // $data[$field] = $this->normalizeTime($data[$field]);
        }

        $record->update($data);

        return redirect()->back()->with('success', 'Data presensi berhasil diperbarui.');
    }
}
