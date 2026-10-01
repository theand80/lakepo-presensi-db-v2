<x-layout>
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

    <x-slot:title>List Asn Dari Api Yang Sudah Ke DB</x-slot>

    {{--  --}}
    <div>
        <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
            <div
                class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                <span>listAsnDariApiYangSudahKeDB</span>
            </div>
        </div>

        <!-- Import Data ASN -->
        <div class="w-full">
            <div class="w-2xl mx-auto">
                <form action="{{ url('/admin/import-duk-excel-untuk-lengkapi-data-asn') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="dropzone-update-data"
                                class="flex flex-col items-center justify-center w-full h-44 bg-slate-50 border-2 border-dashed border-slate-300 rounded-lg hover:border-green-400 cursor-pointer transition-colors">
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
                                <input id="dropzone-update-data" name="file-update-import" type="file"
                                    accept=".xlsx, .xls, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, text/csv"
                                    class="hidden" />
                            </label>

                            <!-- Select Status -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                                <select name="status" class="w-full text-xs border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-300 focus:border-green-500 outline-none bg-white">
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
            </div>
        </div>

        {{--  --}}
        <!-- List Data ASN -->
        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-sm mt-6">
            <div class="bg-slate-50 py-3 px-4 flex justify-between items-center border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-table text-slate-500"></i>
                    <span class="font-bold text-xs uppercase tracking-wide text-slate-600">List Data ASN</span>
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ url('/admin/hapus-data-asn-dari-api-ke-db') }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus SEMUA data ASN?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 text-xs font-medium text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg transition-colors">
                            <i class="fa-solid fa-trash"></i> Hapus Semua
                        </button>
                    </form>

                    <form action="{{ url('/admin/download-data-asn-dari-api-ke-db') }}" method="post">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 text-xs font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-lg transition-colors">
                            <i class="fa-solid fa-download"></i> Download
                        </button>
                    </form>
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
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Pangkat/Golongan</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">status</th>
                            <th scope="col" class="px-4 py-3 font-semibold">Jabatan</th>
                            <th scope="col" class="px-4 py-3 font-semibold">Unit Kerja (SIASN)</th>
                            <th scope="col" class="px-4 py-3 font-semibold">Unit Kerja (Simpegnas)</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $asn)
                            <tr class="bg-white border-b border-slate-100 hover:bg-slate-50">
                                <td class="p-4">
                                    <input type="checkbox"
                                        class="w-4 h-4 border border-slate-300 rounded bg-slate-100 focus:ring-2 focus:ring-green-300">
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-800 whitespace-nowrap">{{ $asn['nip'] }}
                                </td>
                                <td class="px-4 py-3">{{ $asn['nama'] }}</td>
                                <td class="px-4 py-3 text-center">
                                    {{ $asn['pangkat'] ? $asn['pangkat']." -" : ""}}  {{ $asn['golongan'] }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($asn['status'] == 'PNS')
                                        <span
                                            class="text-red-400 font-bold inline-block w-14 rounded-full">{{ $asn['status'] }}</span>
                                    @endif
                                    @if ($asn['status'] == 'PPPK')
                                        <span
                                            class="text-green-400 font-bold inline-block w-14 rounded-full">{{ $asn['status'] }}</span>
                                    @endif
                                    @if ($asn['status'] == 'P3K PW')
                                        <span
                                            class="text-blue-400 font-bold inline-block w-14 rounded-full">{{ $asn['status'] }}</span>
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
                        @empty
                            <tr>
                                <td colspan="30" class="px-4 py-8 text-center text-slate-400">
                                    Tidak ada data ditemukan.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- <div class="py-10 px-2"> --}}
                {{-- {{ $data->appends(request()->query())->links() }} --}}
            {{-- </div> --}}

            <nav class="flex items-center flex-col sm:flex-row justify-between p-4 border-t border-slate-200"
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


    <script>
        document.getElementById('dropzone-update-data').addEventListener('change', function (e) {
            const fileInput = e.target;
            const dropzoneText = document.getElementById('dropzone-text-update-data');

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
    </script>

</x-layout>