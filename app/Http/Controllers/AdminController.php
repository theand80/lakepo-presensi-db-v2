<?php

namespace App\Http\Controllers;

use App\Models\DataAbsen;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\ListKantor;

class AdminController extends Controller
{

    public function index()
    {
        return view('admin.dashboard');
    }

    public function listKantorDariApiIndex()
    {
        $response = Http::withHeaders([
            'presensi-key' => config('services.apiSimpegnas.key'),
        ])->get('https://api-absensi.simpegnas.go.id/absensi/api/get/kantor');

        $data = $response->json()['data']['kantor']; //data
        $listKantor = array_slice($data, 73, 5);

        return view('admin.listKantorDariApi', ['data' => $listKantor]);
    }

    private function __listKantor()
    {
        $response = Http::withHeaders([
            'presensi-key' => config('services.apiSimpegnas.key'),
        ])->get('https://api-absensi.simpegnas.go.id/absensi/api/get/kantor');

        // dd($response->json());
        $status = $response->status(); //true
        $responseCode = $response->reason(); //200
        $data = $response->json()['data']['kantor']; //data
        // $listKantor = array_slice($data, 73, 25);

        // return $listKantor;
        return $data;
    }

    public function simpanListKantorkeDB()
    {
        $response = Http::withHeaders([
            'presensi-key' => config('services.apiSimpegnas.key'),
        ])->get('https://api-absensi.simpegnas.go.id/absensi/api/get/kantor');

        $data = $response->json()['data']['kantor']; //data

        DB::transaction(function () use ($data) {
            $dataToUpsert = [];
            foreach ($data as $item) {
                $dataToUpsert[] = [
                    'id_kantor' => $item['id'],
                    'nama_kantor' => $item['nama_kantor'],
                ];
            }
            ListKantor::upsert(
                $dataToUpsert,
                ['id_kantor', 'nama_kantor'],
                ['created_at', 'updated_at']
            );
        });

        return redirect('/admin/listKantorDariApiIndex')->with('status', 'List Kantor berhasil disimpan ke DB');
    }
    public function listKantorDariDBIndex()
    {
        $listKantor = ListKantor::all();
        // return $listKantor;
        // dd($listKantor->nama_kantor);

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

        return $semuaDataKantor;
        // return array_slice($semuaDataKantor, 18, 5);
    }

    public function lihatRekapBulananByKantor()
    {
        //
        $nama_kantor = 'BKPSDM';
        $id = 'c9956f8f-77ea-4bbf-a22a-182b6ac9823e';
        $tgl = '2026-8';


        $data = $this->__rekapBulananByKantor($id, $tgl);

        dd($data);
        // return $data;
    }

    public function simpanRekapBulananByKantor(Request $request)
    {
        //
        $request->validate([
            'kantor_id' => 'required',
            'kantor_nama' => 'required',
            'bulan' => 'required|integer|min:1|max:12',
        ]);

        $id = $request['kantor_id'];
        $nama_kantor = $request['kantor_nama'];
        $tgl = '2026-' . $request['bulan']; //


        $data = $this->__rekapBulananByKantor($id, $tgl);

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

                    // Masukkan ke array penampung dengan format kolom database
                    $dataToUpsert[] = [
                        'nip'                           => $employeeNip,
                        'nama'                          => $employeeNama,
                        'date'                          => $fullDate, //tahun - bulan // Disimpan sebagai tanggal lengkap di DB
                        'libur'                         => 0,
                        'kegiatan'                      => 0,
                        'unor_simpegnas'                => $nama_kantor,
                        'unor_simpegnas_id'             => $id,

                        'status'                        => $status,
                        'late'                          => $late,

                        'checkIn_work_from'             => $presensi['checkIn']['work_from'] ?? null,
                        'checkIn_status'                => $presensi['checkIn']['status'] ?? null,
                        'checkIn_time_with_timezone'    => $presensi['checkIn']['time_with_timezone'] ?? null,
                        'checkIn_late'                  => $presensi['checkIn']['late'] ?? null,

                        'checkRest_work_from'             => $presensi['checkRest']['work_from'] ?? null,
                        'checkRest_status'                => $presensi['checkRest']['status'] ?? null,
                        'checkRest_time_with_timezone'    => $presensi['checkRest']['time_with_timezone'] ?? null,
                        'checkRest_late'                  => $presensi['checkRest']['late'] ?? null,

                        'checkOut_work_from'             => $presensi['checkOut']['work_from'] ?? null,
                        'checkOut_status'                => $presensi['checkOut']['status'] ?? null,
                        'checkOut_time_with_timezone'    => $presensi['checkOut']['time_with_timezone'] ?? null,
                        'checkOut_late'                  => $presensi['checkOut']['late'] ?? null,

                        'tak'                            => $presensi['tak'] ?? 0,

                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ];
                }
            }

            // dd($dataToUpsert);

            // 3. Eksekusi Upsert Massal (Tetap menggunakan acuan unique gabungan)
            if (!empty($dataToUpsert)) {
                // ImportApi::insert($dataToUpsert);
                DataAbsen::upsert(
                    $dataToUpsert,
                    ['nip', 'date'], // Kunci unik gabungan di DB tetap pakai 'date'
                    [
                        'status', // <-- WAJIB DITAMBAHKAN
                        'late',   // <-- WAJIB DITAMBAHKAN

                        'unor_simpegnas',
                        'unor_simpegnas_id',
                        'checkIn_work_from',
                        'checkIn_status',
                        'checkIn_time_with_timezone',
                        'checkIn_late',

                        'checkRest_work_from',
                        'checkRest_status',
                        'checkRest_time_with_timezone',
                        'checkRest_late',

                        'checkOut_work_from',
                        'checkOut_status',
                        'checkOut_time_with_timezone',
                        'checkOut_late',

                        'tak',

                        'updated_at'
                    ]
                );
            }
        });

        DB::table('list_kantors')
            ->where('id_kantor', $request['kantor_id'])
            ->update(['bulan_' . $request['bulan'] => '1']);

        return redirect('/import-api')->with('status', 'Data berhasil disimpan');
    }


    // =====================
    public function referensi()
    {
        //
        return view('admin.referensi');
    }
}
