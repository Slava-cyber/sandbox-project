<!DOCTYPE html>
<html lang="en">
<head>
    <metacharset="utf-8">
    <title>Авторизация</title>
    <meta bane="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
</head>
    <div class="container" style="height: 100vh">
        <div class="row justify-content-center align-items-center" style="height:100vh">
            <div class="col-sm-12 col-md-4">
                <h2 class="text-center">Авторизация</h2>
                <form name="login" id="login" method="POST" action="" id="form">
                    <div class="form-group py-2">
                        <label for="login">Логин</label>
                        <input type="text" class="form-control" name="login_sign_in" placeholder="Введите свой логин" id="login_sign_in">
                        <small id="loginHelp" class="form-text form-muted">Введите свой логин</small>
                    </div>
                    <div class="form-group py-2">
                        <label for="password">Пароль</label>
                        <input type="password" class="form-control" name="password" placeholder="Введите пароль" id="password">
                        <small id="passwordHelp" class="form-text form-muted">Введите пароль</small>
                    </div>
                    <?php if (!empty($error)): ?>
                        <div class="form-group my-2" name="error" style="box-shadow: 0 0 1px red;"><?= $error ?></div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-secondary w-100 my-2">Войти</button>
                    <div class="col-sm-12 col-md-8 w-100 text-center">
                        У вас еще нет аккаунта? - <a href="/registration">Зарегистрируйтесь</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/registrationValidation.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>





