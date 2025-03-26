@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Reset Password</h2>
        <p class="text-sm text-gray-600 text-center mb-6">
            Enter the token, your email, and your new password to reset your password.
        </p>

        <!-- Display success message -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-info">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="mb-4 text-red-600 text-sm text-center font-medium">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset') }}">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Token</label>
                <input type="text" name="token" value="{{ $token }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Enter the token" required readonly>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Enter your email" required>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                <input type="password" name="newPassword" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Enter new password" required>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input type="password" name="confirmPassword" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Confirm new password" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                Reset Password
            </button>
        </form>
        <p>You will be redirected shortly...</p>
        <script>
            setTimeout(function() {
                window.location.href = "{{ route('login') }}"; // Redirect to login page after timer
            }, {{ session('timer', 5) * 1000 }}); // Default to 5 seconds if timer is not set
        </script>
    </div>
</div>
@endsection
