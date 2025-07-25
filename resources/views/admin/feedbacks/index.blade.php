<x-app-layout>
    <x-slot name="header">
        {{-- Menambahkan warna teks untuk dark mode --}}
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Kritik dan Saran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Menambahkan warna latar belakang dan teks untuk dark mode --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- BAGIAN PENCARIAN DAN EXPORT -->
                    <div class="flex justify-between items-center mb-4">
                        <!-- Form Pencarian -->
                        <div class="w-full max-w-md">
                            <form action="{{ route('feedbacks') }}" method="GET">
                                <div class="flex">
                                    {{-- Menambahkan style dark mode untuk input --}}
                                    <input type="text" name="search" placeholder="Cari nama, kritik, saran..."
                                           value="{{ request('search') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-l-md focus:outline-none focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600">
                                    
                                    {{-- Menggunakan kelas Tailwind untuk tombol agar konsisten --}}
                                    <button type="submit"
                                            class="px-4 py-2 font-semibold rounded-r-md transition ease-in-out duration-150 bg-indigo-600 text-white hover:bg-indigo-700">
                                        Cari
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tombol Export dengan Jarak -->
                        <div class="ml-4">
                            <a href="{{ route('feedbacks.export', ['search' => request('search')]) }}"
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
                                    @hasrole('Super Admin')
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fakultas</th>
                                    @endhasrole
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kritik</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Saran</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            {{-- Menambahkan style dark mode untuk body tabel --}}
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($feedbacks as $feedback)
                                    <tr>
                                        @hasrole('Super Admin')
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $feedback->faculty->name ?? 'N/A' }}</td>
                                        @endhasrole
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">{{ $feedback->nama }}</td>
                                        <td class="px-6 py-4 whitespace-normal max-w-sm text-gray-900 dark:text-gray-200">{{ $feedback->kritik }}</td>
                                        <td class="px-6 py-4 whitespace-normal max-w-sm text-gray-900 dark:text-gray-200">{{ $feedback->saran }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $feedback->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
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
                        {{-- Pagination link juga akan otomatis mendukung dark mode jika Anda menggunakan default Laravel --}}
                        {{ $feedbacks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
