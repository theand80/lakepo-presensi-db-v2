<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - BKPSDM Kota Bima</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
</head>

<body class="bg-white text-gray-800 font-sans antialiased">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur border-b border-green-100">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-600 shadow-lg shadow-green-600/20">
                    <img src="{{ asset('BKPSDM.ico') }}" alt="Logo BKPSDM" class="h-6 w-6 object-contain">
                </span>
                <span class="text-lg font-bold tracking-tight text-gray-900">
                    {{ config('app.name') }}
                </span>
            </a>
            <a href="{{ url('/login') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-200">
                <i class="fa-solid fa-right-to-bracket text-xs"></i>
                Masuk
            </a>
        </div>
    </nav>

    <!-- Hero -->
    <header class="relative overflow-hidden bg-linear-to-b from-green-50 via-white to-white pt-16">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-96 bg-linear-to-b from-emerald-100/60 to-transparent"></div>

        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 pt-20 pb-24 text-center">
            <span
                class="inline-flex items-center gap-2 rounded-full border border-green-200 bg-green-50 px-4 py-1.5 text-xs font-semibold uppercase tracking-wide text-green-700">
                <i class="fa-solid fa-building-columns"></i>
                BKPSDM Kota Bima
            </span>

            <h1 class="mx-auto mt-6 max-w-3xl text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">
                {{ config('app.name') }}
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-base text-gray-500 sm:text-lg">
                Aplikasi presensi &amp; rekap kehadiran ASN — pantau kehadiran per kantor,
                hitung persentase, dan kelola data kehadiran dalam satu tempat.
            </p>

            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="{{ url('/login') }}"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-green-600 px-8 py-4 text-sm font-semibold text-white shadow-lg shadow-green-600/20 transition hover:-translate-y-0.5 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-200 sm:w-auto">
                    Masuk ke Aplikasi
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
                <a href="#fitur"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-8 py-4 text-sm font-semibold text-gray-700 transition hover:border-green-300 hover:text-green-700 sm:w-auto">
                    Lihat Fitur
                </a>
            </div>

            <!-- Ilustrasi mock dashboard -->
            <div class="mx-auto mt-16 max-w-4xl rounded-2xl border border-gray-200 bg-white p-4 shadow-2xl shadow-green-900/10 sm:p-6">
                <div class="grid grid-cols-3 gap-3 sm:gap-4">
                    <div class="col-span-3 sm:col-span-1 rounded-xl border border-gray-100 bg-gray-50 p-4 text-left">
                        <i class="fa-solid fa-calendar-check text-green-600"></i>
                        <p class="mt-2 text-xs font-semibold text-gray-700">Rekap Bulanan</p>
                        <div class="mt-2 h-1.5 w-3/4 rounded bg-green-200"></div>
                        <div class="mt-2 h-1.5 w-1/2 rounded bg-gray-200"></div>
                    </div>
                    <div class="col-span-3 sm:col-span-1 rounded-xl border border-gray-100 bg-gray-50 p-4 text-left">
                        <i class="fa-solid fa-chart-pie text-green-600"></i>
                        <p class="mt-2 text-xs font-semibold text-gray-700">Persentase</p>
                        <div class="mt-2 h-1.5 w-2/3 rounded bg-green-200"></div>
                        <div class="mt-2 h-1.5 w-1/2 rounded bg-gray-200"></div>
                    </div>
                    <div class="col-span-3 sm:col-span-1 rounded-xl border border-gray-100 bg-gray-50 p-4 text-left">
                        <i class="fa-solid fa-file-lines text-green-600"></i>
                        <p class="mt-2 text-xs font-semibold text-gray-700">Ekspor PDF &amp; Excel</p>
                        <div class="mt-2 h-1.5 w-3/4 rounded bg-green-200"></div>
                        <div class="mt-2 h-1.5 w-1/3 rounded bg-gray-200"></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Fitur -->
    <section id="fitur" class="bg-white py-20 sm:py-24">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-green-600">Fitur Unggulan</h2>
                <p class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Semua kebutuhan rekap presensi
                </p>
                <p class="mt-4 text-base text-gray-500">
                    Dirancang untuk Admin, PIC, dan Operator agar pengelolaan kehadiran lebih cepat dan akurat.
                </p>
            </div>

            <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['icon' => 'fa-calendar-days', 'judul' => 'Rekap Kehadiran', 'desc' => 'Rekap kehadiran bulanan per kantor berdasarkan data SIASN, lengkap dengan detail per ASN.'],
                    ['icon' => 'fa-chart-column', 'judul' => 'Persentase Kehadiran', 'desc' => 'Hitung dan simpan persentase kehadiran per kantor dengan cepat dan terukur.'],
                    ['icon' => 'fa-file-pdf', 'judul' => 'Ekspor PDF & Excel', 'desc' => 'Unduh rekap kehadiran dalam format PDF dan Excel untuk kebutuhan pelaporan.'],
                    ['icon' => 'fa-calendar-check', 'judul' => 'Hari Kegiatan', 'desc' => 'Atur hari kegiatan dan impor daftar ASN yang mengikuti kegiatan.'],
                    ['icon' => 'fa-users-gear', 'judul' => 'Manajemen User & Role', 'desc' => 'Kelola pengguna dengan peran Admin, PIC, dan Operator beserta akses kantornya.'],
                    ['icon' => 'fa-arrows-rotate', 'judul' => 'Sinkronisasi Data ASN', 'desc' => 'Tarik dan lengkapi data ASN dari API Simpegnas serta impor Excel DUK.'],
                ] as $fitur)
                    <div
                        class="group rounded-2xl border border-gray-200 bg-white p-6 transition hover:-translate-y-1 hover:border-green-300 hover:shadow-xl hover:shadow-green-900/5">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600 transition group-hover:bg-green-600 group-hover:text-white">
                            <i class="fa-solid {{ $fitur['icon'] }} text-lg"></i>
                        </div>
                        <h3 class="mt-5 text-base font-semibold text-gray-900">{{ $fitur['judul'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-500">{{ $fitur['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-linear-to-r from-green-600 to-emerald-600 py-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                Siap mengelola presensi?
            </h2>
            <p class="mx-auto mt-3 max-w-xl text-sm text-green-50 sm:text-base">
                Masuk menggunakan akun Anda untuk mulai menggunakan aplikasi.
            </p>
            <a href="{{ url('/login') }}"
                class="mt-8 inline-flex items-center gap-2 rounded-xl bg-white px-8 py-4 text-sm font-semibold text-green-700 shadow-lg transition hover:-translate-y-0.5 hover:bg-green-50 focus:outline-none focus:ring-4 focus:ring-green-300">
                Masuk ke Aplikasi
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-white py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 flex flex-col items-center gap-4 sm:flex-row sm:justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('KotaBima.png') }}" alt="Logo Kota Bima" class="h-8 w-8 object-contain">
                <div class="text-sm">
                    <p class="font-semibold text-gray-900">BKPSDM - Kota Bima</p>
                    <p class="text-xs text-gray-500">{{ config('app.name') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-6 text-sm text-gray-500">
                <a href="{{ url('/login') }}" class="transition hover:text-green-600">Masuk</a>
                <span>&copy; 2026 BKPSDM - Kota Bima.</span>
            </div>
        </div>
    </footer>

</body>

</html>
