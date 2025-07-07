<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GBV Reporting System') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body lang="en" class="h-full bg-gray-100">
<section class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-2xl bg-white shadow-lg rounded-lg p-6 lg:p-8">
        <div class="hidden sm:block xl:col-span-2">
            <div class="flex flex-col h-full justify-between">
                <div>
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('asset/img/sbg.jpg') }}" alt="Logo" class="h-8">
                    </a>
                </div>
                <div class="text-center my-auto">
                    <img src="{{ asset('asset/img/sbg.jpg') }}" alt="" class="w-full max-w-xs mx-auto">
                </div>
                <div class="text-center mt-auto">
                    <p class="text-sm">© 2025 GBV Reporting System™. All Rights Reserved.</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-6">
            <h4 class="text-2xl font-semibold uppercase text-red-600">Unauthorized Access</h4>
            <p class="text-gray-600 mt-2">You are not authorized to view this page.</p>
            <div class="mt-4">
                <a href="{{ url('/') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</section>
</body>
</html>
