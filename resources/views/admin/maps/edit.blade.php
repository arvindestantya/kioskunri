<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Denah')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('maps.update', $map) }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Input Judul Denah -->
                        <div>
                            <x-input-label for="title" :value="__('Judul Denah')" class="dark:text-gray-200" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $map->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Upload Gambar Denah Baru -->
                        <div class="mt-4">
                            <x-input-label for="map_image" :value="__('Ganti Gambar (Opsional)')" class="dark:text-gray-200" />
                            <input type="file" name="map_image" id="map_image" class="block w-full mt-1 text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/50 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800/50">
                            <x-input-error :messages="$errors->get('map_image')" class="mt-2" />
                        </div>

                        <!-- Tampilkan Denah Saat Ini -->
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Denah saat ini:</p>
                            <img src="{{ asset('storage/' . $map->path) }}" alt="Denah Saat Ini" class="mt-2 h-48 w-auto rounded-md border border-gray-200 dark:border-gray-700">
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('maps.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
