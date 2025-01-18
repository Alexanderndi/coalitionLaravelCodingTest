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

        // Check if there are any projects
        if ($projects->isEmpty()) {
            return view('tasks.index', [
                'projects' => $projects,
                'tasks' => collect(),
                'selectedProjectId' => null
            ]);
        }

        $selectedProjectId = $request->input('project_id', $projects->first()->id);
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

    // Show the form to edit a task
    public function edit(Task $task)
    {
        // Fetch all projects for the project selection dropdown
        $projects = Project::all();

        // Return the view with the task and projects
        return view('tasks.edit', compact('task', 'projects'));
    }

    // Handle the update of the task
    public function update(Request $request, Task $task)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|integer',
            'project_id' => 'required|exists:projects,id',
        ]);

        // Update the task with new data
        $task->update([
            'name' => $request->name,
            'priority' => $request->priority,
            'project_id' => $request->project_id,
        ]);

        // Redirect back to the task index with a success message
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
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
