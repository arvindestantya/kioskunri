<x-app-layout>
    <x-slot name="header">
        {{-- Menambahkan warna teks untuk dark mode --}}
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Flyer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Upload -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Upload Flyer Baru</h3>
                    
                    @if (session('success'))
                        {{-- Menambahkan style dark mode untuk notifikasi --}}
                        <div class="mb-4 p-3 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 rounded-md text-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 rounded-md text-sm">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('flyers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        {{-- Dropdown Fakultas HANYA untuk Super Admin --}}
                        @hasrole('Super Admin')
                        <div>
                            <x-input-label for="faculty_id" :value="__('Pilih Fakultas untuk Flyer Ini')" />
                            <select name="faculty_id" id="faculty_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="" disabled selected>-- Pilih Fakultas --</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        {{-- Admin Fakultas otomatis menggunakan faculty_id mereka --}}
                        <input type="hidden" name="faculty_id" value="{{ auth()->user()->faculty_id }}">
                        @endhasrole

                        <div>
                            <x-input-label for="flyer_image" :value="__('File Gambar Flyer')" />
                            <div class="flex items-center mt-1">
                                {{-- Menambahkan style dark mode untuk input file --}}
                                <input type="file" id="flyer_image" name="flyer_image" required class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/50 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800/50"/>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            {{-- Menggunakan kelas Tailwind untuk tombol agar konsisten --}}
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150 hover:bg-indigo-700">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tampilan Tabel Daftar Flyer -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Daftar Flyer Saat Ini</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Thumbnail</th>
                                    @hasrole('Super Admin')
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fakultas</th>
                                    @endhasrole
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama File</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Upload</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($flyers as $flyer)
                                    <tr>
                                        <td class="px-6 py-4"><img src="{{ asset('storage/' . $flyer->path) }}" alt="Thumbnail" class="h-16 w-auto rounded-md"></td>
                                        @hasrole('Super Admin')
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $flyer->faculty->name ?? 'N/A' }}</td>
                                        @endhasrole
                                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-700 dark:text-gray-300">{{ $flyer->path }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $flyer->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form action="{{ route('flyers.destroy', $flyer) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus flyer ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="flex items-center gap-1 text-red-600 hover:text-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="{{ auth()->user()->hasRole('Super Admin') ? '5' : '4' }}" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada flyer yang di-upload.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
