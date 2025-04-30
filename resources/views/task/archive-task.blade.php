@extends('layouts.app')

@section('title', 'Archived Tasks')

@include('components.sidebar')

@section('content')
<div class="flex-1 p-6 bg-[#FAFBFB] pt-20">
    <div class="container mx-auto bg-white shadow-md rounded-xl p-4 sm:p-8">    
        <!-- Flash Message -->
        @if (session('success'))
            <div id="flash-message" class="mb-4 p-4 rounded-lg text-white bg-green-500 shadow-lg animate-slide-in">
                <div class="flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button id="close-flash" class="text-white hover:text-gray-200 focus:outline-none">
                        <x-cancelicon class="w-5 h-5" />
                    </button>
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div id="flash-message" class="mb-4 p-4 rounded-lg text-white bg-red-500 shadow-lg animate-slide-in">
                <div class="flex items-center justify-between">
                    <span>{{ $errors->first('error') }}</span>
                    <button id="close-flash" class="text-white hover:text-gray-200 focus:outline-none">
                        <x-cancelicon class="w-5 h-5" />
                    </button>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div class="flex items-center space-x-4">
                <button onclick="window.location.href='{{ route('task') }}'" class="bg-[#205375] text-white p-3 rounded-full hover:bg-[#102B3C] shadow-md">
                    <x-backicon class="w-6 h-6" />
                </button>
                <h1 class="text-3xl font-extrabold text-gray-800">Archived Tasks</h1>
                <span class="font-semibold text-sm text-gray-500">({{ count($archivedTasks) }} archived tasks)</span>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto max-h-96 overflow-y-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-[#205375] text-white sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Task Title</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Task Type</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Assigned To</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="archived-task-table-body" class="divide-y divide-gray-200">
                    @forelse ($archivedTasks as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-600">{{ $task['taskTitle'] }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $task['taskType'] }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $task['assignedTo'] }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $task['priority'] }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($task['dueDate'])->format('Y-m-d H:i A') }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $task['status'] }}</td>
                            <td class="px-6 py-4 flex items-center space-x-2">
                                <form method="POST" action="{{ route('task.unarchive') }}" onsubmit="return confirm('Are you sure you want to unarchive this task?');">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="taskId" value="{{ $task['id'] }}">
                                    <div class="flex items-center space-x-2">
                                        <x-archiveredicon class="w-5 h-5 text-blue-600 hover:text-blue-800" />
                                        <button type="submit" class="text-red-500 hover:underline">Unarchive</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No archived tasks found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
