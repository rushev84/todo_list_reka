<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        @media (min-width: 800px) {
            .container {
                max-width: 700px;
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
    <a href="{{ route('rosters.index') }}">Назад к листам</a>
    <br><br>
    <h1>{{ $roster->name }}</h1>
    <br>
    <form class="d-flex">
        <div class="mb-3 me-2 flex-grow-1">
            <input type="text" id="itemInput" class="form-control" placeholder="Название задачи">
        </div>
        <div>
            <button type="submit" class="btn btn-success">Добавить задачу</button>
        </div>
    </form>

    <ul class="list-group mt-3">
        @foreach($items as $item)
            <li class="list-group-item d-flex align-items-center justify-content-between">
                <div class="editable" data-item-id="{{ $item->id }}">{{ $item->name }}</div>
                <div>
                    <button class="btn btn-primary mr-2 edit-btn">Переименовать</button>
                    <button class="btn btn-primary save-btn d-none">Сохранить</button>
                    <button class="btn btn-success delete-btn" data-item-id="{{ $item->id }}">Выполнено!</button>
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
            $('.edit-btn').click(function () {
                let listItem = $(this).closest('li');
                let editableDiv = listItem.find('.editable');
                let editBtn = listItem.find('.edit-btn');
                let saveBtn = listItem.find('.save-btn');

                // Включаем режим редактирования
                editableDiv.attr('contenteditable', 'true');
                editableDiv.addClass('editing');

                // Показываем кнопку "Сохранить" и скрываем кнопку "Переименовать"
                editBtn.addClass('d-none');
                saveBtn.removeClass('d-none');
            });

            $('.save-btn').click(function () {
                let listItem = $(this).closest('li');
                let editableDiv = listItem.find('.editable');
                let editBtn = listItem.find('.edit-btn');
                let saveBtn = listItem.find('.save-btn');
                let itemId = editableDiv.data('item-id');
                let newText = editableDiv.text();

                // Выключаем режим редактирования
                editableDiv.attr('contenteditable', 'false');
                editableDiv.removeClass('editing');

                // Выполняем ajax-запрос
                $.ajax({
                    url: '/items/update',
                    type: 'POST',
                    data: {
                        itemId: itemId,
                        newText: newText,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        // Обработка успешного ответа от сервера
                        // ...
                        // console.log(response)
                    },
                    error: function (xhr, status, error) {
                        // Обработка ошибки
                        // ...
                    }
                });

                // Обновляем текст элемента списка с текстом из редактируемого div
                listItem.find('.editable').text(newText);

                // Показываем кнопку "Переименовать" и скрываем кнопку "Сохранить"
                editBtn.removeClass('d-none');
                saveBtn.addClass('d-none');
            });

            $('.delete-btn').click(function () {
                let listItem = $(this).closest('li');
                let itemId = $(this).data('item-id');

                // Выполняем ajax-запрос для удаления элемента из базы данных
                $.ajax({
                    url: '/items/delete',
                    type: 'POST',
                    data: {
                        itemId: itemId,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        // Обработка успешного ответа от сервера
                        // ...

                        // Удаляем элемент из списка
                        listItem.remove();
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

        $('form').submit(function(event) {
            event.preventDefault();

            let itemInput = $('#itemInput').val();

            // console.log(itemInput)
            // Выполняем AJAX-запрос для создания новой записи в базе данных
            $.ajax({
                url: '/items/create',
                type: 'POST',
                data: {
                    itemInput: itemInput,
                    rosterId: {{ $roster->id }},
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // Обработка успешного ответа от сервера
                    // ...
                    console.log(response)

                    // Очищаем поле ввода
                    $('#itemInput').val('');

                    // Добавляем новый элемент в список

                    let newItem = `<li class="list-group-item d-flex align-items-center justify-content-between">
                        <div class="editable" contenteditable="true" data-item-id="${response.itemId}">${itemInput}</div>
                        <div>
                            <button class="btn btn-primary mr-2 edit-btn">Переименовать</button>
                            <button class="btn btn-primary save-btn d-none">Сохранить</button>
                            <button class="btn btn-success delete-btn" data-item-id="${response.itemId}">Выполнено!</button>
                        </div>
                    </li>`;

                    $('.list-group').append(newItem);
                    // После добавления нового элемента вызываем функцию для привязки обработчиков событий
                    attachEventHandlers();
                },
                error: function(xhr, status, error) {
                    // Обработка ошибки
                    // ...
                }
            });
        });
    });
</script>
</body>
</html>

