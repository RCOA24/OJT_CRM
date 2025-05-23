<div x-data="{ 
        open: true, 
        mobileOpen: false, 
        activeItem: window.location.pathname 
    }" 
    x-init="$watch('activeItem', val => {
        try { localStorage.setItem('activeItem', val); }
        catch (e) { /* Handle localStorage unavailability silently */ }
    })" 
    class="flex min-h-screen font-montserrat"
>
    <!-- Sidebar / Mobile Navigation -->
    <div 
        :class="open ? 'w-64' : 'w-16'"
        class="hidden md:flex h-screen bg-[#102B3C] shadow-lg transition-all duration-300 flex-col"
    >
        <!-- Sidebar Content -->
        <div class="flex items-center justify-between p-4 border-b space-x-2">
            <span :class="open ? 'block' : 'hidden'" class="transition-all">
                <img src="{{ asset('images/logo.svg') }}" alt="Odecci Logo" class="h-auto">
            </span>
            
            <button @click="open = !open" class="p-2 rounded-md focus:outline-none">
                <svg 
                    class="w-6 h-6 transition-transform transform text-white" 
                    :class="open ? 'rotate-180' : 'rotate-0'" 
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 20 20" 
                    fill="currentColor"
                >
                    <path fill-rule="evenodd" 
                        d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
                        clip-rule="evenodd"
                    />
                </svg>
            </button>
        </div>

        <style>
            /* Fade-in animation for the entire page */
            body {
                opacity: 0;
                transform: translateY(10px);
                animation: fadeIn 0.3s ease-out forwards;
            }
        
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 2;
                    transform: translateY(0);
                }
            }
        </style>
        
        <nav class="flex-1 px-2 py-4 space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
                class="flex items-center px-4 py-2 rounded-lg relative transition-colors duration-300"
                x-bind:class="activeItem.includes('/dashboard') ? 'bg-gray-700 text-[#ED1C24] font-medium' : 'text-white hover:bg-gray-500 hover:text-[#ED1C24]'"
            >
                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center">
                    <x-dashboardicon class="w-6 h-6" x-bind:class="activeItem.includes('/dashboard') ? 'text-[#ED1C24]' : 'text-white'" />
                </span>
                <span x-bind:class="open ? 'ml-2 block' : 'hidden'">Dashboard</span>
            </a>

            <!-- Clients -->
            <div x-data="{ openClients: false }">
                <a href="{{ route('clients.list') }}" 
                   class="flex items-center px-4 py-2 rounded-lg relative transition-colors duration-300 cursor-pointer"
                   x-bind:class="activeItem.includes('/clients') ? 'bg-gray-700 text-[#ED1C24] font-medium' : 'text-white hover:bg-gray-500 hover:text-[#ED1C24]'">
                    <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center">
                        <x-clientsicon class="w-6 h-6 text-white" />
                    </span>
                    <span x-bind:class="open ? 'ml-2 block' : 'hidden'">Clients</span>
                    <svg @click.prevent.stop="openClients = !openClients" 
                         class="w-4 h-4 ml-auto transition-transform transform text-white cursor-pointer" 
                         :class="openClients ? 'rotate-180' : 'rotate-0'" 
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
                <div x-show="openClients" class="ml-8 mt-2 space-y-2 border-l-2 border-gray-500 pl-4" x-cloak>
                    <a href="{{ route('leads.index') }}" 
                       class="block px-4 py-2 rounded-lg text-sm transition-colors duration-300"
                       x-bind:class="activeItem.includes('/leads') ? 'text-[#ED1C24]' : 'text-white hover:bg-gray-500 hover:text-[#ED1C24]'">
                        Lead
                    </a>
                </div>
            </div>

            <!-- Users -->
            <a href="{{ route('users') }}" 
                class="flex items-center px-4 py-2 rounded-lg relative transition-colors duration-300"
                x-bind:class="activeItem.includes('/users') ? 'bg-gray-700 text-[#ED1C24] font-medium' : 'text-white hover:bg-gray-500 hover:text-[#ED1C24]'"
            >
                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center">
                    <x-usersicon class="w-6 h-6" x-bind:class="activeItem.includes('/users') ? 'text-[#ED1C24]' : 'text-white'" />
                </span>
                <span x-bind:class="open ? 'ml-2 block' : 'hidden'">Users</span>
            </a>

            <!-- Task -->
            <a href="{{ route('task') }}" 
                class="flex items-center px-4 py-2 rounded-lg relative transition-colors duration-300"
                x-bind:class="activeItem.includes('/task') ? 'bg-gray-700 text-[#ED1C24] font-medium' : 'text-white hover:bg-gray-500 hover:text-[#ED1C24]'"
            >
                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center">
                    <x-taskicon class="w-6 h-6" x-bind:class="activeItem.includes('/task') ? 'text-[#ED1C24]' : 'text-white'" />
                </span>
                <span x-bind:class="open ? 'ml-2 block' : 'hidden'">Task</span>
            </a>

            <!-- Notifications -->
            <a href="#" 
                class="flex items-center px-4 py-2 rounded-lg relative transition-colors duration-300"
                x-bind:class="activeItem.includes('/notifications') ? 'bg-gray-700 text-[#ED1C24] font-medium' : 'text-white hover:bg-gray-500 hover:text-[#ED1C24]'"
            >
                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center">
                    <x-notificationsicon class="w-6 h-6" x-bind:class="activeItem.includes('/notifications') ? 'text-[#ED1C24]' : 'text-white'" />
                </span>
                <span x-bind:class="open ? 'ml-2 block' : 'hidden'">Notifications</span>
            </a>
        </nav>

        <!-- Profile & Logout -->
        <div class="p-4 mt-auto border-t">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/cha.jpg') }}" class="w-10 h-10 rounded-full">
                <div :class="open ? 'block' : 'hidden'">
                    <h4 class="text-sm font-semibold text-white">
                        {{ session('firstName', 'User') . ' ' . session('lastName', 'Name') }}
                    </h4>
                    <p class="text-xs text-gray-500 text-white break-all">
                        {{ session('email', 'user@email.com') }}
                    </p>
                </div>
            </div>
            <div x-data="{ loggingOut: false }">
                <div x-show="loggingOut" class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-80 z-50">
                    <div class="flex flex-col items-center">
                        <svg class="animate-spin h-12 w-12 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <p class="text-lg font-semibold text-gray-700 mt-3">Logging out...</p>
                    </div>
                </div>
            
                <form method="POST" action="{{ route('logout') }}" @submit="loggingOut = true">
                    @csrf
                    <button type="submit" class="mt-3 flex items-center justify-start px-1 py-2 rounded-lg hover:bg-gray-500 w-full text-white hover:text-[#ED1C24]">
                        <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center">
                            <x-logouticon class="w-6 h-6 text-blue-600" />
                        </span>
                        <span :class="open ? 'ml-2 block' : 'hidden'">Log out</span>
                    </button>
                </form>
            </div>
        </div>
    </div> 

    <!-- Mobile Navbar -->
    <div class="md:hidden fixed top-0 left-0 right-0 bg-[#102B3C] shadow-md z-50">
        <div class="p-4 flex justify-between items-center">
             <!-- Icon Logout -->
             <img src="{{ asset('images/logo.svg') }}" alt="Odecci Logo" class="w-32 h-auto">
             <!-- Button -->
             <button @click="mobileOpen = !mobileOpen" class="p-2 focus:outline-none">
                <svg 
                    class="w-6 h-6 transition-transform transform duration-300 ease-in-out text-white" 
                    :class="mobileOpen ? 'rotate-180' : 'rotate-0'" 
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 24 24" 
                    fill="currentColor"
                >
                <path fill-rule="evenodd" 
                d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" 
                clip-rule="evenodd"
            />
                </svg>
            </button>
        </div>
    </div>

<!-- Light Blurred Background Overlay -->
<div 
    x-show="mobileOpen" 
    class="fixed inset-0 bg-black bg-opacity-20 backdrop-blur-sm z-40 transition-opacity"
    @click="mobileOpen = false">
</div>

<!-- Mobile Sidebar (Overlapping Content but Below Navbar) -->  
<div x-show="mobileOpen" 
    class="fixed top-16 left-0 w-full bg-white shadow-lg z-50 transition-transform transform">
    <nav class="flex flex-col p-4 space-y-3">
        <a href="{{ route('dashboard') }}" class="text-lg font-semibold block">Dashboard</a>
        <div x-data="{ openClientsMobile: false }">
            <a href="{{ route('clients.list') }}" 
               class="text-lg font-semibold block flex items-center justify-between">
                Clients
                <svg @click.prevent.stop="openClientsMobile = !openClientsMobile" 
                     class="w-4 h-4 transition-transform transform text-gray-700 cursor-pointer" 
                     :class="openClientsMobile ? 'rotate-180' : 'rotate-0'" 
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </a>
            <div x-show="openClientsMobile" class="ml-4 mt-2 space-y-2 border-l-2 border-black pl-4" x-cloak>
                <a href="{{ route('leads.index') }}" class="text-base font-medium block">Lead</a>
            </div>
        </div>
        <a href="{{ route('users') }}" class="text-lg font-semibold block">Users</a>
        <a href="{{ route('task') }}" class="text-lg font-semibold block">Task</a>
        <a href="#" class="text-lg font-semibold block">Notifications</a>

        <!-- Log-out Form (Same Function as Button) -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-lg font-semibold block text-left w-full">
                Log-out
            </button>
        </form>
    </nav>
</div>
</div>
