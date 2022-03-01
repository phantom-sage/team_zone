<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
<h1>{{ $date }}</h1>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Deadline</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
        <tr>
            <td>{{ $project->id }}</td>
            <td>{{ $project->name }}</td>
            <td>{{ $project->deadline }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
