<!DOCTYPE html>
<html lang="en">
<head>
    <metacharset="utf-8">
    <title>Регистрация</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
</head>
        <div class="container" style="height: 100vh">
            <div class="row justify-content-center align-items-center" style="height:100vh">
                <div class="col-sm-12 col-md-6">
                    <h2 class="text-center">Регистрация</h2>
                    <form name="registration" method="POST" action="" id="registration">
                        <div class="form-group py-2">
                            <label for="name">Имя</label>
                            <input type="text" name="name" class="form-control" placeholder="Введите имя" id="name">
                            <small id="nameHelp" class="form-text form-muted none">Введите имя</small>
                        </div>
                        <div class="form-group py-2">
                            <label for="surname">Фамилия</label>
                            <input type="text" name="surname" class="form-control" placeholder="Введите фамилию" id="surname">
                            <small id="surnameHelp" class="form-text form-muted none">Введите фамилию</small>
                        </div>
                        <div class="form-group py-2">
                            <label for="birth_date">Дата рождения</label>
                            <input type="date" class="form-control" name="date_of_birth" placeholder="Выберите дату рождения" min="1920-01-01" max="2022-05-01" id="date_of_birth">
                            <small id="birthHelp" class="form-text form-muted">Выберите дату рождения</small>
                        </div>

                        <div class="form-group py-2">
                            <label>Укажите ваш пол</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="sex" name="sex" value="Male" checked>
                                <label for="radio1" class="form-check-label">Мужской</label><br/>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="sex" name="sex" value="Female">
                                <label for="radio2" class="form-check-label">Женский</label><br/>
                            </div>
                        </div>

                        <div class="form-group py-2">
                            <label for="login">Логин</label>
                            <input type="text" class="form-control" name="login_sign_up" placeholder="Введите свой логин" id="login_sign_up">
                            <small id="loginHelp" class="form-text form-muted none">Введите свой логин</small>
                        </div>
                        <div class="form-group py-2">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" name="password_sign_up" placeholder="Введите пароль" id="password_sign_up">
                            <small id="passwordHelp" class="form-text form-muted none">Введите пароль</small>
                        </div>
                        <div class="form-group py-2">
                            <label for="password_confirm">Подтверждение пароля</label>
                            <input type="password" class="form-control" name="password_confirm" placeholder="Подтвердите пароль" id="password_confirm">
                            <small id="password_confirmHelp" class="form-text form-muted none">Подтвердите пароль</small>
                        </div>
                            <div class="form-group my-2" name="error" style="box-shadow: 0 0 1px red;" id="php_error">
                                <?php if (!empty($error)): ?> <?= $error ?> <?php endif; ?>
                            </div>
                        <button type="submit" class="btn btn-secondary w-100 my-2">Зарегистрироваться</button>
                        <div class="col-sm-12 col-md-8 w-100 text-center">
                            У вас уже есть аккаунт? - <a href="/login">Авторизируйтесь</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <script src="js/validation.js"> </script>
    <script src="js/registrationValidation.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
