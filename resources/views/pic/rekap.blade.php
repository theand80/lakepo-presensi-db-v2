<x-layout>
    <x-slot:title>Operator Nama Kanto</x-slot>
        {{-- @if (count($data) > 0)
        @dd($data)
        @endif --}}
        {{-- @dd($data) --}}

        <div>
            <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>Operator Nama Kantor</span>
                    <form action="{{ url('/pic') }}" method="get">
                        <div class="flex items-center gap-3 normal-case font-normal">
                            <div class="flex items-center gap-2">
                                <label for="filterKantor" class="text-xs font-medium text-slate-600">Kantor:</label>
                                <select id="filterKantor" name="filterNamaKantor"
                                    class="text-xs border border-slate-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-green-300 focus:border-green-500 outline-none bg-white">
                                    <option value="">Semua Kantor</option>
                                    <option value="BKPSDM">BKPSDM</option>
                                    <option value="Dinas Pemberdayaan Perempuan dan Perlindungan Anak">Dinas
                                        Pemberdayaan Perempuan dan Perlindungan Anak</option>
                                    {{-- @foreach ($listKantor as $kantor)
                                        <option value="{{ $kantor }}" {{ ($selectedKantor ?? '') == $kantor ? 'selected' : '' }}>
                                            {{ $kantor }}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="flex items-center gap-2">
                                <label for="filterBulan" class="text-xs font-medium text-slate-600">Periode:</label>
                                <input type="month" id="filterBulan" value="2026-07" name="month" 
                                {{-- <input type="month" id="filterBulan" value="{{ $selectedMonth }}" name="month" --}}
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

            <!-- Ringkasan Kehadiran -->
            <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>Ringkasan Kehadiran</span>
                </div>
                <div class="flex flex-col md:flex-row items-stretch">
                    <div class="flex items-center justify-center p-5">
                        <div class="relative w-[200px] h-[200px]">
                            <canvas id="attendanceDonut"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center -mt-16">
                                {{-- <span class="text-2xl font-bold text-slate-800">
                                    {{ count($summary) > 0 && ($summary['totalASN'] ?? 0) > 0 ?
                                    round(($summary['totalHadir'] / ($summary['totalASN'] * 30)) * 100) : 0 }}%
                                </span> --}}
                                <span
                                    {{-- class="text-2xl font-bold text-slate-800">{{ $summary['rataRata'] ?? '0' }}%</span> --}}
                                    class="text-2xl font-bold text-slate-800">12%</span>
                                <span class="text-xs text-slate-500">Rata-rata</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 grid grid-cols-2 sm:grid-cols-4 gap-4 p-5 content-center">
                        <div class="flex items-center gap-3 bg-green-50 rounded-lg p-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100">
                                <i class="fa-solid fa-users text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Total ASN</p>
                                <p class="text-lg font-bold text-green-700">32</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-blue-50 rounded-lg p-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100">
                                <i class="fa-solid fa-check text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Hadir (H+HN)</p>
                                <p class="text-lg font-bold text-blue-700">12</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-orange-50 rounded-lg p-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-orange-100">
                                <i class="fa-solid fa-plane-departure text-orange-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Cuti (CT)</p>
                                <p class="text-lg font-bold text-orange-700">3</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-red-50 rounded-lg p-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-red-100">
                                <i class="fa-solid fa-xmark text-red-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Tidak Hadir</p>
                                <p class="text-lg font-bold text-red-700">23</p>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
                <script>
                    new Chart(document.getElementById('attendanceDonut'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Hadir (H)', 'Cuti (CT)', 'Tidak Hadir (TK)'],
                            datasets: [{
                                data: [
                                    12,
                                    12,
                                    76,
                                ],
                                backgroundColor: ['#16a34a', '#f97316', '#94a3b8'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            cutout: '70%',
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'bottom'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (ctx) {
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
                        <a href=""
                            class="inline-flex items-center gap-1.5 text-xs font-medium text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-lg transition-colors">
                            <i class="fa-solid fa-download"></i> Download Rekapan
                        </a>
                    </div>
                </div>
                <div class="overflow-auto max-h-[600px]">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-600 bg-slate-50 border-b border-slate-200 sticky top-0 z-10">
                            <tr class="bg-slate-50">
                                <th scope="col" class="p-4">
                                    <input id="table-checkbox-all" type="checkbox"
                                        class="w-4 h-4 border border-slate-300 rounded bg-slate-100 focus:ring-2 focus:ring-green-300">
                                </th>
                                <th scope="col" class="px-4 py-3 font-semibold">NIP</th>
                                <th scope="col" class="px-4 py-3 font-semibold min-w-[180px] max-w-[200px]">Nama</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Pangkat/Golongan</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Jabatan</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Status</th>
                                <th scope="col" class="px-4 py-3 font-semibold">H</th>
                                <th scope="col" class="px-4 py-3 font-semibold">HN</th>
                                <th scope="col" class="px-4 py-3 font-semibold">DL</th>
                                <th scope="col" class="px-4 py-3 font-semibold">TB</th>
                                <th scope="col" class="px-4 py-3 font-semibold">CT</th>
                                <th scope="col" class="px-4 py-3 font-semibold">CM</th>
                                <th scope="col" class="px-4 py-3 font-semibold">CB</th>
                                <th scope="col" class="px-4 py-3 font-semibold">CS</th>
                                <th scope="col" class="px-4 py-3 font-semibold">CAP</th>
                                <th scope="col" class="px-4 py-3 font-semibold">CTLN</th>
                                <th scope="col" class="px-4 py-3 font-semibold">CH</th>
                                <th scope="col" class="px-4 py-3 font-semibold">TK</th>
                                <th scope="col" class="px-4 py-3 font-semibold">TAS</th>
                                <th scope="col" class="px-4 py-3 font-semibold">TL1</th>
                                <th scope="col" class="px-4 py-3 font-semibold">TL2</th>
                                <th scope="col" class="px-4 py-3 font-semibold">TL3</th>
                                <th scope="col" class="px-4 py-3 font-semibold">TL4</th>
                                <th scope="col" class="px-4 py-3 font-semibold">PSW1</th>
                                <th scope="col" class="px-4 py-3 font-semibold">PSW2</th>
                                <th scope="col" class="px-4 py-3 font-semibold">PSW3</th>
                                <th scope="col" class="px-4 py-3 font-semibold">PSW4</th>
                                <th scope="col" class="px-4 py-3 font-semibold">TAK</th>
                                <th scope="col"
                                    class="px-4 py-3 font-semibold cursor-pointer hover:bg-slate-100 select-none"
                                    onclick="sortTable(27)">
                                    Persentase Kehadiran<i class="fa-solid fa-sort text-slate-400 ml-1"></i>
                                </th>
                                <th scope="col" class="px-4 py-3 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr class="bg-white border-b border-slate-100 hover:bg-slate-50"
                                    data-persentase="{{ $item['persentase'] ?? 0 }}">
                                    <td class="p-4">
                                        <input type="checkbox"
                                            class="w-4 h-4 border border-slate-300 rounded bg-slate-100 focus:ring-2 focus:ring-green-300">
                                    </td>
                                    <td class="px-4 py-3 font-medium text-slate-800 whitespace-nowrap">{{ $item['nip'] }}
                                    </td>
                                    <td class="px-4 py-3 min-w-[180px] max-w-[200px]">{{ $item['nama'] }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item['pangkat'] == '' ? $item['golongan'] : $item['golongan'] . ' - ' . $item['pangkat'] }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ str($item['jabatan'])->limit(40, '...') }}
                                    </td>

                                    @if ($item['status'] == 'PNS')
                                        <td class="px-4 py-3 text-blue-600 font-bold min-w-[86px] max-w-[90px]">
                                            {{ $item['status'] ?? '-' }}
                                        </td>
                                    @elseif($item['status'] == 'PPPK')
                                        <td class="px-4 py-3 text-green-600 font-bold min-w-[86px] max-w-[90px]">
                                            {{ $item['status'] ?? '-' }}
                                        </td>
                                    @else
                                        <td class="px-4 py-3 text-amber-500 font-bold min-w-[86px] max-w-[90px]">
                                            {{ $item['status'] ?? '-' }}
                                        </td>
                                    @endif

                                    <td class="px-4 py-3 text-center">{{ $item['hadir'] ?? 'N/a'}}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['HN'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['DL'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['TB'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['CT'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['CM'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['CB'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['CS'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['CAP'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['CTLN'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['CH'] }}</td>
                                    <td class="px-4 py-3 text-center text-red-600 font-medium">{{ $item['rekap']['TK'] }}
                                    </td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['TAS'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['TL1'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['TL2'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['TL3'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['TL4'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['PSW1'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['PSW2'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['PSW3'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['PSW4'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item['rekap']['TAK'] }}</td>
                                    <td class="px-4 py-3 font-semibold"> N/a %
                                        {{-- @if ($item['persentase'] < 50)
                                            <span class="text-red-600">{{ $item['persentase'] }}%</span>
                                        @elseif ($item['persentase'] < 75)
                                            <span class="text-amber-600">{{ $item['persentase'] }}%</span>
                                        @else
                                            <span class="text-green-600">{{ $item['persentase'] }}%</span>
                                        @endif --}}
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('lihatRekapBulananByNip-DariDB', ['nip' => $item['nip']]) }}"
                                            class="font-medium text-green-600 hover:underline">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="30" class="px-4 py-8 text-center text-slate-400">
                                        Tidak ada data ditemukan.
                                    </td>
                                </tr>
                            @endforelse

                            <tr>
                                <td colspan="30" class="px-4 py-8 text-center text-slate-400">
                                    Tidak ada data ditemukan.
                                </td>
                            </tr>
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

        <script>
            // let sortDirection = {};
            let sortDirection = {
                27: false
            }; // default: descending (false = desc)

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