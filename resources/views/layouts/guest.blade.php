<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'GBV-Reporting System'))</title>
    <link rel="stylesheet" href="{{ asset('asset/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900" x-data="{ sidebarOpen: false }">
<div class="font-sans text-gray-900 antialiased">
    {{ $slot }}
    <footer class="fixed bottom-0 left-0 z-20 w-full p-4 bg-white border-t border-gray-200 shadow-sm md:flex md:items-center md:justify-between md:p-6">
            <span class="text-sm text-gray-500 sm:text-center">© {{ now()->year }} <a href="https://amina.gbv.com/" class="hover:underline">Ameena™</a>. All Rights Reserved.
            </span>
        <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 sm:mt-0">
            <li>
                <p class="font-bold">
                    {{__('Handcrafted by')}}
                    <span class="hover:underline me-4 md:me-6 text-yellow-500"> <a href="https://amina.gbv.com/" class="btn btn-link">{{__('GBV.')}}</a> </span>
                </p>
            </li>
            <li>
                <p class="font-bold">
                    {{__('Powered by')}}
                    <span class="hover:underline text-yellow-500"> <a href="https://amina.gbv.com/" class="btn btn-link">{{__('GBV-Reporting System.')}}</a> </span>
                </p>
            </li>
        </ul>
    </footer>
</div>
</body>
</html>
