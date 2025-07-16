<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('events.update', $event) }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Judul Kegiatan -->
                        <div>
                            <x-input-label for="title" :value="__('Judul Kegiatan')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $event->title)" required autofocus />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi (Opsional)')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('description', $event->description) }}</textarea>
                        </div>

                        <!-- Waktu Mulai & Selesai -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <x-input-label for="start_time" :value="__('Waktu Mulai')" />
                                <x-text-input id="start_time" class="block mt-1 w-full" type="datetime-local" name="start_time" :value="old('start_time', $event->start_time?->format('Y-m-d\TH:i'))" required />
                            </div>
                            <div>
                                <x-input-label for="end_time" :value="__('Waktu Selesai (Opsional)')" />
                                <x-text-input id="end_time" class="block mt-1 w-full" type="datetime-local" name="end_time" :value="old('end_time', $event->end_time?->format('Y-m-d\TH:i'))" />
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="mt-4">
                            <x-input-label for="location" :value="__('Lokasi (Opsional)')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $event->location)" />
                        </div>

                        <!-- Pilihan Fakultas (Hanya Super Admin) -->
                        @hasrole('Super Admin')
                        <div class="mt-4">
                            <x-input-label for="faculty_id" :value="__('Fakultas (Opsional, untuk kegiatan umum)')" />
                            <select name="faculty_id" id="faculty_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">-- Kegiatan Umum --</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ old('faculty_id', $event->faculty_id) == $faculty->id ? 'selected' : '' }}>{{ $faculty->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endhasrole

                        <!-- Upload Poster -->
                        <div class="mt-4">
                            <x-input-label for="image_path" :value="__('Ganti Poster (Opsional)')" />
                            <input type="file" name="image_path" id="image_path" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/50 dark:file:text-indigo-300">
                            @if($event->image_path)
                            <div class="mt-2"><img src="{{ asset('storage/' . $event->image_path) }}" class="h-24 w-auto rounded"></div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('events.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mr-4">
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
