<!DOCTYPE html>
<html lang="en">
<head>
    <metacharset="utf-8">
    <title>Создать ивент</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="profile">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a href="" class="navbar-brand p-2">Sandbox</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <div class="container-fluid d-flex justify-content-end">
                <ul class="navbar-nav nav-pills mr-auto">
                    <li class="nav-item text-center">
                        <a href="/main" class="nav-link" aria-current="main">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">Текущие ивенты</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link active">Создать ивент</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                           role="button" data-bs-toggle="dropdown" arai-expanded="false">
                            <img src="/images/system/profile1.png" alt="" width="40" height="40">
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="/profile/<?= $user->getLogin() ?>">Профиль</a></li>
                            <li><a class="dropdown-item" href="/profile/view">Безопасность</a></li>
                            <li><a class="dropdown-item" href="/profile/view">Архив</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout">Выход</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-9 bg-white p-3">
                <form name="eventAdd" method="POST" action="" id="eventAdd">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group py-2">
                            <!--    <label for="name">Заголовок</label> -->
                                <input type="text" name="title" class="form-control" placeholder="Заголовок" id="title"
                                       value="">
                                <small id="titleHelp" class="form-text form-muted none">Заголовок</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group py-2">
                                <input type="text" name="town" class="form-control" id="town" placeholder="<?php echo ($user->getTown() != null) ? $user->getTown() : "Город по умолчанию: Москва"; ?>"
                                       value="<?php echo ($user->getTown() != null) ? $user->getTown() : "Москва"; ?>">
                                <small id="townHelp" class="form-text form-muted none">Город</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group py-2">
                                <input type="datetime-local" name="datetime" class="form-control" id="datetime"
                                       value="">
                                <small id="datetimeHelp" class="form-text form-muted">Дата и время начала ивента:</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group py-2">
                                <select class="form-select form-control" name="category" id="category">
                                    <option value="Активный отдых">Активный отдых</option>
                                    <option value="Спорт">Спорт</option>
                                    <option value="Квесты/настольные игры">Квесты/настольные игры</option>
                                    <option value="Ночная жизнь">Ночная жизнь</option>
                                    <option value="Охота/рыбалка">Охота/рыбалка</option>
                                    <option value="Туризм">Туризм</option>
                                    <option value="Другое">Другое</option>
                                </select>
                                <small id="categoryHelp" class="form-text form-muted">Категория</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group py-2">
                                <select class="form-select form-control" disabled>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <small id="subcategoryHelp" class="form-text form-muted">Подкатегория</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group py-2">
                                <textarea class="form-control" id="description" rows="5" name="description" placeholder="Описание ивента" value=""></textarea>
                                <small id="interestHelp" class="form-text form-muted none">Описание ивента</small>
                            </div>
                        </div>
                        <div class="d-flex col-md-12 justify-content-center">
                            <button type="submit" class="btn btn-secondary my-2">Создать ивент</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <script src="../js/validation.js"> </script>
    <script src="../js/eventValidation.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>