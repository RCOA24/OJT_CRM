@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-[#102B3C] to-[#205375] px-4">
    <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-lg overflow-hidden max-w-4xl w-full">
        <!-- Illustration Section -->
        <div class="flex items-center justify-center bg-blue-100 p-10 md:w-1/2 w-full">
            <img src="{{ asset('images/reset.svg') }}" alt="Reset Password Illustration" class="w-[60%] md:w-[100%]">
        </div>

        <!-- Form Section -->
        <div class="p-6 md:p-10 w-full md:w-1/2">
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#102B3C] text-center mb-4 md:mb-6">Reset Your Password</h2>
            <p class="text-sm md:text-base text-[#102B3C] text-center mb-6 md:mb-8">
                Enter your new password and confirm it to regain access to your account.
            </p>

            <!-- Display validation errors, if any -->
            @if ($errors->any())
                <div class="mb-4 md:mb-6 text-red-600 text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <p>⚠️ {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.store') }}" class="space-y-4 md:space-y-6">
                @csrf

                <!-- Hidden input to pass the email -->
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- New Password Input -->
                <div>
                    <label class="block text-sm font-semibold text-[#102B3C] mb-2">New Password</label>
                    <input type="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-4 focus:ring-blue-400 focus:outline-none transition" placeholder="Enter new password" required>
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <label class="block text-sm font-semibold text-[#102B3C] mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-4 focus:ring-blue-400 focus:outline-none transition" placeholder="Confirm new password" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#102B3C] text-white py-3 rounded-lg font-bold hover:bg-[#205375] transition transform hover:scale-105 shadow-md">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection