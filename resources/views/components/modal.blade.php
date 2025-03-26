@props(['id', 'title'])

<div id="{{ $id }}" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-4xl">
        
        <!-- Full-Width Header with Custom Border Color -->
        <div class="bg-[#F9FAFB] w-full rounded-t-2xl border-b border-[#D0D5DD]">
            <h2 class="text-xl font-semibold px-6 py-3">{{ $title }}</h2>
        </div>

        <!-- Flash Message -->
        <div id="flashMessage" class="hidden bg-green-500 text-white text-center py-2 px-4 rounded-t-lg">
            User successfully registered!
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            {{ $slot }} <!-- This holds the form content -->
        </div>

        <!-- Footer with Buttons -->
        <div class="px-6 py-3 flex justify-end space-x-2 border-t border-[#D0D5DD] rounded-b-3xl">
            <button id="closeEditModal" class="bg-[#ED1C24] text-white px-4 py-2 rounded-lg">Cancel</button>
            <button id="registerUser" class="bg-[#102B3C] text-white px-4 py-2 rounded-lg">Register</button>
        </div>
    </div>
</div>
