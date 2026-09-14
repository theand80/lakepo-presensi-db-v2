<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

use Illuminate\Pagination\LengthAwarePaginator;

class ApiSimpegnas extends Model
{
    /** @use HasFactory<\Database\Factories\DataAsnFactory> */
    use HasFactory;

    private $apiKey;

    // Gunakan konstruktor untuk mengisi nilai
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->apiKey = config('services.apiSimpegnas.key');
        // $this->apiKey = env('API_SIMPEGNAS');
    }

    // public static function listKantor()
    public function listKantor()
    {
        $response = Http::withHeaders([
            'presensi-key' => $this->apiKey,
        ])->get('https://api-absensi.simpegnas.go.id/absensi/api/get/kantor');

        // dd($response->json());
        $status = $response->status(); //true
        $responseCode = $response->reason(); //200
        $data = $response->json()['data']['kantor'] ?? []; //data
        // $listKantor = array_slice($data, 73, 25);

        // return $listKantor;
        return $data;
    }

    public function listKantorPaginate()
    {
        $response = Http::withHeaders([
            'presensi-key' => $this->apiKey,
        ])->get('https://api-absensi.simpegnas.go.id/absensi/api/get/kantor');

        $data = $response->json()['data']['kantor'] ?? [];

        $perPage = 10;
        $currentPage = request()->get('page', 1);

        $collection = collect($data);

        return new LengthAwarePaginator(
            $collection->forPage($currentPage, $perPage)->values(),
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }

    public function rekapBulananByKantor($id, $month)
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

            $response = Http::withHeaders([
                'presensi-key' => $this->apiKey,
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
    }

    public function rekapByKantor($id, $month)
    {
        $tglAkhir = date('t', strtotime($month . '-01'));

        $id = "7e504992-b3ea-4172-9bfc-3a3cb080c0d0";

        $url = "https://api-absensi.simpegnas.go.id/absensi/api/get/rekap-by-kantor?kantor_id={$id}&start_date={$month}-01&end_date={$month}-{$tglAkhir}";

        $response = Http::withHeaders([
            'presensi-key' => $this->apiKey,
        ])->get($url);

        // dd($response->json());

        return $response->json()['data'];
    }

    public function riwayatByNip($nip, $month)
    {
        // 1. Pecah bulan dan tahun
        $tahun = explode("-", $month)[0];
        $bulan = explode("-", $month)[1];

        $response = Http::withHeaders([
            'presensi-key' => $this->apiKey,
        ])->get("https://api-absensi.simpegnas.go.id/absensi/api/get/riwayat?nip={$nip}&tahun={$tahun}&bulan={$bulan}");

        // dd($response->json());

        return $response->json()['data'];
    }

    public function rekapByNip($nip, $month)
    {
        $tglAkhir = date('t', strtotime($month . '-01'));

        $url = "https://api-absensi.simpegnas.go.id/absensi/api/get/rekap-by-nip?nip={$nip}&start_date={$month}-01&end_date={$month}-{$tglAkhir}";

        $response = Http::withHeaders([
            'presensi-key' => $this->apiKey,
        ])->get($url);


        // dd($response->json());

        return $response->json()['data'];
    }

    public function dinasLuar($nip, $month)
    {
        $tahun = explode("-", $month)[0];
        $bulan = explode("-", $month)[1];

        $url = "https://api-absensi.simpegnas.go.id/absensi/api/get/dinas-luar?nip={$nip}&tahun={$tahun}&bulan={$bulan}";

        $response = Http::withHeaders([
            'presensi-key' => $this->apiKey,
        ])->get($url);

        return $response->json()['data'];
    }
}
