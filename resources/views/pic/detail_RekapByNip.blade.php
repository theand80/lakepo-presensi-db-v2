<x-layout>
    <x-slot:title>Operator Nama Kantor</x-slot>
    <div>
        <div class="mb-4">
            {{-- <a href="{{ url('/pic/kantor') }}" --}}
            <a href="javascript:history.back()"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-green-600 transition-colors cursor-pointer">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <x-notifError />

        <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
            <div
                class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                <span>detail Rekap By Nip</span>
                <div class="flex gap-2">
                    <div class="flex items-center gap-2 normal-case font-normal">
                        <label for="filterBulan" class="text-xs font-medium text-slate-600">Periode:</label>
                        <input type="month" id="filterBulan" value="8"
                            class="text-xs border border-slate-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-green-300 focus:border-green-500 outline-none">
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="text-xs border border-slate-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-green-300 focus:border-green-500 outline-none bg-green-600 hover:bg-green-700 gap-1.5 font-medium text-white transition-colors">
                            <i class="fa-brands fa-squarespace"></i>
                            Lihat</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
            <div
                class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                <span>Data ASN</span>
            </div>
            <div class="flex flex-col md:flex-row items-stretch">
                <div class="flex-1 p-5 space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-slate-500 w-40">NIP</span>
                        <span class="text-sm text-slate-800">123</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-slate-500 w-40">Nama</span>
                        <span class="text-sm text-slate-800">aaa</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-slate-500 w-40">Pangkat / Golongan</span>
                        <span
                            class="text-sm text-slate-800">{{ [] ? $asn['golongan'] . ' - ' . $asn['pangkat'] : 'Pang -- / Golongan' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-slate-500 w-40">Jabatan</span>
                        <span class="text-sm text-slate-800">{{ ucwords(strtolower($asn['jabatan'] ?? '')) }}</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-xs font-semibold text-slate-500 w-40">Status</span>
                        <span class="text-sm text-slate-800">{{ $asn['status'] ?? '' }}</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-xs font-semibold text-slate-500 w-40">Unit Kerja (Simpegnas)</span>
                        <span class="text-sm text-slate-800">{{ $asn['unor_siasn_induk'] ?? '' }}</span>
                    </div>
                    <div class="flex flex-row gap-2">
                        <span class="text-xs font-semibold text-slate-500">List Melakukan Dinas Luar sebanyak X
                            Kali</span>
                        <span class="text-sm text-slate-800">Lihat</span>
                    </div>
                    <div class="flex flex-row gap-2">
                        <span class="text-xs font-semibold text-slate-500">List Melakukan Ijin sebaganyak X Kali</span>
                        <span class="text-sm text-slate-800">Lihat</span>
                    </div>


                </div>


                <div class="flex items-center justify-center p-5 md:border-l border-slate-200">
                    <div class="relative w-[140px] h-[140px]">
                        <canvas id="attendanceDonut"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">

                            <span class="text-2xl font-bold text-slate-800">
                                80 %
                            </span>

                            <span class="text-xs text-slate-500">Ketidakhadiran</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-5 border-t border-slate-200">
                <div class="flex items-center gap-3 bg-green-50 rounded-lg p-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100">
                        <i class="fa-solid fa-check text-green-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Total Hadir</p>
                        <p class="text-lg font-bold text-green-700">{{ $totalHadir ?? '' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 bg-orange-50 rounded-lg p-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-orange-100">
                        <i class="fa-solid fa-plane-departure text-orange-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Total Cuti</p>
                        <p class="text-lg font-bold text-orange-700">-</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 bg-red-50 rounded-lg p-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-red-100">
                        <i class="fa-solid fa-xmark text-red-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Tidak Hadir</p>
                        <p class="text-lg font-bold text-red-700">-</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 bg-slate-50 rounded-lg p-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-slate-100">
                        <i class="fa-solid fa-calendar-days text-slate-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Total Hari Kerja</p>
                        <p class="text-lg font-bold text-slate-700">{{ $totalHari ?? '' }}</p>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
            <script>
                new Chart(document.getElementById('attendanceDonut'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Hadir', 'Cuti'],
                        datasets: [{
                            data: [142, 223],
                            backgroundColor: ['#76001c', '#f97316'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        cutout: '70%',
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(ctx) {
                                        return ctx.label + ': ' + ctx.parsed + ' hari';
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
        </div>

        <!-- List Data ASN -->
        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-sm">
            <div class="bg-slate-50 py-3 px-4 flex justify-between items-center border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-table text-slate-500"></i>
                    <span class="font-bold text-xs uppercase tracking-wide text-slate-600">List Data ASN</span>
                </div>
                <div class="flex items-center gap-2">
                    <button
                        class="inline-flex items-center gap-1.5 text-xs font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-lg transition-colors">
                        <i class="fa-solid fa-download"></i> Download Rekapan
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-600 bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th scope="col" class="p-4">
                                <input id="table-checkbox-all" type="checkbox"
                                    class="w-4 h-4 border border-slate-300 rounded bg-slate-100 focus:ring-2 focus:ring-green-300">
                            </th>
                            <th scope="col" class="px-4 py-3 font-semibold text-left">Tanggal</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Jam Masuk</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Jam Istirahat</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Jam Pulang</th>
                            <th scope="col" class=" px-4 py-3 font-semibold text-center">Lokasi Kerja</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Kode Masuk</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Kode Istirahat</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Kode Pulang</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Kode Status</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($data['presensi'] as $hadir) --}}
                        @foreach ([] as $hadir)
                            <tr class="bg-white border-b border-slate-100 hover:bg-slate-50">
                                <td class="p-4"><input type="checkbox"
                                        class="w-4 h-4 border border-slate-300 rounded bg-slate-100 focus:ring-2 focus:ring-green-300">
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($hadir['tgl'] ?? '')->locale('id')->translatedFormat('l, d F Y') }}
                                </td>
                                <td class="px-4 py-3 text-center {{ $hadir['change_applied'] ? 'text-amber-600 font-medium' : '' }}">
                                    {{ $hadir['jam_pagi'] == null ? '-' : $hadir['jam_pagi'] . ' WITA' }}
                                    {{-- {{ $hadir['jam_pagi'] ?? '-' }} --}}
                                </td>
                                <td class="px-4 py-3 text-center {{ $hadir['change_applied'] ? 'text-amber-600 font-medium' : '' }}">
                                    {{ $hadir['jam_siang'] == null ? '-' : $hadir['jam_siang'] . ' WITA' }}
                                </td>
                                <td class="px-4 py-3 text-center {{ $hadir['change_applied'] ? 'text-amber-600 font-medium' : '' }}">
                                    {{ $hadir['jam_sore'] == null ? '-' : $hadir['jam_sore'] . ' WITA' }}
                                </td>

                                @if (in_array('WFH', [$hadir['pagi'] ?? '', $hadir['siang'] ?? '', $hadir['sore'] ?? '']))
                                    <td class="px-4 py-3 text-center text-green-500 font-bold">WFH</td>
                                @elseif(in_array('WFO', [$hadir['pagi'] ?? '', $hadir['siang'] ?? '', $hadir['sore'] ?? '']))
                                    <td class="px-4 py-3 text-center text-blue-500 font-bold">WFO</td>
                                @else
                                    <td class="px-4 py-3 text-center">-</td>
                                @endif

                                <td class="px-4 py-3 text-center {{ $hadir['change_applied'] ? 'text-amber-600 font-medium' : '' }}">{{ $hadir['pagi'] }}</td>
                                <td class="px-4 py-3 text-center {{ $hadir['change_applied'] ? 'text-amber-600 font-medium' : '' }}">{{ $hadir['siang'] }}</td>
                                <td class="px-4 py-3 text-center {{ $hadir['change_applied'] ? 'text-amber-600 font-medium' : '' }}">{{ $hadir['sore'] }}</td>

                                @if ($hadir['keterangan'] == 'DL')
                                    <td class="px-4 py-3 text-center {{ $hadir['change_applied'] ? 'text-amber-600 font-medium' : '' }}">
                                        <a href="{{ url('/pic/dinas-luar/' . $asn['nip'] . '/' . $bulan . '') }}"
                                            class="bg-green-500 text-white hover:bg-amber-500 font-bold cursor-pointer px-2 rounded-2xl">
                                            {{ $hadir['keterangan'] }}
                                        </a>
                                    </td>
                                @else
                                    <td class="px-4 py-3 text-center {{ $hadir['change_applied'] ? 'text-amber-600 font-medium' : '' }}">{{ $hadir['keterangan'] }}</td>
                                @endif

                                <td class="px-4 py-3 text-center">
                                    <button type="button"
                                        class="font-medium text-orange-500 hover:underline edit-btn"
                                        data-id="{{ $hadir['id'] }}"
                                        data-status-change="{{ $hadir['change']['status_change'] }}"
                                        data-pagi="{{ $hadir['change']['checkIn_status_change'] }}"
                                        data-pagi-jam="{{ $hadir['change']['checkIn_time_with_timezone_change'] }}"
                                        data-siang="{{ $hadir['change']['checkRest_status_change'] }}"
                                        data-siang-jam="{{ $hadir['change']['checkRest_time_with_timezone_change'] }}"
                                        data-sore="{{ $hadir['change']['checkOut_status_change'] }}"
                                        data-sore-jam="{{ $hadir['change']['checkOut_time_with_timezone_change'] }}"
                                        onclick="openEditModal(this)">Edit</button>
                                </td>
                            </tr>
                        @endforeach

                        {{-- <tr class="bg-white border-b border-slate-100 hover:bg-slate-50">
                            <td class="p-4"><input type="checkbox"
                                    class="w-4 h-4 border border-slate-300 rounded bg-slate-100 focus:ring-2 focus:ring-green-300">
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">Selasa, 14 Juli 2026</td>
                            <td class="px-4 py-3 text-center">07:18 WITA</td>
                            <td class="px-4 py-3 text-center">12:45 WITA</td>
                            <td class="px-4 py-3 text-center">16:10 WITA</td>
                            <td class="px-4 py-3 text-center">WFO</td>
                            <td class="px-4 py-3 text-center">Hadir</td>
                            <td class="px-4 py-3 text-center">HN</td>
                            <td class="px-4 py-3 text-center"><button type="button"
                                    class="font-medium text-orange-500 hover:underline">Edit</button></td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
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

    <!-- Modal Edit Presensi -->
    <div id="editModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
            <h3 class="text-lg font-bold mb-4">Edit Presensi</h3>
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_id">

                <!-- Status Harian -->
                <div class="mb-3">
                    <label class="text-xs font-semibold text-slate-600">Status Harian (Change)</label>
                    <select name="status_change" id="edit_status"
                        class="w-full border border-slate-300 rounded px-3 py-1.5 text-sm mt-1">
                        <option value="">— Kosongkan (Reset) —</option>
                        <option value="H">H</option>
                        <option value="HN">HN</option>
                        <option value="DL">DL</option>
                        <option value="TB">TB</option>
                        <option value="CT">CT</option>
                        <option value="CM">CM</option>
                        <option value="CB">CB</option>
                        <option value="CS">CS</option>
                        <option value="CAP">CAP</option>
                        <option value="CTLN">CTLN</option>
                        <option value="CH">CH</option>
                        <option value="TK">TK</option>
                        <option value="TAS">TAS</option>
                        <option value="TL1">TL1</option>
                        <option value="TL2">TL2</option>
                        <option value="TL3">TL3</option>
                        <option value="TL4">TL4</option>
                        <option value="PSW1">PSW1</option>
                        <option value="PSW2">PSW2</option>
                        <option value="PSW3">PSW3</option>
                        <option value="PSW4">PSW4</option>
                        <option value="TAK">TAK</option>
                        <option value="TM1-SN">TM1-SN</option>
                        <option value="TM2-SN">TM2-SN</option>
                        <option value="TM3-SN">TM3-SN</option>
                        <option value="TMM-SN">TMM-SN</option>
                        <option value="PN-PC1">PN-PC1</option>
                        <option value="PN-PC2">PN-PC2</option>
                        <option value="PN-PC3">PN-PC3</option>
                        <option value="PN-PCM">PN-PCM</option>
                    </select>
                </div>

                <!-- CheckIn -->
                <div class="mb-3">
                    <label class="text-xs font-semibold text-slate-600">Status Masuk (Change)</label>
                    <select name="checkIn_status_change" id="edit_pagi"
                        class="w-full border border-slate-300 rounded px-3 py-1.5 text-sm mt-1">
                        <option value="">— Kosongkan (Reset) —</option>
                        <option value="PN">PN</option>
                        <option value="TM1">TM1</option>
                        <option value="TM2">TM2</option>
                        <option value="TM3">TM3</option>
                        <option value="TMM">TMM</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="text-xs font-semibold text-slate-600">Jam Masuk (Change)</label>
                    <input type="time" name="checkIn_time_with_timezone_change" id="edit_pagi_jam"
                        class="w-full border border-slate-300 rounded px-3 py-1.5 text-sm mt-1">
                </div>

                <!-- CheckRest -->
                <div class="mb-3">
                    <label class="text-xs font-semibold text-slate-600">Status Istirahat (Change)</label>
                    <select name="checkRest_status_change" id="edit_siang"
                        class="w-full border border-slate-300 rounded px-3 py-1.5 text-sm mt-1">
                        <option value="">— Kosongkan (Reset) —</option>
                        <option value="SIN">SIN</option>
                        <option value="TAS">TAS</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="text-xs font-semibold text-slate-600">Jam Istirahat (Change)</label>
                    <input type="time" name="checkRest_time_with_timezone_change" id="edit_siang_jam"
                        class="w-full border border-slate-300 rounded px-3 py-1.5 text-sm mt-1">
                </div>

                <!-- CheckOut -->
                <div class="mb-3">
                    <label class="text-xs font-semibold text-slate-600">Status Pulang (Change)</label>
                    <select name="checkOut_status_change" id="edit_sore"
                        class="w-full border border-slate-300 rounded px-3 py-1.5 text-sm mt-1">
                        <option value="">— Kosongkan (Reset) —</option>
                        <option value="SN">SN</option>
                        <option value="PC1">PC1</option>
                        <option value="PC2">PC2</option>
                        <option value="PC3">PC3</option>
                        <option value="PCM">PCM</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="text-xs font-semibold text-slate-600">Jam Pulang (Change)</label>
                    <input type="time" name="checkOut_time_with_timezone_change" id="edit_sore_jam"
                        class="w-full border border-slate-300 rounded px-3 py-1.5 text-sm mt-1">
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-green-700">Simpan</button>
                    <button type="button" onclick="closeEditModal()"
                        class="bg-slate-200 text-slate-700 px-4 py-2 rounded text-sm font-medium hover:bg-slate-300">Batal</button>
                    <button type="button" onclick="resetChange()"
                        class="bg-red-100 text-red-600 px-4 py-2 rounded text-sm font-medium hover:bg-red-200 ml-auto">Reset ke Asli</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(btn) {
            const id = btn.dataset.id;
            document.getElementById('edit_id').value = id;
            document.getElementById('editForm').action = '/pic/detail/' + id;
            document.getElementById('edit_status').value = btn.dataset.statusChange || '';
            document.getElementById('edit_pagi').value = btn.dataset.pagi || '';
            document.getElementById('edit_siang').value = btn.dataset.siang || '';
            document.getElementById('edit_sore').value = btn.dataset.sore || '';
            document.getElementById('edit_pagi_jam').value = toTimeInput(btn.dataset.pagiJam);
            document.getElementById('edit_siang_jam').value = toTimeInput(btn.dataset.siangJam);
            document.getElementById('edit_sore_jam').value = toTimeInput(btn.dataset.soreJam);
            document.getElementById('editModal').classList.remove('hidden');
        }

        function toTimeInput(val) {
            if (!val) return '';
            return val.length >= 5 ? val.substring(0, 5) : val;
        }

        document.getElementById('editForm').addEventListener('submit', function() {
            ['edit_pagi_jam', 'edit_siang_jam', 'edit_sore_jam'].forEach(id => {
                const el = document.getElementById(id);
                if (el.value && el.value.length === 5) {
                    el.value = el.value + ':00';
                }
            });
        });

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function resetChange() {
            ['edit_status', 'edit_pagi', 'edit_pagi_jam', 'edit_siang', 'edit_siang_jam', 'edit_sore', 'edit_sore_jam'].forEach(id => {
                document.getElementById(id).value = '';
            });
            document.getElementById('editForm').submit();
        }
    </script>
</x-layout>
