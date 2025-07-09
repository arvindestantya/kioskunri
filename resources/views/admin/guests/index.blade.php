<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Buku Tamu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Grafik Jumlah Tamu (7 Hari Terakhir)</h3>
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <canvas id="guestChart" style="height: 320px"></canvas>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-4">
                        <div class="w-full max-w-md">
                            <form action="{{ route('guests') }}" method="GET">
                                <div class="flex">
                                    <input type="text" name="search" placeholder="Cari nama, email, perihal..."
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

                        <div class="ml-4">
                            <a href="{{ route('guests.export', ['search' => request('search')]) }}"
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
                            {{-- ... Sisa kode tabel Anda tetap sama ... --}}
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($guests as $guest)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $guest->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>{{ $guest->no_handphone }}</div>
                                            <div class="text-sm text-gray-500">{{ $guest->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($guest->jenis_pengunjung) }}</td>
                                        <td class="px-6 py-4 whitespace-normal max-w-xs">{{ $guest->perihal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <!-- <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center gap-1 text-red-600 hover:text-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </form> -->
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            @if (request('search'))
                                                Data tidak ditemukan untuk pencarian "{{ request('search') }}".
                                            @else
                                                Belum ada data tamu.
                                            @endif
                                        </td>
                                    </tr>
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

   {{-- Import library Chart.js dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Mengambil data dari variabel PHP yang di-pass oleh controller
    const labels = {!! json_encode($chartLabels) !!};
    const data = {!! json_encode($chartData) !!};

    // Mengambil elemen canvas
    const ctx = document.getElementById('guestChart').getContext('2d');

    // ================== GRADIENT BACKGROUND ==================
    // Membuat warna latar belakang berbentuk gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.5)');   // Warna atas (lebih pekat)
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');      // Warna bawah (transparan)
    // =========================================================

    // Konfigurasi untuk grafik
    const chartConfig = {
        type: 'line', // Jenis grafik tetap 'line'
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Tamu',
                data: data,
                
                // --- Peningkatan Visual ---
                backgroundColor: gradient,      // 🎨 Terapkan gradient sebagai background
                borderColor: 'rgba(79, 70, 229, 1)', // Warna garis utama
                borderWidth: 3,                 // Ketebalan garis
                fill: true,                     // 💧 Aktifkan warna di bawah garis
                tension: 0.4,                   // ✨ Membuat garis melengkung (tidak kaku)

                // --- Pengaturan Titik Data ---
                pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(79, 70, 229, 1)',
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Agar bisa mengatur tinggi chart
            
            // --- Penambahan Judul & Label ---
            plugins: {
                // Konfigurasi judul utama
                title: {
                    display: true,
                    text: 'Jumlah Kunjungan Tamu Harian', // 📝 Judul utama grafik
                    font: {
                        size: 18,
                        weight: 'bold'
                    },
                    padding: {
                        top: 10,
                        bottom: 20
                    }
                },
                // Konfigurasi legenda (label 'Jumlah Tamu')
                legend: {
                    display: false // Kita sembunyikan karena judul sudah cukup jelas
                },
                // Konfigurasi tooltip saat hover
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y + ' tamu'; // 💬 Menambahkan kata 'tamu'
                            }
                            return label;
                        }
                    }
                }
            },

            // --- Pengaturan Sumbu (Axes) ---
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Sumbu Y hanya menampilkan angka bulat
                    },
                    // Label untuk sumbu Y
                    title: {
                        display: true,
                        text: 'Jumlah Tamu'
                    }
                },
                x: {
                    // Label untuk sumbu X
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                }
            }
        }
    };

    // Membuat grafik pada elemen canvas
    const guestChart = new Chart(ctx, chartConfig);
</script>
</x-app-layout>