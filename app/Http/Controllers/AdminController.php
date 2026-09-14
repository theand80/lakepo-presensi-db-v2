<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

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
}
