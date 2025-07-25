<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @hasrole('Faculty Admin')
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                    @endhasrole
                    @hasrole('Super Admin')
                    <a href="{{ route('superadmin.faculties.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                    @endhasrole
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    
                    {{-- Menu ini hanya akan muncul untuk Admin Fakultas --}}
                    @hasrole('Faculty Admin')
                        <x-nav-link :href="route('guests')" :active="request()->routeIs('guests')">
                            {{ __('Buku Tamu') }}
                        </x-nav-link>
                        <x-nav-link :href="route('feedbacks')" :active="request()->routeIs('feedbacks')">
                            {{ __('Kritik dan Saran') }}
                        </x-nav-link>
                        <x-nav-link :href="route('surveys')" :active="request()->routeIs('surveys')">
                            {{ __('Survey Kepuasan') }}
                        </x-nav-link>
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <x-dropdown align="right" width="48">
                                
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none 
                                        @if (request()->routeIs('flyers.index', 'contacts.index', 'schedules.index', 'maps.index', 'announcements.index', 'events.index', 'services.index'))
                                            border-indigo-400 text-gray-900 focus:border-indigo-700
                                        @else
                                            border-transparent text-gray-700 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300
                                        @endif
                                    ">
                                        <div>Manajemen Konten</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('flyers.index')">
                                        {{ __('Manajemen Flyer') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('contacts.index')">
                                        {{ __('Manajemen Kontak') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('schedules.index')">
                                        {{ __('Manajemen Jadwal') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('maps.index')">
                                        {{ __('Manajemen Denah') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('announcements.index')">
                                        {{ __('Manajemen Pengumuman') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('events.index')">
                                        {{ __('Manajemen Kegiatan') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('services.index')">
                                        {{ __('Manajemen Layanan') }}
                                    </x-dropdown-link>
                                    </x-slot>
                                
                            </x-dropdown>
                        </div>
                    @endhasrole
                    
                    {{-- Menu ini hanya akan muncul untuk Super Admin --}}
                    @hasrole('Super Admin')
                        {{-- Super Admin diarahkan ke manajemen fakultas sebagai halaman utamanya --}}
                        <x-nav-link :href="route('superadmin.faculties.index')" :active="request()->routeIs('superadmin.faculties.*') || request()->routeIs('dashboard')">
                            {{ __('Manajemen Fakultas') }}
                        </x-nav-link>
                        <x-nav-link :href="route('superadmin.users.index')" :active="request()->routeIs('superadmin.users.*')">
                            {{ __('Manajemen User') }}
                        </x-nav-link>
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <x-dropdown align="right" width="48">
                                
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none 
                                        @if (request()->routeIs('superadmin.guests.index', 'superadmin.feedbacks.index', 'superadmin.surveys.index'))
                                            border-indigo-400 text-gray-900 focus:border-indigo-700
                                        @else
                                            border-transparent text-gray-700 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300
                                        @endif
                                    ">
                                        <div>Lihat Data</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('superadmin.guests.index')">
                                        {{ __('Buku Tamu') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('superadmin.feedbacks.index')">
                                        {{ __('Kritik dan Saran') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('superadmin.surveys.index')">
                                        {{ __('Survey Kepuasan') }}
                                    </x-dropdown-link>
                                </x-slot>
                                
                            </x-dropdown>
                        </div>
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <x-dropdown align="right" width="48">
                                
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none 
                                        @if (request()->routeIs('superadmin.flyers.index', 'superadmin.contacts.index', 'superadmin.schedules.index', 'superadmin.maps.index', 'superadmin.announcements.index', 'superadmin.events.index', 'superadmin.services.index'))
                                            border-indigo-400 text-gray-900 focus:border-indigo-700
                                        @else
                                            border-transparent text-gray-700 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300
                                        @endif
                                    ">
                                        <div>Manajemen Konten</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('superadmin.flyers.index')">
                                        {{ __('Manajemen Flyer') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('superadmin.contacts.index')">
                                        {{ __('Manajemen Kontak') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('superadmin.schedules.index')">
                                        {{ __('Manajemen Jadwal') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('superadmin.maps.index')">
                                        {{ __('Manajemen Denah') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('superadmin.announcements.index')">
                                        {{ __('Manajemen Pengumuman') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('superadmin.events.index')">
                                        {{ __('Manajemen Kegiatan') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('superadmin.services.index')">
                                        {{ __('Manajemen Layanan') }}
                                    </x-dropdown-link>
                                    </x-slot>
                                
                            </x-dropdown>
                        </div>
                    @endhasrole
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            {{-- Menu ini hanya akan muncul untuk Admin Fakultas di versi mobile --}}
            @hasrole('Faculty Admin')
                <x-responsive-nav-link :href="route('guests')" :active="request()->routeIs('guests')">
                    {{ __('Buku Tamu') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('feedbacks')" :active="request()->routeIs('feedbacks')">
                    {{ __('Kritik dan Saran') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('surveys')" :active="request()->routeIs('surveys')">
                    {{ __('Survey Kepuasan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('flyers.index')" :active="request()->routeIs('flyers.index')">
                    {{ __('Manajemen Flyer') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('contacts.index')" :active="request()->routeIs('contacts.index')">
                    {{ __('Manajemen Kontak') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('schedules.index')" :active="request()->routeIs('schedules.index')">
                    {{ __('Manajemen Jadwal') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('maps.index')" :active="request()->routeIs('maps.index')">
                    {{ __('Manajemen Denah') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('announcements.index')" :active="request()->routeIs('announcements.index')">
                    {{ __('Manajemen Pengumuman') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')">
                    {{ __('Manajemen Kegiatan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('services.index')" :active="request()->routeIs('services.index')">
                    {{ __('Manajemen Layanan') }}
                </x-responsive-nav-link>
                @endhasrole
            
            {{-- Menu ini hanya akan muncul untuk Super Admin di versi mobile --}}
            @hasrole('Super Admin')
                <x-responsive-nav-link :href="route('superadmin.faculties.index')" :active="request()->routeIs('superadmin.faculties.*') || request()->routeIs('dashboard')">
                    {{ __('Manajemen Fakultas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('superadmin.users.index')" :active="request()->routeIs('superadmin.users.*')">
                    {{ __('Manajemen User') }}
                </x-responsive-nav-link>
            @endhasrole
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>