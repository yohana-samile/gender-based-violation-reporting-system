<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('dark') === 'true' }" :class="{ 'dark': darkMode }" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'NEXTHOST Email Manager'))</title>

    <link rel="stylesheet" href="{{ asset('asset/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/packages/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('asset/css/packages/select2.min.css')}}">
    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('after-styles')
    <style>
        .customizer-setting {
            position: fixed;
            bottom: 40%;
            right: 0;
            z-index: 1000;
        }
        .customizer-setting .bg-blue-500 {

            writing-mode: vertical-rl;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-200" x-data="{ sidebarOpen: false }">

