@extends('layouts.app')

@section('title', 'Users')

@include('components.sidebar')

@section('content')

<div id="flashMessage" class="hidden bg-green-500 text-white text-center py-2 rounded mb-4">
    User successfully registered!
</div>

<div class="container mx-auto p-4 pt-20">
    <div class="bg-white shadow rounded-lg p-4 max-w-[calc(100vw-4rem)] max-h-[calc(100vh-6rem)] overflow-auto">
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
                        const flashMessage = document.getElementById("flashMessage");
                    
                        document.getElementById("registerUser").addEventListener("click", async function () {
                            const last_name = document.getElementById("last_name").value;
                            const first_name = document.getElementById("first_name").value;
                            const middle_name = document.getElementById("middle_name").value;
                            const phone_number = document.getElementById("phone_number").value;
                            const username = document.getElementById("username").value;
                            const email = document.getElementById("email").value;
                            const password = document.getElementById("password").value;
                            const confirm_password = document.getElementById("confirm_password").value;
                    
                            const formData = {
                                firstName: first_name,
                                middleName: middle_name,
                                lastName: last_name,
                                phoneNumber: phone_number,
                                status: "Active",
                                userName: username,
                                email: email,
                                password: password,
                                confirmPassword: confirm_password
                            };
                    
                            try {
                                const response = await fetch("http://192.168.1.9:2030/api/Users/register", {
                                    method: "POST",
                                    headers: {
                                        "Authorization": "1234",
                                        "Accept": "application/json",
                                        "Content-Type": "application/json"
                                    },
                                    body: JSON.stringify(formData)
                                });
                    
                                if (!response.ok) {
                                    const errorData = await response.json();
                                    console.error("Error:", errorData);
                                    alert("Registration failed: " + (errorData.message || "Unknown error"));
                                    return;
                                }
                    
                                const result = await response.json();
                                console.log("Success:", result);
                    
                                // Show flash message
                                flashMessage.classList.remove("hidden");
                    
                                // Clear form fields
                                document.getElementById("last_name").value = "";
                                document.getElementById("first_name").value = "";
                                document.getElementById("middle_name").value = "";
                                document.getElementById("phone_number").value = "";
                                document.getElementById("username").value = "";
                                document.getElementById("email").value = "";
                                document.getElementById("password").value = "";
                                document.getElementById("confirm_password").value = "";
                    
                                // Hide flash message after 3 seconds
                                setTimeout(() => {
                                    flashMessage.classList.add("hidden");
                                }, 3000);
                    
                                // Close modal on successful registration
                                userModal.classList.add("hidden");
                    
                            } catch (error) {
                                console.error("Network error:", error);
                                alert("Failed to connect to the server!");
                            }
                        });
                    
                        // Close modal when clicking the "Cancel" button
                        document.body.addEventListener("click", function (event) {
                            if (event.target.closest("#closeEditModal")) {
                                userModal.classList.add("hidden");
                            }
                        });
                    
                        // Close modal when clicking outside of it
                        document.body.addEventListener("click", function (event) {
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
                <tbody id="usersTable">
                    @include('partials.users-table')
                </tbody>
                
                
            </table>
        </div>
    </div>
</div>
@endsection
