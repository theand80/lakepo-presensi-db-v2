<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Green UI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="min-h-screen flex items-center justify-center
  bg-linear-to-br from-green-50 via-emerald-50 to-green-100
  px-4 py-10">

    <div class="w-full max-w-md">

        <!-- Logo -->
        <div class="text-center">
            <div
                class="mx-auto mb-4 flex h-16 w-16 items-center
        justify-center rounded-2xl bg-white border border-green-700 text-white
        shadow-lg shadow-green-600/30">

                <img src="{{ asset('BKPSDM.ico') }}" alt="">
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-800">
                Selamat Datang
            </h1>
            <p class="mt-2 text-sm text-gray-500">
                Silakan masuk ke akun Anda
            </p>
        </div>

        <!-- Login Card -->
        <div class="rounded-3xl border border-white/80 bg-white
      p-7 shadow-xl shadow-green-900/5 sm:p-9">

            <form action="{{ route('authenticate') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Floating Label -->
                <div class="relative">
                    <input type="text" id="username" name="username" placeholder=" " required autofocus
                        value="{{ old('username') }}"
                        class="peer block w-full appearance-none rounded-xl
              border border-gray-300 bg-transparent px-4 pb-3
              pt-6 text-sm text-gray-900 outline-none
              transition-all
              focus:border-green-600 focus:ring-4
              focus:ring-green-100" />
                    <label for="username"
                        class="absolute left-4 top-4 z-10 origin-left
              -translate-y-3 scale-75 transform cursor-text
              text-sm text-gray-500 duration-200
              peer-placeholder-shown:translate-y-0
              peer-placeholder-shown:scale-100
              peer-focus:-translate-y-3
              peer-focus:scale-75
              peer-focus:text-green-600">
                        Username
                    </label>
                </div>

                <!-- Password Floating Label -->
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder=" "
                        autocomplete="current-password" required
                        class="peer block w-full appearance-none rounded-xl
              border border-gray-300 bg-transparent px-4 pb-3
              pt-6 pr-12 text-sm text-gray-900 outline-none
              transition-all
              focus:border-green-600 focus:ring-4
              focus:ring-green-100" />
                    <label for="password"
                        class="absolute left-4 top-4 z-10 origin-left
              -translate-y-3 scale-75 transform cursor-text
              text-sm text-gray-500 duration-200
              peer-placeholder-shown:translate-y-0
              peer-placeholder-shown:scale-100
              peer-focus:-translate-y-3
              peer-focus:scale-75
              peer-focus:text-green-600">
                        Password
                    </label>

                    <button type="button" id="togglePassword" aria-label="Tampilkan password" aria-pressed="false"
                        class="absolute right-3 top-1/2
              -translate-y-1/2 text-gray-400
              transition hover:text-green-600">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z" />
                            <circle cx="12" cy="12" r="3" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>


                <!-- Login Button -->
                <button type="submit"
                    class="flex w-full items-center justify-center
            rounded-xl bg-green-600 px-4 py-3.5
            text-sm font-semibold text-white
            shadow-lg shadow-green-600/20
            transition duration-200
            hover:-translate-y-0.5 hover:bg-green-700
            hover:shadow-green-600/30
            focus:outline-none focus:ring-4
            focus:ring-green-200 active:translate-y-0">
                    Masuk ke Akun
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
                    </svg>
                </button>

            </form>
        </div>

        <p class="mt-6 text-center text-xs text-gray-400">
            &copy; 2026 BKPSDM - Kota Bima.
        </p>
    </div>

    <script>
        const password = document.getElementById('password');
        const toggle = document.getElementById('togglePassword');

        toggle.addEventListener('click', () => {
            const show = password.type === 'password';
            password.type = show ? 'text' : 'password';
            toggle.setAttribute('aria-pressed', String(show));
            toggle.setAttribute(
                'aria-label',
                show ? 'Sembunyikan password' : 'Tampilkan password'
            );
        });
    </script>

</body>

</html>
