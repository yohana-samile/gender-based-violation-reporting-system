@php
    $settingsRoutes = [
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'GBV-Reporting System'))</title>

        <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @livewireStyles
    @stack('after-styles')
    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            @apply text-gray-600;
        }

        .dataTables_wrapper .dataTables_length select {
            @apply border border-gray-300 rounded px-2 py-1 text-sm;
        }

        .dataTables_wrapper .dataTables_filter input {
            @apply border border-gray-300 rounded px-2 py-1 ml-2 text-sm;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply px-3 py-1 mx-1 border border-gray-300 rounded;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-blue-500 text-white border-blue-500;
        }
        .sidebar-transition {
            transition: all 0.3s ease;
        }
        .prose {
            line-height: 1.6;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: window.innerWidth > 768 }">
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 z-20 bg-gray-900 bg-opacity-50 md:hidden"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak>
    </div>

    <div class="fixed inset-y-0 left-0 z-30 w-64 transform bg-white shadow-lg transition-all duration-300"
         :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
         @click.away="if (window.innerWidth < 768) sidebarOpen = false">

        <!-- Sidebar Header -->
        <div class="flex items-center justify-between h-16 px-4 bg-blue-600">
            <div class="flex items-center">
                <i class="fas fa-shield-alt text-white text-xl mr-2"></i>
                <span class="text-lg font-semibold text-white">GBV-Reporting System</span>
            </div>
            <button @click="sidebarOpen = false" class="md:hidden text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Sidebar Content -->
        <div class="h-full overflow-y-auto flex flex-col">
            <nav class="px-4 py-4 flex-1">
                <div class="space-y-1">
                    <x-nav-link href="{{ route('backend.dashboard') }}" :active="request()->routeIs('backend.dashboard')" class="flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-100 rounded-md group">
                        <i class="fas fa-home mr-3 text-blue-600"></i>
                        Dashboard
                    </x-nav-link>
                    @if (access()->allow('case_worker'))
                        <x-nav-link href="{{ route('backend.incident.index') }}" :active="request()->routeIs('gbv.incident.index')" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md group">
                            <i class="fas fa-list mr-3 text-gray-400 group-hover:text-blue-600"></i>
                            Incidents
                        </x-nav-link>
                        <x-nav-link href="{{ route('backend.report.reports') }}" :active="request()->routeIs('gbv.report.reports')" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md group">
                            <i class="fas fa-chart-bar mr-3 text-gray-400 group-hover:text-blue-600"></i>
                            Reports
                        </x-nav-link>
                    @endif

                    @if (access()->allow('all_functions'))
                        <x-nav-link href="{{ route('backend.user') }}" :active="request()->routeIs('backend.user')" class="flex items-center py-2 px-3 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                            <i class="fas fa-users mr-3 text-gray-600 dark:text-gray-300"></i>
                            {{ __('Users') }}
                        </x-nav-link>
                    @endif
                </div>


                <!-- Settings Dropdown -->
                @if (access()->allow('all_functions'))
                    <div class="mt-8" x-data="{ settingsOpen: {{ $isSettingsActive ? 'true' : 'false' }} }">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Settings</h3>
                        <div class="mt-1 space-y-1">
                            <button @click="settingsOpen = !settingsOpen"
                                    class="flex items-center w-full px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md group transition">
                                <i class="fas fa-cogs mr-3 text-gray-400 group-hover:text-blue-600"></i>
                                <span class="flex-1 text-left">Settings</span>
                                <i class="fas fa-chevron-down ml-2 text-gray-400 text-xs transition-transform duration-200"
                                   :class="{ 'transform rotate-180': settingsOpen }"></i>
                            </button>

                            <div x-show="settingsOpen" x-collapse class="pl-8 space-y-1">
                                <x-nav-link href="{{ route('backend.role.index') }}"
                                            :active="request()->routeIs('backend.role.index')"
                                            class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md group">
                                    <i class="fas fa-users mr-3 text-gray-400 group-hover:text-blue-600"></i>
                                    {{ __('Roles') }}
                                </x-nav-link>

                                <x-nav-link href="{{ route('backend.permission.index') }}"
                                            :active="request()->routeIs('backend.permission.index')"
                                            class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md group">
                                    <i class="fas fa-key mr-3 text-gray-400 group-hover:text-blue-600"></i>
                                    {{ __('Permission') }}
                                </x-nav-link>

                                <x-nav-link href="{{ route('backend.audit.index') }}"
                                            :active="request()->routeIs('backend.audit.index')"
                                            class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md group">
                                    <i class="fas fa-database mr-3 text-gray-400 group-hover:text-blue-600"></i>
                                    {{ __('System logs') }}
                                </x-nav-link>

                                <x-nav-link href="{{ route('backend.logs.index') }}"
                                            :active="request()->routeIs('backend.logs.index')"
                                            class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md group">
                                    <i class="fas fa-database mr-3 text-gray-400 group-hover:text-blue-600"></i>
                                    {{ __('Developer logs') }}
                                </x-nav-link>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- User Dropdown within navigation -->
                <div class="mt-8">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Account</h3>
                    <div class="mt-1 space-y-1">
                        <div class="relative" x-data="{ dropdownOpen: false }">
                            <button @click="dropdownOpen = !dropdownOpen"
                                    class="flex items-center w-full px-4 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md group transition">
                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium mr-3">
                                    @if(user()->profile_photo_path)
                                        <img src="{{ user()->profile_photo_url }}" alt="Profile Image" class="w-full h-full object-cover rounded-full">
                                    @else
                                        <span>{{ initials() }}</span>
                                    @endif
                                </div>
                                <span class="truncate">{{ userFullName() }}</span>
                                <i class="fas fa-chevron-down ml-auto text-gray-400 text-xs"
                                   :class="{ 'transform rotate-180': dropdownOpen }"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="dropdownOpen"
                                 @click.away="dropdownOpen = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute left-0 right-0 mt-1 bg-white shadow-lg rounded-md overflow-hidden z-10 border border-gray-200">
                                <a href="{{ route('backend.profile.show') }}"
                                   class="flex items-center py-2 px-4 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-3 text-gray-400"></i> My Account
                                </a>
                                <a href="{{ route('backend.my_logs.index') }}"
                                   class="flex items-center py-2 px-4 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-database mr-3 text-gray-400"></i> My Logs
                                </a>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-left flex items-center py-2 px-4 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>


    <div class="md:pl-64">
        <div class="sticky top-0 z-10 bg-white shadow-sm">
            <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                <!-- Left side - Hamburger menu -->
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <!-- Right side - Notification and User dropdown -->
                <div class="flex items-center space-x-4">
                    <button class="p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="sr-only">View notifications</span>
                        <i class="fas fa-bell"></i>
                    </button>

                    <div class="relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <span class="sr-only">Open user menu</span>
                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium">
                                    @if(user()->profile_photo_path)
                                        <img src="{{ user()->profile_photo_url }}" alt="Profile Image" class="w-full h-full object-cover rounded-full">
                                    @else
                                        <span>{{ initials() }}</span>
                                    @endif
                                </div>
                            </button>
                        </div>
                        <div x-show="open" @click.away="open = false"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                             role="menu" x-cloak>
                            <a href="{{ route('backend.profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                <i class="fas fa-user mr-2"></i> Your Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main class="py-6 px-4 sm:px-6 lg:px-8">
            {{ \Diglactic\Breadcrumbs\Breadcrumbs::render() }}
            <div class="flash-messages">
                @if(session()->has('success'))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                @if(session()->has('warning'))
                    <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
                        {{ session('warning') }}
                    </div>
                @endif
            </div>
            @yield('content')
            <x-back-to-top />
        </main>
    </div>

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.delete-form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });

            @if(session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: @json(session('error')),
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @livewireScripts
    @stack('after-scripts')
    </body>
</html>
