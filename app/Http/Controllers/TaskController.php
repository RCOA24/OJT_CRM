<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private function getSortedTasks($ascending, $pageNumber = 1, $pageSize = 10)
    {
        $apiUrl = 'http://192.168.1.9:2030/api/Task/all-tasks';
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $queryParams = [
                'ascending' => $ascending ? 'true' : 'false',
                'pageNumber' => $pageNumber,
                'pageSize' => $pageSize,
            ];

            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json',
            ])->get($apiUrl, $queryParams);

            if ($response->successful()) {
                $tasks = $response->json('items') ?? [];
                Log::info('API Response:', ['response' => $tasks]);
                return $tasks;
            } else {
                Log::error('Failed to fetch tasks from API', ['status' => $response->status(), 'body' => $response->body()]);
                return [];
            }
        } catch (\Exception $e) {
            Log::error('Error fetching tasks from API:', ['error' => $e->getMessage()]);
            return [];
        }
    }

    public function index(Request $request)
    {
        $ascending = $request->query('ascending', 'true') === 'true';
        $pageNumber = $request->query('pageNumber', 1);
        $pageSize = $request->query('pageSize', 10);

        $tasks = $this->getSortedTasks($ascending, $pageNumber, $pageSize);
        $taskCount = count($tasks);

        return view('task.index', compact('tasks', 'taskCount'));
    }

    public function searchTasks(Request $request)
    {
        $allTasksApiUrl = 'http://192.168.1.9:2030/api/Task/all-tasks';
        $searchApiUrl = 'http://192.168.1.9:2030/api/Task/search-task';
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $query = $request->query('name', '');
            $pageNumber = $request->query('pageNumber', 1);
            $pageSize = $request->query('pageSize', 10);

            // If the query is empty, fetch all tasks with pagination
            if (empty($query)) {
                $response = Http::withHeaders([
                    'Authorization' => $token,
                    'Accept' => 'application/json',
                ])->get($allTasksApiUrl, [
                    'pageNumber' => $pageNumber,
                    'pageSize' => $pageSize,
                ]);

                if ($response->successful()) {
                    $tasks = $response->json('items') ?? [];
                    return response()->json(['tasks' => $tasks]);
                } else {
                    Log::error('Failed to fetch all tasks', ['status' => $response->status(), 'body' => $response->body()]);
                    return response()->json(['tasks' => []], 500);
                }
            }

            // If a query is provided, perform a search
            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json',
            ])->get($searchApiUrl, ['name' => $query]);

            if ($response->successful()) {
                $tasks = $response->json() ?? [];
                return response()->json(['tasks' => $tasks]);
            } else {
                Log::error('Failed to search tasks', ['status' => $response->status(), 'body' => $response->body()]);
                return response()->json(['tasks' => []], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error searching tasks:', ['error' => $e->getMessage()]);
            return response()->json(['tasks' => []], 500);
        }
    }

    public function store(Request $request)
    {
        $apiUrl = 'http://192.168.1.9:2030/api/Task/add-task';
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'taskID' => $request->input('taskID'),
                'taskTitle' => $request->input('taskTitle'),
                'taskType' => $request->input('taskType'),
                'assignedTo' => $request->input('assignedTo'),
                'priority' => $request->input('priority'),
                'dueDate' => $request->input('dueDate'),
                'status' => $request->input('status'),
            ]);

            if ($response->successful()) {
                return redirect()->route('task')->with('success', 'New task successfully saved!');
            } else {
                return back()->withErrors(['error' => 'Failed to save the task.']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while saving the task.']);
        }
    }

    public function fetchSortedTasks(Request $request)
    {
        $ascending = $request->query('ascending', 'true') === 'true';
        $pageNumber = $request->query('pageNumber', 1);
        $pageSize = $request->query('pageSize', 10);

        $tasks = $this->getSortedTasks($ascending, $pageNumber, $pageSize);
        return response()->json(['tasks' => $tasks]);
    }

    public function applyFilters(Request $request)
     {
         $apiUrl = 'http://192.168.1.9:2030/api/Task/filter-tasks';
         $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';
 
         $filters = [
             'taskType' => $request->query('taskType', ''),
             'priority' => $request->query('priority', ''),
             'dueDateFrom' => $request->query('dueDateFrom', ''),
             'dueDateTo' => $request->query('dueDateTo', ''),
             'status' => $request->query('status', ''),
         ];
 
         try {
             $response = Http::withHeaders([
                 'Authorization' => $token,
                 'Accept' => 'application/json',
             ])->get($apiUrl, $filters);
 
             if ($response->successful()) {
                 $tasks = $response->json('items') ?? [];
                 return response()->json(['tasks' => $tasks]);
             } else {
                 return response()->json(['error' => 'Failed to fetch filtered tasks.'], 500);
             }
         } catch (\Exception $e) {
             return response()->json(['error' => 'An error occurred while applying filters.'], 500);
         }
     }

    public function archiveTask(Request $request)
    {
        $archiveUrl = 'http://192.168.1.9:2030/api/Task/is-archive-task';
        $authorization = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $taskId = $request->input('taskId');

            Log::info('Archiving task', ['taskId' => $taskId]);

            if (empty($taskId)) {
                return redirect()->route('task')->withErrors(['error' => 'Task ID is missing or invalid.']);
            }

            $response = Http::withHeaders([
                'Authorization' => $authorization,
                'Accept' => 'application/json',
            ])->put("$archiveUrl?isArchived=true&taskId=$taskId");

            Log::info('Archive task response', ['status' => $response->status(), 'body' => $response->body()]);

            if ($response->successful()) {
                return redirect()->route('task')->with('success', 'Task archived successfully.');
            } else {
                Log::error('Failed to archive task', ['response' => $response->body()]);
                return redirect()->route('task')->withErrors(['error' => 'Failed to archive task.']);
            }
        } catch (\Exception $e) {
            Log::error('Error archiving task:', ['error' => $e->getMessage()]);
            return redirect()->route('task')->withErrors(['error' => 'An error occurred while archiving the task.']);
        }
    }

    public function unarchive(Request $request)
    {
        $unarchiveUrl = 'http://192.168.1.9:2030/api/Task/is-archive-task';
        $authorization = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $taskId = $request->input('taskId');

            Log::info('Unarchiving task', ['taskId' => $taskId]);

            if (empty($taskId)) {
                return redirect()->route('task.archive')->withErrors(['error' => 'Task ID is missing or invalid.']);
            }

            $response = Http::withHeaders([
                'Authorization' => $authorization,
                'Accept' => 'application/json',
            ])->put("$unarchiveUrl?isArchived=false&taskId=$taskId");

            Log::info('Unarchive task response', ['status' => $response->status(), 'body' => $response->body()]);

            if ($response->successful()) {
                return redirect()->route('task.archive')->with('success', 'Task unarchived successfully.');
            } else {
                Log::error('Failed to unarchive task', ['response' => $response->body()]);
                return redirect()->route('task.archive')->withErrors(['error' => 'Failed to unarchive task.']);
            }
        } catch (\Exception $e) {
            Log::error('Error unarchiving task:', ['error' => $e->getMessage()]);
            return redirect()->route('task.archive')->withErrors(['error' => 'An error occurred while unarchiving the task.']);
        }
    }

    public function renderTasks(Request $request)
    {
        $tasks = $request->input('tasks', []); // Expect tasks to be passed as input

        if (empty($tasks)) {
            return response()->json([
                'html' => '
                    <tr>
                        <td colspan="9" class="py-3 md:py-4 px-4 md:px-6 text-center text-gray-500">No tasks available.</td>
                    </tr>
                ',
            ]);
        }

        $html = '';
        foreach ($tasks as $task) {
            $statusClass = strtolower($task['status']) === 'in progress' || strtolower($task['status']) === 'in-progress'
                ? 'bg-green-100 text-green-700'
                : (strtolower($task['status']) === 'pending'
                    ? 'bg-yellow-100 text-yellow-700'
                    : 'bg-blue-100 text-blue-700');

            $html .= "
                <tr class=\"text-sm md:text-base text-gray-700 hover:bg-gray-50 transition\">
                    <td class=\"py-3 md:py-4 px-4 md:px-6\"><input type=\"checkbox\"></td>
                    <td class=\"py-3 md:py-4 px-4 md:px-6\">{$task['id']}</td>
                    <td class=\"py-3 md:py-4 px-4 md:px-6\">{$task['taskTitle']}</td>
                    <td class=\"py-3 md:py-4 px-4 md:px-6\">{$task['taskType']}</td>
                    <td class=\"py-3 md:py-4 px-4 md:px-6\">{$task['assignedTo']}</td>
                    <td class=\"py-3 md:py-4 px-4 md:px-6\">{$task['priority']}</td>
                    <td class=\"py-3 md:py-4 px-4 md:px-6\">" . \Carbon\Carbon::parse($task['dueDate'])->format('Y-m-d H:i A') . "</td>
                    <td class=\"py-3 md:py-4 px-4 md:px-6\">
                        <span class=\"px-3 py-1 rounded-full text-sm md:text-base font-medium {$statusClass}\">
                            {$task['status']}
                        </span>
                    </td>
                    <td class=\"py-3 md:py-4 px-4 md:px-6\">
                        <div class=\"flex items-center space-x-2\">
                            <x-archiveredicon class=\"w-5 h-5 text-blue-600 hover:text-blue-800\" />
                            <button class=\"archive-button text-red-500 hover:underline\" data-task-id=\"{$task['id']}\">Archive</button>
                        </div>
                    </td>
                </tr>
            ";
        }

        return response()->json(['html' => $html]);
    }

    public function archive()
    {
        $apiUrl = 'http://192.168.1.9:2030/api/Task/all-archive-tasks';
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json',
            ])->get($apiUrl);

            if ($response->successful()) {
                $archivedTasks = $response->json() ?? [];
                return view('task.archive-task', compact('archivedTasks'));
            } else {
                Log::error('Failed to fetch archived tasks', ['status' => $response->status(), 'body' => $response->body()]);
                return back()->withErrors(['error' => 'Failed to fetch archived tasks.']);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching archived tasks:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'An error occurred while fetching archived tasks.']);
        }
    }

    public function filterTasks(Request $request)
    {
        $apiUrl = 'http://192.168.1.9:2030/api/Task/all-tasks';
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        // Collect only non-empty filters to reduce query size
        $filters = array_filter([
            'ascending' => $request->query('ascending', 'true'),
            'TaskType' => $request->query('TaskType'),
            'Priority' => $request->query('Priority'),
            'Status' => $request->query('Status'),
            'StartDate' => $request->query('StartDate'),
            'EndDate' => $request->query('EndDate'),
            'pageNumber' => $request->query('pageNumber', 1),
            'pageSize' => $request->query('pageSize', 10),
        ]);

        try {
            // Use caching to avoid repeated API calls for the same filters
            $cacheKey = 'tasks_' . md5(json_encode($filters));
            $tasks = cache()->remember($cacheKey, 60, function () use ($apiUrl, $token, $filters) {
                $response = Http::withHeaders([
                    'Authorization' => $token,
                    'Accept' => 'application/json',
                ])->get($apiUrl, $filters);

                if ($response->successful()) {
                    return $response->json('items') ?? [];
                }

                throw new \Exception('Failed to fetch filtered tasks.');
            });

            return response()->json(['tasks' => $tasks]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching filtered tasks.'], 500);
        }
    }
}
