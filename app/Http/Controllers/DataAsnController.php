<?php

namespace App\Http\Controllers;

use App\Imports\AddDataAsnImport;
use App\Imports\UpdateDataAsnImport;
use App\Models\DataAsn;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataAsnController extends Controller
{
    //
    //  impord data ASN dari Excel
    public function listDataAsn()
    {
        //
        // $data = DataAsn::orderBy('unor_siasn_induk', 'desc')->get();
        $data = DataAsn::orderBy('unor_siasn_induk', 'desc')->paginate(10);
        return view('admin.importDataAsnDariExcel', compact('data'));
    }

    public function addDataAsn(Request $request)
    {
        // dd($request->file());
        // dd($request->status);
        // dd($request->all());

        if ($request->hasFile('file-add-import')) {
            try {
                Excel::import(new AddDataAsnImport($request->status), $request->file('file-add-import'));
                return redirect('/admin/data-asn')->with('success', 'Data Berhasil Terinput!');
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                // Menangkap error validasi baris excel (misal kolom kosong/salah tipe data)
                $failures = $e->failures();
                dd($failures);
            } catch (\Exception $e) {
                // Menangkap error umum (misal duplikat database, kolom tidak cocok)
                dd($e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    public function updateDataAsn(Request $request)
    {
        if ($request->hasFile('file-update-import')) {
            Excel::import(new UpdateDataAsnImport, $request->file('file-update-import'));
            return redirect('/admin/data-asn')->with('success', 'Data Berhasil Diubah!');
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    public function destroyAllDataAsn()
    {
        DataAsn::truncate();
        return redirect('/admin/data-asn')->with('success', 'Semua data ASN berhasil dihapus!');
    }
}
