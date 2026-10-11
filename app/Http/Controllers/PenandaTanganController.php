<?php

namespace App\Http\Controllers;

use App\Models\AsnDariApi;
use App\Models\PenandaTangan;
use Illuminate\Http\Request;

class PenandaTanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $kantor = AsnDariApi::select('unor_siasn_induk')->distinct()->get();

        // menggunakan keyBy
        // $dataPenTtd = PenandaTangan::all()->keyBy('unor_siasn_induk');
        // $data = $kantor->map(function ($item) use ($dataPenTtd) {
        //     $item->penandaTangan = $dataPenTtd->get(
        //         $item->unor_siasn_induk
        //     );

        //     return $item;
        // });
        // return $data;

        // ---------------

        // jika tidak ingin menggunuanak keyBy, bisa menggunakan firstWhere
        $dataPenTtd = PenandaTangan::all();
        $data = $kantor->map(function ($item) use ($dataPenTtd) {
            $item->penandaTangan = $dataPenTtd->firstWhere(
                'unor_siasn_induk',
                $item->unor_siasn_induk
            );

            return $item;
        });
        // return $data;

        // ---------------

        // jika ingin menggunakan if dan foreach untuk menggantikan firstWhere atau keyBy
        // $dataPenTtd = PenandaTangan::all();
        // $data = $kantor->map(function ($item) use ($dataPenTtd) {
        //     $ttd = null;
        //     foreach ($dataPenTtd as $penandaTangan) {
        //         if (
        //             $penandaTangan->unor_siasn_induk
        //             == $item->unor_siasn_induk
        //         ) {
        //             $ttd = $penandaTangan;
        //             break;
        //         }
        //     }
        //     $item->penandaTangan = $ttd;
        //     return $item;
        // });
        // return $data;


        return view('admin.penadaTangan.listPenandaTangan', compact('data'));
    }

   public function __upsert(Request $request){
    // 
    dd($request->all());

    // $request->validate([
    //     'unor_siasn_induk'   => 'required|string', //DIKES - PKM PARUGA - Pustu Posprim Kel. Dara
    //     'bulanUntukDihitung' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12',
    // ]);

    AsnDariApi::select('nip', 'nama', 'pangkat', 'golongan')->firstWhere('nip', $request->input('nip'))->get();
    dd($request->all());


    PenandaTangan::upsert(
        [
        'unor_siasn_induk' => $request->input('namaKantor', ''),
        'sebagai' => $request->input('sebagai', ''),
        'nip' => $nip,
        'nama_pen_ttd' => $nip,
        'pangkat_gol' => $nip,
        ],
        ['unor_siasn_induk'],
        [
            'sebagai',
            'nip',
            'nama_pen_ttd',
            'pangkat_gol',
            'updated_at',
        ]
    );


    return redirect('/admin/list-penandatangan')->with('success', 'Penanda Tangan Berhasil disimpan');
   }
}
