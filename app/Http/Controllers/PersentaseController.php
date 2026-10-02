<?php

namespace App\Http\Controllers;

use App\Models\ListKantor;
use App\Models\Persentase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersentaseController extends Controller
{
    //
    // persentase
    public function persentase()
    {
        //
        return view('admin.persentase.setPersentase');
    }

    // ini dipanggil dari route
    public function __hitungPersentase(Request $request)
    {
        $request->validate([
            'namaKantor'            => 'required|string',
            'bulanUntukDihitung'    => 'required|date',
        ]);
        
        $selectedKantor = $request->input('namaKantor', '');
        $selectedMonth = $request->input('bulanUntukDihitung', date('Y-m'));

        // dd($request);
        // 
        $unor_simpegnas_id = 'c9956f8f-77ea-4bbf-a22a-182b6ac9823e'; //bkpsdm
        // $unor_simpegnas_id = 'fd7277d4-c35d-4de5-a479-1adad7cfceed'; // penanaman modal kantor

        // $tgl = '2026-08';
        $tgl = $selectedMonth;
        $data = $this->__dataYangDitampilkan($unor_simpegnas_id, $tgl); // diatas

        $bln = substr($tgl, 5, 2);//dari 2026-08 jadi 08
        // dd($data);

        DB::transaction(function () use ($data, $bln) {
            $dataToUpsert = [];
            foreach ($data as $item) {

                // hitung perentasenya
                $persentases = ($item['rekap']['TK']*3) 
                    + ($item['rekap']['TL1']*0.5) + ($item['rekap']['TL2']*1) 
                    + ($item['rekap']['TL3']*1.25) + ($item['rekap']['TL4']*1.5)
                    + ($item['rekap']['PSW1']*0.5) + ($item['rekap']['PSW2']*1) 
                    + ($item['rekap']['PSW3']*1.25) + ($item['rekap']['PSW4']*1.5)
                ;

                // $persentase = (1- ($persentases/100));
                // $persentase = 100 - $persentases;
                // $persentase = round(1 - ($persentases / 100), 2);
                $persentase = round((1 - ($persentases / 100)) * 100, 2);

                $dataToUpsert[] = [
                    'nip' => $item['nip'],
                    'nama' => $item['nama'],
                    $bln => $persentase,
                ];
            }

            // dd($dataToUpsert);

            if (!empty($dataToUpsert)) {
                Persentase::upsert(
                    $dataToUpsert,
                    ['nip'], // Kunci unik gabungan di DB tetap pakai 'date'
                    [
                        'nama',
                        'nip',
                        $bln
                    ]
                );

            }
        });

        return redirect('/pic/simpan-persentase')->with('success', 'Hitung Persentase bulan '.$bln.' berhasil dilakukan.');
        // return 'coba persentase sukses';

    }

    // persentase v2
    public function persentasev2()
    {
        //
        // $data = ListKantor::all();

        

        return view('admin.persentase.setPersentasev2', compact('data'));
    }

    // ini dipanggil dari route
    public function __hitungPersentasev2(Request $request)
    {
        $request->validate([
            'namaKantor'            => 'required|string',
            'bulanUntukDihitung'    => 'required|date',
        ]);
        
        $selectedKantor = $request->input('namaKantor', '');
        $selectedMonth = $request->input('bulanUntukDihitung', date('Y-m'));

        // dd($request);
        // 
        $unor_simpegnas_id = $selectedKantor;
        // $unor_simpegnas_id = 'c9956f8f-77ea-4bbf-a22a-182b6ac9823e'; //bkpsdm
        // $unor_simpegnas_id = 'fd7277d4-c35d-4de5-a479-1adad7cfceed'; // penanaman modal kantor

        // $tgl = '2026-08';
        $tgl = $selectedMonth;

        //ini sebaiknya jadikan Service (cara panggil fungsi di controller lain laravel)
        // di PicController diubah jadi private, atau dihapus jika sudah menggunakan service
        $picController = new PicController();
        $data = $picController->__dataYangDitampilkan($unor_simpegnas_id, $tgl);
        // $data = $this->__dataYangDitampilkan($unor_simpegnas_id, $tgl); // diatas

        $bln = substr($tgl, 5, 2);//dari 2026-08 jadi 08
        // dd($data);

        DB::transaction(function () use ($data, $bln) {
            $dataToUpsert = [];
            foreach ($data as $item) {

                // hitung perentasenya
                $persentases = ($item['rekap']['TK']*3) 
                    + ($item['rekap']['TL1']*0.5) + ($item['rekap']['TL2']*1) 
                    + ($item['rekap']['TL3']*1.25) + ($item['rekap']['TL4']*1.5)
                    + ($item['rekap']['PSW1']*0.5) + ($item['rekap']['PSW2']*1) 
                    + ($item['rekap']['PSW3']*1.25) + ($item['rekap']['PSW4']*1.5)
                ;

                // $persentase = (1- ($persentases/100));
                // $persentase = 100 - $persentases;
                // $persentase = round(1 - ($persentases / 100), 2);
                $persentase = round((1 - ($persentases / 100)) * 100, 2);

                $dataToUpsert[] = [
                    'nip' => $item['nip'],
                    'nama' => $item['nama'],
                    $bln => $persentase,
                ];
            }

            // dd($dataToUpsert);

            if (!empty($dataToUpsert)) {
                Persentase::upsert(
                    $dataToUpsert,
                    ['nip'], // Kunci unik gabungan di DB tetap pakai 'date'
                    [
                        'nama',
                        'nip',
                        $bln
                    ]
                );

            }

        });

        return redirect('/pic/simpan-persentase')->with('success', 'Hitung Persentase bulan '.$bln.' berhasil dilakukan.');
        // return 'coba persentase sukses';

    }
}
