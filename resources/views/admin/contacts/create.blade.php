<x-app-layout>
    <x-slot name="header">
        {{-- Menambahkan warna teks untuk dark mode --}}
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Kontak Informasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            {{-- Menambahkan warna latar belakang dan teks untuk dark mode --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('contacts.store') }}">
                        @csrf

                        {{-- Dropdown Fakultas HANYA untuk Super Admin --}}
                        @hasrole('Super Admin')
                        <div>
                            <x-input-label for="faculty_id" :value="__('Pilih Fakultas untuk Kontak Ini')" />
                            {{-- Menambahkan style dark mode untuk select --}}
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

                        <!-- Jenis Kontak -->
                        <div class="mt-4">
                            <x-input-label for="jenis_kontak" :value="__('Jenis Kontak Informasi')" />
                            <select name="jenis_kontak" id="jenis_kontak" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                @php
                                    $contactTypes = ['Alamat', 'Email', 'Instagram', 'Jam Operasional', 'No Telepon', 'Whatsapp', 'Website'];
                                @endphp
                                <option value="">Pilih Jenis Kontak Informasi</option>
                                @foreach($contactTypes as $type)
                                    <option value="{{ $type }}" {{ old('jenis_kontak') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('jenis_kontak')" class="mt-2" />
                        </div>

                        <!-- Detail -->
                        <div class="mt-4">
                            <x-input-label for="detail" :value="__('Detail')" />
                            {{-- Komponen x-text-input dari Breeze/Jetstream biasanya sudah mendukung dark mode --}}
                            <x-text-input id="detail" class="block mt-1 w-full" type="text" name="detail" :value="old('detail')" required />
                            <x-input-error :messages="$errors->get('detail')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            @hasrole('Super Admin')
                            <a href="{{ route('superadmin.contacts.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mr-4">
                                Batal
                            </a>
                            @endhasrole
                            @hasrole('Faculty Admin')
                            <a href="{{ route('contacts.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mr-4">
                                Batal
                            </a>
                            @endhasrole
                            <x-primary-button>
                                {{ __('Simpan Kontak') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
