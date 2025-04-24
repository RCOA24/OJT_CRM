@extends('layouts.app')

@section('title', 'Tasks')

@include('components.sidebar')
@include('task.create-task-modal')

@section('content')
<div class="flex-1 p-4 sm:p-6 bg-[#F9FAFB] pt-20">
    <div class="container mx-auto bg-white shadow-md rounded-xl p-4 sm:p-8">
        <!-- Flash Message -->
        <div id="flash-message" class="hidden mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span id="flash-message-text"></span>
            </div>
        </div>
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
                           class="border border-gray-300 rounded-md pl-12 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#205375] 
                                  placeholder-gray-400 text-gray-700 w-full shadow-sm" autocomplete="on">
                </div>
                <!-- Buttons -->
                <div class="relative">
                    <button id="sort-button" class="bg-[#205375] text-white px-4 md:px-6 py-3 rounded-md hover:bg-[#102B3C] flex items-center shadow-md">
                        <x-sorticon class="w-5 h-5 mr-2" /> Sort
                    </button>
                    <div id="sort-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg z-10">
                        <div class="flex flex-col">
                            <button type="button" data-sort="asc" class="flex items-center space-x-2 w-full text-left px-4 py-2 text-gray-700 hover:bg-[#205375] hover:text-white">
                                <x-ascending class="w-5 h-5 hover:text-white" /> <span>Ascending</span>
                            </button>
                            <button type="button" data-sort="desc" class="flex items-center space-x-2 w-full text-left px-4 py-2 text-gray-700 hover:bg-[#205375] hover:text-white">
                                <x-descending class="w-5 h-5 hover:text-white" /> <span>Descending</span>
                            </button>
                        </div>
                    </div>
                </div>
                <button onclick="window.location.href='{{ route('task.archive') }}'" class="bg-[#205375] text-white px-5 py-3 rounded-md hover:bg-[#102B3C] flex items-center shadow-md">
                    <x-archiveicon class="w-5 h-5 mr-2" /> Archive
                </button>
                <div class="relative">
                    <button id="filter-button" class="bg-[#205375] text-white px-5 py-3 rounded-lg hover:bg-[#102B3C] flex items-center shadow-md z-20">
                        <x-filtericon class="w-5 h-5 mr-2" /> Filters
                    </button>
                    <div id="filter-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-white border rounded-lg shadow-lg p-4 z-20">
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                Filter by Task Type <x-filtericonblack class="w-4 h-4 ml-1" />
                            </h3>
                            <select id="task-type-filter" class="w-full px-4 py-2 text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">Select Task Type</option>
                                <option value="Call">Call</option>
                                <option value="Email">Email</option>
                                <option value="Meeting">Meeting</option>
                                <option value="Follow-up">Follow-up</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                Filter by Priority <x-filtericonblack class="w-4 h-4 ml-1" />
                            </h3>
                            <select id="priority-filter" class="w-full px-4 py-2 text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">Select Priority</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                Filter by Due Date Range <x-filtericonblack class="w-4 h-4 ml-1" />
                            </h3>
                            <div class="flex space-x-2">
                                <input type="date" id="due-date-from" class="w-1/2 px-4 py-2 text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="From">
                                <input type="date" id="due-date-to" class="w-1/2 px-4 py-2 text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="To">
                            </div>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                Filter by Status <x-filtericonblack class="w-4 h-4 ml-1" />
                            </h3>
                            <select id="status-filter" class="w-full px-4 py-2 text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">Select Status</option>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <button id="apply-filters" class="bg-[#205375] text-white px-4 py-2 rounded-md hover:bg-[#102B3C] w-full shadow-md" onclick="applyFilters()">
                            Apply Filters
                        </button>
                    </div>
                </div>
                <button onclick="toggleModal('create-task-modal')" 
                        class="bg-[#205375] text-white px-4 md:px-6 py-3 rounded-md hover:bg-[#102B3C] flex items-center shadow-md">
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
                    @forelse ($tasks as $task)
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
                            <td class="py-3 md:py-4 px-4 md:px-6 flex items-center space-x-2">
                                <form method="POST" action="{{ route('task.archiveTask') }}" onsubmit="return confirm('Are you sure you want to archive this task?');">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="taskId" value="{{ $task['id'] }}"> <!-- Use 'taskId' and the numeric 'id' -->
                                    <div class="flex items-center space-x-2">
                                        <x-archiveredicon class="w-5 h-5 text-blue-600 hover:text-blue-800" />
                                        <button type="submit" class="text-red-500 hover:underline">Archive</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-3 md:py-4 px-4 md:px-6 text-center text-gray-500">No tasks available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include external JavaScript file -->
<script src="{{ asset('js/task-index.js') }}"></script>
@endsection
