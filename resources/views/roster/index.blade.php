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

        .editing a {
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Todo-листы</h1>
    <br>
    <form class="d-flex">
        <div class="mb-3 me-2 flex-grow-1">
            <input type="text" id="rosterInput" class="form-control" placeholder="Название списка">
        </div>
        <div>
            <button type="submit" class="btn btn-success">Добавить список</button>
        </div>
    </form>

    <ul class="list-group mt-3">
        @foreach($rosters as $roster)
            <li class="list-group-item d-flex align-items-center justify-content-between">
                <div class="editable" data-roster-id="{{ $roster->id }}"><a href="{{ route('rosters.show', $roster->id) }}">{{ $roster->name }}</a></div>
                <div>
                    <button class="btn btn-success delete-btn" data-roster-id="{{ $roster->id }}">Выполнено!</button>
                </div>
            </li>
        @endforeach
    </ul>

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {

        // Функция для привязки обработчиков событий к кнопкам
        function attachEventHandlers() {
            $('.delete-btn').click(function () {
                var listRoster = $(this).closest('li');
                var rosterId = $(this).data('roster-id');

                // Выполняем ajax-запрос для удаления элемента из базы данных
                $.ajax({
                    url: '/rosters/delete',
                    type: 'POST',
                    data: {
                        rosterId: rosterId,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        // Обработка успешного ответа от сервера
                        // ...

                        // Удаляем элемент из списка
                        listRoster.remove();
                    },
                    error: function (xhr, status, error) {
                        // Обработка ошибки
                        // ...
                    }
                });
            });
        }

        // Вызываем функцию для привязки обработчиков событий при загрузке страницы
        attachEventHandlers();

        });
</script>

</body>
</html>

