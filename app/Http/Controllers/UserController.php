<?php

namespace App\Http\Controllers;

use App\Models\AsnDariApi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        $listKantor = AsnDariApi::select('unor_siasn_induk')->distinct()->get();

        // daftar kantor yang diset per user (untuk ditampilkan)
        $kantorPerUser = DB::table('user_unor')
            ->whereIn('user_id', $users->pluck('id'))
            ->groupBy('user_id')
            ->select('user_id', DB::raw('GROUP_CONCAT(unor_siasn_induk) as kantors'))
            ->pluck('kantors', 'user_id');

        return view('admin.user.listUser', compact('users', 'listKantor', 'kantorPerUser'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => [
                'required',
                'numeric',
                'regex:/^[0-9]{18}$/',
                Rule::exists((new AsnDariApi)->getTable(), 'nip'),
                Rule::unique('users', 'nip'),
            ],
            'akses' => 'required|string|in:admin,pic,operator',
            'unor' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'kantors' => 'nullable|array',
            'kantors.*' => 'string|max:255',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.string' => 'NIP harus berupa angka.',
            'nip.regex' => 'NIP harus terdiri dari tepat 18 digit angka.',
            'nip.exists' => 'NIP tidak ditemukan dalam data ASN.',
            'nip.unique' => 'NIP sudah terdaftar sebagai pengguna.',

            'akses.required' => 'Akses wajib dipilih.',
            'akses.in' => 'Akses yang dipilih tidak valid.',

            'unor.required' => 'Unit organisasi wajib diisi.',
            'unor.max' => 'Unit organisasi maksimal 255 karakter.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $nama = AsnDariApi::firstWhere('nip', $request->input('nip'));

        $user = User::create([
            'nip' => $request->input('nip'),
            'nama' => $nama->nama,
            'unor' => $request->input('unor'),
            'password' => $request->input('password'),
        ]);

        $user->assignRole($request->input('akses'));

        // simpan kantor yang boleh diakses (untuk pic/operator); admin tidak perlu
        if ($request->input('akses') !== 'admin') {
            $user->syncKantorUnor($request->input('kantors', []));
        }

        return redirect('/admin/list-user')->with('success', 'Data berhasil ditambah');
    }

    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);

        $listKantor = AsnDariApi::select('unor_siasn_induk')->distinct()->get();

        $kantorTerpilih = $user->kantorUnorNames()->all();

        return view('admin.user.editUser', compact('user', 'listKantor', 'kantorTerpilih'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'unor' => 'required|string|max:255',
            'akses' => ['required', 'string', Rule::in(['admin', 'pic', 'operator'])],
            'password' => 'nullable|string|min:8',
            'kantors' => 'nullable|array',
            'kantors.*' => 'string|max:255',
        ], [
            'unor.required' => 'Unit organisasi wajib diisi.',
            'unor.max' => 'Unit organisasi maksimal 255 karakter.',

            'akses.required' => 'Akses wajib dipilih.',
            'akses.in' => 'Akses yang dipilih tidak valid.',

            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // cegah admin mengubah dirinya sendiri menjadi bukan admin
        if ($user->id === auth()->id() && $request->input('akses') !== 'admin') {
            return back()->with('error', 'Anda tidak dapat mengubah akses akun Anda sendiri.');
        }

        $user->update([
            'unor' => $request->input('unor'),
            'password' => $request->filled('password') ? $request->input('password') : $user->password,
        ]);

        $user->syncRoles([$request->input('akses')]);

        if ($request->input('akses') === 'admin') {
            $user->syncKantorUnor([]);
        } else {
            $user->syncKantorUnor($request->input('kantors', []));
        }

        return redirect('/admin/list-user')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // jangan hapus akun sendiri
        if ($user->id === auth()->id()) {
            return redirect('/admin/list-user')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect('/admin/list-user')->with('success', 'Data berhasil dihapus');
    }
}
