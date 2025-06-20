<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('dark') === 'true' }" :class="{ 'dark': darkMode }" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'GBV-Reporting System'))</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/css/tom-select.css" rel="stylesheet">

    @stack('after-styles')
    <style>
        /* Override DataTables styles */
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
        .customizer-setting {
            position: fixed;
            bottom: 40%;
            right: 0;
            z-index: 1000;
        }
        .customizer-setting .bg-blue-500 {
            writing-mode: vertical-rl;
        }
        /* DataTables customization */
        .dataTables_wrapper .dataTables_filter input {
            margin-left: 0.5em;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
        }
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-200" x-data="{ sidebarOpen: false }">

