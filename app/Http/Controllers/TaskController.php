<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator ;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Tasks of the User
        $tasks = Task::where('assigned_to', Auth::id());
        // ->when(request('team_id'), function ($query) {
        //     $query->where('team_id', request('team_id'));
        // })
        // ->when(request('status'), function ($query) {
        //     $query->where('status', request('status'));
        // })
        // ->get();

          return response()->json($tasks);
    }

    public function editTasks(){
         return view('tasks.edit');
    }

    public function getAll() {

        $tasks = Task::with('team')->get();
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          // Manually validate the incoming request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'team_id' => 'required|exists:teams,id',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return validation errors along with a 422 status code
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Proceed with task creation if validation passes
        try {
            $task = Task::create($request->all());
            return response()->json($task, 201);  // Successfully created task
        } catch (\Exception $e) {
            // Return custom error message in case of exception
            return response()->json(['error' => 'Failed to create task'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $task = Task::findOrFail($id);

      //  $this->authorize('update', $task);

        $task->update($request->all());

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $task = Task::findOrFail($id);

      //  $this->authorize('delete', $task);

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
