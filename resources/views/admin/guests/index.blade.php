<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Buku Tamu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="mb-8 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4 text-center text-gray-900 dark:text-gray-100">Grafik Jumlah Tamu (7 Hari Terakhir)</h3>
                        <div class="h-80">
                            <canvas id="guestChart"></canvas>
                        </div>
                    </div>

                    {{-- Form Pencarian dan Tombol Export --}}
                    <div class="flex justify-between items-center mb-4">
                        <div class="w-full max-w-md">
                            <form action="{{ route('guests') }}" method="GET" class="flex">
                                <input type="text" name="search" placeholder="Cari nama, email, perihal..." value="{{ request('search') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-l-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <button type="submit" class="px-4 py-2 font-semibold rounded-r-md bg-indigo-600 text-white hover:bg-indigo-700">Cari</button>
                            </form>
                        </div>
                        <div class="ml-4">
                            <a href="{{ route('guests.export', ['search' => request('search')]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">Export ke Excel</a>
                        </div>
                    </div>

                    {{-- Tabel Data Tamu --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kontak</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jenis</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Perihal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($guests as $guest)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ $guest->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-gray-900 dark:text-gray-200">{{ $guest->no_handphone }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $guest->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ ucfirst($guest->jenis_pengunjung) }}</td>
                                        <td class="px-6 py-4 whitespace-normal max-w-xs text-gray-900 dark:text-gray-200">{{ $guest->perihal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $guest->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada data tamu.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $guests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('guestChart');
            if (!ctx) return;

            // Warna dasar yang akan digunakan
            const colors = {
                light: {
                    grid: 'rgba(0, 0, 0, 0.1)',
                    text: '#374151'
                },
                dark: {
                    grid: 'rgba(255, 255, 255, 0.1)',
                    text: '#e5e7eb'
                }
            };

            const chartConfig = {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Jumlah Tamu',
                        data: {!! json_encode($chartData) !!},
                        backgroundColor: 'rgba(79, 70, 229, 0.2)',
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                        pointBorderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { 
                                stepSize: 1,
                                color: window.matchMedia('(prefers-color-scheme: dark)').matches ? colors.dark.text : colors.light.text
                            },
                            grid: { 
                                color: window.matchMedia('(prefers-color-scheme: dark)').matches ? colors.dark.grid : colors.light.grid
                            }
                        },
                        x: {
                            ticks: { 
                                color: window.matchMedia('(prefers-color-scheme: dark)').matches ? colors.dark.text : colors.light.text
                            },
                             grid: { 
                                color: window.matchMedia('(prefers-color-scheme: dark)').matches ? colors.dark.grid : colors.light.grid
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            };
            
            new Chart(ctx, chartConfig);
        });
    </script>
</x-app-layout>
