@extends('layouts.app')

@section('title', 'Login')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<body class="flex items-center justify-center bg-gray-100 h-screen font-ubuntu" x-data="{ loading: false }">
    <!-- Full-screen Loader Overlay -->
    <div x-show="loading" class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-80 z-50">
        <div class="flex flex-col items-center">
            <svg class="animate-spin h-12 w-12 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <p class="text-lg font-semibold text-gray-700 mt-3">Logging in...</p>
        </div>
    </div>

    <div class="flex flex-col md:flex-row w-full h-full">

<!-- Left Section (Image & Branding) -->
<div class="w-full md:w-1/2 flex flex-col items-center justify-center p-6 md:p-10 text-center text-gray-900 bg-cover bg-center relative" style="background-image: url('{{ asset('images/bg.png') }}');">
    
    <!-- Main Logos -->
    <img src="{{ asset('images/OdecciPrimary.svg') }}" alt="Odecci Logo" class="mb-4">
    <img src="{{ asset('images/sdcci.svg') }}" alt="Odecci Logo" class="mb-4">

    

</div>


        

       <!-- Right Section (Login Form) -->
<div class="relative w-full md:w-1/2 flex flex-col justify-center items-center min-h-screen p-6 sm:p-8 md:p-12 lg:p-16 bg-[#FAFBFB]">
    
    <!-- Background Image -->
    {{-- <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/bgw.jpg') }}');"></div> --}}

    
    <!-- Light Overlay -->
    <div class="absolute inset-0 bg-white/30 backdrop-blur-lg"></div>

    <!-- Content (Above Overlay) -->
    <div class="relative z-10 text-gray-900 w-full max-w-md">
        <h2 class="text-2xl md:text-3xl font-bold mb-6 text-gray-800 text-center">Log In</h2>

      <!-- Display flash message if it exists -->
      @if (session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-center" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
            <svg class="fill-current h-6 w-6 text-green-700" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/>
            </svg>
        </button>
    </div>
@endif

        <!-- Flash Error Message -->
        @if (session('error'))
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="w-full space-y-4" @submit="loading = true">
            @csrf
            
            <div>
                <label class="block text-[#205375]">Username</label>
                <input type="text" name="username" class="w-full px-4 py-3 border rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500 font-montserrat" placeholder="Enter your username" required>
            </div>
            
            <div>
                <label class="block text-[#205375]">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" class="w-full px-4 py-3 border rounded-lg bg-gray-100 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 font-montserrat" placeholder="Enter password" required>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-[#344054] space-y-2 md:space-y-0">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">Remember me
                </label>
                
            <!-- forgot-password.blade.php -->
                <a href="{{ route('password.request') }}" class="text-[#5999FF] hover:underline">Forgot Password?</a>

            </div>

            <!-- Button -->
            <button type="submit" 
                class="w-full bg-[#FFFFFF] text-[#102B3C] py-3 md:py-4 rounded-[35px] 
                    border border-[#D0D5DD] transition-all duration-300 ease-in-out 
                    hover:bg-[#102B3C] hover:text-[#FFFFFF] hover:backdrop-blur-md hover:shadow-lg flex items-center justify-center"
                :disabled="loading">
                <span>Log In</span>
            </button>
        </form>
    </div>
</div>

    </div>
</body>
@endsection
