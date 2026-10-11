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
                        @foreach ($kantor as $value)
                            <tr>
                                <form action="" method="post">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $value->unor_siasn_induk }}</td>
                                    <td>Plt. Kepala BKPSDM</td>
                                    <td>JoloSusafs </td>
                                    <input type="hidden" name="namaKantor" value="{{ $value->unor_siasn_induk }}">
                                    <input type="hidden" name="sebagai" value="{{ $value->unor_siasn_induk }}">
                                    <td class="text-center"><button type="submit">Ubah</button> </td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
