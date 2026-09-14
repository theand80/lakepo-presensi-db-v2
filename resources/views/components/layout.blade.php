<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BKPSDM' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <style>
        .mock-pie {
            background: conic-gradient(#16a34a 0% 31%, #22c55e 31% 54%, #e2e8f0 54% 100%);
        }

        .donut-chart-mock {
            background: radial-gradient(#ffffff 55%, transparent 56%), conic-gradient(#16a34a 0% 75%, #e2e8f0 75% 100%);
        }

        .total-sales-grid {
            background: radial-gradient(circle at top right, #ffffff, #f8fafc);
        }

        .chat-bubble::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 12px;
            width: 0;
            height: 0;
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
            border-right: 6px solid #f1f5f9;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .sidenav-desktop {
            position: fixed;
            top: 50px;
            left: 0;
            height: calc(100vh - 50px);
        }

        .rightnav-desktop {
            position: fixed;
            top: 50px;
            right: 0;
            height: calc(100vh - 50px);
        }

        @media (min-width: 768px) {
            .sidenav-desktop {
                position: sticky;
            }
        }

        @media (min-width: 1024px) {
            .rightnav-desktop {
                position: sticky;
            }
        }
    </style>
</head>

<body class="bg-[#f4f7f6] text-[#333333] text-sm font-['Segoe_UI',Tahoma,Geneva,Verdana,sans-serif] pt-[50px]">

    <x-topnav></x-topnav>

    <div class="flex">
        <x-sidenav></x-sidenav>

        <main class="flex-1 min-w-0 py-4 md:py-4 px-0.5">
            {{ $slot }}
        </main>

        {{-- <x-rightnav></x-rightnav> --}}
    </div>

    <script>
        function toggleSidenav() {
            const sidenav = document.getElementById('sidenav');
            const overlay = document.getElementById('sidenav-overlay');
            sidenav.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function toggleRightnav() {
            const rightnav = document.getElementById('rightnav');
            const overlay = document.getElementById('rightnav-overlay');
            rightnav.classList.toggle('translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>

</html>