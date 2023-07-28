<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Регистрация</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="name">Имя</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                        </div>

                        <div class="form-group mb-4">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="password">Пароль</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="password_confirmation">Подтверждение пароля</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
