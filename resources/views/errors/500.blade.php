<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'NEXTHOST Email Manager') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body lang="en" x-data="{ darkMode: localStorage.getItem('dark') === 'true' }" :class="{ 'dark': darkMode }" class="h-full">
        <section class="flex items-center justify-center min-h-screen p-4 bg-gray-100">
            <div class="w-full max-w-5xl bg-cover bg-center p-6 lg:p-8 rounded-lg shadow-lg" style="background-image: url('/asset/img/new_logo_web.png');">
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-center">
                    <div class="hidden sm:block xl:col-span-2">
                        <div class="flex flex-col h-full justify-between">
                            <div>
                                <a href="{{ url('/') }}">
                                    <img src="{{ URL::asset('asset/img/nexthost_N.png') }}" alt="Logo" class="h-8">
                                </a>
                            </div>
                            <div class="text-center my-auto">
                                <img src="{{ URL::asset('/asset/img/logo.png') }}" alt="" class="w-full max-w-xs mx-auto">
                            </div>
                            <div class="text-center mt-auto">
                                <p class="text-sm">© 2025 Nextbyte™. All Rights Reserved.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mx-auto xl:col-span-1">
                        <div class="bg-white shadow-lg rounded-lg p-6 lg:p-8">
                            <div class="text-center">
                                <a href="{{ url('/') }}" class="block mb-6">
                                    <img src="{{ URL::asset('/asset/img/new_logo_web.png') }}" class="h-10 mx-auto">
                                </a>
                            </div>
                            <div class="text-center px-6">
                                <img src="{{ URL::asset('asset/img/auth/500.png') }}" class="w-full max-w-xs mx-auto" alt="500 Error">
                            </div>
                            <div class="mt-6 text-center">
                                <h4 class="text-2xl font-semibold uppercase">Internal Server Error</h4>
                                <p class="text-gray-600 mt-2">It seems you’ve hit a dead end. Let’s get you back on track.</p>
                                <div class="mt-4">
                                    <a href="{{ url('/') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition inline-flex items-center">
                                        <i class="mdi mdi-home mr-2"></i> Back to home
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>

