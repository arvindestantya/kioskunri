<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Fakultas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('superadmin.faculties.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Tambah Fakultas
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 border-l-4 border-green-500 dark:border-green-600 rounded-r-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Fakultas</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Slug</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah Admin</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:bg-gray-800 divide-gray-200 dark:divide-gray-700">
                                @forelse ($faculties as $faculty)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ $faculty->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ $faculty->slug }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ $faculty->users_count }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-4">
                                            <a href="{{ route('superadmin.faculties.edit', $faculty) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('superadmin.faculties.destroy', $faculty) }}" method="POST" onsubmit="return confirm('Menghapus fakultas akan menghapus semua data terkait (user, tamu, flyer). Yakin?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data fakultas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $faculties->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>