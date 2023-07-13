<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        @media (min-width: 600px) {
            .container {
                max-width: 500px;
            }
        }
        .editing {
            border: 2px solid green;
            padding: 4px;
        }

    </style>
</head>
<body>
<div class="container">
    <h1>Todo-листы</h1>

    <ul class="list-group mt-3">
        @foreach($rosters as $roster)
            <li class="list-group-item d-flex align-items-center justify-content-between">
                <div><a href="{{ route('rosters.show', $roster->id) }}">{{ $roster->name }}</a></div>
            </li>
        @endforeach
    </ul>

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js"></script>

</body>
</html>

