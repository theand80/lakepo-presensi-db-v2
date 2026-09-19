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
        $data = DataAbsen::all();
        // dd($data);
        return view('pic.rekap');
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
