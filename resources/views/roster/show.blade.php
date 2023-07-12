<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <style>
        @media (min-width: 600px) {
            .container {
                max-width: 500px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Todo List</h1>
    <form>
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Add a new task">
        </div>
        <button type="submit" class="btn btn-primary">Add Task</button>
    </form>

    <ul class="list-group mt-3">
        @foreach($items as $item)
            <li class="list-group-item">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox">
                    <label class="form-check-label">{{ $item->name }}</label>
                </div>
            </li>
        @endforeach
    </ul>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js"></script>
</body>
</html>

