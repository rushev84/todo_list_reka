<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        @media (min-width: 1000px) {
            .container {
                max-width: 900px;
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
@include('includes.head')
<div class="container">
    <div style="display: flex; width: 100%; margin-bottom: 20px">
        <div style="flex-grow: 1;"><a href="{{ route('rosters.index') }}">На главную</a></div>
    </div>
    <h1>Тэги</h1>
    <br>
    <form class="d-flex">
        <div class="mb-3 me-2 flex-grow-1">
            <input type="text" id="name" class="form-control border-primary" placeholder="Название тэга">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Добавить тэг</button>
        </div>
    </form>

    <ul class="list-group mt-3">
        @foreach($tags as $tag)
            <li class="list-group-item d-flex align-items-center justify-content-between">
                <div class="editable" data-tag-id="{{ $tag->id }}">
                    {{ $tag->name }}
                </div>
                <div>
                    <button class="btn btn-danger delete-btn" data-tag-id="{{ $tag->id }}">Удалить</button>
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
                let listTag = $(this).closest('li');
                let tagId = $(this).data('tag-id');

                // Выполняем ajax-запрос для удаления элемента из базы данных
                $.ajax({
                    url: '/tags/delete',
                    type: 'POST',
                    data: {
                        tagId: tagId,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        // Обработка успешного ответа от сервера
                        // ...

                        // Удаляем элемент из списка
                        listTag.remove();
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

            let name = $('#name').val();

            // Выполняем AJAX-запрос для создания новой записи в базе данных
            $.ajax({
                url: '/tags/create',
                type: 'POST',
                data: {
                    name: name,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // Обработка успешного ответа от сервера
                    // ...
                    console.log(response)

                    // Очищаем поле ввода
                    $('#name').val('');

                    let tagId = response.tagId;

                    // Добавляем новый элемент в список
                    let newTag = `<li class="list-group-item d-flex align-items-center justify-content-between">
                        <div class="editable" data-tag-id="${tagId}">
                            ${name}
                        </div>
                        <div>
                            <button class="btn btn-danger delete-btn" data-tag-id="${tagId}">Удалить</button>
                        </div>
                    </li>`;


                    $('.list-group').append(newTag);
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

