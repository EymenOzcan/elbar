<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Takımlarım / Takımım - Rol'a göre farklı sayfalar -->
                    @if(auth()->user()->hasRole('group-leader'))
                        <x-nav-link :href="route('group-leader.dashboard')" :active="request()->routeIs('group-leader.*')">
                            {{ __('Takımlarım') }}
                        </x-nav-link>
                        <a href="{{ route('group-leader.teams.create') }}" style="display: inline-flex; align-items: center; padding-left: 0.25rem; padding-right: 0.25rem; border-bottom: 2px solid transparent; font-size: 0.875rem; font-weight: 500; line-height: 1.25rem; color: #10b981; text-decoration: none; background-color: transparent;" class="hover:text-green-700 hover:border-green-300 dark:hover:text-green-400 transition duration-150 ease-in-out">
                            {{ __('+Yeni Takım') }}
                        </a>
                    @elseif(auth()->user()->hasRole('team-leader'))
                        <x-nav-link :href="route('team-leader.dashboard')" :active="request()->routeIs('team-leader.*')">
                            {{ __('Takımlarım') }}
                        </x-nav-link>
                        <a href="{{ route('team-leader.personel.index') }}" style="display: inline-flex; align-items: center; padding-left: 0.25rem; padding-right: 0.25rem; border-bottom: 2px solid transparent; font-size: 0.875rem; font-weight: 500; line-height: 1.25rem; color: #3b82f6; text-decoration: none; background-color: transparent;" class="hover:text-blue-700 hover:border-blue-300 dark:hover:text-blue-400 transition duration-150 ease-in-out">
                            {{ __('👥Personel') }}
                        </a>
                    @elseif(auth()->user()->hasRole('personnel'))
                        <x-nav-link :href="route('personnel.dashboard')" :active="request()->routeIs('personnel.*')">
                            {{ __('Takımım') }}
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->hasRole(['super-admin', 'admin', 'editor']))
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Admin Panel') }}
                        </x-nav-link>

                        <!-- İçerikler -->
                        <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative inline-flex">
                            <button @click="open = !open" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.pages.*') || request()->routeIs('admin.galleries.*') || request()->routeIs('admin.static-pages.*') ? 'border-indigo-400 dark:border-indigo-600' : 'border-transparent' }} text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                                {{ __('İçerikler') }}
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </button>
                            <div x-show="open" x-transition style="position: absolute; top: 100%; left: 0; margin-top: 0.125rem; width: 300px;" class="w-80 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1">
                                    <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Kategoriler') }}</a>
                                    <a href="{{ route('admin.pages.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Sayfalar') }}</a>
                                    <a href="{{ route('admin.static-pages.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Sabit Sayfalar') }}</a>
                                    <a href="{{ route('admin.galleries.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Galeriler') }}</a>
                                </div>
                            </div>
                        </div>

                        @if(auth()->user()->hasRole(['super-admin', 'admin']))
                            <!-- Takipçiler -->
                            <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative inline-flex">
                                <button @click="open = !open" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.secret-wall.*') ? 'border-indigo-400 dark:border-indigo-600' : 'border-transparent' }} text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                                    {{ __('Takipçiler') }}
                                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                                <div x-show="open" x-transition style="position: absolute; top: 100%; left: 0; margin-top: 0.125rem; width: 300px;" class="w-80 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="py-1">
                                        <a href="{{ route('admin.secret-wall.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Gizli Duvar') }}</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Etkinlikler -->
                            <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative inline-flex">
                                <button @click="open = !open" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.qr-system.*') || request()->routeIs('admin.visual-show.*') ? 'border-indigo-400 dark:border-indigo-600' : 'border-transparent' }} text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                                    {{ __('Etkinlikler') }}
                                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                                <div x-show="open" x-transition style="position: absolute; top: 100%; left: 0; margin-top: 0.125rem; width: 300px;" class="w-80 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="py-1">
                                        <a href="{{ route('admin.qr-system.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('QR Kodlar') }}</a>
                                        <a href="{{ route('admin.visual-show.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Görsel Show') }}</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Yönetimler -->
                            <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative inline-flex">
                                <button @click="open = !open" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.scanner-users.*') || request()->routeIs('admin.personel.*') || request()->routeIs('admin.media-settings.*') || request()->routeIs('admin.company-social-media.*') || request()->routeIs('admin.modules.*') || request()->routeIs('admin.teams.*') ? 'border-indigo-400 dark:border-indigo-600' : 'border-transparent' }} text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                                    {{ __('Yönetimler') }}
                                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                                <div x-show="open" x-transition style="position: absolute; top: 100%; left: 0; margin-top: 0.125rem; width: 300px;" class="w-80 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="py-1">
                                        <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Kullanıcılar') }}</a>
                                        <a href="{{ route('admin.roles.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Roller') }}</a>
                                        <a href="{{ route('admin.scanner-users.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Etkinlik Görevlileri') }}</a>
                                        <a href="{{ route('admin.personel.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Personel') }}</a>
                                        <a href="{{ route('admin.teams.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Takımlar') }}</a>
                                        <div class="border-t border-gray-200 dark:border-gray-600"></div>
                                        <a href="{{ route('admin.modules.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Modül Yönetimi') }}</a>
                                        <a href="{{ route('admin.company-social-media.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Sosyal Medya Hesapları') }}</a>
                                        <a href="{{ route('admin.media-settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Medya Ayarları') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
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
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
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
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(auth()->user()->hasRole('group-leader'))
                <x-responsive-nav-link :href="route('group-leader.dashboard')" :active="request()->routeIs('group-leader.*')">
                    {{ __('Takımlarım') }}
                </x-responsive-nav-link>
            @elseif(auth()->user()->hasRole('team-leader'))
                <x-responsive-nav-link :href="route('team-leader.dashboard')" :active="request()->routeIs('team-leader.*')">
                    {{ __('Takımlarım') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('team-leader.personel.index')" :active="request()->routeIs('team-leader.personel.*')">
                    {{ __('👥 Personel') }}
                </x-responsive-nav-link>
            @elseif(auth()->user()->hasRole('personnel'))
                <x-responsive-nav-link :href="route('personnel.dashboard')" :active="request()->routeIs('personnel.*')">
                    {{ __('Takımım') }}
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasRole(['super-admin', 'admin', 'editor']))
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Admin Panel') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                    {{ __('Kategoriler') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')">
                    {{ __('Sayfalar') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.galleries.index')" :active="request()->routeIs('admin.galleries.*')">
                    {{ __('Galeriler') }}
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasRole(['super-admin', 'admin']))
                <!-- Takipçiler Menu -->
                <div class="pt-2 pb-1 border-t border-gray-200 dark:border-gray-600">
                    <div class="px-4 text-xs text-gray-400 uppercase">{{ __('Takipçiler') }}</div>
                    <x-responsive-nav-link :href="route('admin.secret-wall.index')" :active="request()->routeIs('admin.secret-wall.*')">
                        {{ __('Gizli Duvar') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Etkinlikler Menu -->
                <div class="pt-2 pb-1 border-t border-gray-200 dark:border-gray-600">
                    <div class="px-4 text-xs text-gray-400 uppercase">{{ __('Etkinlikler') }}</div>
                    <x-responsive-nav-link :href="route('admin.qr-system.index')" :active="request()->routeIs('admin.qr-system.*')">
                        {{ __('QR Kodlar') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Yönetimler Menu -->
                <div class="pt-2 pb-1 border-t border-gray-200 dark:border-gray-600">
                    <div class="px-4 text-xs text-gray-400 uppercase">{{ __('Yönetimler') }}</div>
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        {{ __('Kullanıcılar') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                        {{ __('Roller') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.scanner-users.index')" :active="request()->routeIs('admin.scanner-users.*')">
                        {{ __('Etkinlik Görevlileri') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.media-settings.index')" :active="request()->routeIs('admin.media-settings.*')">
                        {{ __('Medya Ayarları') }}
                    </x-responsive-nav-link>
                </div>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
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