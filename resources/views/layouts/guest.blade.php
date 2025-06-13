<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('dark') === 'true' }" :class="{ 'dark': darkMode }" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'NEXTHOST Email Manager'))</title>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css')}}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-200" x-data="{ sidebarOpen: false }">
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
        <footer class="fixed bottom-0 left-0 z-20 w-full p-4 bg-white border-t border-gray-200 shadow-sm md:flex md:items-center md:justify-between md:p-6 dark:bg-gray-800 dark:border-gray-600">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ now()->year }} <a href="https://nextbyte.co.tz/" class="hover:underline">GSB™</a>. All Rights Reserved.
            </span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                <li>
                    <p class="font-bold">
                        {{__('Handcrafted by')}}
                        <span class="hover:underline me-4 md:me-6 text-yellow-500"> <a href="https://nexthost.co.tz/" class="btn btn-link">{{__('Amina.')}}</a> </span>
                    </p>
                </li>
                <li>
                    <p class="font-bold">
                        {{__('Powered by')}}
                        <span class="hover:underline text-yellow-500"> <a href="https://gsb.co.tz/" class="btn btn-link">{{__('Gender-Based Violations Reporting System.')}}</a> </span>
                    </p>
                </li>
            </ul>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const darkMode = localStorage.getItem('dark') === 'true';

            // Set initial state based on localStorage
            if (darkMode) {
                document.documentElement.classList.add('dark');
                document.getElementById('dark-icon').style.display = 'inline';
                document.getElementById('light-icon').style.display = 'none';
            } else {
                document.documentElement.classList.remove('dark');
                document.getElementById('dark-icon').style.display = 'none';
                document.getElementById('light-icon').style.display = 'inline';
            }
        });

        function toggleDarkMode() {
            const isDarkMode = document.documentElement.classList.contains('dark');
            const darkMode = !isDarkMode;

            // Set dark mode state in localStorage
            localStorage.setItem('dark', darkMode);

            // Toggle the dark mode class on the <html> element
            if (darkMode) {
                document.documentElement.classList.add('dark');
                document.getElementById('dark-icon').style.display = 'inline';
                document.getElementById('light-icon').style.display = 'none';
            } else {
                document.documentElement.classList.remove('dark');
                document.getElementById('dark-icon').style.display = 'none';
                document.getElementById('light-icon').style.display = 'inline';
            }
        }
    </script>
    @livewireScripts
</body>
</html>
