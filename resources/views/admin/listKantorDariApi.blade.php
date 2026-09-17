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
                    <span>List Kantor</span>
                    <a href="{{ url('/admin/simpanListKantorkeDB') }}">Simpan List Kantor Ke DB</a>
                    <div>
                        <i class="fa-solid fa-rotate mr-2.5"></i>
                        <i class="fa-solid fa-gear text-slate-400 cursor-pointer"></i>
                    </div>
                </div>
                <div>
                    <ul>
                        {{-- @dd($data) --}}
                        @foreach ($data as $item)
                            @if (isset($item['id_kantor']))
                                <li class="mt-2"><span class="bg-green-500 py-2 px-2">Dari DB : {{ $item['nama_kantor'] }}</span> - {{ $item['id_kantor'] }}</li>
                            @else
                                <li class="mt-2"><span class="bg-green-500 py-2 px-2">Dari API : {{ $item['nama_kantor'] }}</span> - {{ $item['id'] }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
</x-layout>