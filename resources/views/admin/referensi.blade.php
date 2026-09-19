<x-layout>
    <x-slot:title>Admin</x-slot>
    <div>
        <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
            <div
                class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                <span>Admin</span>
            </div>
        </div>

        <x-menu></x-menu>

        <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
            <div
                class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                <span>Referensi</span>
                <div>
                    <i class="fa-solid fa-rotate mr-2.5"></i>
                    <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
                </div>
            </div>
            <div class="min-h-[100px] flex justify-center gap-8 bg-white py-8">
                @if ($data->isEmpty())
                    [- Data Kosong -]
                @else
                    {{-- masuk --}}
                    <div
                        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg shadow-slate-200/50">
                        <div class="border-b border-slate-200 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                            <h3 class="text-base font-bold text-white">
                                Kode Masuk
                            </h3>
                            <p class="mt-1 text-xs text-blue-100">
                                Ketentuan berdasarkan jam masuk
                            </p>
                        </div>

                        <table class="w-full">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Kode
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Jam Masuk
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-3">
                                        <span
                                            class="rounded-md bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">
                                            PM
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-sm font-medium text-slate-700">
                                        &lt; {{ $data[0]['waktu'] }}
                                    </td>
                                </tr>

                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-3">
                                        <span
                                            class="rounded-md bg-amber-100 px-2.5 py-1 text-xs font-bold text-amber-700">
                                            {{ $data[0]['kode'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-sm font-medium text-slate-700">
                                        &gt; {{ $data[0]['waktu'] }}
                                    </td>
                                </tr>

                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-3">
                                        <span
                                            class="rounded-md bg-orange-100 px-2.5 py-1 text-xs font-bold text-orange-700">
                                            {{ $data[1]['kode'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-sm font-medium text-slate-700">
                                        &gt; {{ $data[1]['waktu'] }}
                                    </td>
                                </tr>

                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-3">
                                        <span class="rounded-md bg-red-100 px-2.5 py-1 text-xs font-bold text-red-700">
                                            {{ $data[2]['kode'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-sm font-medium text-slate-700">
                                        &gt; {{ $data[2]['waktu'] }}
                                    </td>
                                </tr>

                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-3">
                                        <span
                                            class="rounded-md bg-rose-200 px-2.5 py-1 text-xs font-bold text-rose-800">
                                            {{ $data[3]['kode'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-sm font-medium text-slate-700">
                                        &gt; {{ $data[3]['waktu'] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Pulang --}}
                    <div
                        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg shadow-slate-200/50">
                        <div class="border-b border-slate-200 bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                            <h3 class="text-base font-bold text-white">
                                Kode Pulang
                            </h3>
                            <p class="mt-1 text-xs text-blue-100">
                                Ketentuan berdasarkan jam pulang
                            </p>
                        </div>

                        <table class="w-full">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Kode
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Jam Pulang
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-3">
                                        <span
                                            class="rounded-md bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">
                                            PP
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-sm font-medium text-slate-700">
                                        &gt; {{ $data[4]['waktu'] }}
                                    </td>
                                </tr>

                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-3">
                                        <span
                                            class="rounded-md bg-amber-100 px-2.5 py-1 text-xs font-bold text-amber-700">
                                            {{ $data[4]['kode'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-sm font-medium text-slate-700">
                                        &lt; {{ $data[4]['waktu'] }}
                                    </td>
                                </tr>

                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-3">
                                        <span
                                            class="rounded-md bg-orange-100 px-2.5 py-1 text-xs font-bold text-orange-700">
                                            {{ $data[4]['kode'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-sm font-medium text-slate-700">
                                        &lt; {{ $data[4]['waktu'] }}
                                    </td>
                                </tr>

                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-3">
                                        <span class="rounded-md bg-red-100 px-2.5 py-1 text-xs font-bold text-red-700">
                                            {{ $data[6]['kode'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-sm font-medium text-slate-700">
                                        &lt; {{ $data[6]['waktu'] }}
                                    </td>
                                </tr>

                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-3">
                                        <span
                                            class="rounded-md bg-rose-200 px-2.5 py-1 text-xs font-bold text-rose-800">
                                            {{ $data[7]['kode'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-sm font-medium text-slate-700">
                                        &lt; {{ $data[7]['waktu'] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- hari --}}
                    <div
                        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg shadow-slate-200/50">

                        <!-- Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                            <h1 class="text-base font-bold text-white">
                                Keterangan Hari
                            </h1>
                            <p class="mt-1 text-xs text-blue-100">
                                Ringkasan kalender kerja bulan berjalan
                            </p>
                        </div>

                        <div class="p-5">

                            <!-- Periode -->
                            <div class="mb-4 grid grid-cols-2 gap-3">
                                <div class="rounded-xl bg-slate-50 p-4">
                                    <div class="text-xs font-medium uppercase tracking-wide text-slate-500">
                                        Tahun
                                    </div>
                                    <div class="mt-1 text-xl font-bold text-slate-800">
                                        2026
                                    </div>
                                </div>

                                <div class="rounded-xl bg-slate-50 p-4">
                                    <div class="text-xs font-medium uppercase tracking-wide text-slate-500">
                                        Bulan
                                    </div>
                                    <div class="mt-1 text-xl font-bold text-slate-800">
                                        8
                                    </div>
                                </div>
                            </div>

                            <!-- Statistik -->
                            <div class="space-y-3">

                                <div class="flex items-center justify-between rounded-xl bg-emerald-50 px-4 py-3">
                                    <span class="text-sm font-medium text-emerald-800">
                                        Hari Kerja Efektif
                                    </span>
                                    <span class="text-lg font-bold text-emerald-700">
                                        19
                                    </span>
                                </div>

                                <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">
                                    <span class="text-sm font-medium text-slate-600">
                                        Sabtu & Minggu
                                    </span>
                                    <span class="text-lg font-bold text-slate-700">
                                        10
                                    </span>
                                </div>

                                <div class="flex items-center justify-between rounded-xl bg-red-50 px-4 py-3">
                                    <span class="text-sm font-medium text-red-800">
                                        Libur Nasional
                                    </span>
                                    <span class="text-lg font-bold text-red-700">
                                        2
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </div>

    </div>
</x-layout>
