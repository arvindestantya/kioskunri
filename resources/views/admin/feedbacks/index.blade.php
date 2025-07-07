<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Kritik dan Saran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- BAGIAN PENCARIAN DAN EXPORT -->
                    <div class="flex justify-between items-center mb-4">
                        <!-- Form Pencarian -->
                        <div class="w-full max-w-md">
                            <form action="{{ route('feedbacks') }}" method="GET">
                                <div class="flex">
                                    <input type="text" name="search" placeholder="Cari nama, kritik, saran..."
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
                            <a href="{{ route('feedbacks.export', ['search' => request('search')]) }}"
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kritik</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saran</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($feedbacks as $feedback)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $feedback->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $feedback->kritik }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $feedback->saran }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $feedback->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form action="{{ route('feedbacks.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center gap-1 text-red-600 hover:text-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            @if (request('search'))
                                                Data tidak ditemukan untuk pencarian "{{ request('search') }}".
                                            @else
                                                Belum ada data kritik dan saran.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $feedbacks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>