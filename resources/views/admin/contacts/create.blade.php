<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kontak Informasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('contacts.store') }}">
                        @csrf

                         {{-- Dropdown Fakultas HANYA untuk Super Admin --}}
                        @hasrole('Super Admin')
                        <div>
                            <x-input-label for="faculty_id" :value="__('Pilih Fakultas untuk Kontak Ini')" />
                            <select name="faculty_id" id="faculty_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
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

                        <!-- Jenis Kontak -->
                        <div class="mt-4">
                            <x-input-label for="jenis_kontak" :value="__('Jenis Kontak Informasi')" />
                            <select name="jenis_kontak" id="jenis_kontak" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @php
                                    $contactTypes = ['Alamat', 'Email', 'Instagram', 'Jam Operasional', 'No Telepon', 'Whatsapp', 'Website'];
                                @endphp
                                <option value="">Pilih Jenis Kontak Informasi</option>
                                @foreach($contactTypes as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('jenis_kontak')" class="mt-2" />
                        </div>

                        <!-- Detail -->
                        <div class="mt-4">
                            <x-input-label for="detail" :value="__('Detail')" />
                            <x-text-input id="detail" class="block mt-1 w-full" type="text" name="detail" required />
                            <x-input-error :messages="$errors->get('detail')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-x-4">
                            <a href="{{ route('contacts.index') }}" 
                                    style="background-color:rgb(255, 0, 0); color: white;"
                                    class="inline-flex items-center px-4 py-2 border border-black rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:opacity-80">
                                batal
                            </a>
                            <button type="submit" 
                                    style="background-color: #4f46e5; color: white;"
                                    class="inline-flex items-center px-4 py-2 border border-black rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 hover:opacity-80">
                                Simpan Kontak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>