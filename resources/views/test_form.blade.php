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
<form id="form_add_item" class="d-flex" method="POST" action="/items/56/delete_image" enctype="multipart/form-data">
@csrf <!-- добавьте это для защиты от CSRF атак-->
    <div>
        <button type="submit" class="btn btn-primary">Добавить</button>
    </div>
</form>

</body>
</html>
