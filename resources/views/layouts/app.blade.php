<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dashboard Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- ================== PERBAIKAN KUNCI DI SINI ================== -->
        <!-- 1. Memuat Tailwind CSS langsung dari CDN -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- 2. Memuat Alpine.js (untuk dropdown) langsung dari CDN -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <!-- 3. Memuat Chart.js untuk semua grafik -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- 4. Konfigurasi Tailwind untuk Dark Mode (Otomatis) -->
        <script>
            tailwind.config = {
                darkMode: 'media', // Atau 'class' jika Anda ingin tombol manual
            }
        </script>
        <!-- ============================================================= -->
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
