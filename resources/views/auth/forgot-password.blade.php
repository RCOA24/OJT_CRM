@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Forgot Password</h2>
        <p class="text-sm text-gray-600 text-center mb-6">
            Enter your email address below, and we'll send you a link to reset your password.
        </p>

        <!-- Display success or error messages -->
        @if (session('success'))
            <div class="mb-4 text-green-600 text-sm text-center font-medium">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="mb-4 text-red-600 text-sm text-center font-medium">
                {{ session('error') }}
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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Enter your email" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                Send Password Reset Link
            </button>
        </form>
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline font-medium">Back to Login</a>
        </div>
    </div>
</div>
@endsection
