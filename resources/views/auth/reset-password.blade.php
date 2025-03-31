@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Reset Password</h2>
        <p class="text-sm text-gray-600 text-center mb-6">
            Enter your new password and confirm it to reset your password.
        </p>

        @if ($errors->any())
            <div class="mb-4 text-red-600 text-sm text-center font-medium">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrfw  
            {{-- <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}"> --}}

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Enter new password" required>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Confirm new password" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                Reset Password
            </button>
        </form>
    </div>
</div>
@endsection