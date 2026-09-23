<?php

namespace App\Http\Controllers;

use App\Exports\RekapAbsenExport;
use App\Models\ApiSimpegnas;
use App\Models\DataAbsen;
use App\Models\DataAsn;
use App\Models\ImportApi;
use App\Models\ListKantor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // index: rekap dari data lokal import_api
    public function index(Request $request)
    {
        // $unor_simpegnas_id = 'c9956f8f-77ea-4bbf-a22a-182b6ac9823e'; //bkpsdm
        $unor_simpegnas_id = 'fd7277d4-c35d-4de5-a479-1adad7cfceed'; // penanaman modal kantor

        $tgl = '2026-07';

        $records = DataAbsen::where('unor_simpegnas_id', $unor_simpegnas_id)->whereLike('date', $tgl . '%')->get()->groupBy('nip');

        // $nipList = $records->keys()->toArray();

        // dd($records['197009131999021001'][0]['nama']);

        $kodeAbsen = [
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

        $data = [];

        foreach ($records as $nip => $group) {
            $rekap = [
                'nip'       => $nip,
                'nama'      => $group[0]['nama'],
                'golongan'  => $asn->golongan ?? '',
                'pangkat'   => $asn->pangkat ?? '',
                'jabatan'   => $asn->jabatan ?? '-',
                'status'    => $asn->status ?? '-',
                'kantor'    => $first->unor_simpegnas ?? '-',
                'rekap'     => array_fill_keys($kodeAbsen, 0),
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

                //jumlahkan beberapa kode
                // $jumlahBeberapaKode = $this->__jumlahkanBeberapaKode($rekap);
                [
                    'TL1'   => $rekap['rekap']['TL1'],
                    'TL2'   => $rekap['rekap']['TL2'],
                    'TL3'   => $rekap['rekap']['TL3'],
                    'TL4'   => $rekap['rekap']['TL4'],
                    'PSW1'  => $rekap['rekap']['PSW1'],
                    'PSW2'  => $rekap['rekap']['PSW2'],
                    'PSW3'  => $rekap['rekap']['PSW3'],
                    'PSW4'  => $rekap['rekap']['PSW4'],
                    'H'     => $rekap['hadir'],
                ] = $this->__jumlahkanBeberapaKode($rekap);
            }


            $data[] = $rekap;
        }

        // dd($data);


        return view('pic.rekap', compact('data'));
    }

    private function __jumlahkanBeberapaKode($rekap)
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
            'TL1'   => $rekap['rekap']['TL1'],
            'TL2'   => $rekap['rekap']['TL2'],
            'TL3'   => $rekap['rekap']['TL3'],
            'TL4'   => $rekap['rekap']['TL4'],
            'PSW1'  => $rekap['rekap']['PSW1'],
            'PSW2'  => $rekap['rekap']['PSW2'],
            'PSW3'  => $rekap['rekap']['PSW3'],
            'PSW4'  => $rekap['rekap']['PSW4'],
            'H'     => $rekap['hadir'],
        ];
    }

    public function bpk(Request $request)
    {
        return view('pic.bpk');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = DataAbsen::findOrFail($id);

        $data = $request->validate([
            'status_change'                           => 'nullable|string|max:10',
            'checkIn_status_change'                   => 'nullable|string|max:10',
            'checkIn_time_with_timezone_change'       => 'nullable|string|max:19',
            'checkRest_status_change'                 => 'nullable|string|max:10',
            'checkRest_time_with_timezone_change'     => 'nullable|string|max:19',
            'checkOut_status_change'                  => 'nullable|string|max:10',
            'checkOut_time_with_timezone_change'      => 'nullable|string|max:19',
        ]);

        foreach (['checkIn_time_with_timezone_change', 'checkRest_time_with_timezone_change', 'checkOut_time_with_timezone_change'] as $field) {
            $data[$field] = $this->normalizeTime($data[$field]);
        }

        $record->update($data);

        return redirect()->back()->with('success', 'Data presensi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
