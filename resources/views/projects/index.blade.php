<!DOCTYPE html>
<html>
<head>
    <title>Projects</title>
</head>
<body>
<h1>Projects</h1>
<ul>
    @foreach ($projects as $project)
        <li>
            <a href="{{ url('/?project_id=' . $project->id) }}">{{ $project->name }}</a>
        </li>
    @endforeach
</ul>
</body>
</html>
