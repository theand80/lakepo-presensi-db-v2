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
        return $data;

        // ---------------

        // jika ingin menggunakan if dan foreach untuk menggantikan firstWhere atau keyBy
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


        return view('admin.penadaTangan.listPenandaTangan', compact('kantor'));
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
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
