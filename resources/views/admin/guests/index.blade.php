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

                    <!-- Grafik -->
                    <div class="mb-8 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4 text-center text-gray-900 dark:text-gray-100">Grafik Jumlah Tamu (7 Hari Terakhir)</h3>
                        <div class="h-80">
                            <canvas id="guestChart"></canvas>
                        </div>
                    </div>

                    <form action="{{ route('guests') }}" method="GET" class="mb-6">
                        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Filter & Pencarian</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                
                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cari Kata Kunci</label>
                                    <input type="text" id="search" name="search" placeholder="Nama, NIP, perihal..." value="{{ request('search') }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="jenis_pengunjung" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Pengunjung</label>
                                    <select id="jenis_pengunjung" name="jenis_pengunjung" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Semua Jenis</option>
                                        {{-- @foreach($visitorTypes as $type) 
                                        <option value="{{ $type }}" @selected(request('jenis_pengunjung') == $type)>{{ ucfirst($type) }}</option>
                                        @endforeach --}}
                                        <option value="mahasiswa" @selected(request('jenis_pengunjung') == 'mahasiswa')>Mahasiswa</option>
                                        <option value="dosen" @selected(request('jenis_pengunjung') == 'dosen')>Dosen</option>
                                        <option value="tendik" @selected(request('jenis_pengunjung') == 'tendik')>Tendik</option>
                                        <option value="umum" @selected(request('jenis_pengunjung') == 'umum')>Umum</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4 space-x-4">
                                <a href="{{ route('guests') }}" class="px-4 py-2 font-semibold rounded-md bg-gray-500 text-white hover:bg-gray-600">Reset</a>
                                <button type="submit" class="px-4 py-2 font-semibold rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Terapkan Filter</button>
                            </div>
                        </div>
                    </form>

                    <div class="flex justify-end mb-4">
                        <a href="{{ route('guests.export', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">Export ke Excel</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIP/NIM/NUPTK<br>Asal Fakultas</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kontak</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jenis</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jenis Layanan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Perihal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($guests as $guest)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-normal text-gray-900 dark:text-gray-200">{{ $guest->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-gray-900 dark:text-gray-200">{{ $guest->no_identitas }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $guest->nama_fakultas }}</div>
                                        </td>
                                        <td class="px-6 py-4 w-48 whitespace-normal break-all">
                                            <div class="text-gray-900 dark:text-gray-200">{{ $guest->no_handphone }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $guest->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ ucfirst($guest->jenis_pengunjung) }}</td>
                                        <td class="px-6 py-4 whitespace-normal max-w-xs text-gray-900 dark:text-gray-200">{{ $guest->jenis_layanan }}</td>
                                        <td class="px-6 py-4 whitespace-normal text-gray-900 dark:text-gray-200">{{ $guest->perihal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $guest->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Data tidak ditemukan sesuai filter.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $guests->withQueryString()->links() }}
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
