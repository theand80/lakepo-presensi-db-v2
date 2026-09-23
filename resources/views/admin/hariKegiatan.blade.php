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
                    <span>Tambah Hari Kegiatan</span>
                    <div>
                        <i class="fa-solid fa-rotate mr-2.5"></i>
                        <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
                    </div>
                </div>
                <div class="min-h-[100px] flex items-center justify-center text-slate-500 bg-white">
                    <x-hariKegiatan.input/>
                </div>

                <div class="min-h-[100px] flex items-center justify-center text-slate-500 bg-white">
                    <x-hariKegiatan.tabel/>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>List Pegawai Yang telah mengikuti Hari Kegiatan pada Tangga 12-09-2026</span>
                    <div>
                        <i class="fa-solid fa-rotate mr-2.5"></i>
                        <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
                    </div>
                </div>
                <div class="min-h-[100px] flex items-center justify-center text-slate-500 bg-white">
                    {{-- [ Kategori Grafik Kunjungan Mingguan ] --}}
                </div>
            </div>

        </div>
</x-layout>