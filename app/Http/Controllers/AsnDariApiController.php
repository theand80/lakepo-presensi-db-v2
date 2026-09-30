<?php

namespace App\Http\Controllers;

use App\Models\AsnDariApi;
use App\Models\ListKantor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AsnDariApiController extends Controller
{

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

    // simpan ke DB
    public function simpanDataAbsenDariApiKeDB()
    {
        // dd($listKantor);
        $listKantor = ListKantor::select('id_kantor', 'nama_kantor')->skip(72)->limit(1)->get();

        foreach ($listKantor as $value) {

            $id = $value['id_kantor'];
            $nama_kantor = $value['nama_kantor'];

            $tgl = '2026-08'; //

            $datas = $this->__rekapBulananByKantor($id, $tgl); //diatas

            // $data = $datas;
            $data = array_slice($datas, 2, 3);

            DB::transaction(function () use ($data, $nama_kantor, $id) {

                $dataToUpsert = [];

                // Loop Tingkat 1: Mengambil employee_id
                foreach ($data as $item) {
                    $employeeNip = $item['nip'];
                    $employeeNama = $item['nama'];

                    if ($employeeNip === '') {
                        continue;
                    }

                    // Masukkan ke array penampung dengan format kolom database
                    $dataToUpsert[] = [
                        'nip'                           => $employeeNip,
                        'nama'                          => $employeeNama,
                        'unor_simpegnas'                => $nama_kantor,
                        'unor_simpegnas_id'             => $id,

                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ];
                    
                }

                // 3. Eksekusi Upsert Massal (Tetap menggunakan acuan unique gabungan)
                if (!empty($dataToUpsert)) {
                    // ImportApi::insert($dataToUpsert);
                    AsnDariApi::upsert(
                        $dataToUpsert,
                        ['nip'], // Kunci unik gabungan di DB tetap pakai 'date'
                        [
                            'nama',
                            'unor_simpegnas',
                            'unor_simpegnas_id',

                            'updated_at'
                        ]
                    );
                }
            });

        }

        return redirect('/admin')->with('success', 'Data ASN dari API berhasil disimpan ke DB');
    }

}
