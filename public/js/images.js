/**
 * Добавляет изображение в задачу.
 * @param {HTMLElement} button - Кнопка, по которой произведён клик.
 * @param {string} itemId - Идентификатор задачи.
 * @returns {void}
 */
function addImage(button, itemId) {

    // Создаем элемент input типа file
    let fileInput = document.createElement('input')
    fileInput.type = 'file'
    fileInput.setAttribute('id', 'fileInput')
    fileInput.setAttribute('name', 'fileInput')

    // Находим текущий контейнер с изображением и кнопками
    let imgCont = $(button).closest('.imgcont')

    // Добавляем обработчик события изменения файла
    fileInput.addEventListener('change', function () {

        let formData = new FormData()
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

                console.log(response)
                // imgCont.html('<div>sdfsdf</div>')

                // Обработка успешного ответа от сервера
                // Можно обновить изображение на странице

            },
            error: function (xhr, status, error) {
                // Обработка ошибки
            }
        });
    });

    // Запускаем окно выбора файла
    fileInput.click()
}

/**
 * Удаляет изображение из задачи.
 * @param {string} itemId - Идентификатор задачи.
 * @returns {void}
 */
function deleteImage(itemId) {

    $.ajax({
        url: `/items/${itemId}/delete_image`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        processData: false,
        contentType: false,
        success: function(response) {

            console.log(response)
            // imgCont.html('<div>sdfsdf</div>')

            // Обработка успешного ответа от сервера
            // Можно обновить изображение на странице

        },
        error: function(xhr, status, error) {
            // Обработка ошибки
        }
    });
}
