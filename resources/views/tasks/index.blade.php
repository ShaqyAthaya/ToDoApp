<!DOCTYPE html>
<html>
<head>
    <title>Tasks</title>
</head>
<body>
    <h1>Tasks</h1>
    @foreach($tasks as $task)
        <div>{{ $task->title }}</div>
    @endforeach
</body>
</html>
