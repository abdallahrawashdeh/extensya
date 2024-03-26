<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Session;
class TasksController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'description' => 'required|string|max:255',
            'state' => 'required|in:pending,done,failed', // Validate the 'state'
        ]);

        Task::create([
            'email' => $request->input('email'),
            'description' => $request->input('description'),
            'state' => $request->input('state'), // Save the 'state'
        ]);

        Session::flash('success', 'Task created successfully.');

        return redirect()->route('tasks.index');
    }


    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
{
    $request->validate([
        'description' => 'required|string|max:255',
        'state' => 'required|in:pending,done,failed', // Validate the 'state'
    ]);

    $task->update([
        'description' => $request->input('description'),
        'state' => $request->input('state'), // Update the 'state'
    ]);

    return redirect()->route('tasks.index');
}

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
    public function up()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->enum('state', ['pending', 'done', 'failed'])->default('pending');
    });
}

public function updateState(Request $request, Task $task)
{
    $request->validate([
        'state' => 'required|in:pending,done,failed', // Validate the 'state'
    ]);

    $task->update([
        'state' => $request->input('state'), // Update the 'state'
    ]);

    return response()->json(['message' => 'Task state updated successfully'], 200);
}



}
