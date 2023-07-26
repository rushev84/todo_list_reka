
function attachImageButtonsHandlers() {





    $('.add-image').click(function () {

        // Создаем элемент input типа file
        const fileInput = document.createElement('input')
        fileInput.type = 'file'
        fileInput.setAttribute('id', 'fileInput')
        fileInput.setAttribute('name', 'fileInput')

        const itemId = $(this).data('item-id')

        // Находим текущий контейнер с изображением и кнопками
        const imgCont = $(this).closest('.imgcont')

        // Добавляем обработчик события изменения файла
        fileInput.addEventListener('change', function () {

            const formData = new FormData()
            formData.append('fileInput', fileInput.files[0])

            $.ajax({
                url: `/items/${itemId}/add_image`,
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                processData: false,
                contentType: false,
                success: function (response) {
                    imgCont.html(response.html)
                    attachImageButtonsHandlers()
                },
                error: function (xhr, status, error) {
                    // Обработка ошибки
                }
            });
        });

        // Запускаем окно выбора файла
        fileInput.click()
    });

    $('.delete-image').click(function () {

        const itemId = $(this).data('item-id')
        const imgCont = $(this).closest('.imgcont')

        $.ajax({
            url: `/items/${itemId}/delete_image`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            processData: false,
            contentType: false,
            success: function (response) {
                imgCont.html(response.html)
                attachImageButtonsHandlers()
            },
            error: function (xhr, status, error) {
                // Обработка ошибки
            }
        });
    });

    $('.preview-image').click(function () {
        const fullImage = $(this).data('full-image')
        window.open('/storage/images/' + fullImage, '_blank')
    });

}

attachImageButtonsHandlers()
