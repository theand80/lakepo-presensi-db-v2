<div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
    <div
        class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
        <span>Menu</span>
        <div>
            <i class="fa-solid fa-rotate mr-2.5"></i>
            <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
        </div>
    </div>
    <div class="min-h-[100px] flex items-center justify-center text-slate-500 bg-white gap-4">
        <a href="{{ url('/admin/listKantorDariApiIndex') }}" class="bg-red-600 py-2 px-4 text-white">List Kantor Dari
            APi</a>
        <a href="{{ url('/admin/simpanListKantorkeDB') }}"
            class="bg-fuchsia-600 py-2 px-4 text-white">simpanListKantorDariApikeDB</a>
        <a href="{{ url('/admin/listKantorDariDBIndex') }}" class="bg-teal-600 py-2 px-4 text-white">List Kantor Dari
            DB</a>

        <a href="{{ url('/admin/data-asn') }}" class="bg-green-600 py-2 px-4 text-white">Data ASN yg diimport dari
            Excel</a>
        <a href="{{ url('/admin/lihatRekapBulananByKantor') }}" class="bg-gray-600 py-2 px-4 text-white">dd Import Data
            Absen dari API Simpegnas</a>
        <a href="{{ url('/admin/simpanRekapBulananByKantor') }}" class="bg-sky-600 py-2 px-4 text-white">Import Data
            Absen dari API Simpegnas</a>

    </div>


    <div class="min-h-[100px] flex items-center justify-center text-slate-500 bg-white gap-4">

        <a href="#" class="bg-sky-600 py-2 px-4 text-white">Hitung</a>
        <a href="http://" class="bg-red-900 py-2 px-4 text-white">Hari Libur</a>
        <a href="http://" class="bg-yellow-800 py-2 px-4 text-white">Import Kegiatan</a>
        <a href="http://" class="bg-yellow-600 py-2 px-4 text-white">List User</a>

        <a href="{{ url('/admin/lihatRekapBulananByNip') }}" class="bg-teal-600 py-2 px-4 text-white">Rekap Bulanan By
            Nip / Detail</a>

        <a href="{{ url('/admin/referensi') }}" class="bg-red-700 py-2 px-4 text-white">Referensi</a>
        <a href="http://" class="bg-blue-700 py-2 px-4 text-white">Rekapitulasi (chart)</a>
    </div>
</div>

<div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
    <div
        class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
        <span>PIC</span>
        <div>
            <i class="fa-solid fa-rotate mr-2.5"></i>
            <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
        </div>
    </div>
    <div class="min-h-[100px] flex items-center justify-center text-slate-500 bg-white gap-4">
        <a href="{{ url('/pic/dashboard/pic') }}" class="bg-red-900 py-2 px-4 text-white">Rekap</a>
        <a href="{{ url('/pic/detail') }}" class="bg-green-700 py-2 px-4 text-white">Data Absen Individu</a>
        <a href="{{ url('/pic/dashboard/bpk') }}" class="bg-sky-600 py-2 px-4 text-white">BPK</a>
    </div>

</div>
