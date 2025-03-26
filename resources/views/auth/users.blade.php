@extends('layouts.app')

@section('title', 'Users')

@include('components.sidebar')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mx-auto p-4">
    <div class="bg-white shadow rounded-lg p-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">Users</h2>
            <div class="flex gap-2 items-center">
                <input type="text" id="searchUser" placeholder="Search Username" class="border rounded-lg px-4 py-2 w-full md:w-64">
                <script>
                    document.getElementById("searchUser").addEventListener("input", function () {
                        let searchValue = this.value.toLowerCase();
                        let rows = document.querySelectorAll("tbody tr");
                
                        rows.forEach(row => {
                            let username = row.querySelector("td:nth-child(4)").textContent.toLowerCase();
                            if (username.includes(searchValue)) {
                                row.style.display = "";
                            } else {
                                row.style.display = "none";
                            }
                        });
                    });
                </script>
                

               <!-- Add User Button -->
                <button onclick="document.getElementById('userModal').classList.remove('hidden')" 
                class="bg-[#102B3C] text-white px-4 py-2 rounded-lg flex items-center">
                <span class="mr-2">Add User</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                </button>
                <!-- Add User Button -->


        
            

    <!-- Include the Modal Component -->
<x-modal id="userModal" title="User Registration Form">
    <div class="grid grid-cols-3 gap-4">
        <!-- Profile Picture Section -->
        <div class="col-span-1 flex flex-col items-center">
            <img src="{{ asset('images/adminprofile.svg') }}" alt="Profile Photo" class="rounded-full w-32 h-32 object-cover">
            <button class="mt-2 bg-[#102B3C] text-white px-4 py-2 rounded">Add photo</button>
        </div>

        <!-- Form Fields -->
        <div class="col-span-2 grid grid-cols-2 gap-4">
            <input type="text" id="last_name" placeholder="Last name" class="border p-2 rounded">
            <input type="text" id="first_name" placeholder="First name" class="border p-2 rounded">
            <input type="text" id="middle_name" placeholder="Middle name" class="border p-2 rounded">
            <input type="text" id="phone_number" placeholder="Phone number" class="border p-2 rounded">
            <input type="text" id="username" placeholder="Username" class="border p-2 rounded">
            <input type="email" id="email" placeholder="Email" class="border p-2 rounded">
            <input type="password" id="password" placeholder="Create password" class="col-span-2 border p-2 rounded">
            <input type="password" id="confirm_password" placeholder="Confirm password" class="col-span-2 border p-2 rounded">
        </div>
    </div>

                </x-modal>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
    const userModal = document.getElementById("userModal");

    document.getElementById("registerUser").addEventListener("click", async function () {
        const formData = {
            firstName: document.getElementById("first_name").value,
            middleName: document.getElementById("middle_name").value,
            lastName: document.getElementById("last_name").value,
            phoneNumber: document.getElementById("phone_number").value,
            userName: document.getElementById("username").value,
            email: document.getElementById("email").value,
            password: document.getElementById("password").value,
            confirmPassword: document.getElementById("confirm_password").value,
            status: "Active"
        };

        try {
            const response = await fetch("http://192.168.1.9:2030/api/Users/register", {
                method: "POST",
                headers: {
                    "Authorization": "1234", // Include your token
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(formData)
            });

            if (!response.ok) {
                const errorData = await response.json();
                alert("Registration failed: " + (errorData.message || "Unknown error"));
                return;
            }

            alert("User registered successfully!");
            location.reload();
        } catch (error) {
            console.error("Network error:", error);
            alert("Failed to connect to the server!");
        }
    });

    // Close modal when clicking outside
    document.addEventListener("click", function (event) {
        if (event.target === userModal) {
            userModal.classList.add("hidden");
        }
    });
});

                    </script>
                    
                    

                    
                <!-- Form Fields -->


            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border text-left text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3"><input type="checkbox"></th>
                        <th class="p-3">Full Name</th>
                        <th class="p-3">Phone Number</th>
                        <th class="p-3">Username</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTable">
                    @include('partials.users-table')
                </tbody>
                
                
            </table>
        </div>
    </div>
</div>
@endsection
