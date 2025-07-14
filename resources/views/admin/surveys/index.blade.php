<x-app-layout>
    <x-slot name="header">
        {{-- Menambahkan warna teks untuk dark mode --}}
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Survey Kepuasan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Menambahkan warna latar belakang dan teks untuk dark mode --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                        
                        {{-- Menambahkan warna border dan teks untuk dark mode --}}
                        <div class="lg:col-span-2 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-center text-gray-900 dark:text-gray-100">Rata-Rata Tingkat Kepuasan Pelayanan (7 Hari Terakhir)</h3>
                            <div>
                                <canvas id="ratingChart" style="height: 320px;"></canvas>
                            </div>
                        </div>

                        {{-- Menambahkan warna border dan teks untuk dark mode --}}
                        <div class="flex flex-col justify-center items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Rata-rata Rating Keseluruhan</h3>
                            <div class="text-center">
                                <p class="text-6xl font-bold text-amber-500">
                                    {{ round($overallAverageRating, 1) }}
                                    <span class="text-4xl align-middle">★</span>
                                </p>
                                <p class="text-gray-500 dark:text-gray-400 mt-2">
                                    dari {{ $totalSurveys }} total suara
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- BAGIAN PENCARIAN DAN EXPORT -->
                    <div class="flex justify-between items-center mb-4">
                        <!-- Form Pencarian -->
                        <div class="w-full max-w-md">
                            <form action="{{ route('surveys') }}" method="GET">
                                <div class="flex">
                                    {{-- Menambahkan style dark mode untuk input --}}
                                    <input type="text" name="search" placeholder="Cari rating, pesan..."
                                           value="{{ request('search') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-l-md focus:outline-none focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600">
                                    
                                    <button type="submit"
                                            class="px-4 py-2 font-semibold rounded-r-md transition ease-in-out duration-150 bg-indigo-600 text-white hover:bg-indigo-700">
                                        Cari
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tombol Export -->
                        <div class="ml-4">
                            <a href="{{ route('surveys.export', ['search' => request('search')]) }}"
                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150 hover:bg-green-700">
                                Export ke Excel
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        {{-- Menambahkan style dark mode untuk notifikasi --}}
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 border-l-4 border-green-500 dark:border-green-600 rounded-r-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            {{-- Menambahkan style dark mode untuk header tabel --}}
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rating</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pesan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            {{-- Menambahkan style dark mode untuk body tabel --}}
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($surveys as $survey)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ $survey->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ $survey->rating }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ $survey->pesan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $survey->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            @if (request('search'))
                                                Data tidak ditemukan untuk pencarian "{{ request('search') }}".
                                            @else
                                                Belum ada data rating dan pesan.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{-- Pagination link juga akan otomatis mendukung dark mode jika Anda menggunakan default Laravel --}}
                        {{ $surveys->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    // Gunakan event listener 'alpine:init' jika Anda menggunakan Alpine.js untuk tema,
    // atau 'DOMContentLoaded' sebagai alternatif yang baik.
    document.addEventListener('DOMContentLoaded', () => {
        // Pastikan elemen canvas ada sebelum melanjutkan
        const ctx = document.getElementById('ratingChart')?.getContext('2d');
        if (!ctx) {
            console.error('Elemen canvas untuk ratingChart tidak ditemukan.');
            return;
        }
    
        const labels = {!! json_encode($chartLabels) !!};
        const data = {!! json_encode($chartData) !!};
        let ratingChart = null;
    
        // Fungsi untuk mendapatkan opsi chart berdasarkan tema
        const getChartOptions = () => {
            // Periksa status dark mode SETIAP KALI fungsi ini dipanggil
            const isDarkMode = document.documentElement.classList.contains('dark');
            
            const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.2)' : 'rgba(0, 0, 0, 0.1)';
            const textColor = isDarkMode ? '#e5e7eb' : '#374151'; // Warna abu-abu sangat terang untuk dark mode
    
            return {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (context) => `Rata-rata: ${context.parsed.y} Bintang`
                        }
                    }
                },
                scales: {
                    y: {
                        min: 0,
                        max: 5, 
                        ticks: { 
                            stepSize: 1,
                            color: textColor // Warna teks sumbu Y
                        },
                        grid: {
                            color: gridColor // Warna garis grid sumbu Y
                        },
                        title: { 
                            display: true, 
                            text: 'Rata-rata Bintang', 
                            color: textColor // Warna judul sumbu Y
                        }
                    },
                    x: {
                        ticks: {
                            color: textColor // Warna teks sumbu X
                        },
                        grid: {
                            color: gridColor // Warna garis grid sumbu X
                        },
                        title: { 
                            display: true, 
                            text: 'Tanggal', 
                            color: textColor // Warna judul sumbu X
                        }
                    }
                }
            };
        };
    
        // Fungsi untuk membuat atau memperbarui chart
        const renderChart = () => {
            // Hancurkan chart lama jika ada untuk menghindari duplikasi
            if (ratingChart) {
                ratingChart.destroy();
            }
            
            const isDarkMode = document.documentElement.classList.contains('dark');
    
            ratingChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Rata-rata Rating',
                        data: data,
                        backgroundColor: 'rgba(245, 158, 11, 0.2)',
                        borderColor: 'rgba(245, 158, 11, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(245, 158, 11, 1)',
                        pointBorderColor: isDarkMode ? '#1f2937' : '#fff',
                    }]
                },
                // Panggil getChartOptions() di sini untuk mendapatkan konfigurasi terbaru
                options: getChartOptions()
            });
        };
    
        // Render chart saat halaman pertama kali dimuat
        renderChart();
    
        // Gunakan MutationObserver untuk mendeteksi perubahan tema secara real-time
        const observer = new MutationObserver((mutationsList) => {
            for (const mutation of mutationsList) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    // Gambar ulang grafik setiap kali kelas pada <html> berubah
                    renderChart();
                }
            }
        });
    
        // Mulai mengamati elemen <html> untuk perubahan atribut
        observer.observe(document.documentElement, { attributes: true });
    });
    </script>
</x-app-layout>

