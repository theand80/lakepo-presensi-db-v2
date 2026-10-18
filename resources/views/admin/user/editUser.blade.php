<x-layout>

    @if ($errors->any())
        <div class="mb-4 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>

            <div>
                <p class="font-medium">Terdapat kesalahan:</p>

                <ul class="mt-1 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 flex items-center gap-3 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <x-slot:title>Edit User</x-slot>
        <div>
            <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>Edit User</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>Form Edit User</span>
                    <div>
                        <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
                    </div>
                </div>
                <div class="min-h-[100px] flex items-center justify-center text-slate-500 bg-white">

                    <div class="rounded-xl border border-gray-200 bg-white shadow-sm my-4 w-full max-w-3xl">
                        <!-- Form -->
                        <form action="{{ url('/admin/update-user', $user->id) }}" method="POST" class="p-6">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                                <!-- NIP (read-only) -->
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">NIP</label>
                                    <input type="text" value="{{ $user->nip }}" readonly
                                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-500 outline-none">
                                </div>

                                <!-- Nama (read-only) -->
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" value="{{ $user->nama }}" readonly
                                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-500 outline-none">
                                </div>

                                <!-- Password (opsional) -->
                                <div>
                                    <label for="password"
                                        class="mb-2 block text-sm font-medium text-gray-700">
                                        Password <span class="text-slate-400">(opsional — kosongkan jika tidak diubah)</span>
                                    </label>
                                    <input type="password" id="password" name="password"
                                        placeholder="Masukkan password baru"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                </div>

                                <!-- Unor -->
                                <div>
                                    <label for="unor"
                                        class="mb-2 block text-sm font-medium text-gray-700">
                                        Unit Organisasi (Unor)
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <select id="unor" name="unor" required
                                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                        <option value="">Pilih unit organisasi</option>
                                        @foreach ($listKantor as $item)
                                            <option value="{{ $item->unor_siasn_induk }}"
                                                @selected($user->unor === $item->unor_siasn_induk)>{{ $item->unor_siasn_induk }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Akses -->
                                <div>
                                    <label for="akses"
                                        class="mb-2 block text-sm font-medium text-gray-700">
                                        Akses Sebagai <span class="text-red-500">*</span>
                                    </label>
                                    <select id="akses" name="akses" required
                                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                        <option value="">Pilih hak akses</option>
                                        <option value="admin" @selected($user->hasRole('admin'))>Admin</option>
                                        <option value="pic" @selected($user->hasRole('pic'))>Pic</option>
                                        <option value="operator" @selected($user->hasRole('operator'))>Operator</option>
                                    </select>
                                </div>

                            </div>

                            <!-- Kantor yang boleh diakses (PIC / Operator) -->
                            <div id="kantor-wrapper" class="mt-5">
                                <label for="kantors"
                                    class="mb-2 block text-sm font-medium text-gray-700">
                                    Kantor yang Boleh Diakses
                                    <span class="text-slate-400">(opsional — kosong = kantor sendiri / unor)</span>
                                </label>
                                <select id="kantors" name="kantors[]" multiple size="6"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    @foreach ($listKantor as $item)
                                        <option value="{{ $item->unor_siasn_induk }}"
                                            @selected(in_array($item->unor_siasn_induk, $kantorTerpilih, true))>
                                            {{ $item->unor_siasn_induk }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-slate-400">Tahan Ctrl (Cmd) untuk memilih lebih dari satu.</p>
                            </div>

                            <!-- Tombol -->
                            <div class="mt-6 flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:justify-end">
                                <a href="{{ url('/admin/list-user') }}"
                                    class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 text-center">
                                    Kembali
                                </a>

                                <button type="submit"
                                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <script>
            (function () {
                const akses = document.getElementById('akses');
                const wrapper = document.getElementById('kantor-wrapper');

                function toggleKantor() {
                    const isKantorRole = akses.value === 'pic' || akses.value === 'operator';
                    wrapper.style.display = isKantorRole ? '' : 'none';
                }

                akses.addEventListener('change', toggleKantor);
                toggleKantor();
            })();
        </script>
</x-layout>
