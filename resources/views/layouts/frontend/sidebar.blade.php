<aside :class="sidebarOpen ? 'block' : 'hidden'" class="w-64 bg-white dark:bg-gray-800 p-5 md:block fixed left-0 top-0 h-full overflow-y-auto shadow-lg z-50">
    <div class="shrink-0 flex items-center">
        <a href="{{ route('frontend.dashboard') }}">
            <x-application-logo class="block h-9 w-auto" />
        </a>
    </div>
    <div>
        <x-dark-or-right-mode />
    </div>

    <nav class="mt-5">
        <x-nav-link href="{{ route('frontend.dashboard') }}" :active="request()->routeIs('frontend.dashboard')" class="flex items-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
            <i class="fas fa-tachometer-alt mr-3 text-gray-600 dark:text-gray-300"></i>
            {{ __('label.dashboard') }}
        </x-nav-link>

        <x-nav-link href="{{ route('frontend.domain.index') }}" :active="request()->routeIs('frontend.domain')" class="flex items-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
            <i class="fas fa-database mr-3 text-gray-600 dark:text-gray-300"></i>
            {{__('label.domain')}}
        </x-nav-link>

        <x-nav-link href="{{ route('frontend.email.managers') }}" :active="request()->routeIs('frontend.email.managers')" class="flex items-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
            <i class="fas fa-envelope mr-3 text-gray-600 dark:text-gray-300"></i>
            {{ __('label.email_managers') }}
        </x-nav-link>

        <!-- Collapse Menu for Settings -->
        {{--            <div class="Collapse-relative">--}}
        {{--                <button class="flex items-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700 w-full text-left">--}}
        {{--                    <i class="fas fa-cogs mr-3 text-gray-600 dark:text-gray-300"></i>--}}
        {{--                    {{__('label.setting')}}--}}
        {{--                    <i class="fas fa-chevron-down ml-auto"></i>--}}
        {{--                </button>--}}
        {{--                <div class="collapse-content hidden mt-1">--}}
        {{--                    <x-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="flex items-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700">--}}
        {{--                        {{__('label.account_setting')}}--}}
        {{--                    </x-nav-link>--}}
        {{--                </div>--}}
        {{--            </div>--}}


        <!-- User Info with Avatar and Dropdown at the Bottom -->
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

            <!-- Dropdown menu -->
            <div id="dropdownMenu" class="absolute left-0 right-0 bg-white dark:bg-gray-800 shadow-lg rounded mb-1 bottom-full hidden transition-all duration-300 ease-in-out opacity-0">
                <a href="{{ route('frontend.profile.show') }}" class="block py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-center">
                    <i class="fas fa-user ml-auto"></i> {{ __('label.my_account') }}
                </a>
                <a href="{{ route('frontend.my_logs.index') }}" class="block py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-center">
                    <i class="fas fa-database ml-auto"></i> {{ __('label.my_logs') }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-danger" x-data>
                    @csrf
                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="text-center">
                        <i class="fas fa-arrow-left ml-auto"></i>
                        {{ __('label.action_crud.logout') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>
    </nav>
</aside>
