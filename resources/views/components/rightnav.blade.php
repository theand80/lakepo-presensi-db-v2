<!-- Mobile Overlay -->
<div id="rightnav-overlay" onclick="toggleRightnav()" class="fixed inset-0 z-40 bg-black/50 hidden lg:hidden"></div>

<!-- Right Nav Panel -->
<div id="rightnav"
    class="rightnav-desktop z-40 h-[calc(100vh-50px)] w-[320px] lg:w-[380px] bg-[#f4f7f6] overflow-y-auto transform translate-x-full lg:translate-x-0 transition-transform duration-300">
    <div class="p-4">
        {{-- 10 terbaik --}}
        <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
            <div
                class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                <span>10 Kehadiran Terbaik Bulan ini</span>
                <div>
                    <i class="fa-solid fa-plus mr-2.5"></i>
                    <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
                </div>
            </div>

            <ul class="list-none">
                <li class="flex py-3 px-4 border-b border-slate-100 bg-white items-start">
                    <div class="w-15 text-[11px] text-slate-500 shrink-0 mr-2">93 %</div>
                    <img class="w-9 h-9 rounded-full object-cover mr-3 shrink-0 border border-slate-200"
                        src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=80&auto=format&fit=crop&q=60"
                        alt="User">
                    <div>
                        <h4 class="text-[13px] mb-0.5 text-slate-800">John Doe</h4>
                        <p class="text-[11px] text-slate-600 leading-relaxed">Staff Bidang Informasi</p>
                    </div>
                </li>
                <li class="flex py-3 px-4 border-b border-slate-100 bg-white items-start">
                    <div class="w-15 text-[11px] text-slate-500 shrink-0 mr-2">73 %</div>
                    <img class="w-9 h-9 rounded-full object-cover mr-3 shrink-0 border border-slate-200"
                        src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=80&auto=format&fit=crop&q=60"
                        alt="User">
                    <div>
                        <h4 class="text-[13px] mb-0.5 text-slate-800">Brad Pitt</h4>
                        <p class="text-[11px] text-slate-600 leading-relaxed">Staff Sub Bagian Kepegawaian</p>
                    </div>
                </li>
                <li class="flex py-3 px-4 border-b border-slate-100 bg-white items-start">
                    <div class="w-15 text-[11px] text-slate-500 shrink-0 mr-2">69 %</div>
                    <img class="w-9 h-9 rounded-full object-cover mr-3 shrink-0 border border-slate-200"
                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&auto=format&fit=crop&q=60"
                        alt="User">
                    <div>
                        <h4 class="text-[13px] mb-0.5 text-slate-800">Angelina Jolie</h4>
                        <p class="text-[11px] text-slate-600 leading-relaxed">Staff Bidang Kesejahteraan</p>
                    </div>
                </li>
                <li class="flex py-3 px-4 border-b border-slate-100 bg-white items-start">
                    <div class="w-15 text-[11px] text-slate-500 shrink-0 mr-2">52 %</div>
                    <img class="w-9 h-9 rounded-full object-cover mr-3 shrink-0 border border-slate-200"
                        src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=80&auto=format&fit=crop&q=60"
                        alt="User">
                    <div>
                        <h4 class="text-[13px] mb-0.5 text-slate-800">Keira Knightley</h4>
                        <p class="text-[11px] text-slate-600 leading-relaxed">Kepala Sub Bagian Keuangan</p>
                    </div>
                </li>
            </ul>
            <a href="#"
                class="block w-full py-3 bg-slate-50 text-green-600 no-underline text-xs font-semibold border-t border-slate-200 transition-colors hover:bg-green-50 text-center">Lihat
                Semua List...</a>
        </div>

        {{-- 10 terburuk --}}
        <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
            <div
                class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                <span>10 Kehadiran Terendah Bulan ini</span>
                <div>
                    <i class="fa-solid fa-plus mr-2.5"></i>
                    <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
                </div>
            </div>

            <ul class="list-none">
                <li class="flex py-3 px-4 border-b border-slate-100 bg-white items-start">
                    <div class="w-15 text-[11px] text-red-500 font-bold shrink-0 mr-2">27 %</div>
                    <img class="w-9 h-9 rounded-full object-cover mr-3 shrink-0 border border-slate-200"
                        src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=80&auto=format&fit=crop&q=60"
                        alt="User">
                    <div>
                        <h4 class="text-[13px] mb-0.5 text-slate-800">John Doe</h4>
                        <p class="text-[11px] text-slate-600 leading-relaxed">Kepala Bidang Kepegawaian</p>
                    </div>
                </li>
                <li class="flex py-3 px-4 border-b border-slate-100 bg-white items-start">
                    <div class="w-15 text-[11px] text-red-500 font-bold shrink-0 mr-2">27 %</div>
                    <img class="w-9 h-9 rounded-full object-cover mr-3 shrink-0 border border-slate-200"
                        src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=80&auto=format&fit=crop&q=60"
                        alt="User">
                    <div>
                        <h4 class="text-[13px] mb-0.5 text-slate-800">Brad Pitt</h4>
                        <p class="text-[11px] text-slate-600 leading-relaxed">Staff Bidang Kesejahteraan</p>
                    </div>
                </li>
                <li class="flex py-3 px-4 border-b border-slate-100 bg-white items-start">
                    <div class="w-15 text-[11px] text-red-500 font-bold shrink-0 mr-2">13 %</div>
                    <img class="w-9 h-9 rounded-full object-cover mr-3 shrink-0 border border-slate-200"
                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&auto=format&fit=crop&q=60"
                        alt="User">
                    <div>
                        <h4 class="text-[13px] mb-0.5 text-slate-800">Angelina Jolie</h4>
                        <p class="text-[11px] text-slate-600 leading-relaxed">Kepala Sub Bagian Keuangan</p>
                    </div>
                </li>
                <li class="flex py-3 px-4 border-b border-slate-100 bg-white items-start">
                    <div class="w-15 text-[11px] text-red-500 font-bold shrink-0 mr-2">23 %</div>
                    <img class="w-9 h-9 rounded-full object-cover mr-3 shrink-0 border border-slate-200"
                        src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=80&auto=format&fit=crop&q=60"
                        alt="User">
                    <div>
                        <h4 class="text-[13px] mb-0.5 text-slate-800">Keira Knightley</h4>
                        <p class="text-[11px] text-slate-600 leading-relaxed">Staff Bidang Hukum</p>
                    </div>
                </li>
            </ul>
            <a href="#"
                class="block w-full py-3 bg-slate-50 text-green-600 no-underline text-xs font-semibold border-t border-slate-200 transition-colors hover:bg-green-50 text-center">Lihat
                Semua List...</a>
        </div>
    </div>
</div>
