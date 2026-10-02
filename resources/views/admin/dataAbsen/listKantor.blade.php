<x-layout>

    {{-- @dd($data->all()[0]) --}}
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

    <x-slot:title>List Kantor</x-slot>

    <div>
        <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
            <div
                class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                <span>List Kantor</span>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
            <div
                class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                <span>This Week Visits</span>
                <div>
                    <i class="fa-solid fa-rotate mr-2.5"></i>
                    <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
                </div>
            </div>
            <div class="min-h-[100px] flex items-center justify-center text-slate-500 bg-white">
                {{-- [ Kategori Grafik Kunjungan Mingguan ] --}}
            </div>
            {{--  --}}
            <div class="overflow-auto max-h-[730px]">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-600 bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th rowspan="2" class="p-4">
                                <input id="table-checkbox-all" type="checkbox"
                                    class="w-4 h-4 border border-slate-300 rounded bg-slate-100 focus:ring-2 focus:ring-green-300">
                            </th>
                            <th rowspan="2" class="px-4 py-3 font-semibold text-center">No.</th>
                            <th rowspan="2" class="px-4 py-3 font-semibold">Nama Kantor</th>
                            <th colspan="12" class="px-4 py-3 font-semibold text-center border-b border-gray-200">
                                Bulan</th>
                            <th rowspan="2" class="px-4 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                        <tr>
                            @for ($bulan = 1; $bulan <= 12; $bulan++)
                                @if ($bulan == 1)
                                    <th class="px-4 py-3 font-semibold text-center border-r border-l border-gray-200">
                                        {{ $bulan }}</th>
                                @else
                                    <th class="px-4 py-3 font-semibold text-center border-r border-gray-200">
                                        {{ $bulan }}
                                    </th>
                                @endif
                            @endfor


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $kantor)
                            <tr class="bg-white border-b border-slate-100 hover:bg-slate-50">
                                <td class="p-4">
                                    <input type="checkbox"
                                        class="w-4 h-4 border border-slate-300 rounded bg-slate-100 focus:ring-2 focus:ring-green-300">
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-800 whitespace-nowrap">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 border-r border-gray-200">{{ $kantor['nama_kantor'] }}</td>

                                @for ($bulan = 1; $bulan <= 12; $bulan++)
                                    <td class="px-4 py-3 text-xs text-center border-r border-gray-200">
                                        <form action="{{ url('/admin/simpanRekapBulananByKantor') }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="kantor_id" value="{{ $kantor['id_kantor'] }}">
                                            <input type="hidden" name="kantor_nama" value="{{ $kantor['nama_kantor'] }}">
                                            {{-- <input type="hidden" name="bulan{{ $bulan }}" value="{{ $bulan }}"> --}}
                                            <input type="hidden" name="bulan" value="{{ $bulan }}">

                                            @if ($kantor["bulan_$bulan"] == 0)
                                                <button type="submit"
                                                    class="bg-green-600 text-white px-2 py-1 rounded-2xl cursor-pointer">
                                                    Update
                                                </button>
                                                {{-- @elseif($kantor["bulan_$bulan"] == null)
                                                    <button type="submit"
                                                        class="bg-gray-400 text-white px-2 py-1 rounded-2xl cursor-pointer">
                                                        Update
                                                    </button> --}}
                                            @else
                                                <button type="submit"
                                                    class="bg-gray-400 text-white border-2 border-red-600 px-2 py-1 rounded-2xl cursor-pointer">
                                                    ReUpdate
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{--  --}}
        </div>
    </div>
</x-layout>
