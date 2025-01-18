<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">
<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Tasks for Projects</h1>

    <!-- Select Project -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form method="GET" action="{{ route('tasks.index') }}" class="space-y-4">
            <div>
                <label for="project_id" class="block text-sm font-medium text-gray-700">Select Project</label>
                <select id="project_id" name="project_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" @if($project->id == request()->project_id) selected @endif>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                Filter Tasks
            </button>
        </form>
    </div>

    <!-- Task List -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">All Tasks for {{$project->name}}</h2>
        <ul id="task-list" class="divide-y divide-gray-200">
            @foreach ($tasks as $task)
                <li data-id="{{ $task->id }}" class="flex justify-between py-2">
                    <div>
                        <span class="font-medium text-gray-800">{{ $task->name }}</span>
                        <span class="text-sm text-gray-500">(Priority: {{ $task->priority }})</span>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('tasks.edit', $task) }}"
                           class="text-blue-500 hover:text-blue-700">Edit</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Form to Create a New Task -->
    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <h2 class="text-xl font-semibold mb-4">Create a New Task</h2>
        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Task Name</label>
                <input type="text" id="name" name="name" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="project_id" class="block text-sm font-medium text-gray-700">Select Project</label>
                <select id="project_id" name="project_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select a Project</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                <input type="number" id="priority" name="priority"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                Create Task
            </button>
        </form>
    </div>

</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const list = document.querySelector('#task-list');

        new Sortable(list, {
            animation: 150,
            onEnd: function (event) {
                const order = Array.from(list.children).map(item => item.dataset.id);

                fetch('{{ route('tasks.reorder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ order }),
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.message);
                    });
            },
        });
    });
</script>
</html>
