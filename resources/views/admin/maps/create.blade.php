<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Denah Lokasi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('maps.store') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <!-- Pilihan Fakultas -->
                        @hasrole('Super Admin')
                        <div>
                            <x-input-label for="faculty_id" :value="__('Pilih Fakultas')" class="dark:text-gray-200" />
                            <select name="faculty_id" id="faculty_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="" disabled selected>-- Pilih Fakultas --</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>{{ $faculty->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('faculty_id')" class="mt-2" />
                        </div>
                        @else
                        {{-- Admin Fakultas otomatis menggunakan faculty_id mereka --}}
                        <input type="hidden" name="faculty_id" value="{{ auth()->user()->faculty_id }}">
                        @endhasrole
                        
                        <!-- Input Judul Denah -->
                        <div>
                            <x-input-label for="title" :value="__('Judul Denah')" class="dark:text-gray-200" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Upload Gambar Denah -->
                        <div class="mt-4">
                            <x-input-label for="map_image" :value="__('File Gambar Denah')" class="dark:text-gray-200" />
                            <input type="file" name="map_image" id="map_image" required class="block w-full mt-1 text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/50 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800/50">
                            <x-input-error :messages="$errors->get('map_image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('maps.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Upload Denah') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
