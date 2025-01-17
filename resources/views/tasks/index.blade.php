<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>
<body>
<h1>Tasks for Project {{ $projectId }}</h1>
<ul id="task-list">
    @foreach($tasks as $task)
        <li data-id="{{ $task->id }}">{{ $task->name }}</li>
    @endforeach
</ul>

<script>
    const list = document.querySelector('#task-list');
    new Sortable(list, {
        animation: 150,
        onEnd: function () {
            const order = Array.from(list.children).map((item, index) => ({
                id: item.dataset.id,
                priority: index + 1,
            }));
            fetch('{{ route('tasks.reorder') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ order }),
            });
        },
    });
</script>
</body>
</html>
