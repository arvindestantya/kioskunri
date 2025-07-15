<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Tambah Kegiatan
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 border-l-4 border-green-500 rounded-r-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Poster</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Judul & Deskripsi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu & Lokasi</th>
                                    @hasrole('Super Admin')
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fakultas</th>
                                    @endhasrole
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($events as $event)
                                    <tr>
                                        <td class="px-6 py-4">
                                            @if($event->image_path)
                                                <img src="{{ asset('storage/' . $event->image_path) }}" alt="Poster" class="h-20 w-auto rounded-md">
                                            @else
                                                <span class="text-xs text-gray-400">Tidak ada</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-normal">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $event->title }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($event->description, 50) }}</p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            <p>{{ \Carbon\Carbon::parse($event->start_time)->format('d M Y, H:i') }}</p>
                                            <p class="text-xs text-gray-500">{{ $event->location }}</p>
                                        </td>
                                        @hasrole('Super Admin')
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $event->faculty->name ?? 'Umum' }}</td>
                                        @endhasrole
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center gap-x-4">
                                                <a href="{{ route('events.edit', $event) }}" class="flex items-center gap-1 text-indigo-600 hover:text-indigo-900">
                                                    <span>Edit</span>
                                                </a>
                                                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="flex items-center gap-1 text-red-600 hover:text-red-900">
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="{{ auth()->user()->hasRole('Super Admin') ? '5' : '4' }}" class="px-6 py-4 text-center text-gray-500">Belum ada kegiatan yang ditambahkan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
