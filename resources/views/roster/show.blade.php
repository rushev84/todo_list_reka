<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        @media (min-width: 1000px) {
            .container {
                max-width: 900px;
            }
        }
        .editing {
            border: 2px solid #000;
            padding: 4px;
        }

        .delete-tag, .add-tag {
            cursor: pointer;
        }

        .tag-list-container {
            position: absolute;
            top: 20px;
            right: 215px;
            z-index: 1;
            background-color: #fff;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-height: 200px;
            overflow-y: auto;
        }

        .tag-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .tag-list li {
            padding: 5px 10px;
            margin-bottom: 5px;
            background-color: #f5f5f5;
            border-radius: 4px;
        }

        .tag-list li:last-child {
            margin-bottom: 0;
        }

        .tag-list li:hover {
            background-color: #e9e9e9;
            cursor: pointer;
        }

        .user-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color: #f8f9fa;
            flex-direction: row-reverse;
        }

        .image-container {
            border-radius: 7px;
            overflow: hidden;
        }

        .extra-small {
            font-size: 12px;
        }

        .preview-image {
            cursor: pointer;
        }

        .add-preview {
            cursor: pointer;
        }

    </style>
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
            <button type="button" class="btn btn-warning" onclick="resetFilter()">Сбросить</button>
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
        @forelse($items as $item)
            <li class="list-group-item d-flex align-items-center justify-content-between">
                <div>
                    @if($item->preview_image === 'grey.jpg')
                        <div class="image-container">
                            <img src="/storage/images/{{ $item->preview_image }}" data-full-image="/storage/images/{{ $item->image }}" alt="" width="70" height="70" class="no-preview-image">
                        </div>
                        <div class="text-center d-flex justify-content-center">
                            <div>
                                <a class="add-preview" data-item-id="{{ $item->id }}">
                                    <i class="fas fa-plus extra-small add-preview"></i>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="image-container">
                            <img src="/storage/images/{{ $item->preview_image }}" data-full-image="/storage/images/{{ $item->image }}" alt="" width="70" height="70" class="preview-image">
                        </div>
                        <div class="text-center d-flex justify-content-center">
                            <div style="margin-right: 2px">
                                <a href="#">
                                    <i class="fas fa-sync-alt extra-small"></i>
                                </a>
                            </div>
                            <div style="margin-left: 2px">
                                <a href="#">
                                    <i class="fas fa-trash extra-small text-danger"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>


                <div style="flex-grow: 1; padding-left: 10px" class="editable" data-item-id="{{ $item->id }}">{{ $item->name }}</div>
                <div class="tags-container d-flex align-items-center">
                    <div class="tags mr-20">
                        @foreach($item->tags as $tag)
                            <span class="badge bg-info" id="{{ $tag->id }}">{{ $tag->name }}&nbsp;<i class="fas fa-times delete-tag"></i></span>
                        @endforeach
                        <span class="badge bg-primary plus-tag"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="tag-list-container" style="display: none;">
                        <ul class="tag-list">
                            @foreach($userTags as $userTag)
                                <li id="{{ $userTag->id }}" class="add-tag">{{ $userTag->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div style="margin-left: 5px">
                        <button class="btn btn-secondary edit-btn">Переименовать</button>
                        <button class="btn btn-dark save-btn d-none">Сохранить</button>
                        <button class="btn btn-success delete-btn" data-item-id="{{ $item->id }}">Выполнено!</button>
                    </div>
                </div>
            </li>
        @empty
            <span class="text-danger">Задач с указанными условиями не найдено!</span>
        @endforelse
    </ul>


</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>


<script>

    $('.add-preview').click(function () {
        // Создаем элемент input типа file
        let fileInput = document.createElement('input');
        fileInput.type = 'file';

        // ПОЛУЧИТЬ itemId, передать его в ajax, в методе на сервере менять значение в БД, возвращать в response новый урл (только превью или нет?)

        let itemId = $(this).attr('data-item-id')


        // Добавляем обработчик события изменения файла
        fileInput.addEventListener('change', function() {
            var file = fileInput.files[0];

            var formData = new FormData();
            formData.append('file', file);

            $.ajax({
                url: '/items/' + itemId + '/upload_image',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                processData: false,
                contentType: false,
                success: function(response) {

                    console.log(response)

                    // console.log(response.imageUrl)
                    // Обработка успешного ответа от сервера
                    // Можно обновить изображение на странице

                    $('#preview-image').attr('src', response.imageUrl);
                },
                error: function(xhr, status, error) {
                    // Обработка ошибки
                }
            });
        });

        // Запускаем окно выбора файла
        fileInput.click();

    })


   $('.preview-image').click(function () {
       let fullImage = $(this).attr('data-full-image');
       window.open(fullImage, '_blank');







        {{--console.log($(this).closest('.list-group-item').find('.editable').data('item-id'))--}}


    });

    function resetFilter() {
        document.getElementById("form_search_item").action = window.location.href;
        document.getElementById("form_search_item").submit();
    }

    $(document).ready(function() {

        $('.plus-tag').click(function () {
            $(this).closest('.d-flex').find('.tag-list-container').toggle();
        });

        $('.tag-list li').click(function () {
            $(this).closest('.tag-list-container').hide();
        });

        $('.delete-tag').click(function() {

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

                    // Добавляем новый элемент в лист

                    let newItem = `<li class="list-group-item d-flex align-items-center justify-content-between">




                        <div class="editable" data-item-id="${response.itemId}">${itemInput}</div>
                        <div>
                            <button class="btn btn-secondary mr-2 edit-btn">Переименовать</button>
                            <button class="btn btn-dark save-btn d-none">Сохранить</button>
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

