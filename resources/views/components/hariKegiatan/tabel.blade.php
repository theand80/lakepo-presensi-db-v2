<div class="w-full bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    {{-- Header --}}
    <div class="px-6 py-5 border-b border-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-sm text-gray-500 mt-1">
                    Daftar kegiatan yang telah ditambahkan.
                </p>
            </div>
            <div class="text-sm text-gray-500">
                Total:
                <span class="font-semibold text-gray-800">
                    {{-- {{ $kegiatan ?: $kegiatan->count() ?? '' }} --}}
                </span>
                kegiatan
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-xs uppercase text-gray-600">
                <tr>
                    <th scope="col" class="px-6 py-4 w-16">
                        No
                    </th>
                    <th scope="col" class="px-6 py-4">
                        Tanggal Kegiatan
                    </th>
                    <th scope="col" class="px-6 py-4">
                        Nama Kegiatan
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse([] as $item)
                    <tr class="bg-white hover:bg-gray-50 transition">
                        {{-- Nomor --}}
                        <td class="px-6 py-4 font-medium text-gray-500">
                            {{ $loop->iteration }}
                        </td>
                        {{-- Tanggal --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">

                                <div class="flex items-center justify-center
                                            w-9 h-9 rounded-lg
                                            bg-blue-100 text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>

                                <span class="font-medium text-gray-700">
                                    {{ \Carbon\Carbon::parse($item->tglKegiatan)->format('d/m/Y') }}
                                </span>

                            </div>
                        </td>

                        {{-- Nama Kegiatan --}}
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-800">
                                {{ $item->namaKegiatan }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">

                                {{-- Edit --}}
                                <a href="{{ url('editHariKegiatan/'.$item->id) }}"
                                class="inline-flex items-center gap-1.5
                                        rounded-lg bg-yellow-100
                                        px-3 py-2
                                        text-xs font-medium text-yellow-700
                                        hover:bg-yellow-200
                                        transition">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-7.5a2.121 2.121 0 013 3L12 16l-4 1 1-4 7.5-7.5z"/>
                                    </svg>

                                    Edit
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ url('hapusHariKegiatan/'.$item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-1.5
                                            rounded-lg bg-red-100
                                            px-3 py-2
                                            text-xs font-medium text-red-700
                                            hover:bg-red-200
                                            transition">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"/>
                                        </svg>

                                        Hapus
                                    </button>

                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    {{-- Data kosong --}}
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">

                            <div class="flex flex-col items-center">

                                <div class="flex items-center justify-center
                                            w-16 h-16 rounded-full
                                            bg-gray-100 text-gray-400 mb-4">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-8 h-8"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>

                                </div>

                                <h3 class="text-lg font-semibold text-gray-700">
                                    Belum Ada Kegiatan
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Silakan tambahkan kegiatan baru.
                                </p>

                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>