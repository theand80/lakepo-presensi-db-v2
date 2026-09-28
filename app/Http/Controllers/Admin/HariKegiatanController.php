<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataAbsen;
use App\Models\HariKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HariKegiatanController extends Controller
{
    //
    public function setHariKegiatan()
    {
        //
        $data = HariKegiatan::orderBy('tanggal', 'asc')->get();
        return view('admin.kegiatan.setHariKegiatan', compact('data'));
    }

    public function simpanSetHariKegiatan(Request $request)
    {
        //
        $request->validate([
            'tglKegiatan' => 'required|date',
            'namaKegiatan' => 'required|string',
            // 'bulan' => 'required|integer|min:1|max:12',
        ]);

        // disini buat agar data absen pada kolom kegiatan menjadi 1 pada tanggal tertentu
        DB::transaction(function () use ($request) {

            // Update data absensi pada tanggal kegiatan
            // DataAbsen::where('date', $request->input('tglKegiatan'))
            DataAbsen::whereDate('date', $request->input('tglKegiatan'))
            ->update([
                'kegiatan' => 1
            ]);

            // Simpan hari kegiatan
            HariKegiatan::create([
                'tanggal' => $request->input('tglKegiatan'),
                'nama_kegiatan' => $request->input('namaKegiatan'),
            ]);

        });
        
        return redirect('/admin/hari-kegiatan')->with('success', 'Hari Kegiatan berhasil ditambahkan.');
    }

    public function hapusHariKegiatan(Request $request, string $id)
    {
        // dd($request);
        $request->validate([
            'tanggalYgDihapus' => 'required|date',
        ]);

        DB::transaction(function () use ($id, $request) {

            // Ambil data hari kegiatan berdasarkan ID
            $hariKegiatan = HariKegiatan::findOrFail($id);

            // Ubah kegiatan menjadi 0 pada tanggal kegiatan
            // DataAbsen::whereDate('date', $request->input('tglKegiatan'))
            DataAbsen::whereDate('date', $request->input('tanggalYgDihapus'))
                ->update([
                    'kegiatan' => '',
                ]);

            // Hapus data hari kegiatan
            $hariKegiatan->delete();

            // Hapus HariKegiatan berdasarkan tanggal kegiatan
            // HariKegiatan::whereDate('tanggal', $request->tglKegiatan)
            //     ->delete();
        });

        return redirect('/admin/hari-kegiatan')
            ->with('success', 'Hari Kegiatan berhasil dihapus.');

    }




    public function ImportAsnYgMengikutiKegiatan(Request $request)
    {
        //
        // $selectedMonth = $request->input('month', date('Y-m-d'));
        // $selectedMonth = $request->input('month', date('01-08-2026'));

        $selectedKantor = $request->input('filterNamaKantor', '');
        $selectedMonth = $request->input('month', '2026-08-01');

        $query = DataAbsen::where('date', $selectedMonth)->where('kegiatan', 1)->get();

        
        if ($selectedKantor) {
            $query->where('unor_simpegnas', $selectedKantor);
        }

        $data = $query;
        
        // dd($query);
        // $data = $query->get()->groupBy('nip');


        return view('admin.kegiatan.importAsnYgIkutHariKegiatan', compact('data'));
    }
}
