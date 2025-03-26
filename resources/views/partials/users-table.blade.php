<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Flash Message -->
@if (session('success'))
    <div id="flashMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<tbody>
    @forelse($users as $user)
        <tr class="border-t">
            <td class="p-3"><input type="checkbox"></td>
            <td class="p-3 flex items-center gap-2">
                <img src="{{ asset('images/adminprofile.svg') }}" class="w-10 h-10 rounded-full">
                {{ $user['firstName'] ?? 'N/A' }} {{ $user['middleName'] ?? '' }} {{ $user['lastName'] ?? 'N/A' }}
            </td>
            <td class="p-3">{{ $user['phoneNumber'] ?? 'N/A' }}</td>
            <td class="p-3">{{ $user['userName'] ?? 'N/A' }}</td>
            <td class="p-3">{{ $user['email'] ?? 'N/A' }}</td>
            <td class="p-3">
                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                    {{ isset($user['status']) && $user['status'] == 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $user['status'] ?? 'Inactive' }}
                </span>
            </td>
            <td class="p-3 flex gap-2">
                <button class="text-gray-500 hover:text-gray-700 edit-user-btn"
                    data-id="{{ $user['userId'] ?? '' }}"
                    data-firstname="{{ $user['firstName'] ?? '' }}"
                    data-middlename="{{ $user['middleName'] ?? '' }}"
                    data-lastname="{{ $user['lastName'] ?? '' }}"
                    data-phonenumber="{{ $user['phoneNumber'] ?? '' }}"
                    data-username="{{ $user['userName'] ?? '' }}"
                    data-email="{{ $user['email'] ?? '' }}">
                    <x-pencilicon class="w-6 h-6 text-blue-600" />
                </button>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center p-4 text-gray-500">No users found.</td>
        </tr>
    @endforelse
</tbody>

<!-- Edit User Modal -->
<div id="editUserModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-lg font-semibold mb-4">Edit User</h2>
        <form id="updateUserForm" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="userId" id="userId">
            <div class="mb-2">
                <label>First Name:</label>
                <input type="text" name="firstName" id="firstName" class="border p-2 w-full">
            </div>
            <div class="mb-2">
                <label>Middle Name:</label>
                <input type="text" name="middleName" id="middleName" class="border p-2 w-full">
            </div>
            <div class="mb-2">
                <label>Last Name:</label>
                <input type="text" name="lastName" id="lastName" class="border p-2 w-full">
            </div>
            <div class="mb-2">
                <label>Phone Number:</label>
                <input type="text" name="phoneNumber" id="phoneNumber" class="border p-2 w-full">
            </div>
            <div class="mb-2">
                <label>Username:</label>
                <input type="text" name="userName" id="userName" class="border p-2 w-full">
            </div>
            <div class="mb-2">
                <label>Email:</label>
                <input type="email" name="email" id="editEmail" class="border p-2 w-full">

            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" id="closeEditModal" class="bg-[#ED1C24] text-white px-4 py-2 rounded">Cancel</button>
                <button type="submit" id="updateUserBtn" class="bg-[#102B3C] text-white px-4 py-2 rounded ml-2">Update</button>
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
        document.body.prepend(flashMessage);

        setTimeout(() => {
            flashMessage.remove();
        }, 5000); // Auto-hide after 5 seconds
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
                    "Authorization": "1234", // Ensure this matches your API requirement
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
            location.reload(); // Reload the page to reflect changes
        } catch (error) {
            console.error("Network error:", error);
            showFlashMessage("Failed to connect to the server!", "error");
        }
    });

    document.getElementById("registerUserForm").addEventListener("submit", async function (event) {
        event.preventDefault();

        const formData = {
            firstName: document.getElementById("registerFirstName").value,
            middleName: document.getElementById("registerMiddleName").value,
            lastName: document.getElementById("registerLastName").value,
            phoneNumber: document.getElementById("registerPhoneNumber").value,
            userName: document.getElementById("registerUserName").value,
            email: document.getElementById("registerEmail").value,
            password: document.getElementById("registerPassword").value
        };

        try {
            const response = await fetch("http://192.168.1.9:2030/api/Users/register", {
                method: "POST",
                headers: {
                    "Authorization": "1234", // Ensure this matches your API requirement
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(formData)
            });

            const responseData = await response.json();

            if (!response.ok) {
                showFlashMessage("Registration failed: " + (responseData.message || "Unknown error"), "error");
                return;
            }

            showFlashMessage("User registered successfully!");
            location.reload(); // Reload the page to reflect changes
        } catch (error) {
            console.error("Network error:", error);
            showFlashMessage("Failed to connect to the server!", "error");
        }
    });

    // Auto-close flash message after 5 seconds
    const flashMessage = document.getElementById("flashMessage");
    if (flashMessage) {
        setTimeout(() => {
            flashMessage.classList.add("hidden"); // Hide the message
        }, 5000); // 5 seconds
    }
});
</script>




