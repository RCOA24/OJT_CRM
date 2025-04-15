@extends('layouts.app')

@section('title', 'Tasks')

@include('components.sidebar')
@include('task.create-task-modal')

@section('content')
<div class="flex-1 p-4 sm:p-6 bg-[#F9FAFB] pt-20">
    <div class="container mx-auto bg-white shadow-md rounded-xl p-4 sm:p-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 md:mb-8 space-y-4 md:space-y-0">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-semibold text-gray-800">
                Tasks <span id="task-count" class="text-sm text-gray-500">({{ $taskCount }} tasks)</span>
            </h1>
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
                <!-- Search Bar -->
                <div class="relative w-full md:w-80">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <x-searchtask class="w-5 h-5 text-gray-400" />
                    </span>
                    <input type="text" id="search-input" placeholder="Search tasks..." 
                           class="border border-gray-300 rounded-full pl-12 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#205375] 
                                  placeholder-gray-400 text-gray-700 w-full shadow-sm">
                </div>
                <!-- Buttons -->
                <button id="sort-button" class="bg-[#205375] text-white px-4 md:px-6 py-3 rounded-full hover:bg-[#102B3C] flex items-center shadow-md">
                    <x-sorticon class="w-5 h-5 mr-2" /> Sort
                </button>
                <button id="filter-button" class="bg-[#205375] text-white px-4 md:px-6 py-3 rounded-full hover:bg-[#102B3C] flex items-center shadow-md">
                    <x-filtericon class="w-5 h-5 mr-2" /> Filters
                </button>
                <button onclick="toggleModal('create-task-modal')" 
                        class="bg-[#205375] text-white px-4 md:px-6 py-3 rounded-full hover:bg-[#102B3C] flex items-center shadow-md">
                    <x-addicon class="w-5 h-5 mr-2" /> Add Task
                </button>
            </div>
        </div>

        <!-- Task Table -->
        <div class="overflow-x-auto rounded-xl shadow">
            <table class="min-w-full bg-white">
                <thead class="bg-[#205375] border-b">
                    <tr class="text-left text-sm md:text-base font-medium text-white">
                        <th class="py-3 md:py-4 px-4 md:px-6"><input type="checkbox"></th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Task ID</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Task Title</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Task Type</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Assigned To</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Priority</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Due Date & Time</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Status</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Actions</th>
                    </tr>
                </thead>
                <tbody id="task-table-body">
                    @if (!empty($tasks) && count($tasks) > 0)
                        @foreach ($tasks as $task)
                        <tr class="text-sm md:text-base text-[#444444] hover:bg-gray-200 transition duration-200 ease-in-out">
                            <td class="py-3 md:py-4 px-4 md:px-6"><input type="checkbox"></td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ $task['taskID'] }}</td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ $task['taskTitle'] }}</td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ $task['taskType'] }}</td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ $task['assignedTo'] }}</td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ $task['priority'] }}</td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ \Carbon\Carbon::parse($task['dueDate'])->format('Y-m-d H:i A') }}</td>
                            <td class="py-3 md:py-4 px-4 md:px-6">
                                <span class="px-3 py-1 rounded-full text-sm md:text-base font-medium 
                                    {{ strtolower($task['status']) == 'in progress' || strtolower($task['status']) == 'in-progress' ? 'bg-green-100 text-green-700' : (strtolower($task['status']) == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                                    {{ $task['status'] }}
                                </span>
                            </td>   
                            <td class="py-3 md:py-4 px-4 md:px-6">
                                <div class="flex items-center space-x-2">
                                    <x-archiveredicon class="w-5 h-5 text-blue-600 hover:text-blue-800" />
                                    <button class="text-red-500 hover:underline">Archive</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="py-3 md:py-4 px-4 md:px-6 text-center text-gray-500">No tasks available.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search-input');
        const taskTableBody = document.getElementById('task-table-body');
        let allTasks = @json($tasks);

        // Render tasks in the table
        function renderTasks(tasks) {
            taskTableBody.innerHTML = '';

            if (tasks.length === 0) {
                taskTableBody.innerHTML = `
                    <tr>
                        <td colspan="9" class="py-3 md:py-4 px-4 md:px-6 text-center text-gray-500">No tasks available.</td>
                    </tr>
                `;
                return;
            }

            tasks.forEach(task => {
                const row = `
                    <tr class="text-sm md:text-base text-gray-700 hover:bg-gray-50 transition">
                        <td class="py-3 md:py-4 px-4 md:px-6"><input type="checkbox"></td>
                        <td class="py-3 md:py-4 px-4 md:px-6">${task.taskID}</td>
                        <td class="py-3 md:py-4 px-4 md:px-6">${task.taskTitle}</td>
                        <td class="py-3 md:py-4 px-4 md:px-6">${task.taskType}</td>
                        <td class="py-3 md:py-4 px-4 md:px-6">${task.assignedTo}</td>
                        <td class="py-3 md:py-4 px-4 md:px-6">${task.priority}</td>
                        <td class="py-3 md:py-4 px-4 md:px-6">${new Date(task.dueDate).toLocaleString()}</td>
                        <td class="py-3 md:py-4 px-4 md:px-6">
                            <span class="px-3 py-1 rounded-full text-sm md:text-base font-medium 
                                ${task.status.toLowerCase() === 'in progress' || task.status.toLowerCase() === 'in-progress' ? 'bg-green-100 text-green-700' : (task.status.toLowerCase() === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700')}">
                                ${task.status}
                            </span>
                        </td>   
                        <td class="py-3 md:py-4 px-4 md:px-6">
                            <div class="flex items-center space-x-2">
                                <x-archiveredicon class="w-5 h-5 text-blue-600 hover:text-blue-800" />
                                <button class="text-red-500 hover:underline">Archive</button>
                            </div>
                        </td>
                    </tr>
                `;
                taskTableBody.insertAdjacentHTML('beforeend', row);
            });
        }

        // Handle search input
        function handleSearch() {
            const query = searchInput.value.trim().toLowerCase();
            if (query.length > 0) {
                const searchResults = allTasks.filter(task => task.taskTitle.toLowerCase().startsWith(query));
                renderTasks(searchResults);
            } else {
                renderTasks(allTasks); // Reset to all tasks if search is empty
            }
        }

        // Debounce function to limit API calls
        function debounce(func, delay) {
            let timeout;
            return function (...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), delay);
            };
        }

        searchInput.addEventListener('input', debounce(handleSearch, 300));
    });
</script>
@endsection
