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
    <div class="w-full max-w-4xl p-6 bg-cover bg-center rounded-lg shadow-lg" style="background-image: url('/asset/img/new_logo_web.png');">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
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
            <div class="flex justify-center">
                <div class="bg-white rounded-lg shadow-lg p-6 lg:p-10">
                    <div class="text-center">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('asset/img/sbg.jpg') }}" alt="gbv-logo" class="h-20 mx-auto">
                        </a>
                    </div>
                    <div class="mt-6 text-center">
                        <img src="{{ asset('asset/img/auth/404-4.png') }}" class="mx-auto w-48" alt="404">
                    </div>
                    <div class="mt-6 text-center">
                        <h4 class="text-2xl font-bold uppercase">Oops, page not found</h4>
                        <p class="text-gray-600 mt-3">It seems you’ve hit a dead end. Let’s get you back on track.</p>
                        <a href="{{ url('/') }}" class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                            <i class="mdi mdi-home mr-2"></i>Back to home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
