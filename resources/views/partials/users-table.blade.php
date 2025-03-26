<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Flash Message -->
@if (session('success'))
    <div id="flashMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 text-center mx-auto max-w-md shadow-lg">
        {{ session('success') }}
    </div>
@endif

<!-- Flash Message Container -->
<div id="flashMessageContainer" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50"></div>

<div class="w-full overflow-x-auto">
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="w-12 py-3 px-6 text-left">#</th>
                <th class="w-1/4 py-3 px-6 text-left">Full Name</th>
                <th class="w-1/6 py-3 px-6 text-left">Phone Number</th>
                <th class="w-1/6 py-3 px-6 text-left">Username</th>
                <th class="w-1/6 py-3 px-6 text-left">Email</th>
                <th class="w-1/6 py-3 px-6 text-left">Status</th>
                <th class="w-12 py-3 px-6 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            @forelse($users as $user)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <input type="checkbox" class="form-checkbox h-4 w-4">
                    </td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/adminprofile.svg') }}" class="w-10 h-10 rounded-full shadow-md">
                            <span class="font-medium">{{ $user['firstName'] ?? 'N/A' }} {{ $user['middleName'] ?? '' }} {{ $user['lastName'] ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $user['phoneNumber'] ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $user['userName'] ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $user['email'] ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ isset($user['status']) && $user['status'] == 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $user['status'] ?? 'Inactive' }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <button class="text-gray-500 hover:text-gray-700 edit-user-btn"
                            data-id="{{ $user['userId'] ?? '' }}"
                            data-firstname="{{ $user['firstName'] ?? '' }}"
                            data-middlename="{{ $user['middleName'] ?? '' }}"
                            data-lastname="{{ $user['lastName'] ?? '' }}"
                            data-phonenumber="{{ $user['phoneNumber'] ?? '' }}"
                            data-username="{{ $user['userName'] ?? '' }}"
                            data-email="{{ $user['email'] ?? '' }}">
                            <x-pencilicon class="w-6 h-6 text-blue-600 hover:text-blue-800" />
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination Controls -->
@if(isset($pagination))
    <div class="mt-4 flex justify-between items-center text-sm text-gray-600">
        <div>
            Showing {{ ($pagination['current_page'] - 1) * $pagination['per_page'] + 1 }} 
            to {{ min($pagination['current_page'] * $pagination['per_page'], $pagination['total']) }} 
            of {{ $pagination['total'] }} users
        </div>
        <div class="flex gap-2">
            @if($pagination['current_page'] > 1)
                <a href="?page={{ $pagination['current_page'] - 1 }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 shadow-md">Previous</a>
            @endif
            @if($pagination['current_page'] < $pagination['last_page'])
                <a href="?page={{ $pagination['current_page'] + 1 }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 shadow-md">Next</a>
            @endif
        </div>
    </div>
@endif

<!-- Edit User Modal -->
<div id="editUserModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white p-6 rounded-lg w-1/3 shadow-lg">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">Edit User</h2>
        <form id="updateUserForm" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="userId" id="userId">
            <div class="mb-2">
                <label class="block text-gray-600">First Name:</label>
                <input type="text" name="firstName" id="firstName" class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-2">
                <label class="block text-gray-600">Middle Name:</label>
                <input type="text" name="middleName" id="middleName" class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-2">
                <label class="block text-gray-600">Last Name:</label>
                <input type="text" name="lastName" id="lastName" class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-2">
                <label class="block text-gray-600">Phone Number:</label>
                <input type="text" name="phoneNumber" id="phoneNumber" class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-2">
                <label class="block text-gray-600">Username:</label>
                <input type="text" name="userName" id="userName" class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-2">
                <label class="block text-gray-600">Email:</label>
                <input type="email" name="email" id="editEmail" class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" id="closeEditModal" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cancel</button>
                <button type="submit" id="updateUserBtn" class="bg-blue-500 text-white px-4 py-2 rounded ml-2 hover:bg-blue-600">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
   document.addEventListener("DOMContentLoaded", function () {
    const showFlashMessage = (message, type = "success") => {
        const flashMessage = document.createElement("div");
        flashMessage.className = `flash-message bg-${type === "success" ? "green" : "red"}-100 border border-${type === "success" ? "green" : "red"}-400 text-${type === "success" ? "green" : "red"}-700 px-4 py-2 rounded mb-4`;
        flashMessage.textContent = message;
        document.getElementById("flashMessageContainer").appendChild(flashMessage);

        setTimeout(() => {
            flashMessage.remove();
        }, 5000);
    };

    document.body.addEventListener("click", function (event) {
        if (event.target.closest(".edit-user-btn")) {
            const button = event.target.closest(".edit-user-btn");
            const userId = button.getAttribute("data-id");

            if (!userId) {
                alert("User ID is missing!");
                return;
            }

            console.log("Retrieved email:", button.getAttribute("data-email"));

            // Populate modal fields
            document.getElementById("userId").value = userId;
            document.getElementById("firstName").value = button.getAttribute("data-firstname")?.trim() || "";
            document.getElementById("middleName").value = button.getAttribute("data-middlename")?.trim() || "";
            document.getElementById("lastName").value = button.getAttribute("data-lastname")?.trim() || "";
            document.getElementById("phoneNumber").value = button.getAttribute("data-phonenumber")?.trim() || "";
            document.getElementById("userName").value = button.getAttribute("data-username")?.trim() || "";

            const emailValue = button.getAttribute("data-email")?.trim() || "";
            document.querySelector("#editUserModal input[name='email']").value = emailValue;

            console.log("Set email:", emailValue);

            // Show modal
            document.getElementById("editUserModal").classList.remove("hidden");
        }

        // Close the modal when clicking the cancel button
        if (event.target.id === "closeEditModal" || event.target.closest("#closeEditModal")) {
            document.getElementById("editUserModal").classList.add("hidden");
        }

        // Close modal when clicking outside of it
        if (event.target.id === "editUserModal") {
            document.getElementById("editUserModal").classList.add("hidden");
        }
    });

    document.getElementById("updateUserForm").addEventListener("submit", async function (event) {
        event.preventDefault();

        const userId = document.getElementById("userId").value;

        const formData = {
            firstName: document.getElementById("firstName").value,
            middleName: document.getElementById("middleName").value,
            lastName: document.getElementById("lastName").value,
            phoneNumber: document.getElementById("phoneNumber").value,
            userName: document.getElementById("userName").value,
            email: document.getElementById("editEmail").value
        };

        try {
            const response = await fetch(`http://192.168.1.9:2030/api/Users/update/${userId}`, {
                method: "PUT",
                headers: {
                    "Authorization": "1234",
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(formData)
            });

            const responseData = await response.json();

            if (!response.ok) {
                showFlashMessage("Update failed: " + (responseData.message || "Unknown error"), "error");
                return;
            }

            showFlashMessage("User updated successfully!");
            document.getElementById("editUserModal").classList.add("hidden");
            location.reload();
        } catch (error) {
            console.error("Network error:", error);
            showFlashMessage("Failed to connect to the server!", "error");
        }
    });

    // Auto-close flash message after 5 seconds
    const flashMessage = document.getElementById("flashMessage");
    if (flashMessage) {
        setTimeout(() => {
            flashMessage.classList.add("hidden");
        }, 5000);
    }
});
</script>




