<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::all();
        $selectedProjectId = $request->input('project_id', $projects->first()->id); // Default to first project
        $tasks = Task::where('project_id', $selectedProjectId)->orderBy('priority')->get();

        return view('tasks.index', compact('projects', 'tasks', 'selectedProjectId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        $maxPriority = Task::where('project_id', $validated['project_id'])->max('priority') ?? 0;

        Task::create([
            'name' => $validated['name'],
            'priority' => $maxPriority + 1,
            'project_id' => $validated['project_id'],
        ]);

        return redirect()->back()->with('success', 'Task created successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $task->update(['name' => $request->name]);

        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->back();
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'task_order' => 'required|array',
            'task_order.*' => 'exists:tasks,id',
        ]);

        foreach ($validated['task_order'] as $priority => $taskId) {
            Task::where('id', $taskId)->update(['priority' => $priority + 1]);
        }

        return response()->json(['message' => 'Task order updated.']);
    }

}
