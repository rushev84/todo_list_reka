<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Form</title>
</head>
<body>
<form id="form_add_item" class="d-flex" method="POST" action="/items/3/upload_image" enctype="multipart/form-data">
@csrf <!-- добавьте это для защиты от CSRF атак-->
    <div class="mb-3 me-2 flex-grow-1">
        <input type="file" id="fileInput" name="fileInput" class="form-control border-primary">
    </div>
    <div>
        <button type="submit" class="btn btn-primary">Добавить</button>
    </div>
</form>

</body>
</html>
