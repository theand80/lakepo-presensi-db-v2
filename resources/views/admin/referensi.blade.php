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
                <div class="min-h-[100px] flex bg-white py-8">

                    <div class="basis-1/3 text-center bg-green-200">
                        <h1 class="bg-green-400 py-4 font-bold">Tabel Keterangan Kehadiran</h1>
                        <div class="flex justify-evenly mb-4 mt-2">
                            <div>
                                <div>PM</div>
                                <div>TL1</div>
                                <div>TL2</div>
                                <div>TL3</div>
                                <div>TL4</div>
                            </div>
                            <div>
                                <div>PP</div>
                                <div>PSW1</div>
                                <div>PSW2</div>
                                <div>PSW3</div>
                                <div>PSW4</div>
                            </div>
                        </div>
                    </div>

                    <div class="basis-2/3 text-center bg-blue-200">
                        <h1 class="bg-blue-400 py-4 font-bold">Tabel Keterangan Hari</h1>
                        <div class="flex mb-4 mt-2 pl-[25%]">
                            <div class="text-left">
                                <div>Tahun</div>
                                <div>Bulan</div>
                                <div>Total Hari Kerja Efektif</div>
                                <div>Jumlah Hari Minggu dan Sabtu</div>
                                <div>Jumlah Libur Nasional yang Jatuh Pada Hari Kerja</div>
                            </div>
                            <div class="font-bold ml-4">
                                <div>2026</div>
                                <div>8</div>
                                <div>19</div>
                                <div>10</div>
                                <div>2</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
</x-layout>