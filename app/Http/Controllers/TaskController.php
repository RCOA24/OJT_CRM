<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
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
                return $response->json('items') ?? [];
            } else {
                return [];
            }
        } catch (\Exception $e) {
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
        $apiUrl = 'http://192.168.1.9:2030/api/Task/search-task';
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $query = $request->query('name', '');

            if (empty($query)) {
                // Fetch all tasks if the query is empty
                $allTasksApiUrl = 'http://192.168.1.9:2030/api/Task/all-tasks';
                $response = Http::withHeaders([
                    'Authorization' => $token,
                    'Accept' => 'application/json',
                ])->get($allTasksApiUrl);

                if ($response->successful()) {
                    $tasks = $response->json('items') ?? [];
                    return response()->json(['tasks' => $tasks]);
                } else {
                    return response()->json(['tasks' => []], 500);
                }
            }

            // Fetch tasks based on the search query
            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json',
            ])->get($apiUrl, ['name' => $query]);

            if ($response->successful()) {
                $tasks = $response->json() ?? [];
                return response()->json(['tasks' => $tasks]);
            } else {
                return response()->json(['tasks' => []], 500);
            }
        } catch (\Exception $e) {
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
