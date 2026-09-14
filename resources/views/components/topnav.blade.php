<nav
    class="fixed top-0 left-0 right-0 z-[60] bg-white flex justify-between items-center px-4 md:px-5 h-[50px] border-b border-gray-200 shadow-[0_2px_4px_rgba(0,0,0,0.02)]">
    <div class="flex items-center">
        <button onclick="toggleSidenav()" class="md:hidden mr-3 text-slate-600 hover:text-green-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <div class="text-xl text-green-600 pr-5 font-bold flex items-center">
            <img src="{{ asset('BKPSDM.ico') }}" alt="" srcset="" class="w-8">
            <span class="hidden sm:inline">BKPSDM</span>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <input type="text" placeholder="search..."
            class="bg-gray-100 border border-gray-200 py-1.5 px-3 text-gray-800 rounded text-xs outline-none w-28 sm:w-40 md:w-auto">
        <button onclick="toggleRightnav()" class="lg:hidden text-slate-600 hover:text-green-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </button>
    </div>
</nav>
