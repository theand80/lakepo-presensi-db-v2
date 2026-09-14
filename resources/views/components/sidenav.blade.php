<!-- Mobile Overlay -->
<div id="sidenav-overlay" onclick="toggleSidenav()" class="fixed inset-0 z-40 bg-black/50 hidden md:hidden"></div>

<!-- Sidebar -->
<div id="sidenav"
    class="sidenav-desktop z-50 h-[calc(100vh-50px)] w-[280px] bg-[#f4f7f6] overflow-y-auto transform -translate-x-full md:translate-x-0 transition-transform duration-300">
    <div class="p-4">
        <div class="bg-white border border-slate-200 rounded-t-md p-5 flex justify-center">
            <div class="relative w-full h-[90px] mb-2.5 flex justify-between items-center text-center">
                <div class="text-[11px] text-slate-500"><b class="text-[#333]">Kota Bima</b><br><span
                        style="font-size:9px;">2026</span></div>
                <div
                    class="w-[70px] h-[70px] rounded-full border-[2px] border-gray-300 hover:border-green-700 flex justify-center items-center">
                    <img src="{{ asset('KotaBima.png') }}" alt="Avatar" class="w-7 h-10 object-cover">
                </div>
                <div class="text-[11px] text-slate-500">14/07/2026<br><span class="text-[9px]">Senin</span></div>
            </div>
        </div>

        <ul class="list-none bg-white border border-slate-200 border-t-0 rounded-b-md mb-5">


            <li><a href="{{ url('/dashboard') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-envelope mr-2.5 w-4"></i> Dashboard</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            {{-- <li><a href="{{ route('listKantor') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-envelope mr-2.5 w-4"></i> API List Kantor</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li> --}}
            {{-- <li><a href="{{ route('rekapBulananByKantor') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-envelope mr-2.5 w-4"></i> API RekapBulananByKantor</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li> --}}
            <hr>


            <li><a href="{{ url('/admin') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-chart-simple mr-2.5 w-4"></i>Admin Dashboard</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            <li><a href="{{ url('/import-excel-data-asn') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-envelope mr-2.5 w-4"></i> Import Excel</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            {{-- <li><a href="{{ url('/simpan-list-kantor') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-envelope mr-2.5 w-4"></i> Import List Kantor</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li> --}}
            <li><a href="{{ url('/import-api') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-envelope mr-2.5 w-4"></i> Import API Simpegnas</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            <li><a href="{{ url('/admin/hariLibur') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-envelope mr-2.5 w-4"></i> Hari Libur</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            <li><a href="{{ url('/users') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-envelope mr-2.5 w-4"></i> List User</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            <li><a href="{{ url('/user/edit') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-envelope mr-2.5 w-4"></i> User Edit (Hidden)</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>

            <hr>

            <li><a href="{{ url('/pic/dashboard') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-sliders mr-2.5 w-4"></i> Dashboard PIC BKPSDM</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            <li><a href="{{ url('/pic') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-sliders mr-2.5 w-4"></i> PIC BKPSDM</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            {{-- <li><a href="{{ route('pic.bpk') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-sliders mr-2.5 w-4"></i> BPK</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li> --}}
            <li><a href="{{ url('/pic/detail') }}"
                    class="hidden flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-sliders mr-2.5 w-4"></i> Detail ASN (hidden)</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            <li><a href="{{ url('/pic/terbaikDanTerendah') }}"
                    class="hidden flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-sliders mr-2.5 w-4"></i>Terbaik & Terendah (hidden)</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            <hr>




            <li><a href="{{ url('/operator/dashboard') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-sliders mr-2.5 w-4"></i> Dashboard Operator</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            <li><a href="{{ url('/operator') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-sliders mr-2.5 w-4"></i> Operator OPD</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            <li><a href="{{ url('/operator/detail') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-sliders mr-2.5 w-4"></i> Detail ASN (hidden)</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            <li><a href="{{ url('/operator/terbaikDanTerendah') }}"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-sliders mr-2.5 w-4"></i>Terbaik & Terendah (hidden)</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
            <hr>


            <li><a href="#"
                    class="flex justify-between items-center py-3 px-4 text-slate-600 no-underline border-b border-slate-100 transition-colors hover:bg-slate-50 hover:text-green-700">
                    <div><i class="fa-solid fa-power-off mr-2.5 w-4"></i> Logout</div> <i
                        class="fa-solid fa-chevron-right text-[10px]"></i>
                </a></li>
        </ul>

        <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
            <div
                class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                <span>Kehadiran Hari Ini</span>
                <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
            </div>
            <div class="p-4">
                <div class="text-[11px] text-slate-500 mb-2">presentase kehadiran kantor</div>
                <div class="flex justify-between text-xs mb-1 text-slate-700"><span>Tidak Hadir</span> <span>89%</span>
                </div>
                <div class="bg-slate-100 h-2 rounded overflow-hidden mb-4">
                    <div class="h-full bg-red-500" style="width: 89%;"></div>
                </div>
                <div class="flex justify-between text-xs mb-1 text-slate-700"><span>Hadir</span> <span>56%</span></div>
                <div class="bg-slate-100 h-2 rounded overflow-hidden">
                    <div class="h-full bg-amber-500" style="width: 56%;"></div>
                </div>
            </div>
        </div>

    </div>
</div>