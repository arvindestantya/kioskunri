<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Keberatan Informasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('ppid.keberatan') }}" method="GET" class="mb-6">
                        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Filter & Pencarian</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cari Kata Kunci</label>
                                    <input type="text" id="search" name="search" placeholder="Nama, Email, Perihal..." value="{{ request('search') }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>

                                {{-- Jika Anda memiliki filter tambahan (misalnya filter Fakultas) letakkan di sini --}}

                            </div>

                            <div class="flex items-center justify-end mt-4 space-x-4">
                                {{-- Tombol Reset akan diarahkan ke route index saat ini tanpa query string --}}
                                <a href="{{ url()->current() }}" class="px-4 py-2 font-semibold rounded-md bg-gray-500 text-white hover:bg-gray-600">Reset</a>
                                <button type="submit" class="px-4 py-2 font-semibold rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Terapkan Filter</button>
                            </div>
                        </div>
                    </form>

                    <div class="flex justify-end mb-4">
                        <a href="{{ route('ppid.keberatan.export', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">Export ke Excel</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    @hasrole('Super Admin')
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fakultas</th>
                                    @endhasrole
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Pemohon</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kontak & Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Alasan Keberatan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tujuan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">File</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Submit</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($keberatan as $item)
                                    <tr>
                                        @hasrole('Super Admin')
                                        <td class="px-6 py-4 whitespace-normal break text-sm text-gray-700 dark:text-gray-300">{{ $item->faculty->name ?? 'N/A' }}</td>
                                        @endhasrole
                                        <td class="px-6 py-4 whitespace-normal text-gray-900 dark:text-gray-200">{{ $item->nama }}</td>
                                        <td class="px-6 py-4 w-48 whitespace-normal">
                                            <div class="text-gray-900 dark:text-gray-200">{{ $item->telepon }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 break-all">{{ $item->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-normal max-w-xs text-gray-900 dark:text-gray-200">
                                            <div>{{ $item->alasan }}</div>
                                            @if($item->alasan_lainnya) ({{ $item->alasan_lainnya }}) @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-normal max-w-xs text-gray-900 dark:text-gray-200">{{ $item->tujuan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ Storage::url($item->file_identitas) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Lihat File</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Data Keberatan tidak ditemukan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $keberatan->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
