<x-app-layout>
    <x-slot name="header">
        {{-- Menambahkan warna teks untuk dark mode --}}
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Kontak Informasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                {{-- Mengubah style tombol agar konsisten dan mendukung dark mode --}}
                <a href="{{ route('contacts.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Tambah Kontak Informasi
                </a>
            </div>

            {{-- Menambahkan warna latar belakang dan teks untuk dark mode --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        {{-- Menambahkan style dark mode untuk notifikasi --}}
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 border-l-4 border-green-500 dark:border-green-600 rounded-r-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-medium mb-4">Daftar Kontak Informasi Saat Ini</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            {{-- Menambahkan style dark mode untuk header tabel --}}
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    @hasrole('Super Admin')
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fakultas</th>
                                    @endhasrole
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jenis Kontak</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Detail Kontak</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Upload</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            {{-- Menambahkan style dark mode untuk body tabel --}}
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($contacts as $contact)
                                    <tr>
                                        @hasrole('Super Admin')
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $contact->faculty->name ?? 'N/A' }}</td>
                                        @endhasrole
                                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-700 dark:text-gray-300">{{ $contact->jenis_kontak }}</td>
                                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-700 dark:text-gray-300">{{ $contact->detail }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $contact->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{-- Menambahkan flex container untuk menata tombol aksi --}}
                                            <div class="flex items-center gap-x-4">
                                                <a href="{{ route('contacts.edit', $contact) }}" class="flex items-center gap-1 text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                    <span>Edit</span>
                                                </a>
                                                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus contact ini?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="flex items-center gap-1 text-red-600 dark:text-red-500 hover:text-red-900 dark:hover:text-red-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="{{ auth()->user()->hasRole('Super Admin') ? '5' : '4' }}" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada contact yang di-upload.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
