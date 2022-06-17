<!DOCTYPE html>
<html lang="en">
<head>
    <metacharset="utf-8">
    <title>Регистрация</title>
    <meta bane="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
   <!-- <div class="container"> -->
        <div class="container" style="height: 100vh">
            <div class="row justify-content-center align-items-center" style="height:100vh">
                <div class="col-sm-12 col-md-6">
                    <h2 class="text-center">Регистрация</h2>
                    <form name="registration" method="POST" action="" id="form">
                        <div class="form-group py-2">
                            <label for="name">Имя</label>
                            <input type="text" name="name" class="form-control" placeholder="Введите имя" id="name">
                            <small id="nameHelp" class="form-text form-muted">Введите имя</small>
                        </div>
                        <div class="form-group py-2">
                            <label for="surname">Фамилия</label>
                            <input type="text" name="surname" class="form-control" placeholder="Введите фамилию" id="surname">
                            <small id="surnameHelp" class="form-text form-muted">Введите фамилию</small>
                        </div>
                        <div class="form-group py-2">
                            <label for="birth_date">Дата рождения</label>
                            <input type="date" class="form-control" name="birth_date" placeholder="Выберите дату рождения" min="1920-01-01" max="2022-05-01" id="birth_date">
                            <small id="birthHelp" class="form-text form-muted">Выберите дату рождения</small>
                        </div>

                        <div class="form-group py-2">
                            <label>Укажите ваш пол</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="radio1" name="gender" value="Male" checked>
                                <label for="radio1" class="form-check-label">Мужской</label><br/>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="radio2" name="gender" value="Female">
                                <label for="radio2" class="form-check-label">Женский</label><br/>
                            </div>
                            <small id="genderHelp" class="form-text form-muted"></small>
                        </div>

                        <div class="form-group py-2">
                            <label for="login">Логин</label>
                            <input type="text" class="form-control" name="login" placeholder="Введите свой логин" id="login">
                            <small id="loginHelp" class="form-text form-muted">Введите свой логин</small>
                        </div>
                        <div class="form-group py-2">
                            <label for="password">Пароль</label>
                            <input type="text" class="form-control" name="password" placeholder="Введите пароль" id="password">
                            <small id="passwordHelp" class="form-text form-muted">Введите пароль</small>
                        </div>
                        <div class="form-group py-2">
                            <label for="password_confirm">Подтверждение пароля</label>
                            <input type="text" class="form-control" name="password_confirm" placeholder="Подтвердите пароль" id="password_confirm">
                            <small id="password_confirmHelp" class="form-text form-muted">Подтвердите пароль</small>
                        </div>
                        <?php if (!empty($error)): ?>
                            <div class="form-group my-2" name="error" style="box-shadow: 0 0 1px red;"><?= $error ?></div>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-secondary w-100 my-2">Зарегистрироваться</button>
                        <div class="col-sm-12 col-md-8 w-100 text-center">
                            У вас уже есть аккаунт? - <a href="/login">Авторизируйтесь</a>
                        </div>
                        <!--<button type="submit" class="register-button">Зарегистрироваться</button>-->
                    </form>
                </div>
            </div>
        </div>
    <!--</div>-->


    <script src="js/registrationValidation.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
