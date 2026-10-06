<?php

namespace App\Http\Controllers;

use App\Models\DataAbsen;
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
        // $unorSimpegnas = DataAbsen::select('unor_simpegnas')->distinct()->get();
        // $data = $unorSimpegnas;

        // return view('admin.persentase.setPersentasev2', compact('data'));

        $tahun = date('Y');


        // Ambil semua data tanggal 01 pada tahun berjalan
        $dataAbsen = DataAbsen::select(
                'unor_simpegnas',
                'date',
                'persentase'
            )
            ->whereYear('date', $tahun)
            ->whereDay('date', 1)
            ->get();

        // Kelompokkan berdasarkan kantor / unor_simpegnas
        $data = $dataAbsen
            ->groupBy('unor_simpegnas')
            ->map(function ($rows, $unorSimpegnas) {

                $item = [
                    'unor_simpegnas' => $unorSimpegnas,
                ];

                // Default semua bulan = belum dihitung
                // | 0 = Hitung
                // | 1 = Hitung Ulang
                for ($bulan = 1; $bulan <= 12; $bulan++) {
                    $item["bulan_$bulan"] = 0;
                }


                // Cek persentase masing-masing bulan
                foreach ($rows as $row) {

                    // Hanya dianggap sudah dihitung
                    // jika persentase tidak NULL
                    if ($row->persentase !== null) {

                        $bulan = date('n', strtotime($row->date));

                        $item["bulan_$bulan"] = 1;
                    }
                }

                return $item;
            })
            ->values();

        return view(
            'admin.persentase.setPersentasev2', compact('data')
        );
    }

    // ini dipanggil dari route
    public function __hitungPersentasev2(Request $request)
    {
        // dd($request);
        $request->validate([
            'namaKantor'            => 'required|string', //DIKES - PKM PARUGA - Pustu Posprim Kel. Dara
            // 'bulanUntukDihitung'    => 'required|date', //5
            'bulanUntukDihitung' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12',
        ]);
        
        $selectedKantor = $request->input('namaKantor', '');
        $selectedMonth = $request->input('bulanUntukDihitung', date('Y-m'));
        // $selectedMonth = str_pad(
        //     $request->input('bulanUntukDihitung', date('m')), 2, '0', STR_PAD_LEFT
        // ); // ini sudah dilakukan di view

        // 
        $unor_simpegnas_id = ListKantor::select('id_kantor')->where('nama_kantor', $selectedKantor)->get()[0];
        // $unor_simpegnas_id = $selectedKantor;
        // $unor_simpegnas_id = 'c9956f8f-77ea-4bbf-a22a-182b6ac9823e'; //bkpsdm
        // $unor_simpegnas_id = 'fd7277d4-c35d-4de5-a479-1adad7cfceed'; // penanaman modal kantor
        // dd($unor_simpegnas_id);


        // $tgl = '2026-08';
        // $tgl = $selectedMonth;
        $bln = $selectedMonth; //08
        // $bln = date('Y').'-'.$selectedMonth; //2026-08

        // dd($bln);

        //ini sebaiknya jadikan Service (cara panggil fungsi di controller lain laravel)
        // di PicController diubah jadi private, atau dihapus jika sudah menggunakan service
        $picController = new PicController();
        $data = $picController->__dataYangDitampilkan($unor_simpegnas_id, date('Y').'-'.$bln);
        // $data = $this->__dataYangDitampilkan($unor_simpegnas_id, $tgl); // diatas

        // $bln = substr($tgl, 5, 2);//dari 2026-08 jadi 08
        // dd($data);

        

        DB::transaction(function () use ($data, $bln, $selectedKantor) {

            $date = date('Y') . '-' . $bln . '-01';

            foreach ($data as $item) {

                $persentases = ($item['rekap']['TK'] * 3)
                    + ($item['rekap']['TL1'] * 0.5)
                    + ($item['rekap']['TL2'] * 1)
                    + ($item['rekap']['TL3'] * 1.25)
                    + ($item['rekap']['TL4'] * 1.5)
                    + ($item['rekap']['PSW1'] * 0.5)
                    + ($item['rekap']['PSW2'] * 1)
                    + ($item['rekap']['PSW3'] * 1.25)
                    + ($item['rekap']['PSW4'] * 1.5);

                $persentase = round((1 - ($persentases / 100)) * 100, 2);

                DataAbsen::where('nip', $item['nip'])
                    ->where('date', $date)
                    ->update([
                        'persentase' => $persentase,
                    ]);
            }
            });
            
        return redirect('/pic/simpan-persentase-v2')->with('success', 'Hitung Persentase bulan '.$bln.' pada kantor '.$selectedKantor.' berhasil dilakukan.');

    }
}
