@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-[#102B3C] to-[#205375] px-4">
    <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-lg overflow-hidden max-w-4xl w-full">
        <!-- Illustration Section -->
        <div class="flex items-center justify-center bg-blue-100 p-10 md:w-1/2 w-full">
            <img src="{{ asset('images/forgot.svg') }}" alt="Forgot Password Illustration" class="w-[60%] md:w-[100%]">
        </div>

        <!-- Form Section -->
        <div class="p-6 md:p-10 w-full md:w-1/2">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 text-center mb-4 md:mb-6">Forgot Your Password?</h2>
            <p class="text-sm md:text-base text-gray-600 text-center mb-6 md:mb-8">
                Enter your email address below, and we'll send you a link to reset your password.
            </p>

            <!-- Display success or error messages -->
            @if (session('success'))
                <div class="mb-4 md:mb-6 text-green-600 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="mb-4 md:mb-6 text-red-600 text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Display validation errors, if any -->
            @if ($errors->any())
                <div class="mb-4 md:mb-6 text-red-600 text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <p>⚠️ {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4 md:space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-4 focus:ring-blue-400 focus:outline-none transition" placeholder="Enter your email" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#102B3C] text-white py-3 rounded-lg font-bold hover:bg-[#205375] transition transform hover:scale-105 shadow-md">
                    Reset Password
                </button>
            </form>

            <div class="mt-6 md:mt-8 text-center">
                <a href="{{ route('login') }}" class="text-sm text-[#102B3C] hover:underline font-medium">Back to Login</a>
            </div>
        </div>
    </div>
</div>
@endsection
