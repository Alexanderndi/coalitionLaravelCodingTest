<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project List</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100 text-gray-800">
<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Project List</h1>

    <!-- Project List -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">All Projects</h2>
        <ul class="divide-y divide-gray-200">
            @foreach ($projects as $project)
                <li class="flex justify-between py-2">
                    {{ $project->name }}
                    <div class="flex space-x-4">
                        <a href="{{ route('projects.edit', $project->id) }}"
                           class="text-blue-500 hover:text-blue-700">Edit</a>

                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this project?')">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Form to Create a New Project -->
    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <h2 class="text-xl font-semibold mb-4">Create a New Project</h2>
        <form action="{{ route('projects.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
                <input type="text" id="name" name="name" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                Create Project
            </button>
        </form>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    </div>
</div>
</body>
</html>
