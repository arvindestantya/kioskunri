<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Survey Kepuasan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="p-6 text-gray-900">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                        
                        <div class="lg:col-span-2 p-4 border border-gray-200 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-center">Rata-Rata Tingkat Kepuasan Pelayanan (7 Hari Terakhir)</h3>
                            <div>
                                <canvas id="ratingChart" style="height: 320px;"></canvas>
                            </div>
                        </div>

                        <div class="flex flex-col justify-center items-center p-4 border border-gray-200 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Rata-rata Rating Keseluruhan</h3>
                            <div class="text-center">
                                <p class="text-6xl font-bold text-amber-500">
                                    {{-- Tampilkan rata-rata, bulatkan 1 angka desimal --}}
                                    {{ round($overallAverageRating, 1) }}
                                    <span class="text-4xl align-middle">★</span>
                                </p>
                                <p class="text-gray-500 mt-2">
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
                                    <input type="text" name="search" placeholder="Cari rating, pesan..."
                                           value="{{ request('search') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    
                                    <button type="submit"
                                            style="background-color: #4f46e5; color: white;"
                                            class="px-4 py-2 font-semibold rounded-r-md transition ease-in-out duration-150 hover:opacity-80">
                                        Cari
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tombol Export dengan Jarak -->
                        <div class="ml-4">
                            <a href="{{ route('surveys.export', ['search' => request('search')]) }}"
                               style="background-color: #16a34a; color: white;" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:opacity-80">
                                Export ke Excel
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 border-l-4 border-green-500 rounded-r-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pesan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($surveys as $survey)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $survey->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $survey->rating }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $survey->pesan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $survey->created_at->format('d M Y, H:i') }}</td>
                                        <!-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form action="{{ route('surveys.destroy', $survey->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center gap-1 text-red-600 hover:text-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </td> -->
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
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
                        {{ $surveys->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Set font default jika ingin
    Chart.defaults.font.family = "'Poppins', sans-serif";

    const labels = {!! json_encode($chartLabels) !!};
    const data = {!! json_encode($chartData) !!};
    const ctx = document.getElementById('ratingChart').getContext('2d');

    // Gradient warna untuk rating (kuning/emas)
    const gradient = ctx.createLinearGradient(0, 0, 0, 320);
    gradient.addColorStop(0, 'rgba(245, 158, 11, 0.5)'); // Warna kuning dari Tailwind (amber-500)
    gradient.addColorStop(1, 'rgba(245, 158, 11, 0)');

    const chartConfig = {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rata-rata Rating',
                data: data,
                backgroundColor: gradient,
                borderColor: 'rgba(245, 158, 11, 1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(245, 158, 11, 1)',
                pointBorderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    // text: 'Rata-rata Kepuasan Harian',
                    font: { size: 18, weight: '600' }
                },
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (context) => `Rata-rata: ${context.parsed.y} Bintang`
                    }
                }
            },
            scales: {
                y: {
                    // Skala sumbu Y diatur dari 0 hingga 5 untuk rating
                    min: 0,
                    max: 5, 
                    ticks: { stepSize: 1 },
                    title: { display: true, text: 'Rata-rata Bintang' }
                },
                x: {
                    title: { display: true, text: 'Tanggal' }
                }
            }
        }
    };

    new Chart(ctx, chartConfig);
</script>