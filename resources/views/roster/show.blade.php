<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="/css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>

@include('includes.head')

<div class="container">
    <div style="display: flex; width: 100%; margin-bottom: 20px">
        <div style="flex-grow: 1;"><a href="{{ route('rosters.index') }}">На главную</a></div>
        <div><a href="{{ route('tags.index') }}" class="text-dark">Управление тэгами</a></div>
    </div>

    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="editable-header">{{ $roster->name }}</h1>
        </div>
        <div>
            <button class="btn btn-secondary mr-2 edit-header-btn">Переименовать</button>
            <button class="btn btn-dark save-header-btn d-none">Сохранить</button>
        </div>
    </div>
    <br>

    <h4 class="text-secondary">Фильтр</h4>
    <form id="form_search_item" class="mb-3" action="{{ route('rosters.show', $roster->id) }}" method="GET">
        <div class="input-group mb-2">
            <input type="text" id="search_input" class="form-control" name="searchText" placeholder="Текст...">
            <button type="submit" class="btn btn-primary">Применить</button>
            <button type="button" id="reset-filter" class="btn btn-warning">Сбросить</button>
        </div>
        <div class="mb-3">
            <div class="text-secondary"><b>Только задачи с тегами:</b></div>
            @foreach($userTags as $userTag)
                <input type="checkbox" id="tag_{{ $userTag->id }}" name="tag[]" value="{{ $userTag->id }}">
                <label for="tag_{{ $userTag->id }}">{{ $userTag->name }}</label>
            @endforeach
        </div>
    </form>

    <h4 class="text-secondary">Новая задача</h4>
    <form id="form_add_item" class="d-flex">
        <div class="mb-3 me-2 flex-grow-1">
            <input type="text" id="itemInput" class="form-control border-primary" placeholder="Название...">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Добавить</button>
        </div>
    </form>


    <ul class="list-group mt-2">
        @foreach($items as $item)
            <x-item :item="$item" :userTags="$userTags"/>
        @endforeach

        @if(request()->has('searchText') && $items->isEmpty())
            <span class="text-danger">Задач с указанными условиями не найдено!</span>
        @endif
    </ul>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

<script>
    const token = '{{ csrf_token() }}'
</script>
<script src="/js/filter.js"></script>
<script src="/js/images.js"></script>

<script>
    // Функция для привязки обработчиков событий к кнопкам
    function attachEventHandlers() {

        $('.plus-tag').click(function () {
            $(this).closest('.tags-container').find('.tag-list-container').toggle();
        });

        $('.tag-list li').click(function () {
            $(this).closest('.tag-list-container').hide();
        });

        $('.delete-tag').click(function() {

            console.log('work')
            let tagElement = $(this);
            let tag = tagElement.parent();

            let itemId = tag.closest('.list-group-item').find('.editable').data('item-id');
            let tagId = tag.attr('id')

            console.log(111)

            // Отправка AJAX запроса
            $.ajax({
                url: '/items/delete_tag',
                type: 'POST',
                dataType: 'json',
                data: {
                    itemId: itemId,
                    tagId: tagId,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // Обновление интерфейса после успешного удаления
                    tag.remove();
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });

        $('.add-tag').click(function () {
            console.log('111')
            let plus = $('.plus-tag')

            let tagId = $(this).attr('id');

            let tagElement = $(this);
            let tag = tagElement.parent();
            let itemId = tag.closest('.list-group-item').find('.editable').data('item-id');
            console.log(itemId)

            // Отправка AJAX запроса
            $.ajax({
                url: '/items/add_tag',
                type: 'POST',
                dataType: 'json',
                data: {
                    itemId: itemId,
                    tagId: tagId,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // Обновление интерфейса после успешного добавления
                    let newTagElement = $('<span>').addClass('badge bg-info').attr('id', tagId).text(tagElement.text()).append('&nbsp;<i class="fas fa-times delete-tag"></i><br>');
                    tagElement.closest('.tags-container').find('.plus-tag').before(newTagElement);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        })

        $(document).click(function(event) {
            let target = $(event.target);
            if (!target.closest('.tag-list-container').length && !target.closest('.plus-tag').length) {
                $('.tag-list-container').hide();
            }
        });


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

            // Обновляем текст элемента листа с текстом из редактируемого div
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

                    // Удаляем элемент из листа
                    listItem.remove();
                },
                error: function (xhr, status, error) {
                    // Обработка ошибки
                    // ...
                }
            });
        });

        $('.edit-header-btn').click(function () {

            let editableDiv = $(".editable-header");
            console.log(editableDiv)

            let editHeaderBtn = $(".edit-header-btn");
            let saveHeaderBtn = $(".save-header-btn");

            // Включаем режим редактирования
            editableDiv.attr('contenteditable', 'true');
            editableDiv.addClass('editing');

            // Показываем кнопку "Сохранить" и скрываем кнопку "Переименовать"
            editHeaderBtn.addClass('d-none');
            saveHeaderBtn.removeClass('d-none');
        });

        $('.save-header-btn').click(function () {
            let editableDiv = $(".editable-header");
            let editHeaderBtn = $(".edit-header-btn");
            let saveHeaderBtn = $(".save-header-btn");
            let newText = editableDiv.text();

            // Выключаем режим редактирования
            editableDiv.attr('contenteditable', 'false');
            editableDiv.removeClass('editing');

            // Выполняем ajax-запрос
            $.ajax({
                url: '/rosters/update',
                type: 'POST',
                data: {
                    rosterId: {{ $roster->id }},
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

            // Обновляем текст заголовка с текстом из редактируемого div
            editableDiv.text(newText);

            // Показываем кнопку "Переименовать" и скрываем кнопку "Сохранить"
            editHeaderBtn.removeClass('d-none');
            saveHeaderBtn.addClass('d-none');
        });
    }

    // Вызываем функцию для привязки обработчиков событий при загрузке страницы
    attachEventHandlers();

    // Функция для создания новой задачи
    $('#form_add_item').submit(function(event) {
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

                // Добавляем новую задачу лист
                $('.list-group').append(response.html);

                // После добавления новой задачи вызываем функции для привязки обработчиков событий
                attachEventHandlers()
                attachImageButtonsHandlers()
            },
            error: function(xhr, status, error) {
                // Обработка ошибки
                // ...
            }
        });
    });

</script>
</body>
</html>

