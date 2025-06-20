@include('includes.resources.header_resources')
<div x-data="{ sidebarOpen: window.innerWidth >= 768 }" @resize.window="sidebarOpen = window.innerWidth >= 768">
    <x-sidebar />
    <main class="p-5 md:ml-64 transition-all duration-300">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-900 dark:text-white mb-4 block md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render() }}
        @yield('content')
        <x-back-to-top />
    </main>
</div>
@include('includes.resources.footer_resources')
