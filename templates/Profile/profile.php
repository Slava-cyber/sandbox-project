<!DOCTYPE html>
<html lang="en">
<head>
    <metacharset="utf-8">
    <title>Профиль</title>
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
                        <a href="/event/add" class="nav-link">Создать ивент</a>
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

    <div class="container profile-content mt-5 px-0">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center py-5">
                    <img class="rounded-circle" width="150px" src="<?php echo ($user->getAvatar() != null) ? $user->getAvatar() : "/images/system/avatar_null.jpg"; ?>">
                    <span class="font-weight-bold"><?= $user->getLogin() ?></span>
                    <span class="text-black-50">Рейтинг: 0</span>
                    <span class="text-black-50">Всего отзывов: 0</span>
                    <a href="#" class="btn btn-secondary btn-sm" role="button" aria-disabled="true">Архив</a>
                    <span> </span>
                </div>
            </div>
            <div class="col-md-9 justify-content-start p-5">
                <div class="row gy-2">
                    <strong>Основная информация</strong>
                    <hr class="separator mt-0">
                    <div class="col-sm-3">
                        <strong>ФИО:</strong>
                    </div>
                    <div class="col-sm-9 justify-content-start">
                        <?= $user->getName() ?> <?= $user->getSurname() ?>
                    </div>
                    <div class="col-sm-3">
                        <strong>Дата рождения:</strong>
                    </div>
                    <div class="col-sm-9 justify-content-start">
                        <?= $user->getDateOfBirth() ?>
                    </div>
                    <div class="col-sm-3">
                        <strong>Город:</strong>
                    </div>
                    <div class="col-sm-9 justify-content-start">
                        <?= $user->getTown() ?>
                    </div>
                    <div class="col-sm-12 justify-content-start mt-3">
                        <strong>Контакты</strong>
                    </div>
                    <hr class="separator mt-0">
                    <div class="col-sm-3">
                        <strong>Телефон:</strong>
                    </div>
                    <div class="col-sm-9 justify-content-start">
                        <?= $user->getPhoneNumber() ?>
                    </div>
                    <div class="col-sm-12 justify-content-start mt-3">
                        <strong>Личная информация</strong>
                    </div>
                    <hr class="separator mt-0">
                    <div class="col-sm-12">
                        <strong>Интересы:</strong>
                    </div>
                    <div class="col-sm-12 justify-content-start">
                        <div class="text p-2">
                            <?= $user->getInterest() ?>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <strong>О себе:</strong>
                    </div>
                    <div class="col-sm-12 justify-content-start">
                        <div class="text p-2">
                            <?= $user->getDescription() ?>
                        </div>
                    </div>
                    <div class="col-sm-12 text-end">
                        <a href="/profile/edit" class="btn btn-secondary" role="button" aria-disabled="true">Редактировать профиль</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- <script src="js/registrationValidation.js"> </script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>