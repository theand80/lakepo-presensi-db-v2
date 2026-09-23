<?php

namespace App\Http\Controllers;

use App\Models\DataAbsen;
use App\Models\JamReferensi;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\ListKantor;
use Carbon\Carbon;

class AdminController extends Controller
{

    public function index()
    {
        // $jam = JamReferensi::all();
        // dd( $jam [0]['waktu']);
        return view('admin.dashboard');
    }

    public function listKantorDariApiIndex()
    {
        $response = Http::withHeaders([
            'presensi-key' => config('services.apiSimpegnas.key'),
        ])->get('https://api-absensi.simpegnas.go.id/absensi/api/get/kantor');

        $data = $response->json()['data']['kantor']; //data

        // $listKantor = array_slice($data, 73, 5);
        $listKantor = $data;

        return view('admin.listKantorDariApi', ['data' => $listKantor]);
    }

    public function simpanListKantorkeDB()
    {
        $response = Http::withHeaders([
            'presensi-key' => config('services.apiSimpegnas.key'),
        ])->get('https://api-absensi.simpegnas.go.id/absensi/api/get/kantor');

        $datas = $response->json()['data']['kantor']; //data
        $data = array_slice($datas, 73, 5);

        DB::transaction(function () use ($data) {
            $dataToUpsert = [];
            foreach ($data as $item) {
                $dataToUpsert[] = [
                    'id_kantor' => $item['id'],
                    'nama_kantor' => $item['nama_kantor'],
                ];
            }

            if (!empty($dataToUpsert)) {
                ListKantor::upsert(
                    $dataToUpsert,
                    ['id_kantor'],
                    ['nama_kantor', 'updated_at']
                );
            };
        });

        return redirect('/admin/listKantorDariDBIndex')->with('status', 'List Kantor berhasil disimpan ke DB');
    }

    public function listKantorDariDBIndex()
    {
        $listKantor = ListKantor::all();

        return view('admin.listKantorDariApi', ['data' => $listKantor]);
    }

    private function __rekapBulananByKantor($id, $month)
    {
        // 1. Pecah bulan dan tahun
        $tahun = explode("-", $month)[0];
        $bulan = explode("-", $month)[1];

        // 2. Siapkan wadah untuk menampung semua data kantor
        $semuaDataKantor = [];

        // 3. Pastikan $id selalu berupa array (antisipasi jika hanya 1 ID berupa string yang dikirim)
        $idArray = is_array($id) ? $id : [$id];

        // 4. Looping untuk mengambil data dari setiap ID kantor
        foreach ($idArray as $kantorId) {
            $url = "https://api-absensi.simpegnas.go.id/absensi/api/get/rekap-bulanan-by-kantor?kantor_id={$kantorId}&tahun={$tahun}&bulan={$bulan}";
            $apiKey = config('services.apiSimpegnas.key');
            $response = Http::withHeaders([
                'presensi-key' => $apiKey,
            ])->get($url);

            // 5. Periksa jika request sukses dan data ada
            if ($response->successful() && isset($response->json()['data'])) {
                $dataKantor = $response->json()['data'];

                // 6. Gabungkan data ke wadah utama
                // $semuaDataKantor[] = $dataKantor; 
                // ATAU gunakan array_merge jika data berbentuk list/array numerik:
                $semuaDataKantor = array_merge($semuaDataKantor, $dataKantor);
            }
        }

        // 7. Kembalikan semua data yang sudah utuh berkumpul
        // dd($semuaDataKantor[1]);
        return $semuaDataKantor;
        // return array_slice($semuaDataKantor, 18, 5);
    }

    public function lihatDataAbsenDariApi()
    {
        //
        $nama_kantor = 'BKPSDM';
        $id = 'c9956f8f-77ea-4bbf-a22a-182b6ac9823e';
        $tgl = '2026-8';


        $data = $this->__rekapBulananByKantor($id, $tgl);

        dd($data[0]);
        // return $data;
    }

    public function simpanDataAbsenDariApiKeDB(Request $request)
    {
        //
        // $request->validate([
        //     'kantor_id' => 'required',
        //     'kantor_nama' => 'required',
        //     'bulan' => 'required|integer|min:1|max:12',
        // ]);

        // $id = $request['kantor_id'] ?? 'c9956f8f-77ea-4bbf-a22a-182b6ac9823e';
        // $nama_kantor = $request['kantor_nama'] ?? 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia test';

        // $tgl = '2026-' . $request['bulan'] ?? '2026-07'; //

        $id = $request['kantor_id'] ?? 'fd7277d4-c35d-4de5-a479-1adad7cfceed';
        $nama_kantor = $request['kantor_nama'] ?? 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu - Kantor test';

        $tgl = '2026-07'; //

        $datas = $this->__rekapBulananByKantor($id, $tgl);

        // dd($datas);
        // dd($datas[1]['presensi']);

        $data = $datas;
        // $data = array_slice($datas, 2, 3);

        // dd($data);
        // return $data;
        DB::transaction(function () use ($data, $nama_kantor, $id) {

            $dataToUpsert = [];

            // Loop Tingkat 1: Mengambil employee_id
            foreach ($data as $item) {
                $employeeNip = $item['nip'];
                $employeeNama = $item['nama'];
                $tahun = $item['tahun'];
                $bulan = $item['bulan'];


                // Loop Tingkat 2: Mengambil array presensi
                foreach ($item['presensi'] as $presensi) {
                    $day = $presensi['day']; // Angka 1-31
                    $status = $presensi['status'];
                    $late = $presensi['late'];

                    // Format angka bulan dan hari agar selalu 2 digit (misal: 8 menjadi 08, 5 menjadi 05)
                    $bulanFormat = sprintf('%02d', $bulan);
                    $dayFormat = sprintf('%02d', $day);
                    // Gabungkan menjadi format tanggal standar SQL: YYYY-MM-DD
                    $fullDate = "{$tahun}-{$bulanFormat}-{$dayFormat}";



                    $kodeAbsen = [
                        'H',
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
                        'TMM',
                        'PC1',
                        'PC2',
                        'PC3',
                        'PCM',
                        'TAK',
                        'TM1-PC1',
                        'TM1-PC2',
                        'TM1-PC3',
                        'TM1-PCM',
                        'TM2-PC1',
                        'TM2-PC2',
                        'TM2-PC3',
                        'TM2-PCM',
                        'TM3-PC1',
                        'TM3-PC2',
                        'TM3-PC3',
                        'TM3-PCM',
                        'TMM-PC1',
                        'TMM-PC2',
                        'TMM-PC3',
                        //
                        'TM1-SN',
                        'TM2-SN',
                        'TM3-SN',
                        'TMM-SN',
                        'PN-PC1',
                        'PN-PC2',
                        'PN-PC3',
                        'PN-PCM',
                    ];


                    // $status_script = $this->__nilaiStatusScript($presensi['checkIn']['time_with_timezone'], $presensi['checkOut']['time_with_timezone']); 
                    // [
                    //     $checkIn_status_script, $checkOut_status_script, $status_script
                    // ] = $this->__nilaiStatusScript(
                    //     $presensi['checkIn']['time_with_timezone'], $presensi['checkOut']['time_with_timezone']
                    // );
                    [
                        'checkIn_status_script' => $checkIn_status_script,
                        'checkOut_status_script' => $checkOut_status_script,
                        'status_script' => $status_script,
                    ] = $this->__nilaiStatusScript(
                        $presensi['checkIn']['time_with_timezone'],
                        $presensi['checkOut']['time_with_timezone'],
                        $fullDate
                    );

                    // sabtu + Minggu
                    $date = Carbon::parse($fullDate);
                    $sabming = $date->isWeekend() ? 1 : '';


                    // Masukkan ke array penampung dengan format kolom database
                    $dataToUpsert[] = [
                        'nip'                           => $employeeNip,
                        'nama'                          => $employeeNama,
                        'date'                          => $fullDate, //tahun - bulan // Disimpan sebagai tanggal lengkap di DB
                        'hari_libur'                    => $sabming, //sabtu atau minggu bernilai 1, lainnya 0
                        'kegiatan'                      => '',
                        'unor_simpegnas'                => $nama_kantor,
                        'unor_simpegnas_id'             => $id,

                        'status'                        => $status,
                        'status_script'                 => $status_script ?? null,
                        'late'                          => $late,

                        'checkIn_work_from'             => $presensi['checkIn']['work_from'] ?? null,
                        'checkIn_status'                => $presensi['checkIn']['status'] ?? null,
                        'checkIn_status_script'         => $checkIn_status_script ?? null,
                        'checkIn_time_with_timezone'    => $presensi['checkIn']['time_with_timezone'] ?? null,
                        'checkIn_late'                  => $presensi['checkIn']['late'] ?? null,

                        'checkRest_work_from'             => $presensi['checkRest']['work_from'] ?? null,
                        'checkRest_status'                => $presensi['checkRest']['status'] ?? null,
                        'checkRest_time_with_timezone'    => $presensi['checkRest']['time_with_timezone'] ?? null,
                        'checkRest_late'                  => $presensi['checkRest']['late'] ?? null,

                        'checkOut_work_from'             => $presensi['checkOut']['work_from'] ?? null,
                        'checkOut_status'                => $presensi['checkOut']['status'] ?? null,
                        'checkOut_status_script'         => $checkOut_status_script ?? null,
                        'checkOut_time_with_timezone'    => $presensi['checkOut']['time_with_timezone'] ?? null,
                        'checkOut_late'                  => $presensi['checkOut']['late'] ?? null,

                        'tak'                            => $presensi['tak'] ?? 0,

                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ];
                }
            }

            // 3. Eksekusi Upsert Massal (Tetap menggunakan acuan unique gabungan)
            if (!empty($dataToUpsert)) {
                // ImportApi::insert($dataToUpsert);
                DataAbsen::upsert(
                    $dataToUpsert,
                    ['nip', 'date'], // Kunci unik gabungan di DB tetap pakai 'date'
                    [
                        'status',
                        'status_script',
                        'late',

                        'unor_simpegnas',
                        'unor_simpegnas_id',

                        'checkIn_work_from',
                        'checkIn_status',
                        'checkIn_status_script',
                        'checkIn_time_with_timezone',
                        'checkIn_late',

                        'checkRest_work_from',
                        'checkRest_status',
                        'checkRest_time_with_timezone',
                        'checkRest_late',

                        'checkOut_work_from',
                        'checkOut_status',
                        'checkOut_status_script',
                        'checkOut_time_with_timezone',
                        'checkOut_late',

                        'tak',

                        'updated_at'
                    ]
                );
            }
        });

        // DB::table('list_kantors')
        //     ->where('id_kantor', $request['kantor_id'])
        //     ->update(['bulan_' . $request['bulan'] => '1']);

        return redirect('/pic/dashboard/pic')->with('status', 'Data berhasil disimpan');
    }

    private function __nilaiStatusScript($checkIn_nilai, $checkOut_nilai, $fullDate)
    {

        $jamRef = JamReferensi::all();
        // 
        // Reset setiap kali loop presensi
        $checkIn_status_script = null;
        // if (!empty($presensi['checkIn']['time_with_timezone'])) {
        if (!empty($checkIn_nilai)) {
            $checkInTime = Carbon::parse(
                // $presensi['checkIn']['time_with_timezone']
                $checkIn_nilai
            );
            $jam = $checkInTime->format('H:i:s');

            if (Carbon::parse($fullDate)->isFriday()) {
                // proses khusus hari Jumat
                // if ($jam > '09:00:00') {
                $jamRef4 = date('H:i:s', strtotime($jamRef[3]['waktu'] . ' -30 minutes'));
                $jamRef3 = date('H:i:s', strtotime($jamRef[2]['waktu'] . ' -30 minutes'));
                $jamRef2 = date('H:i:s', strtotime($jamRef[1]['waktu'] . ' -30 minutes'));
                $jamRef1 = date('H:i:s', strtotime($jamRef[0]['waktu'] . ' -30 minutes'));

                if ($jam > $jamRef4) {          // 09:00 -> 08:30
                    $checkIn_status_script = 'TM4';
                } elseif ($jam > $jamRef3) {    // 08:30 -> 08:00
                    $checkIn_status_script = 'TM3';
                } elseif ($jam > $jamRef2) {    // 08:00:30 -> 07:30:31
                    $checkIn_status_script = 'TM2';
                } elseif ($jam > '') {    // 07:30 -> 07:00
                    $checkIn_status_script = 'TM1';
                } else {
                    $checkIn_status_script = 'PGN';
                }
            } else {
                //
                // if ($jam > '09:00:00') {
                if ($jam > $jamRef[3]['waktu']) {  //'09:00:00'
                    $checkIn_status_script = 'TM4';
                } elseif ($jam > $jamRef[2]['waktu']) { //'08:30:00'
                    $checkIn_status_script = 'TM3';
                } elseif ($jam > $jamRef[1]['waktu']) { //'08:00:00'
                    $checkIn_status_script = 'TM2';
                } elseif ($jam > $jamRef[0]['waktu']) { //'07:30:31'
                    $checkIn_status_script = 'TM1';
                } elseif ($jam < $jamRef[0]['waktu']) { //'07:30:30'
                    $checkIn_status_script = 'PGN';
                }
            }
        }

        $checkOut_status_script = null;
        // if (!empty($presensi['checkOut']['time_with_timezone'])) {
        if (!empty($checkOut_nilai)) {
            $jamCheckOut = Carbon::parse(
                // $presensi['checkOut']['time_with_timezone']
                $checkOut_nilai
            )->format('H:i:s');
            if ($jamCheckOut < '14:30:00') {
                $checkOut_status_script = 'CP4';
            } elseif ($jamCheckOut >= '14:30:00' && $jamCheckOut < '15:00:00') {
                $checkOut_status_script = 'CP3';
            } elseif ($jamCheckOut >= '15:00:00' && $jamCheckOut < '15:30:00') {
                $checkOut_status_script = 'CP2';
            } elseif ($jamCheckOut >= '15:30:00' && $jamCheckOut < '16:00:00') {
                $checkOut_status_script = 'CP1';
            } elseif ($jamCheckOut >= '16:00:00') {
                $checkOut_status_script = 'PLN';
            }
        }
        // ============
        $status_script = null;
        if (empty($checkIn_status_script) && empty($checkOut_status_script)) {
            $status_script = 'TK';
        }

        if (empty($checkIn_status_script) && $checkOut_status_script == 'PLN') {
            $status_script = 'TAD-PLN';
        }
        if (empty($checkIn_status_script) && $checkOut_status_script == 'CP1') {
            $status_script = 'TAD-CP1';
        }
        if (empty($checkIn_status_script) && $checkOut_status_script == 'CP2') {
            $status_script = 'TAD-CP2';
        }
        if (empty($checkIn_status_script) && $checkOut_status_script == 'CP3') {
            $status_script = 'TAD-CP3';
        }
        if (empty($checkIn_status_script) && $checkOut_status_script == 'CP4') {
            $status_script = 'TAD-CP4';
        }

        if ($checkIn_status_script == 'PGN' && empty($checkOut_status_script)) {
            $status_script = 'PGN-TAP';
        }
        if ($checkIn_status_script == 'TM1' && empty($checkOut_status_script)) {
            $status_script = 'TM1-TAP';
        }
        if ($checkIn_status_script == 'TM2' && empty($checkOut_status_script)) {
            $status_script = 'TM2-TAP';
        }
        if ($checkIn_status_script == 'TM3' && empty($checkOut_status_script)) {
            $status_script = 'TM3-TAP';
        }
        if ($checkIn_status_script == 'TM4' && empty($checkOut_status_script)) {
            $status_script = 'TM4-TAP';
        }



        if (!empty($checkIn_status_script) && !empty($checkOut_status_script)) {
            # code...
            if ($checkIn_status_script == 'PGN' && $checkOut_status_script == 'PLN') {
                $status_script = 'HN';
            }

            // 
            if ($checkIn_status_script == 'TM1' && $checkOut_status_script == 'PLN') {
                $status_script = 'TM1';
            }
            if ($checkIn_status_script == 'TM2' && $checkOut_status_script == 'PLN') {
                $status_script = 'TM2';
            }
            if ($checkIn_status_script == 'TM3' && $checkOut_status_script == 'PLN') {
                $status_script = 'TM3';
            }
            if ($checkIn_status_script == 'TM4' && $checkOut_status_script == 'PLN') {
                $status_script = 'TM4';
            }

            // 
            if ($checkIn_status_script == 'PGN' && $checkOut_status_script == 'CP1') {
                $status_script = 'CP1';
            }
            if ($checkIn_status_script == 'TM1' && $checkOut_status_script == 'CP1') {
                $status_script = 'TM1-CP1';
            }
            if ($checkIn_status_script == 'TM2' && $checkOut_status_script == 'CP1') {
                $status_script = 'TM2-CP1';
            }
            if ($checkIn_status_script == 'TM3' && $checkOut_status_script == 'CP1') {
                $status_script = 'TM3-CP1';
            }
            if ($checkIn_status_script == 'TM4' && $checkOut_status_script == 'CP1') {
                $status_script = 'TM4-CP1';
            }

            // 
            if ($checkIn_status_script == 'PGN' && $checkOut_status_script == 'CP2') {
                $status_script = 'CP2';
            }
            if ($checkIn_status_script == 'TM1' && $checkOut_status_script == 'CP2') {
                $status_script = 'TM1-CP2';
            }
            if ($checkIn_status_script == 'TM2' && $checkOut_status_script == 'CP2') {
                $status_script = 'TM2-CP2';
            }
            if ($checkIn_status_script == 'TM3' && $checkOut_status_script == 'CP2') {
                $status_script = 'TM3-CP2';
            }
            if ($checkIn_status_script == 'TM4' && $checkOut_status_script == 'CP2') {
                $status_script = 'TM4-CP2';
            }

            // 
            if ($checkIn_status_script == 'PGN' && $checkOut_status_script == 'CP3') {
                $status_script = 'CP3';
            }
            if ($checkIn_status_script == 'TM1' && $checkOut_status_script == 'CP3') {
                $status_script = 'TM1-CP3';
            }
            if ($checkIn_status_script == 'TM2' && $checkOut_status_script == 'CP3') {
                $status_script = 'TM2-CP3';
            }
            if ($checkIn_status_script == 'TM3' && $checkOut_status_script == 'CP3') {
                $status_script = 'TM3-CP3';
            }
            if ($checkIn_status_script == 'TM4' && $checkOut_status_script == 'CP3') {
                $status_script = 'TM4-CP3';
            }

            // 
            if ($checkIn_status_script == 'PGN' && $checkOut_status_script == 'CP4') {
                $status_script = 'CP4';
            }
            if ($checkIn_status_script == 'TM1' && $checkOut_status_script == 'CP4') {
                $status_script = 'TM1-CP4';
            }
            if ($checkIn_status_script == 'TM2' && $checkOut_status_script == 'CP4') {
                $status_script = 'TM2-CP4';
            }
            if ($checkIn_status_script == 'TM3' && $checkOut_status_script == 'CP4') {
                $status_script = 'TM3-CP4';
            }
            if ($checkIn_status_script == 'TM4' && $checkOut_status_script == 'CP4') {
                $status_script = 'TM4-CP4';
            }
        }

        // return [$checkIn_status_script, $checkOut_status_script, $status_script];
        return [
            'checkIn_status_script' => $checkIn_status_script,
            'checkOut_status_script' => $checkOut_status_script,
            'status_script' => $status_script,
        ];
    }

    private function __rekapBulananByNip($nip, $bulan)
    {

        // 
        $records = DataAbsen::where('nip', $nip)
            ->where('date', 'like', $bulan . '%')
            ->orderBy('date')
            ->get();

        $presensi = [];
        foreach ($records as $rec) {
            $presensi[] = [
                'id'        => $rec->id,
                'tgl'       => $rec->date,
                'jam_pagi'  => $rec->checkIn_time_with_timezone_change ?: $rec->checkIn_time_with_timezone,
                'jam_siang' => $rec->checkRest_time_with_timezone_change ?: $rec->checkRest_time_with_timezone,
                'jam_sore'  => $rec->checkOut_time_with_timezone_change ?: $rec->checkOut_time_with_timezone,
                'pagi'      => $rec->checkIn_status_change ?: $rec->checkIn_status_script,
                'siang'     => $rec->checkRest_status_change ?: $rec->checkRest_status,
                'sore'      => $rec->checkOut_status_change ?: $rec->checkOut_status_script,
                'keterangan' => $rec->status_change ?: $rec->status_script ?? '-',
                'change_applied' => (bool) ($rec->status_change
                    || $rec->checkIn_status_change
                    || $rec->checkIn_time_with_timezone_change
                    || $rec->checkRest_status_change
                    || $rec->checkRest_time_with_timezone_change
                    || $rec->checkOut_status_change
                    || $rec->checkOut_time_with_timezone_change),
                'change'    => [
                    'status_change'                          => $rec->status_change,
                    'checkIn_status_change'                  => $rec->checkIn_status_change,
                    'checkIn_time_with_timezone_change'      => $rec->checkIn_time_with_timezone_change,
                    'checkRest_status_change'                => $rec->checkRest_status_change,
                    'checkRest_time_with_timezone_change'    => $rec->checkRest_time_with_timezone_change,
                    'checkOut_status_change'                 => $rec->checkOut_status_change,
                    'checkOut_time_with_timezone_change'     => $rec->checkOut_time_with_timezone_change,
                ],
            ];
        }

        $data = [
            'nip'      => $nip,
            'nama'     => $records->first()->nama ?? 'nama',
            'presensi' => $presensi,
        ];

        // $totalHari  = count($presensi);
        // $totalHadir = $records->filter(fn($r) => in_array($r->status_change ?: $r->status, ['H', 'HN']))->count();

        // return view('pic.detail_RekapByNip', compact('asn', 'data', 'bulan', 'persen', 'totalHari', 'totalHadir'));

        return $data;
    }

    public function show(Request $request)
    {
        // dd($request['nip']);
        if (!empty($request['nip'])) {
            # code...

            $nip = $request['nip'];
            $bulan = '2026-08';
            //
            $data = $this->__rekapBulananByNip($nip, $bulan);

            return view('pic.detail_RekapByNip', compact('data'));
        }

        return back()->with('error', 'Data NIP tidak ada.');
    }

    // -----------

    public function listDataAsn()
    {
        //
        return view('admin.importDataAsnDariExcel');
    }


    // =====================
    public function referensi()
    {
        //

        $data = JamReferensi::all();
        return view('admin.referensi', compact('data'));
    }
}
