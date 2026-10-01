<x-layout>
    <x-slot:title>Hari Kegiatan</x-slot>
        <div>
            <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>Hari Kegiatan</span>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>Import Kegiatan</span>
                    <div>
                        <i class="fa-solid fa-rotate mr-2.5"></i>
                        <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
                    </div>
                </div>
                <div class="min-h-[100px] flex items-center justify-center text-slate-500 bg-white">
                    <form action="{{ url('/admin/hari-kegiatan') }}" method="POST"
                        class="w-4xl bg-white rounded-2xl shadow-lg border border-gray-100 p-6 m-6">
                        @csrf
                        {{-- Form Horizontal --}}
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            {{-- Tanggal --}}
                            <div class="md:col-span-3">
                                <label for="tglKegiatan"
                                    class="block mb-2 text-sm font-medium text-gray-700">
                                    Tanggal Kegiatan
                                </label>
                                <input
                                    type="date"
                                    name="tglKegiatan"
                                    id="tglKegiatan"
                                    value="{{ old('tglKegiatan') }}"
                                    required
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3
                                        text-sm text-gray-900
                                        focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                                        outline-none transition"
                                >
                                @error('tglKegiatan')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            {{-- Nama Kegiatan --}}
                            <div class="md:col-span-6">
                                <label for="asnYgIkutKegiatan"
                                    class="block mb-2 text-sm font-medium text-gray-700">
                                    Import Data ASN
                                </label>
                                <input
                                    type="file"
                                    name="asnYgIkutKegiatan"
                                    id="asnYgIkutKegiatan"
                                    value="{{ old('asnYgIkutKegiatan') }}"
                                    placeholder="Contoh: Rapat Koordinasi"
                                    required
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3
                                        text-sm text-gray-900 placeholder-gray-400
                                        focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                                        outline-none transition"
                                >
                                @error('asnYgIkutKegiatan')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            {{-- Tombol --}}
                            <div class="md:col-span-3 flex gap-2">
                                <button
                                    type="reset"
                                    class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-3
                                        text-sm font-medium text-gray-700
                                        hover:bg-gray-100 transition">
                                    Reset
                                </button>
                                <button
                                    type="submit"
                                    class="flex-1 rounded-lg bg-blue-600 px-4 py-3
                                        text-sm font-medium text-white
                                        hover:bg-blue-700
                                        focus:outline-none focus:ring-4 focus:ring-blue-300
                                        transition">
                                    Simpan
                                </button>

                            </div>

                        </div>

                    </form>
                </div>

            </div>

            <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>List Pegawai Yang telah mengikuti Hari Kegiatan</span>
                    <form action="{{ url('/admin/asn-kegiatan') }}" method="get">
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
                <div class="min-h-[100px] flex items-center justify-center text-slate-500 bg-white">
                    {{-- [ Kategori Grafik Kunjungan Mingguan ] --}}
                    {{-- @dd($data) --}}
                    <table>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $asn)
                                <tr>
                                    <td>{{ $asn->nama }}</td>
                                    <td>{{ $asn->nip }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
</x-layout>