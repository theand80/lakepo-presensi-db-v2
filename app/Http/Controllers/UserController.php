<?php

namespace App\Http\Controllers;

use App\Models\AsnDariApi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index()
    {
        //
        $users = User::all();
        // dd($users);

        $listKantor = AsnDariApi::select('unor_siasn_induk')->distinct()->get();
        
        return view('admin.user.listUser', compact('users', 'listKantor'));
    }

    public function store(Request $request)
    {
        //
        // dd($request)->all();
        $request->validate([
            'nip' => [
                'required',
                'numeric',
                // 'digits_between:1,18',
                'regex:/^[0-9]{18}$/',
                Rule::exists((new AsnDariApi)->getTable(), 'nip'),// hanya yg ada di tabel AsnDariApi
                // Rule::unique('users', 'nip') //Nip yg sama akan ditolak
                Rule::unique('users', 'nip')->where('role', $request->akses),// Nip dengan Akses yang sama akan ditolak
            ],
            'akses'    => 'required|string|in:admin,pic,operator',
            'unor'     => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.string'   => 'NIP harus berupa angka.',
            // 'nip.max'      => 'NIP maksimal 18 digit.',
            'nip.regex'    => 'NIP harus terdiri dari tepat 18 digit angka.',
            'nip.exists'   => 'NIP tidak ditemukan dalam data ASN.',
            // 'nip.unique'   => 'NIP sudah terdaftar sebagai pengguna.',
            'nip.unique'   => 'NIP dengan akses tersebut sudah terdaftar.',

            'akses.required' => 'Akses wajib dipilih.',
            'akses.in'       => 'Akses yang dipilih tidak valid.',

            'unor.required' => 'Unit organisasi wajib diisi.',
            'unor.max'      => 'Unit organisasi maksimal 255 karakter.',

            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
            // 'password.confirmed'=> 'Konfirmasi password tidak cocok.',//|confirmed
        ]);
            
        $nama = AsnDariApi::firstWhere('nip', $request->input('nip'));

        // dd($nama->nama);
            
        User::create([
            'nip' => $request->input('nip'),
            'nama' => $nama->nama,
            'role' => $request->input('akses'),
            'unor' => $request->input('unor'),
            'password' => $request->input('password'),
        ]);

        // User::updateOrCreate(
        //     [
        //         'nip'   => $request->nip,
        //         'akses' => $request->akses,
        //     ],
        //     [
        //         'unor'     => $request->unor,
        //         'password' => Hash::make($request->password),
        //     ]
        // );

        return redirect('/admin/list-user')->with('success', 'Data berhasil ditambah');

    }


    public function destroy(string $id)
    {
        //
        $user = User::findOrFail($id);
        $user->delete();

        // $user = User::where('nip', $nip)->firstOrFail();
        // $user->delete();

        return redirect('/admin/list-user')->with('success', 'Data berhasil dihapus');
    }
}
