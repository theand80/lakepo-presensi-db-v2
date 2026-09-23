<form action="{{ url('tambahHariKegiatan') }}" method="POST"
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
            <label for="namaKegiatan"
                class="block mb-2 text-sm font-medium text-gray-700">
                Nama Kegiatan
            </label>
            <input
                type="text"
                name="namaKegiatan"
                id="namaKegiatan"
                value="{{ old('namaKegiatan') }}"
                placeholder="Contoh: Rapat Koordinasi"
                required
                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3
                    text-sm text-gray-900 placeholder-gray-400
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                    outline-none transition"
            >
            @error('namaKegiatan')
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