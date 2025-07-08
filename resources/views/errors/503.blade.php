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
    <div class="w-full max-w-5xl bg-cover bg-center p-6 lg:p-8 rounded-lg shadow-lg" style="background-image: url('/asset/img/new_logo_web.png');">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-center">
            <div class="hidden sm:block xl:col-span-2">
                <div class="flex flex-col h-full justify-between">
                    <div>
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('asset/img/sbg.jpg') }}" alt="Logo" class="h-8">
                        </a>
                    </div>
                    <div class="text-center my-auto">
                        <img src="{{ asset('/asset/img/sbg.jpg') }}" alt="" class="w-full max-w-xs mx-auto">
                    </div>
                    <div class="text-center mt-auto">
                        <p class="text-sm">© 2025 GBV Reporting System™. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
            <div class="mx-auto xl:col-span-1">
                <div class="bg-white shadow-lg rounded-lg p-6 lg:p-8">
                    <div class="text-center">
                        <a href="{{ route('home') }}" class="block mb-6">
                            <img src="{{ asset('/asset/img/sbg.jpg') }}" alt="" class="h-10 mx-auto">
                        </a>
                    </div>
                    <div class="text-center px-6">
                        <img src="{{ asset('build/images/auth/503.png') }}" class="w-full max-w-xs mx-auto" alt="503 Error">
                    </div>
                    <div class="mt-6 text-center">
                        <h4 class="text-2xl font-semibold uppercase">Service Unavailable</h4>
                        <p class="text-gray-600 mt-2">The service is temporarily unavailable, try again later!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
