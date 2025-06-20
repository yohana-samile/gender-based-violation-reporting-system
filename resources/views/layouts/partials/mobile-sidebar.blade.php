<div class="relative z-20">
    <div x-show="sidebarOpen" class="fixed inset-0 flex z-40 md:hidden" x-cloak>
        <div class="fixed inset-0" @click="sidebarOpen = false">
            <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
        </div>

        <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white"
             x-show="sidebarOpen"
             @click.away="sidebarOpen = false"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">

            <div class="absolute top-0 right-0 -mr-14 p-1">
                <button @click="sidebarOpen = false" class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>

            <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                <div class="flex-shrink-0 flex items-center px-4">
                    <i class="fas fa-shield-alt text-blue-600 text-xl mr-2"></i>
                    <span class="text-lg font-semibold text-gray-800">IncidentSafe</span>
                </div>
                <nav class="mt-5 px-2 space-y-1">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-base font-medium rounded-md">
                        <i class="fas fa-home {{ request()->routeIs('dashboard') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('gbv.incident.index') }}" class="{{ request()->routeIs('incident.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-base font-medium rounded-md">
                        <i class="fas fa-list {{ request()->routeIs('incident.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3"></i>
                        Incidents
                    </a>
                    <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-base font-medium rounded-md">
                        <i class="fas fa-users text-gray-400 group-hover:text-gray-500 mr-3"></i>
                        Cases
                    </a>
                    <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-base font-medium rounded-md">
                        <i class="fas fa-chart-bar text-gray-400 group-hover:text-gray-500 mr-3"></i>
                        Reports
                    </a>
                </nav>
            </div>

            <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                        <p class="text-xs font-medium text-gray-500">{{ Auth::user()->role }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
