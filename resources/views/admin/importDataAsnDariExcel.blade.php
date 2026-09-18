<x-layout>
    <x-slot:title>Data ASN V2</x-slot>

        <div class="space-y-5">

            <x-notifError />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:mx-40">
                <!-- Import Data ASN -->
                <form action="{{ url('/import-excel-add-data-asn') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-sm">
                        <!-- Header Card -->
                        <div class="bg-slate-50 py-3 px-4 flex items-center gap-2 border-b border-slate-200">
                            <i class="fa-solid fa-file-arrow-up text-green-600"></i>
                            <span class="font-bold text-xs uppercase tracking-wide text-slate-600">Unggah Data</span>
                        </div>

                        <!-- Isi Konten Card -->
                        <div class="p-5 flex flex-col gap-4">
                            <!-- Area Dropzone File -->
                            <label for="dropzone-import-data"
                                class="flex flex-col items-center justify-center w-full h-44 bg-slate-50 border-2 border-dashed border-slate-300 rounded-lg hover:border-green-400 cursor-pointer transition-colors">
                                <div id="dropzone-text-import-data"
                                    class="flex flex-col items-center justify-center text-center p-4">
                                    <svg class="w-10 h-10 mb-3 text-slate-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
                                    </svg>
                                    <p class="text-sm text-slate-600 mb-1"><span class="font-semibold">Click to
                                            upload</span> or drag and drop</p>
                                    <p class="text-xs text-slate-400">Format: .xlsx, .xls, atau .csv (Maks. 10MB)</p>
                                </div>
                                <input id="dropzone-import-data" name="file-add-import" type="file"
                                    accept=".xlsx, .xls, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, text/csv"
                                    class="hidden" />
                            </label>

                            <!-- Select Status -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                                <select name="status"
                                    class="w-full text-xs border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-300 focus:border-green-500 outline-none bg-white">
                                    <option value="PNS">PNS</option>
                                    <option value="PPPK">PPPK</option>
                                    <option value="P3K PW">P3K PW</option>
                                </select>
                            </div>

                            <!-- Tombol Submit Utama -->
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-1.5 text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-4 py-2.5 focus:outline-none transition-colors">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                Unggah Data
                            </button>
                        </div>
                    </div>
                </form>


                <!-- Update Data ASN -->
                <form action="{{ url('/import-excel-update-data-asn') }}" method="POST" enctype="multipart/form-data">
                    @csrf


                    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-sm">
                        <div class="bg-slate-50 py-3 px-4 flex items-center gap-2 border-b border-slate-200">
                            <i class="fa-solid fa-file-arrow-down text-blue-500"></i>
                            <span class="font-bold text-xs uppercase tracking-wide text-slate-600">Update Data
                                ASN</span>
                        </div>


                        <!-- Isi Konten Card -->
                        <div class="p-5 flex flex-col gap-4">
                            <!-- Area Dropzone Gambar -->
                            <label for="dropzone-update-data"
                                class="flex flex-col items-center justify-center w-full h-63 bg-slate-50 border-2 border-dashed border-slate-300 rounded-lg hover:border-blue-400 cursor-pointer transition-colors">
                                <!-- ID ditambahkan di sini untuk memanipulasi teks via JS -->
                                <div id="dropzone-text-update-data"
                                    class="flex flex-col items-center justify-center text-center p-4">
                                    <svg class="w-10 h-10 mb-3 text-slate-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
                                    </svg>
                                    <p class="text-sm text-slate-600 mb-1"><span class="font-semibold">Click to
                                            upload</span> or drag and drop</p>
                                    <p class="text-xs text-slate-400">Format: .xlsx, .xls, atau .csv (Maks. 10MB)</p>

                                </div>
                                <!-- Input File Tersembunyi -->
                                {{-- <input id="dropzone-update-data" name="file" type="file" accept="image/*"
                                    class="hidden" /> --}}
                                <input id="dropzone-update-data" name="file-update-import" type="file"
                                    accept=".xlsx, .xls, .csv" class="hidden" />

                            </label>

                            <!-- Tombol Submit Utama -->
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-1.5 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-4 py-2.5 focus:outline-none transition-colors">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                Update Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- List Data ASN -->
            <div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-sm">
                <div class="bg-slate-50 py-3 px-4 flex justify-between items-center border-b border-slate-200">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-table text-slate-500"></i>
                        <span class="font-bold text-xs uppercase tracking-wide text-slate-600">List Data ASN</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <form action="{{ url('import-excel-delete-all-data-asn') }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus SEMUA data ASN?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1.5 text-xs font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg transition-colors">
                                <i class="fa-solid fa-trash"></i> Hapus Semua
                            </button>
                        </form>
                        <button
                            class="inline-flex items-center gap-1.5 text-xs font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-lg transition-colors">
                            <i class="fa-solid fa-download"></i> Download
                        </button>
                    </div>
                </div>
                <div class="overflow-auto max-h-[730px]">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-600 bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th scope="col" class="p-4">
                                    <input id="table-checkbox-all" type="checkbox"
                                        class="w-4 h-4 border border-slate-300 rounded bg-slate-100 focus:ring-2 focus:ring-green-300">
                                </th>
                                <th scope="col" class="px-4 py-3 font-semibold text-center">NIP</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Nama</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Pangkat/Golongan</th>
                                <th scope="col" class="px-4 py-3 font-semibold">status</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Jabatan</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Unit Kerja (SIASN)</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Unit Kerja (Simpegnas)</th>
                                <th scope="col" class="px-4 py-3 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ([] as $asn)
                                <tr class="bg-white border-b border-slate-100 hover:bg-slate-50">
                                    <td class="p-4">
                                        <input type="checkbox"
                                            class="w-4 h-4 border border-slate-300 rounded bg-slate-100 focus:ring-2 focus:ring-green-300">
                                    </td>
                                    <td class="px-4 py-3 font-medium text-slate-800 whitespace-nowrap">{{ $asn['nip'] }}
                                    </td>
                                    <td class="px-4 py-3">{{ $asn['nama'] }}</td>
                                    <td class="px-4 py-3">
                                        {{ $asn['golongan'] }}{{ $asn['pangkat'] ? " - {$asn['pangkat']}" : '' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($asn['status'] == 'PNS')
                                            <span
                                                class="bg-red-200 p-0.5 inline-block w-14 rounded-full">{{ $asn['status'] }}</span>
                                        @endif
                                        @if ($asn['status'] == 'PPPK')
                                            <span
                                                class="bg-green-200 p-0.5 inline-block w-14 rounded-full">{{ $asn['status'] }}</span>
                                        @endif
                                        @if ($asn['status'] == 'P3K PW')
                                            <span
                                                class="bg-blue-200 p-0.5 inline-block w-14 rounded-full">{{ $asn['status'] }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ str($asn['jabatan'])->limit(30, '...') }}</td>
                                    <td class="px-4 py-3">
                                        {{ str($asn['unor_siasn_induk'])->limit(30, '...') }}
                                        {{-- {{ str($asn['unor_siasn_induk']) }} --}}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ str($asn['unor_simpegnas'])->limit(30, '...') }}
                                        {{-- {{ str($asn['unor_simpegnas']) }} --}}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button
                                                onclick="openEditModal('198501152010012005','Dr. Ahmad Fauzi, S.Kom., M.T.','III/c - Penata Muda Tk. I','Kepala Bidang Kepegawaian','Badaan Kepegawaian dan Pengembangan Sumber Daya Manusia','Badaan Kepegawaian dan Pengembangan Sumber Daya Manusia')"
                                                type="button"
                                                class="font-medium text-green-600 hover:underline">Edit</button>
                                            <button onclick="deleteRow('198501152010012005')" type="button"
                                                class="font-medium text-red-600 hover:underline">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="py-10 px-2">
                    {{-- {{ $data->appends(request()->query())->links() }} --}}
                </div>

                <nav class="hidden flex items-center flex-col sm:flex-row justify-between p-4 border-t border-slate-200"
                    aria-label="Table navigation">
                    <span class="text-sm font-normal text-slate-500 mb-4 sm:mb-0">Showing <span
                            class="font-semibold text-slate-700">1-10</span> of <span
                            class="font-semibold text-slate-700">100</span></span>
                    <ul class="flex items-center -space-x-px text-sm">
                        <li>
                            <a href="#"
                                class="flex items-center justify-center px-3 h-9 text-slate-500 bg-white border border-slate-300 rounded-l-lg hover:bg-slate-100 hover:text-slate-700 font-medium">Previous</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center w-9 h-9 text-green-600 bg-green-50 border border-slate-300 font-medium">1</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center w-9 h-9 text-slate-500 bg-white border border-slate-300 hover:bg-slate-100 hover:text-slate-700 font-medium">2</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center w-9 h-9 text-slate-500 bg-white border border-slate-300 hover:bg-slate-100 hover:text-slate-700 font-medium">3</a>
                        </li>
                        <li>
                            <span
                                class="flex items-center justify-center w-9 h-9 text-slate-500 bg-white border border-slate-300">...</span>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center w-9 h-9 text-slate-500 bg-white border border-slate-300 hover:bg-slate-100 hover:text-slate-700 font-medium">10</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center px-3 h-9 text-slate-500 bg-white border border-slate-300 rounded-r-lg hover:bg-slate-100 hover:text-slate-700 font-medium">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editModal"
            class="fixed inset-0 z-50 hidden w-full h-full bg-black/50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
                <div class="flex items-center justify-between p-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800">Edit Data ASN</h3>
                    <button onclick="closeEditModal()" type="button" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="editForm" class="p-4 space-y-4">
                    <input type="hidden" id="editNip">
                    <input type="hidden" id="editNama">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">NIP</label>
                        <input type="text" id="editNipDisplay" disabled
                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg bg-slate-50 text-slate-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
                        <input type="text" id="editNamaDisplay" disabled
                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg bg-slate-50 text-slate-500">
                    </div>
                    <div>
                        <label for="editGolongan"
                            class="block text-sm font-medium text-slate-700 mb-1">Pangkat/Golongan</label>
                        <select id="editGolongan"
                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                            <option value="">-- Pilih Pangkat/Golongan --</option>
                            <option value="I/a - Juru Muda">I/a - Juru Muda</option>
                            <option value="I/b - Juru Muda Tk. I">I/b - Juru Muda Tk. I</option>
                            <option value="I/c - Juru">I/c - Juru</option>
                            <option value="I/d - Juru Tk. I">I/d - Juru Tk. I</option>
                            <option value="II/a - Pengatur Muda">II/a - Pengatur Muda</option>
                            <option value="II/b - Pengatur Muda Tk. I">II/b - Pengatur Muda Tk. I</option>
                            <option value="II/c - Pengatur">II/c - Pengatur</option>
                            <option value="II/d - Pengatur Tk. I">II/d - Pengatur Tk. I</option>
                            <option value="III/a - Penata Muda">III/a - Penata Muda</option>
                            <option value="III/b - Penata Muda Tk. I">III/b - Penata Muda Tk. I</option>
                            <option value="III/c - Penata">III/c - Penata</option>
                            <option value="III/d - Penata Tk. I">III/d - Penata Tk. I</option>
                            <option value="IV/a - Pembina">IV/a - Pembina</option>
                            <option value="IV/b - Pembina Tk. I">IV/b - Pembina Tk. I</option>
                            <option value="IV/c - Pembina Utama">IV/c - Pembina Utama</option>
                            <option value="IV/e - Pembina Utama">IV/e - Pembina Utama</option>
                        </select>
                    </div>
                    <div>
                        <label for="editJabatan" class="block text-sm font-medium text-slate-700 mb-1">Jabatan</label>
                        <input type="text" id="editJabatan"
                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                    </div>
                    <div>
                        <label for="editUnitSiasn" class="block text-sm font-medium text-slate-700 mb-1">Unit Kerja
                            (SIASN)</label>
                        <input type="text" id="editUnitSiasn"
                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                    </div>
                    <div>
                        <label for="editUnitSimpeg" class="block text-sm font-medium text-slate-700 mb-1">Unit Kerja
                            (Simpegnas)</label>
                        <input type="text" id="editUnitSimpeg"
                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 border border-slate-300 rounded-lg hover:bg-slate-200">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openEditModal(nip, nama, golonganPangkat, jabatan, unitSiasn, unitSimpeg) {
                document.getElementById('editNip').value = nip;
                document.getElementById('editNama').value = nama;
                document.getElementById('editNipDisplay').value = nip;
                document.getElementById('editNamaDisplay').value = nama;
                document.getElementById('editGolongan').value = golonganPangkat;
                document.getElementById('editJabatan').value = jabatan;
                document.getElementById('editUnitSiasn').value = unitSiasn;
                document.getElementById('editUnitSimpeg').value = unitSimpeg;
                document.getElementById('editModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeEditModal() {
                document.getElementById('editModal').classList.add('hidden');
                document.body.style.overflow = '';
            }

            document.getElementById('editForm').addEventListener('submit', function (e) {
                e.preventDefault();
                const nip = document.getElementById('editNip').value;
                const nama = document.getElementById('editNama').value;
                const golonganPangkat = document.getElementById('editGolongan').value;
                const jabatan = document.getElementById('editJabatan').value;
                const unitSiasn = document.getElementById('editUnitSiasn').value;
                const unitSimpeg = document.getElementById('editUnitSimpeg').value;

                alert('Data berhasil disimpan!\n\nNIP: ' + nip + '\nNama: ' + nama + '\nPangkat/Golongan: ' +
                    golonganPangkat + '\nJabatan: ' + jabatan + '\nUnit Kerja SIASN: ' + unitSiasn +
                    '\nUnit Kerja Simpeg: ' + unitSimpeg);
                closeEditModal();
            });

            document.getElementById('editModal').addEventListener('click', function (e) {
                if (e.target === this) closeEditModal();
            });

            function deleteRow(nip) {
                if (confirm('Apakah Anda yakin ingin menghapus data dengan NIP ' + nip + '?')) {
                    alert('Data dengan NIP ' + nip + ' berhasil dihapus!');
                }
            }
        </script>

        {{-- theand import dan update data menggunakan excel --}}
        <script>
            document.getElementById('dropzone-import-data').addEventListener('change', function (e) {
                const fileInput = e.target;
                const dropzoneText = document.getElementById('dropzone-text-import-data');

                // Memeriksa apakah ada file yang dipilih
                if (fileInput.files && fileInput.files[0]) {
                    const fileName = fileInput.files[0].name;

                    // Mengubah tampilan teks di dalam dropzone menjadi nama file
                    dropzoneText.innerHTML = `
                    <i class="fa-regular fa-file-excel text-4xl mb-3 text-green-600 animate-bounce"></i>
                    <p class="text-sm font-semibold text-slate-700 mb-1">File Excel Terpilih:</p>
                    <p class="text-xs text-green-600 bg-green-50 px-3 py-1.5 border border-green-200 rounded font-mono break-all max-w-xs">${fileName}</p>
                    <p class="text-[10px] text-slate-400 mt-2">Klik area ini kembali untuk mengubah file</p>
                `;
                }
            });

            // 
            document.getElementById('dropzone-update-data').addEventListener('change', function (e) {
                const fileInput = e.target;
                const dropzoneText = document.getElementById('dropzone-text-update-data');

                // Memeriksa apakah ada file yang dipilih
                if (fileInput.files && fileInput.files[0]) {
                    const fileName = fileInput.files[0].name;

                    // Mengubah tampilan teks di dalam dropzone menjadi nama file
                    dropzoneText.innerHTML = `
                    <i class="fa-regular fa-file-excel text-4xl mb-3 text-blue-600 animate-bounce"></i>
                    <p class="text-sm font-semibold text-slate-700 mb-1">File Excel Terpilih:</p>
                    <p class="text-xs text-blue-600 bg-blue-50 px-3 py-1.5 border border-blue-200 rounded font-mono break-all max-w-xs">${fileName}</p>
                    <p class="text-[10px] text-slate-400 mt-2">Klik area ini kembali untuk mengubah file</p>
                `;
                }
            });
        </script>



</x-layout>