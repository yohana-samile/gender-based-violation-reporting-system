@php
    $settingsRoutes = [
        'backend.setting',
        'backend.role.index',
        'backend.permission.index',
        'backend.audit.index',
        'backend.logs.index',
        // for roles and other settings,
    ];
    $isSettingsActive = collect($settingsRoutes)->contains(function($route) {
        return request()->routeIs($route);
    });
@endphp
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed top-0 left-0 w-64 h-screen bg-white dark:bg-gray-800 p-5 transition-transform duration-300 md:translate-x-0 md:block overflow-y-auto z-50 shadow-lg">
    <button @click="sidebarOpen = false" class="absolute top-4 right-4 text-gray-600 dark:text-gray-300 md:hidden">
        <i class="fas fa-times"></i>
    </button>
    <div class="shrink-0 flex text-center">
        <a href="{{ route('gbv.dashboard') }}">
            <x-application-mark class="block h-9 w-auto" />
        </a>
    </div>
    <div>
        <x-dark-or-right-mode />
    </div>

    <nav class="mt-5">
        <x-nav-link href="{{ route('gbv.dashboard') }}" :active="request()->routeIs('backend.dashboard')" class="flex items-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
            <i class="fas fa-tachometer-alt mr-3 text-gray-600 dark:text-gray-300"></i>
            {{ __('Dashboard') }}
        </x-nav-link>

        @if (access()->allow('case_worker'))
            <x-nav-link href="{{ route('gbv.incident.index') }}" :active="request()->routeIs('backend.incident.index')" class="flex items-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                <i class="fas fa-users mr-3 text-gray-600 dark:text-gray-300"></i>
                {{ __('Incidents') }}
            </x-nav-link>

            <x-nav-link href="{{ route('gbv.incident.reports') }}" :active="request()->routeIs('backend.incident.reports')" class="flex items-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                <i class="fas fa-users mr-3 text-gray-600 dark:text-gray-300"></i>
                {{ __('Reports') }}
            </x-nav-link>

            <x-nav-link href="{{ route('backend.user') }}" :active="request()->routeIs('backend.user')" class="flex items-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                <i class="fas fa-users mr-3 text-gray-600 dark:text-gray-300"></i>
                {{ __('Reporter') }}
            </x-nav-link>
        @endif

        <!-- Collapse Menu for Settings -->
        <div class="Collapse-relative">
            <button class="flex items-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700 w-full text-left {{ $isSettingsActive ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                <i class="fas fa-cogs mr-3 text-gray-600 dark:text-gray-300"></i>
                {{ __('Settings') }}
                <i class="fas fa-chevron-down ml-auto"></i>
            </button>

            <div class="collapse-content {{ $isSettingsActive ? '!block' : 'hidden' }} mt-1 pl-6">
                <x-nav-link href="{{ route('backend.role.index') }}" :active="request()->routeIs('backend.role.index')" class="flex text-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i class="fas fa-users mr-3 text-gray-600 dark:text-gray-300"></i> {{ __('Roles') }}
                </x-nav-link>
                <x-nav-link href="{{ route('backend.permission.index') }}" :active="request()->routeIs('backend.permission.index')" class="flex text-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i class="fas fa-key mr-3 text-gray-600 dark:text-gray-300"></i>  {{ __('Permission') }}
                </x-nav-link>
                <x-nav-link href="{{ route('backend.audit.index') }}" :active="request()->routeIs('backend.audit.index')" class="flex text-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i class="fas fa-database mr-3 text-gray-600 dark:text-gray-300"></i> {{ __('System logs') }}
                </x-nav-link>
                <x-nav-link href="{{ route('backend.logs.index') }}" :active="request()->routeIs('backend.logs.index')" class="flex text-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i class="fas fa-database mr-3 text-gray-600 dark:text-gray-300"></i> {{ __('Developer logs') }}
                </x-nav-link>
            </div>
        </div>


        <div class="user-info absolute bottom-0 left-0 px-3 py-2 flex justify-center w-64">
            <button id="dropdownButton" class="flex items-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700 flex-grow bg-gray-100 dark:bg-gray-900">
                <!-- Avatar -->
                <div class="flex items-center justify-center w-8 h-8 bg-gray-500 text-white rounded-full overflow-hidden">
                    @if(user()->profile_photo_path)
                        <img src="{{ user()->profile_photo_url }}" alt="Profile Image" class="w-full h-full object-cover">
                    @else
                        <span>{{ initials() }}</span>
                    @endif
                </div>
                <span class="ml-3 flex-grow text-left">{{ userFullName() }}</span>
                <i class="fas fa-chevron-up ml-2"></i>
            </button>


            <div id="dropdownMenu" class="absolute left-0 right-0 bg-white dark:bg-gray-800 shadow-lg rounded mb-1 bottom-full hidden transition-all duration-300 ease-in-out opacity-0">
                <a href="{{ route('backend.profile.show') }}" class="block py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-center">
                    <i class="fas fa-user ml-auto"></i> {{ __('My account') }}
                </a>
                <a href="{{ route('backend.my_logs.index') }}" class="block py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-center">
                    <i class="fas fa-database ml-auto"></i> {{ __('My logs') }}
                </a>

                <form method="POST" action="{{ route('logout') }}" class="block py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-danger" x-data>
                    @csrf
                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="text-center">
                        <i class="fas fa-arrow-left ml-auto"></i>
                        {{ __('Logout') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>
    </nav>
</aside>
