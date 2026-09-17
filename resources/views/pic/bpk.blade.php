<x-layout>
    <x-slot:title>BPK</x-slot>
        <div>
            <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>BPK</span>
                    <form action="{{ url('/pic/bpk') }}" method="get">
                        <div class="flex items-center gap-3 normal-case font-normal">
                            <div class="flex items-center gap-2">
                                <label for="filterKantor" class="text-xs font-medium text-slate-600">Kantor:</label>
                                <select id="filterKantor" name="filterNamaKantor"
                                    class="text-xs border border-slate-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-green-300 focus:border-green-500 outline-none bg-white">
                                    <option value="">Semua Kantor</option>
                                    @foreach ($listKantor as $kantor)
                                        <option value="{{ $kantor }}" {{ ($selectedKantor ?? '') == $kantor ? 'selected' : '' }}>
                                            {{ $kantor }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center gap-2">
                                <label for="filterBulan" class="text-xs font-medium text-slate-600">Periode:</label>
                                <input type="month" id="filterBulan" value="{{ $selectedMonth }}" name="month"
                                    class="text-xs border border-slate-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-green-300 focus:border-green-500 outline-none">
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="submit"
                                    class="text-xs border border-slate-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-green-300 focus:border-green-500 outline-none bg-green-600 hover:bg-green-700 gap-1.5 font-medium text-white transition-colors">
                                    <i class="fa-brands fa-squarespace"></i>
                                    Lihat</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>Data Kantor</span>
                    <div>
                        <i class="fa-solid fa-rotate mr-2.5"></i>
                        <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
                    </div>
                </div>
                <div class="min-h-[100px] text-slate-500 bg-white">
                    <div class="overflow-auto max-h-[600px]">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-slate-600 bg-slate-50 border-b border-slate-200">
                                <!-- Baris 1: Header Utama -->
                                <tr class="bg-slate-50">
                                    <th rowspan="3" scope="col" class="p-4">
                                        <input id="table-checkbox-all" type="checkbox"
                                            class="w-4 h-4 border border-slate-300 rounded bg-slate-100 focus:ring-2 focus:ring-green-300">
                                    </th>
                                    <th rowspan="3" scope="col" class="px-4 py-3 font-semibold">NIP</th>
                                    <th rowspan="3" scope="col"
                                        class="px-4 py-3 font-semibold min-w-[180px] max-w-[200px]">Nama</th>
                                    <th rowspan="3" scope="col" class="px-4 py-3 font-semibold">Pangkat/Golongan</th>
                                    <th rowspan="3" scope="col" class="px-4 py-3 font-semibold">Jabatan</th>
                                    <th rowspan="3" scope="col" class="px-4 py-3 font-semibold">Status</th>
                                    <th rowspan="3" scope="col"
                                        class="px-4 py-3 font-semibold cursor-pointer hover:bg-slate-100 select-none"
                                        onclick="sortTable(6)">
                                        Persentase Kehadiran<i class="fa-solid fa-sort text-slate-400 ml-1"></i>
                                    </th>

                                    <!-- Colspan dikali 4 karena setiap tanggal dipecah menjadi 4 kolom komponen presensi -->
                                    <th colspan="<?= $jumlah_hari * 3; ?>" style="padding: 6px; text-align:center;">
                                        Tanggal</th>

                                    <th rowspan="3"
                                        style="border: 1px solid #cbd5e1; padding: 6px; vertical-align: middle; text-align: center;">
                                        Aksi</th>
                                </tr>

                                <!-- Baris 2: Angka Kalender Tanggal (1 sampai 30/31) -->

                                <tr class="bg-slate-100">
                                    <?php for ($hari = 1; $hari <= $jumlah_hari; $hari++): ?>
                                    <th colspan="3"
                                        class="px-4 py-3 font-semibold text-center border border-r-2 border-gray-200">
                                        {{-- style="border: 1px solid green; padding: 4px; text-align:center;
                                        font-weight: bold; font-size: 13px; background-color: #cbd5e1;"> --}}
                                        <?= $hari; ?>
                                    </th>
                                    <?php endfor; ?>
                                </tr>

                                <!-- Baris 3: Komponen Presensi Per Tanggal -->
                                <tr class="bg-slate-50 text-[9px]">
                                    <?php for ($hari = 1; $hari <= $jumlah_hari; $hari++): ?>
                                    <th class="border border-gray-200 p-2 text-center text-[#1e3a8a]" title="Check In">
                                        Status API</th>
                                    <th class="border border-gray-200 p-2 text-center text-[#b45309]"
                                        title="Check Rest">Status Edited DB</th>
                                    <th class="border border-gray-200 border-r-2 p-2 text-center text-green-600"
                                        title="Check Rest">Status Booth</th>
                                    <?php endfor; ?>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($data as $nip => $records)
                                    @php
                                        $asn = $asnMap[$nip] ?? null;
                                        $totalDays = $records->count();
                                        $hadirCount = $records->filter(fn($r) => in_array($r->status_change ?: $r->status, ['H', 'HN']))->count();
                                        $persen = $totalDays > 0 ? round(($hadirCount / $totalDays) * 100) : 0;
                                    @endphp
                                    <tr class="bg-white border-b border-slate-100 hover:bg-slate-50" data-persentase="{{ $persen }}">
                                        <td class="p-4">
                                            <input type="checkbox"
                                                class="w-4 h-4 border border-slate-300 rounded bg-slate-100 focus:ring-2 focus:ring-green-300">
                                        </td>
                                        <td class="px-4 py-3 font-medium text-slate-800 whitespace-nowrap">{{ $nip }}</td>
                                        <td class="px-4 py-3 min-w-[180px] max-w-[200px]">{{ $records->first()->nama }}</td>
                                        <td class="px-4 py-3">
                                            {{ $asn ? (($asn->golongan ?? '') . ' - ' . ($asn->pangkat ?? '')) : '-' }}
                                        </td>
                                        <td class="px-4 py-3">{{ str($asn->jabatan ?? '-')->limit(40, '...') }}</td>
                                        <td class="px-4 py-3">
                                            @if (($asn->status ?? '') == 'PNS')
                                                <span class="text-blue-600 font-bold">{{ $asn->status }}</span>
                                            @elseif(($asn->status ?? '') == 'PPPK')
                                                <span class="text-green-600 font-bold">{{ $asn->status }}</span>
                                            @else
                                                <span class="text-amber-500 font-bold">{{ $asn->status ?? '-' }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 font-semibold">
                                            @if ($persen < 50)
                                                <span class="text-red-600">{{ $persen }}%</span>
                                            @elseif ($persen < 75)
                                                <span class="text-amber-600">{{ $persen }}%</span>
                                            @else
                                                <span class="text-green-600">{{ $persen }}%</span>
                                            @endif
                                        </td>


                                        @for($hari = 1; $hari <= $jumlah_hari; $hari++)
                                            @php
                                                $tanggal = date("Y-m-", strtotime($startDate)) . sprintf("%02d", $hari);
                                                $record = $records->firstWhere('date', $tanggal);
                                            @endphp
                                            {{-- Status API --}}
                                            <td class="border border-gray-200 p-2 text-center text-xs text-[#1e3a8a]">
                                                {{ $record->status ?? '-' }}
                                            </td>
                                            {{-- Status Edited DB --}}
                                            <td class="border border-gray-200 p-2 text-center text-xs text-[#b45309]">
                                                {{ $record->status_change ?? '-' }}
                                            </td>
                                            {{-- Status Booth: status_change jika ada, else status --}}
                                            <td
                                                class="border border-gray-200 border-r-2 p-2 text-center text-xs text-green-600">
                                                {{ $record->status_change ?? $record->status ?? '-' }}
                                            </td>
                                        @endfor

                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ url('/pic/detail/' . $nip . '/' . $selectedMonth . '/' . $persen) }}"
                                                class="font-medium text-green-600 hover:underline">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-8 text-center text-slate-400">Tidak ada data
                                            ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let sortDirection = { 6: false };

            function sortTable(colIndex) {
                const table = document.querySelector('table');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));

                sortDirection[colIndex] = !sortDirection[colIndex];
                const ascending = sortDirection[colIndex];

                rows.sort((a, b) => {
                    const aVal = parseFloat(a.getAttribute('data-persentase')) || 0;
                    const bVal = parseFloat(b.getAttribute('data-persentase')) || 0;
                    return ascending ? aVal - bVal : bVal - aVal;
                });

                rows.forEach(row => tbody.appendChild(row));
            }
        </script>
</x-layout>