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
        <div
            class="mb-4 flex items-center gap-3 rounded-lg border border-red-
                200 bg-red-50 p-4 text-sm text-red-700">
            <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if (session('success'))
        <div
            class="mb-4 flex items-center gap-3 rounded-lg border border-green-
                200 bg-green-50 p-4 text-sm text-green-700">
            <svg class="h-5 w-5 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- @dd($listKantor) --}}

    <x-slot:title>List User</x-slot>
        <div>
            <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>List User</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>Tambah Data User</span>
                    <div>
                        <i class="fa-solid fa-rotate mr-2.5"></i>
                        <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
                    </div>
                </div>
                <div class="min-h-[100px] flex items-center justify-center text-slate-500 bg-white"> 
                    {{--  --}}

                    <div class="rounded-xl border border-gray-200 bg-white shadow-sm my-4">
                        <!-- Form -->
                        <form action="{{ url('/admin/add-user') }}" method="POST" class="p-6">
                            @csrf
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                                <!-- NIP -->
                                <div>
                                    <label for="nip"
                                        class="mb-2 block text-sm font-medium text-gray-700">
                                        NIP <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="nip"
                                        name="nip"
                                        placeholder="Masukkan NIP"
                                        required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                    >
                                </div>

                                <!-- Password -->
                                <div>
                                    <label for="password"
                                        class="mb-2 block text-sm font-medium text-gray-700">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        placeholder="Masukkan password"
                                        required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                    >
                                </div>

                                
                                <!-- Unor -->
                                <div>
                                    <label for="unor"
                                        class="mb-2 block text-sm font-medium text-gray-700">
                                        Unit Organisasi (Unor)
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        id="unor"
                                        name="unor"
                                        required
                                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                    >
                                        <option value="">Pilih unit organisasi</option>
                                        @foreach ($listKantor as $item)
                                            <option value="{{ $item->unor_siasn_induk }}">{{ $item->unor_siasn_induk }}</option>
                                        @endforeach
                                            
                                    </select>
                                </div>

                                <!-- Akses -->
                                <div>
                                    <label for="akses"
                                        class="mb-2 block text-sm font-medium text-gray-700">
                                        Akses Sebagai <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        id="akses"
                                        name="akses"
                                        required
                                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                    >
                                        <option value="">Pilih hak akses</option>
                                        <option value="admin">Admin</option>
                                        <option value="pic">Pic</option>
                                        <option value="operator">Operator</option>
                                    </select>
                                </div>

                            </div>

                            <!-- Kantor yang boleh diakses (PIC / Operator) -->
                            <div id="kantor-wrapper" class="mt-5 hidden">
                                <label for="kantors"
                                    class="mb-2 block text-sm font-medium text-gray-700">
                                    Kantor yang Boleh Diakses
                                    <span class="text-slate-400">(opsional — kosong = kantor sendiri / unor)</span>
                                </label>
                                <select
                                    id="kantors"
                                    name="kantors[]"
                                    multiple
                                    size="6"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >
                                    @foreach ($listKantor as $item)
                                        <option value="{{ $item->unor_siasn_induk }}">{{ $item->unor_siasn_induk }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-slate-400">Tahan Ctrl (Cmd) untuk memilih lebih dari satu.</p>
                            </div>

                            <!-- Tombol -->
                            <div class="mt-6 flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:justify-end">
                                <button
                                    type="reset"
                                    class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                                >
                                    Reset
                                </button>

                                <button
                                    type="submit"
                                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                >
                                    Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>

                    {{--  --}}
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>List User</span>
                    <div>
                        <i class="fa-solid fa-rotate mr-2.5"></i>
                        <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
                    </div>
                </div>

                <!-- Pencarian & Filter Role -->
                <div class="border-b border-slate-200 px-4 py-3">
                    <form action="{{ url('/admin/list-user') }}" method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                        <div class="flex-1">
                            <label for="q" class="mb-1 block text-xs font-medium text-gray-500 uppercase">Cari</label>
                            <input
                                type="text"
                                id="q"
                                name="q"
                                value="{{ $filterQ ?? '' }}"
                                placeholder="Cari NIP / nama..."
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            >
                        </div>
                        <div class="sm:w-48">
                            <label for="filter-role" class="mb-1 block text-xs font-medium text-gray-500 uppercase">Role</label>
                            <select
                                id="filter-role"
                                name="role"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            >
                                <option value="">Semua Role</option>
                                <option value="admin" {{ ($filterRole ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="pic" {{ ($filterRole ?? '') === 'pic' ? 'selected' : '' }}>Pic</option>
                                <option value="operator" {{ ($filterRole ?? '') === 'operator' ? 'selected' : '' }}>Operator</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button
                                type="submit"
                                class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            >
                                Filter
                            </button>
                            <a
                                href="{{ url('/admin/list-user') }}"
                                class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                            >
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <div class="min-h-[100px] flex items-center justify-center text-slate-500 bg-white">
                    {{-- [ Kategori Grafik Kunjungan Mingguan ] --}}

                    <table class="w-full min-w-[800px] divide-y divide-gray-200 text-sm text-left">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-center">No</th>
                                <th scope="col" class="px-6 py-4">Nama</th>
                                <th scope="col" class="px-6 py-4">NIP</th>
                                <th scope="col" class="px-6 py-4">Unor</th>
                                <th scope="col" class="px-6 py-4">Kantor Akses</th>
                                <th scope="col" class="px-6 py-4">Akses Sebagai</th>
                                <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($users as $user)
                                <tr class="transition-colors hover:bg-gray-50">
                                    <td class="px-6 py-4 text-center text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $user->nama }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $user->nip }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $user->unor }}</td>
                                    <td class="px-6 py-4 text-gray-600">
                                        @php
                                            $kantorTampil = $kantorPerUser->get($user->id);
                                        @endphp
                                        @if ($user->hasRole('admin'))
                                            <span class="text-slate-400">Semua kantor</span>
                                        @elseif ($kantorTampil)
                                            <span class="text-xs text-gray-600">{{ $kantorTampil }}</span>
                                        @else
                                            <span class="text-slate-400">{{ $user->unor }} (default)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                            {{ Str::ucfirst($user->getRoleNames()->first() ?? '-') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ url('/admin/edit-user', $user->id) }}"
                                                class="rounded-md bg-blue-600 px-3 py-2 text-xs font-medium text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                                Edit
                                            </a>

                                            @if ($user->id !== auth()->id())
                                                <button
                                                    type="button"
                                                    class="quick-set-btn rounded-md bg-emerald-600 px-3 py-2 text-xs font-medium text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                                                    data-user-id="{{ $user->id }}"
                                                    data-user-nama="{{ $user->nama }}"
                                                    data-user-nip="{{ $user->nip }}"
                                                    data-role="{{ $user->getRoleNames()->first() ?? '' }}"
                                                    data-kantors="{{ $kantorPerUser->get($user->id) ?? '' }}"
                                                >
                                                    Atur
                                                </button>
                                            @endif

                                            <form action="{{ url('/admin/delete-user', $user->id) }}" method="post"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="rounded-md bg-red-600 px-3 py-2 text-xs font-medium text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                                >
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- [ Kategori Grafik Kunjungan Mingguan ] --}}

                </div>
            </div>
        </div>

        <!-- Modal Quick-Set Role & Kantor -->
        <div id="quick-set-modal" class="fixed inset-0 z-50 hidden">
            <div class="quick-set-backdrop absolute inset-0 bg-black/50"></div>
            <div class="relative flex min-h-full items-center justify-center p-4">
                <div class="w-full max-w-lg rounded-xl bg-white shadow-xl">
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900">Atur Role & Kantor</h3>
                        <button type="button" id="quick-set-close" class="text-gray-400 transition hover:text-gray-600">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form id="quick-set-form" method="POST" action="">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4 px-6 py-5">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Nama</label>
                                <input
                                    type="text"
                                    id="quick-set-nama"
                                    readonly
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-600"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">NIP</label>
                                <input
                                    type="text"
                                    id="quick-set-nip"
                                    readonly
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-600"
                                >
                            </div>

                            <div>
                                <label for="quick-set-akses" class="mb-1 block text-sm font-medium text-gray-700">
                                    Akses Sebagai <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="quick-set-akses"
                                    name="akses"
                                    required
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >
                                    <option value="admin">Admin</option>
                                    <option value="pic">Pic</option>
                                    <option value="operator">Operator</option>
                                </select>
                            </div>

                            <div id="quick-set-kantor-wrapper" class="hidden">
                                <label for="quick-set-kantors" class="mb-1 block text-sm font-medium text-gray-700">
                                    Kantor yang Boleh Diakses
                                    <span class="text-slate-400">(opsional — kosong = kantor sendiri / unor)</span>
                                </label>
                                <select
                                    id="quick-set-kantors"
                                    name="kantors[]"
                                    multiple
                                    size="6"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >
                                    @foreach ($listKantor as $item)
                                        <option value="{{ $item->unor_siasn_induk }}">{{ $item->unor_siasn_induk }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-slate-400">Tahan Ctrl (Cmd) untuk memilih lebih dari satu.</p>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 border-t border-gray-200 px-6 py-4">
                            <button
                                type="button"
                                id="quick-set-cancel"
                                class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                            >
                                Batal
                            </button>
                            <button
                                type="submit"
                                class="rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                            >
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            (function () {
                // form tambah user
                const akses = document.getElementById('akses');
                const wrapper = document.getElementById('kantor-wrapper');

                function toggleKantor() {
                    const isKantorRole = akses.value === 'pic' || akses.value === 'operator';
                    wrapper.classList.toggle('hidden', !isKantorRole);
                }

                akses.addEventListener('change', toggleKantor);
                toggleKantor();
            })();

            (function () {
                // modal quick-set
                const modal = document.getElementById('quick-set-modal');
                const form = document.getElementById('quick-set-form');
                const namaInput = document.getElementById('quick-set-nama');
                const nipInput = document.getElementById('quick-set-nip');
                const aksesSelect = document.getElementById('quick-set-akses');
                const kantorWrapper = document.getElementById('quick-set-kantor-wrapper');
                const kantorSelect = document.getElementById('quick-set-kantors');
                const allKantorOptions = Array.from(kantorSelect.options).map((o) => o.value);

                function toggleModalKantor() {
                    const isKantorRole = aksesSelect.value === 'pic' || aksesSelect.value === 'operator';
                    kantorWrapper.classList.toggle('hidden', !isKantorRole);
                }

                aksesSelect.addEventListener('change', toggleModalKantor);

                function openModal(btn) {
                    const userId = btn.dataset.userId;
                    form.action = '/admin/quick-set-role/' + userId;
                    namaInput.value = btn.dataset.userNama || '';
                    nipInput.value = btn.dataset.userNip || '';

                    const role = btn.dataset.role || '';
                    if (allKantorOptions.includes(role)) {
                        aksesSelect.value = role;
                    } else {
                        aksesSelect.value = 'operator';
                    }

                    // pre-select kantor dari data-kantors (dipisah koma)
                    const kantors = (btn.dataset.kantors || '').split(',').filter(Boolean);
                    Array.from(kantorSelect.options).forEach((o) => {
                        o.selected = kantors.includes(o.value);
                    });

                    toggleModalKantor();
                    modal.classList.remove('hidden');
                }

                function closeModal() {
                    modal.classList.add('hidden');
                }

                document.querySelectorAll('.quick-set-btn').forEach((btn) => {
                    btn.addEventListener('click', function () {
                        openModal(this);
                    });
                });

                document.getElementById('quick-set-close').addEventListener('click', closeModal);
                document.getElementById('quick-set-cancel').addEventListener('click', closeModal);
                modal.querySelector('.quick-set-backdrop').addEventListener('click', closeModal);
            })();
        </script>
</x-layout>