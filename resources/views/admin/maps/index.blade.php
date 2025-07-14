<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Denah Lokasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex justify-end">
                <a href="{{ route('maps.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Tambah Denah Baru
                </a>
            </div>

            @if (session('success'))
                <div class="p-4 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Daftar Denah Ter-upload</h3>
                    <div class="space-y-8">
                        @forelse ($facultiesWithMaps as $faculty)
                            <div>
                                <h4 class="font-bold text-xl border-b pb-2 dark:border-gray-700">{{ $faculty->name }}</h4>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-4">
                                    @foreach ($faculty->maps as $map)
                                        <div class="relative group border dark:border-gray-700 rounded-lg overflow-hidden">
                                            <img src="{{ asset('storage/' . $map->path) }}" alt="{{ $map->title }}" class="object-cover w-full h-40">
                                            <div class="absolute bottom-0 left-0 right-0 p-2 bg-black bg-opacity-50">
                                                <p class="text-white text-sm font-semibold truncate">{{ $map->title }}</p>
                                            </div>
                                            <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <a href="{{ route('maps.edit', $map) }}" class="p-2 bg-blue-600 text-white rounded-full hover:bg-blue-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                </a>
                                                <form action="{{ route('maps.destroy', $map) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus denah ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 bg-red-600 text-white rounded-full hover:bg-red-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400">Belum ada denah yang diunggah untuk fakultas manapun.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
