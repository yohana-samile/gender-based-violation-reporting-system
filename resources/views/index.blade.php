<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Gender-Based Violations Reporting System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Gender Based Violation System" name="description">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="{{ asset('asset/css/tailwind.min.css')}}">
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-white shadow">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">Gender-Based Violations Reporting System</h1>
            <div>
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 mr-4 font-medium">Login</a>
                <a href="{{ route('register') }}" class="text-white bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">Register</a>
            </div>
        </div>
    </header>

    <div x-data="{
                baseUrl: '{{ asset('asset/img') }}/',
                activeSlide: 0,
                slides: ['sbg3.jpg', 'sbg2.jpg', 'sbg.jpg']
            }" class="relative w-full mb-12">

                <div class="overflow-hidden w-full">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="activeSlide === index" class="transition-all duration-700 ease-in-out">
                            <img :src="baseUrl + slide"
                                 alt="Gender-Based Violence Slide"
                                 class="w-full h-45 object-cover">
                        </div>
                    </template>
                </div>

        <!-- Dots Navigation -->
        <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index"
                        :class="activeSlide === index ? 'bg-blue-600' : 'bg-gray-300'"
                        class="w-4 h-4 rounded-full transition-colors duration-300">
                </button>
            </template>
        </div>
    </div>

    <div class="container mx-auto px-4 py-20 text-center">
        <h2 class="text-4xl font-bold text-blue-600">Gender-Based Violations Reporting System</h2>
        <h4 class="my-4 text-3xl md:text-4xl font-semibold leading-tight">Report and Track Gender-Based Violence Incidents</h4>
        <h6 class="text-gray-600 text-lg font-medium mb-10">
            A safe and secure platform to report, monitor, and address gender-based violence in your community.
        </h6>
    </div>

    <div class="flex flex-col items-center">
        <div class="w-full py-16">
            <div class="container mx-auto px-4">
                <!-- Heading Section -->
                <div class="w-full text-center mb-12">
                    <h2 class="text-3xl font-bold text-blue-600 mb-4">Services</h2>
                    <h3 class="text-3xl md:text-4xl font-semibold mb-4">Services Section For Everyone</h3>
                    <p class="text-gray-500 text-lg max-w-2xl mx-auto">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </p>
                </div>

                <!-- Services Cards -->
                <div class="flex flex-col md:flex-row justify-center gap-8">
                    <!-- Service Card 1 -->
                    <div class="bg-white rounded-lg shadow-md w-full max-w-sm relative transform hover:-translate-y-2 transition-transform duration-300">
                        <div class="flex flex-col items-center pt-16 pb-8 px-6">
                        <span class="absolute -top-10 flex items-center justify-center h-20 w-20 rounded-full bg-blue-50 border-4 border-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-9 w-9 stroke-blue-500">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="12" r="6"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                            </svg>
                        </span>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Creativity</h3>
                            <p class="text-gray-600 text-center mb-6">
                                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                            </p>
                            <button class="text-blue-500 hover:text-white hover:bg-blue-500 bg-blue-100 font-medium py-2 px-5 rounded-full transition-colors duration-300">
                                Read More
                            </button>
                        </div>
                    </div>

                    <!-- Service Card 2 -->
                    <div class="bg-blue-600 rounded-lg shadow-md w-full max-w-sm relative z-10">
                        <div class="flex flex-col items-center pt-16 pb-8 px-6">
                        <span class="absolute -top-10 flex items-center justify-center h-20 w-20 rounded-full bg-blue-100 border-4 border-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-9 w-9 stroke-blue-500">
                                <path d="M18 6a4 4 0 0 0-4 4 7 7 0 0 0-7 7c0-5 4-5 4-10.5a4.5 4.5 0 1 0-9 0 2.5 2.5 0 0 0 5 0C7 10 3 11 3 17c0 2.8 2.2 5 5 5h10"></path>
                                <path d="M16 20c0-1.7 1.3-3 3-3h1a2 2 0 0 0 2-2v-2a4 4 0 0 0-4-4V4"></path>
                                <path d="M15.2 22a3 3 0 0 0-2.2-5"></path>
                                <path d="M18 13h.01"></path>
                            </svg>
                        </span>
                            <h3 class="text-2xl font-bold text-white mb-4">Development</h3>
                            <p class="text-blue-100 text-center mb-6">
                                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                            </p>
                            <button class="text-blue-500 hover:bg-white bg-blue-100 font-medium py-2 px-5 rounded-full transition-colors duration-300">
                                Read More
                            </button>
                        </div>
                    </div>

                    <!-- Service Card 3 -->
                    <div class="bg-white rounded-lg shadow-md w-full max-w-sm relative transform hover:-translate-y-2 transition-transform duration-300">
                        <div class="flex flex-col items-center pt-16 pb-8 px-6">
                        <span class="absolute -top-10 flex items-center justify-center h-20 w-20 rounded-full bg-blue-50 border-4 border-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-9 w-9 stroke-blue-500">
                                <circle cx="12" cy="10" r="8"></circle>
                                <circle cx="12" cy="10" r="3"></circle>
                                <path d="M7 22h10"></path>
                                <path d="M12 22v-4"></path>
                            </svg>
                        </span>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Management</h3>
                            <p class="text-gray-600 text-center mb-6">
                                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                            </p>
                            <button class="text-blue-500 hover:text-white hover:bg-blue-500 bg-blue-100 font-medium py-2 px-5 rounded-full transition-colors duration-300">
                                Read More
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br><br>

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

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('slider', () => ({
                activeSlide: 0,
                slides: ['sbg.jpg', 'sbg2.jpg', 'sbg3.jpg'],
                init() {
                    setInterval(() => {
                        this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                    }, 4000);
                }
            }));
        });
    </script>

    <script src="{{ asset('asset/js/simplebar.min.js')}}"></script>
    <script src="{{ asset('asset/js/lucide.min.js')}}"></script>
    <script src="{{ asset('asset/js/app.js')}}"></script>
</body>
</html>
