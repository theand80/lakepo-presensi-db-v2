<?php

namespace App\Http\Controllers;

use App\Exports\DataAsnDariApiKeDbExport;
use App\Imports\lengkapiDataAsnDariApiKeDbMenggunakanDukImport;
use App\Models\AsnDariApi;
use App\Models\ListKantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AsnDariApiController extends Controller
{
    private function __rekapBulananByKantor($id, $month)
    {
        [$tahun, $bulan] = explode('-', $month);

        $url = 'https://api-absensi.simpegnas.go.id/absensi/api/get/rekap-bulanan-by-kantor';

        $response = Http::withHeaders([
            'presensi-key' => config('services.apiSimpegnas.key'),
        ])
            ->connectTimeout(10)
            ->timeout(120)
            ->get($url, [
                'kantor_id' => $id,
                'tahun'     => $tahun,
                'bulan'     => $bulan,
            ]);

        if (!$response->successful()) {

            Log::error('API rekap bulanan gagal', [
                'kantor_id' => $id,
                'status'    => $response->status(),
                'response'  => $response->body(),
            ]);

            return [];
        }

        return $response->json('data', []);
    }

    public function simpanDataAsnDariApiKeDB()
    {
        $tgl = '2026-08';

        ListKantor::select('id_kantor', 'nama_kantor')
            // ->skip(72)->limit(2) // TESTING: batasi 2 kantor
            // ->where('id_kantor', '44832e9f-feca-414e-8385-0f8b18f9a06b')
            ->skip(220)->limit(20)
            ->chunkById(10, function ($listKantor) use ($tgl) {

                foreach ($listKantor as $kantor) {

                    $id = $kantor->id_kantor;
                    $namaKantor = $kantor->nama_kantor;

                    try {

                        // Ambil data dari API.
                        // Karena API tidak mendukung pagination,
                        // data satu kantor akan diterima sekaligus.
                        $datas = $this->__rekapBulananByKantor($id, $tgl);
                        // $datas = array_slice($datas, 2, 3);

                        if (empty($datas)) {
                            Log::info('Tidak ada data ASN', [
                                'kantor_id' => $id,
                                'kantor'    => $namaKantor,
                            ]);

                            continue;
                        }

                        // TESTING: hanya ambil 3 ASN dari setiap kantor
                        // $datas = array_slice($datas, 0, 3);
                        // $datas = array_slice($datas, 6, 3);

                        $jumlahData = count($datas);

                        Log::info('Mulai menyimpan ASN', [
                            'kantor_id' => $id,
                            'kantor'    => $namaKantor,
                            'jumlah'    => $jumlahData,
                        ]);

                        /*
                        * Database diproses per 500 data.
                        * Jangan melakukan upsert seluruh data sekaligus.
                        */
                        foreach (array_chunk($datas, 500) as $batch) {

                            $now = now();
                            $dataToUpsert = [];

                            foreach ($batch as $item) {

                                $nip = trim($item['nip'] ?? '');

                                if ($nip === '') {
                                    continue;
                                }

                                $dataToUpsert[] = [
                                    'nip'               => $nip,
                                    'nama'              => $item['nama'] ?? null,
                                    'unor_simpegnas'    => $namaKantor,
                                    'unor_simpegnas_id' => $id,
                                    'created_at'        => $now,
                                    'updated_at'        => $now,
                                ];
                            }

                            if (!empty($dataToUpsert)) {

                                AsnDariApi::upsert(
                                    $dataToUpsert,
                                    ['nip'],
                                    [
                                        'nama',
                                        'unor_simpegnas',
                                        'unor_simpegnas_id',
                                        'updated_at',
                                    ]
                                );
                            }

                            unset($dataToUpsert);
                        }

                        /*
                        * Lepaskan data kantor dari memory
                        * sebelum pindah ke kantor berikutnya.
                        */
                        unset($datas);

                        Log::info('Selesai menyimpan ASN', [
                            'kantor_id' => $id,
                            'kantor'    => $namaKantor,
                            'jumlah'    => $jumlahData,
                        ]);

                    } catch (\Throwable $e) {

                        /*
                        * Kalau satu kantor gagal, kantor berikutnya
                        * masih bisa diproses.
                        */
                        Log::error('Gagal sinkronisasi ASN', [
                            'kantor_id' => $id,
                            'kantor'    => $namaKantor,
                            'error'     => $e->getMessage(),
                        ]);

                        continue;
                    }
                }

                /*
                * Beri kesempatan PHP melakukan garbage collection
                * setelah setiap chunk kantor.
                */
                gc_collect_cycles();
            }, 'id_kantor');

        return redirect('/admin')
            ->with(
                'success',
                'Proses sinkronisasi ASN dari API selesai.'
            );
    }

    public function lihatDataAsnDariApiYangSudahKeDB(){
        // 
        // $data = AsnDariApi::limit(10)->get();
        $data = AsnDariApi::all();
        return view('admin.asnDariApi.listAsnDariApiYangSudahKeDB', compact('data'));
    }

    public function lengkapiDataAsnDariApiKeDbMenggunakanDuk(Request $request){
        // 
        if ($request->hasFile('file-update-import')) {
            Excel::import(new lengkapiDataAsnDariApiKeDbMenggunakanDukImport($request->status), $request->file('file-update-import'));
            return redirect('/admin/lihat-asn-dari-api')->with('success', 'Data Berhasil Diupdate!');
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    public function hapusSemuaDataAsnDariApiKeDb()
    {
        AsnDariApi::truncate();
        return redirect('/admin/lihat-asn-dari-api')->with('success', 'Semua data ASN berhasil dihapus!');
    }

    public function downloadDataAsnDariApiKeDb()
    {
        $filename = 'data_asn_di_lakepo_presensi.xlsx';

        return Excel::download(new DataAsnDariApiKeDbExport, $filename);

    }

    // private function __rekapBulananByKantor($id, $month)
    // {
    //     // 1. Pecah bulan dan tahun
    //     $tahun = explode("-", $month)[0];
    //     $bulan = explode("-", $month)[1];

    //     // 2. Siapkan wadah untuk menampung semua data kantor
    //     $semuaDataKantor = [];

    //     // 3. Pastikan $id selalu berupa array (antisipasi jika hanya 1 ID berupa string yang dikirim)
    //     $idArray = is_array($id) ? $id : [$id];

    //     // 4. Looping untuk mengambil data dari setiap ID kantor
    //     foreach ($idArray as $kantorId) {
    //         $url = "https://api-absensi.simpegnas.go.id/absensi/api/get/rekap-bulanan-by-kantor?kantor_id={$kantorId}&tahun={$tahun}&bulan={$bulan}";
    //         $apiKey = config('services.apiSimpegnas.key');
    //         $response = Http::withHeaders([
    //             'presensi-key' => $apiKey,
    //         ])->get($url);

    //         // 5. Periksa jika request sukses dan data ada
    //         if ($response->successful() && isset($response->json()['data'])) {
    //             $dataKantor = $response->json()['data'];

    //             // 6. Gabungkan data ke wadah utama
    //             // $semuaDataKantor[] = $dataKantor; 
    //             // ATAU gunakan array_merge jika data berbentuk list/array numerik:
    //             $semuaDataKantor = array_merge($semuaDataKantor, $dataKantor);
    //         }
    //     }

    //     // 7. Kembalikan semua data yang sudah utuh berkumpul
    //     // dd($semuaDataKantor[1]);
    //     return $semuaDataKantor;
    //     // return array_slice($semuaDataKantor, 18, 5);
    // }

    // simpan ke DB
    // public function simpanDataAsnDariApiKeDB()
    // {
    //     // dd($listKantor);
    //     $listKantor = ListKantor::select('id_kantor', 'nama_kantor')->skip(72)->limit(1)->get();

    //     foreach ($listKantor as $value) {

    //         $id = $value['id_kantor'];
    //         $nama_kantor = $value['nama_kantor'];

    //         $tgl = '2026-08'; //

    //         $datas = $this->__rekapBulananByKantor($id, $tgl); //diatas

    //         // $data = $datas;
    //         $data = array_slice($datas, 2, 3);

    //         DB::transaction(function () use ($data, $nama_kantor, $id) {

    //             $dataToUpsert = [];

    //             // Loop Tingkat 1: Mengambil employee_id
    //             foreach ($data as $item) {
    //                 $employeeNip = $item['nip'];
    //                 $employeeNama = $item['nama'];

    //                 if ($employeeNip === '') {
    //                     continue;
    //                 }

    //                 // Masukkan ke array penampung dengan format kolom database
    //                 $dataToUpsert[] = [
    //                     'nip'                           => $employeeNip,
    //                     'nama'                          => $employeeNama,
    //                     'unor_simpegnas'                => $nama_kantor,
    //                     'unor_simpegnas_id'             => $id,

    //                     'created_at'        => now(),
    //                     'updated_at'        => now(),
    //                 ];
                    
    //             }

    //             // 3. Eksekusi Upsert Massal (Tetap menggunakan acuan unique gabungan)
    //             if (!empty($dataToUpsert)) {
    //                 // ImportApi::insert($dataToUpsert);
    //                 AsnDariApi::upsert(
    //                     $dataToUpsert,
    //                     ['nip'], // Kunci unik gabungan di DB tetap pakai 'date'
    //                     [
    //                         'nama',
    //                         'unor_simpegnas',
    //                         'unor_simpegnas_id',

    //                         'updated_at'
    //                     ]
    //                 );
    //             }
    //         });

    //     }

    //     return redirect('/admin')->with('success', 'Data ASN dari API berhasil disimpan ke DB');
    // }


    

}
