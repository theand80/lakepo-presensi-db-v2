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

    {{-- @dd($data) --}}

    <x-slot:title>listPenandaTangan</x-slot>
    <div>
        <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
            <div
                class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                <span>listPenandaTangan</span>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
            <div
                class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                <span>Set</span>
                <div>
                    <i class="fa-solid fa-rotate mr-2.5"></i>
                    <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
                </div>
            </div>
            <div class="min-h-25 border border-slate-200 px-6 flex items-center justify-center text-slate-500 bg-white">
                {{-- [ Kategori Grafik Kunjungan Mingguan ] --}}
                <table class="w-[65%] text-sm text-left mx-auto">
                    <thead class="text-xs text-slate-600 bg-slate-50 border-b border-slate-200 h-12">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Kantor</th>
                            <th>Sebagai</th>
                            <th>Nama</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $value)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="text-center p-3">{{ $loop->iteration }}</td>
                                <td class="p-3">{{ $value->unor_siasn_induk }}</td>
                                <td class="p-3">{{ $value->penandaTangan->sebagai ?? '' }}</td>
                                <td class="p-3">{{ $value->penandaTangan->nama_pen_ttd ?? '' }} </td>
                                <td class="p-3">{{ $value->penandaTangan->pangkat_gol ?? '' }} </td>
                                <td class="p-3">{{ $value->penandaTangan->nip ?? '' }} </td>

                                <!-- PERBAIKAN: Menggunakan Class dan Menyimpan Data di Atribut HTML -->
                                <td class="text-center p-3">
                                    <button type="button"
                                        class="btn-ubah bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition cursor-pointer"
                                        data-id="{{ $value->id }}" data-kantor="{{ $value->unor_siasn_induk }}"
                                        data-sebagai="{{ $value->penandaTangan->sebagai ?? '' }}"
                                        data-nip="{{ $value->penandaTangan->nip ?? '' }}">
                                        Ubah
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Struktur Utama Modal Container (Tersembunyi secara default) -->
    <div id="modalContainer" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">

        <!-- Backdrop / Latar Belakang Gelap -->
        <div id="modalBackdrop" class="fixed inset-0 bg-black/50 transition-opacity"></div>

        <!-- PERBAIKAN DI SINI: Pastikan id="modalBox" terpasang di tag form pembungkus ini -->
        <form action="{{ url('/admin/simpan-penandatangan') }}" method="POST" id="modalBox"
            class="bg-white rounded-xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all z-10 scale-95 opacity-0 duration-300">
            @csrf

            <!-- Input Hidden untuk ID Data -->
            <input type="hidden" name="id" id="inputIdData">

            <!-- Header Modal -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">Ubah Data Penandatangan</h3>
                <button type="button" id="closeModalCross"
                    class="text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Konten Modal -->
            <div class="p-6 space-y-4">
                <div>
                    <label for="namaKantor" class="block text-sm font-medium text-gray-700 mb-1">Nama Kantor
                        Induk</label>
                    <input type="text" id="namaKantor" name="namaKantor"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900"
                        required>
                </div>

                <div>
                    <label for="sebagai" class="block text-sm font-medium text-gray-700 mb-1">Bertindak Sebagai</label>
                    <input type="text" id="sebagai" name="sebagai"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900">
                </div>

                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP Penandatangan</label>
                    <input type="text" id="nip" name="nip"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900">
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="flex justify-end space-x-3 p-4 bg-gray-50 border-t border-gray-200">
                <button type="button" id="closeModalBtn"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-4 py-2 rounded-lg transition cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition cursor-pointer">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>





    {{-- script modal --}}
    <script>
        // 1. Inisialisasi Elemen Form & Input
        const inputIdData = document.getElementById('inputIdData');
        const inputKantor = document.getElementById('namaKantor');
        const inputSebagai = document.getElementById('sebagai');
        const inputNip = document.getElementById('nip');

        // 2. Inisialisasi Elemen Container Modal
        const modalContainer = document.getElementById('modalContainer');
        const modalBox = document.getElementById('modalBox');
        const modalBackdrop = document.getElementById('modalBackdrop');

        // 3. Logika untuk MEMBUKA Modal saat tombol "Ubah" di tabel diklik
        document.querySelectorAll('.btn-ubah').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah aksi default jika ada

                // Ambil data dari atribut tombol
                const idData = this.getAttribute('data-id');
                const kantor = this.getAttribute('data-kantor');
                const sebagai = this.getAttribute('data-sebagai');
                const nip = this.getAttribute('data-nip');

                // Isi nilai ke input modal
                if (inputIdData) inputIdData.value = idData;
                if (inputKantor) inputKantor.value = kantor;
                if (inputSebagai) inputSebagai.value = sebagai;
                if (inputNip) inputNip.value = nip;

                // Tampilkan modal dengan efek transisi
                modalContainer.classList.remove('hidden');
                setTimeout(() => {
                    modalBox.classList.remove('scale-95', 'opacity-0');
                    modalBox.classList.add('scale-100', 'opacity-100');
                }, 10);
            });
        });

        // Fungsi membuka modal
        function openModal() {
            modalContainer.classList.remove('hidden');
            setTimeout(() => {
                // PERBAIKAN JS: Cek apakah elemen modalBox ada
                if (modalBox) {
                    modalBox.classList.remove('scale-95', 'opacity-0');
                    modalBox.classList.add('scale-100', 'opacity-100');
                }
            }, 10);
        }

        // 4. Fungsi Utama untuk MENUTUP Modal
        function closeModal(e) {
            // Jika fungsi dipicu oleh event click, cegah perilaku bawaan form/button
            if (e) {
                e.preventDefault();
            }

            // Jalankan animasi mengecil dan memudar
            modalBox.classList.remove('scale-100', 'opacity-100');
            modalBox.classList.add('scale-95', 'opacity-0');

            // Sembunyikan container utama setelah animasi selesai (300ms)
            setTimeout(() => {
                modalContainer.classList.add('hidden');
            }, 300);
        }

        // 5. MEMASANG Event Listener Penutup (Pastikan ID ini sesuai di HTML Anda)
        const closeBtn = document.getElementById('closeModalBtn');
        const closeCross = document.getElementById('closeModalCross');

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (closeCross) closeCross.addEventListener('click', closeModal);
        if (modalBackdrop) modalBackdrop.addEventListener('click', closeModal);
    </script>

</x-layout>
