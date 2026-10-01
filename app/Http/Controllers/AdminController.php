<?php

namespace App\Http\Controllers;

use App\Models\DataAbsen;
use App\Models\DataAsn;
use App\Models\JamReferensi;
use App\Models\ListKantor;
use App\Models\Persentase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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

        $listKantor = array_slice($data, 73, 5);
        // $listKantor = $data;

        return view('admin.listKantorDariApi', ['data' => $listKantor]);
    }

    public function simpanListKantorkeDB()
    {
        $response = Http::withHeaders([
            'presensi-key' => config('services.apiSimpegnas.key'),
        ])->get('https://api-absensi.simpegnas.go.id/absensi/api/get/kantor');

        $datas = $response->json()['data']['kantor']; //data
        // $data = array_slice($datas, 73, 5);
        $data = $datas;

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


    

    // panggil dari show dibawah
    private function __rekapBulananByNip($nip, $bulan)
    {

        // 
        $records = DataAbsen::where('nip', $nip)
            ->where('date', 'like', $bulan . '%')
            ->orderBy('date')
            ->get();

        $presensi = [];
        foreach ($records as $rec) {

            // ubah TM daji TL, CP jadi PSW
            $status_script_pagi_update = $this->__ubahStatusPagiYangTampil($rec->checkIn_status_script); //dibawah
            // $status_script_siang_update = $this->__ubahStatusSiangYangTampil($rec->checkRest_status); //dibawah
            $status_script_sore_update = $this->__ubahStatusSoreYangTampil($rec->checkOut_status_script); //dibawah

            $work_from = $this->__statusWorkFrom($rec->checkIn_work_from, $rec->checkOut_work_from); // dibawah

            // ubah TM daji TL, CP jadi PSW
            $status_script_update = $this->__ubahStatusYangTampil($rec->status_script); //dibawah


            $presensi[] = [
                'id'        => $rec->id,
                'tgl'       => $rec->date,
                'jam_pagi'  => $rec->checkIn_time_with_timezone_change ?: $rec->checkIn_time_with_timezone,
                'jam_siang' => $rec->checkRest_time_with_timezone_change ?: $rec->checkRest_time_with_timezone,
                'jam_sore'  => $rec->checkOut_time_with_timezone_change ?: $rec->checkOut_time_with_timezone,
                // 'pagi'      => $rec->checkIn_status_change ?: $rec->checkIn_status_script,
                'siang'     => $rec->checkRest_status_change ?: $rec->checkRest_status ?: '-',
                // 'sore'      => $rec->checkOut_status_change ?: $rec->checkOut_status_script,
                'pagi'      => $rec->checkIn_status_change ?: $status_script_pagi_update,
                // 'siang'     => $rec->checkRest_status_change ?: $status_script_siang_update,
                'sore'      => $rec->checkOut_status_change ?: $status_script_sore_update,
                // 'work_from' => $rec->checkIn_work_from ?? '-',
                'work_from' => $work_from ?? '-',
                // 'keterangan' => $rec->status_change ?: $status_script_update ?? '-',
                'keterangan' => $rec->status_change ?? $status_script_update ?? $rec->status_script ?? '-',
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

    // panggil dari __rekapBulananByNip diatas
    private function __ubahStatusPagiYangTampil($kodeStatusPagi)
    {
        $mapping = [
            'TM1'     => 'TL1',
            'TM2'     => 'TL2',
            'TM3'     => 'TL3',
            'TM4'     => 'TL4',
        ];

        return $mapping[$kodeStatusPagi] ?? $kodeStatusPagi;
    }

    private function __ubahStatusSoreYangTampil($kodeStatusSore)
    {
        $mapping = [
            'CP1'     => 'PSW1',
            'CP2'     => 'PSW2',
            'CP3'     => 'PSW3',
            'CP4'     => 'PSW4',
        ];

        return $mapping[$kodeStatusSore] ?? $kodeStatusSore;
    }

    // panggil dari __rekapBulananByNip diatas
    private function __statusWorkFrom($checkIn_work_from, $checkOut_work_from)
    {
        if ($checkIn_work_from == 'WFH' && empty($checkOut_work_from)) {
            return 'WFH - X';
        }
        if (empty($checkIn_work_from)&& $checkOut_work_from == 'WFH') {
            return 'X - WFH';
        }

        if ($checkIn_work_from == 'WFO' && empty($checkOut_work_from)) {
            return 'WFO - X';
        }
        if (empty($checkIn_work_from)&& $checkOut_work_from == 'WFO') {
            return 'X - WFO';
        }

        if ($checkIn_work_from == 'WFH' && $checkOut_work_from == 'WFH') {
            return 'WFH';
        } elseif ($checkIn_work_from == 'WFH' && $checkOut_work_from == 'WFO') {
            return 'WFH-WFO';
        } elseif ($checkIn_work_from == 'WFO' && $checkOut_work_from == 'WFH') {
            return 'WFO-WFH';
        } elseif ($checkIn_work_from == 'WFO' && $checkOut_work_from == 'WFO') {
            return 'WFO';
        } else {
            return '-';
        }
    }

    // panggil dari __rekapBulananByNip diatas
    private function __ubahStatusYangTampil($kodeStatus)
    {
        $mapping = [
            'TM1'     => 'TL1',
            'TM2'     => 'TL2',
            'TM3'     => 'TL3',
            'TM4'     => 'TL4',
            'CP1'     => 'PSW1',
            'CP2'     => 'PSW2',
            'CP3'     => 'PSW3',
            'CP4'     => 'PSW4',

            'TAD-PLN' => 'TL4',
            'PGN-TAP' => 'PSW4',

            'TAD-CP1' => 'TL4-PSW1',
            'TAD-CP2' => 'TL4-PSW2',
            'TAD-CP3' => 'TL4-PSW3',
            'TAD-CP4' => 'TL4-PSW4',

            'TM1-TAP' => 'TL1-PSW4',
            'TM2-TAP' => 'TL2-PSW4',
            'TM3-TAP' => 'TL3-PSW4',
            'TM4-TAP' => 'TL4-PSW4',

            'TM1-CP1' => 'TL1-PSW1',
            'TM2-CP1' => 'TL2-PSW1',
            'TM3-CP1' => 'TL3-PSW1',
            'TM4-CP1' => 'TL4-PSW1',

            'TM1-CP2' => 'TL1-PSW2',
            'TM2-CP2' => 'TL2-PSW2',
            'TM3-CP2' => 'TL3-PSW2',
            'TM4-CP2' => 'TL4-PSW2',

            'TM1-CP3' => 'TL1-PSW3',
            'TM2-CP3' => 'TL2-PSW3',
            'TM3-CP3' => 'TL3-PSW3',
            'TM4-CP3' => 'TL4-PSW3',

            'TM1-CP4' => 'TL1-PSW4',
            'TM2-CP4' => 'TL2-PSW4',
            'TM3-CP4' => 'TL3-PSW4',
            'TM4-CP4' => 'TL4-PSW4',


        ];

        return $mapping[$kodeStatus] ?? $kodeStatus;
    }

    public function show(Request $request)
    {
        // dd($request->nip);
        if (!empty($request['nip'])) {
            # code...

            $nip = $request['nip'];
            $bulan = '2026-08';
            //
            $data = $this->__rekapBulananByNip($nip, $bulan); //diatas

            $persentases = Persentase::get();
            $persentase = $persentases->firstWhere('nip', $data['nip']);
            $data['persentase'] = $persentase ? (float) $persentase->{'08'} : 0;

            // dd($persentases);

            return view('pic.detail_RekapByNip', compact('data'));
        }

        return back()->with('error', 'Data NIP tidak ada.');
    }

    // -----------



    // =====================
    public function referensi()
    {
        //

        $data = JamReferensi::all();
        return view('admin.referensi', compact('data'));
    }
}
