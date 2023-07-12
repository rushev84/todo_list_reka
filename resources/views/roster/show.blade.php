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
    <h1>{{ $roster->name }}</h1>
    <form class="d-flex">
        <div class="mb-3 me-2 flex-grow-1">
            <input type="text" class="form-control" placeholder="Название задачи">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Добавить задачу</button>
        </div>
    </form>

    <ul class="list-group mt-3">
        @foreach($items as $item)
            <li class="list-group-item d-flex align-items-center justify-content-between">
                <div class="editable" contenteditable="true" data-item-id="{{ $item->id }}">{{ $item->name }}</div>
                <div>
                    <button class="btn btn-success mr-2 edit-btn">Изменить</button>
                    <button class="btn btn-success save-btn d-none">Сохранить</button>
                    <button class="btn btn-danger">Удалить</button>
                </div>
            </li>
        @endforeach
    </ul>

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('.edit-btn').click(function() {
            var listItem = $(this).closest('li');
            var editableDiv = listItem.find('.editable');
            var editBtn = listItem.find('.edit-btn');
            var saveBtn = listItem.find('.save-btn');

            // Включаем режим редактирования
            editableDiv.attr('contenteditable', 'true');
            editableDiv.addClass('editing');

            // Показываем кнопку "Сохранить" и скрываем кнопку "Изменить"
            editBtn.addClass('d-none');
            saveBtn.removeClass('d-none');
        });

        $('.save-btn').click(function() {
            var listItem = $(this).closest('li');
            var editableDiv = listItem.find('.editable');
            var editBtn = listItem.find('.edit-btn');
            var saveBtn = listItem.find('.save-btn');
            var itemId = editableDiv.data('item-id');
            var newText = editableDiv.text();

            // Выключаем режим редактирования
            editableDiv.attr('contenteditable', 'false');
            editableDiv.removeClass('editing');

            // Выполняем ajax-запрос
            $.ajax({
                url: '/items/store',
                type: 'POST',
                data: {
                    itemId: itemId,
                    newText: newText,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // Обработка успешного ответа от сервера
                    // ...
                    console.log(response)
                },
                error: function(xhr, status, error) {
                    // Обработка ошибки
                    // ...
                }
            });

            // Обновляем текст элемента списка с текстом из редактируемого div
            listItem.find('.editable').text(newText);

            // Показываем кнопку "Изменить" и скрываем кнопку "Сохранить"
            editBtn.removeClass('d-none');
            saveBtn.addClass('d-none');
        });

    });
</script>
</body>
</html>

