<html lang="en" class="light scroll-smooth" dir="ltr"><head>
    <meta charset="utf-8">
    <title>Gender-Based Violations Reporting System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="" name="Gender Based Violation System">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="{{ asset('asset/css/tailwind.min.css')}}">
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white">
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-blue-600">Gender-Based Violations Reporting System</h1>
                <div>
                    <a href="{{ route('gbv.dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 mr-4 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="text-white bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">Register</a>
                </div>
            </div>
        </header>

        <div x-data="{
                baseUrl: '{{ asset('asset/img') }}/',
                activeSlide: 0,
                slides: ['sbg.jpg', 'sbg2.jpg', 'sbg3.jpg']
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
        <h2 class="main-title text-center text-4xl font-bold text-primary-600">Gender-Based Violations Reporting System</h2>
        <h4 class="my-4 text-[30px] md:text-[40px] font-semibold leading-tight dark:text-slate-200">Report and Track Gender-Based Violence Incidents</h4>
        <h6 class="text-gray-600 dark:text-gray-400 text-lg font-medium mb-10">
            A safe and secure platform to report, monitor, and address gender-based violence in your community.
        </h6>
    </div>

        <div class="flex flex-col">
            <div class="relative w-full py-[70px]">
                <div class="container z-1">
                    <div class="grid grid-cols-12 sm:grid-cols-12 md:grid-cols-12 lg:grid-cols-12 xl:grid-cols-12 gap-4 mb-4 justify-center">
                        <div class="col-span-12 sm:col-span-12  md:col-span-12 lg:col-span-12 xl:col-span-12 ">
                            <div class=" w-full relative mb-10">
                                <div class="flex-auto p-4">
                                    <h2 class="main-title text-center">Services</h2>
                                    <div class="text-center mb-5 -mt-10">
                                        <h4 class="my-1 font-semibold text-[30px] md:text-[40px] dark:text-slate-200 mb-5 leading-12">Services Section For Everyone</h4>
                                        <h6 class="text-gray-500 dark:text-gray-400 text-lg font-medium">Lorem Ipsum is simply dummy text of the printing <br> and typesetting industry.</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 sm:grid-cols-12 md:grid-cols-12 lg:grid-cols-12 xl:grid-cols-12 gap-4 mb-4 items-center">
                        <div class="col-span-12 sm:col-span-12  md:col-span-6 lg:col-span-4 xl:col-span-4 me-0 md:me-0 lg:-me-7 xl:-me-7">
                            <div class="bg-white dark:bg-gray-800/40  rounded-md w-full relative transform translate-y-0 hover:-translate-y-4 duration-500 ease-in-out mb-8 sm:mb-8 lg:mb-0">
                                        <span class="inline-flex absolute left-[50%] start-[50%] -translate-x-[50%] -translate-y-[50%] justify-center items-center h-[80px] w-[80px] rounded-full bg-primary-50 dark:bg-gray-900 border-[5px] border-solid border-white dark:border-slate-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="target" class="lucide lucide-target h-9 w-9 stroke-primary-500"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                                        </span>
                                <div class="flex-auto text-center p-8 md:p-14">
                                    <h2 class="font-bold text-2xl capitalize tracking-wide text-center my-4 text-gray-800 dark:text-white">
                                        Creativity
                                    </h2>
                                    <div class="text-center text-slate-700 dark:text-slate-400 text-lg">
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                                    </div>
                                    <div class="block mt-5">
                                        <button class=" hover:text-white
                                                 text-primary-500 hover:bg-primary-500 bg-primary-500/5 text-base
                                                font-medium py-[6px] px-5 rounded-full print:hidden">
                                            Read More
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-12  md:col-span-6 lg:col-span-4 xl:col-span-4 z-2">
                            <div class="bg-primary dark:bg-primary border border-slate-200 dark:border-slate-700/40  rounded-md w-full relative mb-8 sm:mb-8 lg:mb-0">
                                        <span class="inline-flex absolute left-[50%] start-[50%] -translate-x-[50%] -translate-y-[50%] justify-center items-center h-[80px] w-[80px] rounded-full bg-primary-50 dark:bg-primary-50 border-[5px] border-solid border-white dark:border-slate-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="squirrel" class="lucide lucide-squirrel h-9 w-9 stroke-primary-500"><path d="M18 6a4 4 0 0 0-4 4 7 7 0 0 0-7 7c0-5 4-5 4-10.5a4.5 4.5 0 1 0-9 0 2.5 2.5 0 0 0 5 0C7 10 3 11 3 17c0 2.8 2.2 5 5 5h10"></path><path d="M16 20c0-1.7 1.3-3 3-3h1a2 2 0 0 0 2-2v-2a4 4 0 0 0-4-4V4"></path><path d="M15.2 22a3 3 0 0 0-2.2-5"></path><path d="M18 13h.01"></path></svg>
                                        </span>
                                <div class="flex-auto text-center p-8 md:p-14">
                                    <h2 class="font-bold text-2xl capitalize tracking-wide text-center my-4 text-white dark:text-white">
                                        Development
                                    </h2>
                                    <div class="text-center text-slate-200 text-lg">
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                                    </div>
                                    <div class="block mt-5">
                                        <button class=" hover:text-primary-500
                                                 text-primary-500 hover:bg-white bg-primary-100 text-base
                                                font-medium py-[6px] px-5 rounded-full print:hidden">
                                            Read More
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-12  md:col-span-6 lg:col-span-4 xl:col-span-4 me-0 md:me-0 lg:-me-7 xl:-me-7">
                            <div class="bg-white dark:bg-gray-800/40  rounded-md w-full relative transform translate-y-0 hover:-translate-y-4 duration-500 ease-in-out mb-8 sm:mb-8 lg:mb-0">
                                        <span class="inline-flex absolute left-[50%] start-[50%] -translate-x-[50%] -translate-y-[50%] justify-center items-center h-[80px] w-[80px] rounded-full bg-primary-50 dark:bg-gray-900 border-[5px] border-solid border-white dark:border-slate-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="webcam" class="lucide lucide-webcam h-9 w-9 stroke-primary-500"><circle cx="12" cy="10" r="8"></circle><circle cx="12" cy="10" r="3"></circle><path d="M7 22h10"></path><path d="M12 22v-4"></path></svg>
                                        </span>
                                <div class="flex-auto text-center p-8 md:p-14">
                                    <h2 class="font-bold text-2xl capitalize tracking-wide text-center my-4 text-gray-800 dark:text-white">
                                        Management
                                    </h2>
                                    <div class="text-center text-slate-700 dark:text-slate-400 text-lg">
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                                    </div>
                                    <div class="block mt-5">
                                        <button class=" hover:text-white
                                                 text-primary-500 hover:bg-primary-500 bg-primary-500/5 text-base
                                                font-medium py-[6px] px-5 rounded-full print:hidden">
                                            Read More
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('slider', () => ({
                    activeSlide: 0,
                    slides: ['sbg.jpg', 'sbg2.jpg', 'sbg2.jpg'],
                    init() {
                        setInterval(() => {
                            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                        }, 4000);
                    }
                }));
            });
        </script>

        <!-- <div class="menu-overlay"></div> -->
        <script src="{{ asset('asset/js/simplebar.min.js')}}"></script>
        <script src="{{ asset('asset/js/lucide.min.js')}}"></script>
        <script src="{{ asset('asset/js/app.js')}}"></script>
    </body>
</html>
