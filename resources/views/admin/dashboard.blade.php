<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-8">

                <!-- Blok Sambutan -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h2>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">
                        @if(Auth::user()->hasRole('Super Admin'))
                            Berikut adalah ringkasan statistik dari semua fakultas.
                        @else
                            Berikut adalah ringkasan statistik untuk {{ Auth::user()->faculty->name ?? 'Fakultas Anda' }}.
                        @endif
                    </p>
                </div>

                <!-- Tombol Filter Periode -->
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('dashboard', ['period' => 'today']) }}"
                       class="px-4 py-2 text-sm font-semibold rounded-md transition {{ $currentPeriod == 'today' ? 'bg-indigo-600 text-white shadow' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        Hari Ini
                    </a>
                    <a href="{{ route('dashboard', ['period' => 'week']) }}"
                       class="px-4 py-2 text-sm font-semibold rounded-md transition {{ $currentPeriod == 'week' ? 'bg-indigo-600 text-white shadow' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        Minggu Ini
                    </a>
                    <a href="{{ route('dashboard', ['period' => 'month']) }}"
                       class="px-4 py-2 text-sm font-semibold rounded-md transition {{ $currentPeriod == 'month' ? 'bg-indigo-600 text-white shadow' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        Bulan Ini
                    </a>
                    <a href="{{ route('dashboard', ['period' => 'all_time']) }}"
                       class="px-4 py-2 text-sm font-semibold rounded-md transition {{ $currentPeriod == 'all_time' ? 'bg-indigo-600 text-white shadow' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        Semua Waktu
                    </a>
                </div>

                <!-- Kartu Statistik -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse ($visitorData as $facultyName => $count)
                        <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center gap-5 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                            <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $count }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold truncate" title="{{ $facultyName }}">Pengunjung</p>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-500 py-4">Belum ada data pengunjung.</p>
                    @endforelse
                    
                    @forelse ($ratingData as $facultyName => $rating)
                        <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center gap-5 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                            <div class="bg-amber-100 dark:bg-amber-900/50 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500 dark:text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $rating }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-semibold truncate" title="{{ $facultyName }}">Rata-rata Rating</p>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-500 py-4">Belum ada data rating.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
