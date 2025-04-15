<div id="create-task-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden" style="z-index: 10;">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl">
        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Create Task</h2>
            <button onclick="toggleModal('create-task-modal')" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>
        <!-- Modal Body -->
        <form id="create-task-form" method="POST" action="{{ route('task.store') }}" class="px-6 py-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="taskID" class="block text-sm font-medium text-gray-700">Task ID</label>
                    <input type="text" name="taskID" id="taskID" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="taskTitle" class="block text-sm font-medium text-gray-700">Task Title</label>
                    <input type="text" name="taskTitle" id="taskTitle" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="taskType" class="block text-sm font-medium text-gray-700">Task Type</label>
                    <input type="text" name="taskType" id="taskType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="assignedTo" class="block text-sm font-medium text-gray-700">Assigned To</label>
                    <input type="text" name="assignedTo" id="assignedTo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                    <input type="text" name="priority" id="priority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="dueDate" class="block text-sm font-medium text-gray-700">Due Date & Time</label>
                    <input type="datetime-local" name="dueDate" id="dueDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <input type="text" name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="flex justify-end mt-6">
                <button type="button" onclick="toggleModal('create-task-modal')" class="text-red-500 hover:underline mr-4">Cancel</button>
                <button type="submit" class="bg-[#205375] text-white px-4 py-2 rounded-md hover:bg-[#102B3C]">Save</button>
            </div>
        </form>
    </div>
</div>

<div id="task-success-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md text-center p-6">
        <h2 class="text-lg font-semibold text-gray-800">Saved</h2>
        <p class="mt-4 text-gray-600">New task successfully saved!</p>
        <button onclick="toggleModal('task-success-modal')" class="mt-6 bg-[#205375] text-white px-4 py-2 rounded-md hover:bg-[#102B3C]">Continue</button>
    </div>
</div>

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
</script>
