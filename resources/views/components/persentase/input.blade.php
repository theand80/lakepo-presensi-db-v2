<form action="{{ url('/pic/simpan-persentase') }}" method="POST"
    class="w-4xl bg-white rounded-2xl shadow-lg border border-gray-100 p-6 m-6">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

        {{-- Tanggal --}}
        <div class="md:col-span-3">
            <label for="bulanUntukDihitung"
                class="block mb-2 text-sm font-medium text-gray-700">
                Bulan
            </label>

            <input
                {{-- type="date" --}}
                type="month"
                name="bulanUntukDihitung"
                id="bulanUntukDihitung"
                value="{{ old('bulanUntukDihitung') }}"
                required
                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3
                    text-sm text-gray-900
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                    outline-none transition"
            >

            @error('bulanUntukDihitung')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Nama Kantor --}}
        <div class="md:col-span-6">
            <label for="namaKantor"
                class="block mb-2 text-sm font-medium text-gray-700">
                Kantor
            </label>

            <select
                name="namaKantor"
                id="namaKantor"
                required
                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3
                    text-sm text-gray-900
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                    outline-none transition"
            >
                <option value="" disabled selected>
                    -- Pilih Nama Kantor --
                </option>

                {{-- @php
                    $kantors = [
                        "Kantor Pusat",
                        "Kantor Cabang Bima",
                        "Kantor Cabang Mataram",
                        "Kantor Cabang Sumbawa"
                    ];
                @endphp --}}
                @php
                    $kantors = collect([
                        ['nama_kantor' => 'Kantor Pusat'],
                        ['nama_kantor' => 'Kantor Cabang Bima'],
                        ['nama_kantor' => 'Kantor Cabang Mataram'],
                        ['nama_kantor' => 'Kantor Cabang Sumbawa'],
                    ])->map(fn ($kantor) => (object) $kantor);
                @endphp

                @foreach ($kantors as $kantor)
                    <option
                        value="{{ $kantor->nama_kantor }}"
                        {{ old('namaKantor') == $kantor->nama_kantor ? 'selected' : '' }}
                    >
                        {{ $kantor->nama_kantor }}
                    </option>
                @endforeach
            </select>

            @error('namaKantor')
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
                Hitung
            </button>
        </div>

    </div>
</form>
