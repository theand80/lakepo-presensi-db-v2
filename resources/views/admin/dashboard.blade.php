<x-layout>
    {{-- error jika tidak ada nip yg dikirim --}}
    @if (session('error'))
        <div class="mb-4 flex items-center gap-3 rounded-lg border border-red-
                200 bg-red-50 p-4 text-sm text-red-700">
            <svg class="h-5 w-5 shrink-0 text-red-500" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    <x-slot:title>Admin</x-slot>
        <div>
            <div class="bg-white border border-slate-200 rounded-md overflow-hidden shadow-sm mb-5">
                <div
                    class="bg-slate-50 py-3 px-4 flex justify-between items-center font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-slate-200">
                    <span>Admin</span>
                </div>
            </div>

            <x-menu></x-menu>
            
        </div>
</x-layout>