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

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-9 bg-white p-3">
                <form name="profile" method="POST" action="" id="profile">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <div class="d-flex flex-column align-items-center text-center py-5">
                                <div class="profile-img">
                                    <img class="rounded-circle" id="image" src="<?php echo ($user->getAvatar() != null) ? $user->getAvatar() : "/images/system/avatar_null.jpg"; ?>" width="200px" alt=""/>
                                    <div class="file_item form-group">
                                        <small id="nameHelp" class="form-text form-muted none">Имя</small>
                                        <input type="file" accept=".jpg, .png" id="avatar" name="file" class="file_input">
                                        <div class="file_button">Загрузить фотографию</div>

                                        <input type="hidden" name="path_image" id="path_image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <strong>Общая информация</strong>
                        <hr class="separator mt-0">
                    </div>
                    <div class="row justify-content between">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group py-2">
                                <label for="name">Имя</label>
                                <input type="text" name="name" class="form-control" placeholder="Введите имя" id="name"
                                       value="<?= $user->getName() ?>">
                                <small id="nameHelp" class="form-text form-muted none">Имя</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group py-2">
                                <label for="name">Фамилия</label>
                                <input type="text" name="surname" class="form-control" placeholder="Введите фамилию" id="surname"
                                       value="<?= $user->getSurname() ?>">
                                <small id="surnameHelp" class="form-text form-muted none">Фамили</small>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content between">
                        <div class="col-md-6">
                            <div class="form-group py-2">
                                <label for="birth_date">Дата рождения</label>
                                <input type="date" class="form-control" name="date_of_birth" placeholder="Выберите дату рождения"
                                       min="1920-01-01" max="2022-05-01" id="date_of_birth" value="<?= $user->getDateOfBirth() ?>">
                                <small id="birthHelp" class="form-text form-muted none">Выберите дату рождения</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group py-2">
                                <label for="name">Город</label>
                                <input type="text" name="town" class="form-control" placeholder="Введите город" id="town"
                                       value="<?= $user->getTown() ?>">
                                <small id="townHelp" class="form-text form-muted none">Город</small>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <strong>Контакты</strong>
                        <hr class="separator mt-0">
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Номер телефона</label>
                                <input type="text" name="phone_number" class="form-control"  placeholder="Введите номер телефона"
                                       value="<?= $user->getPhoneNumber() ?>" id="phone_number">
                                <small id="phoneHelp" class="form-text form-muted none">Номер телефона</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class=" mt-3">
                                    <strong>Личная информация</strong>
                                    <hr class="separator mt-0">
                                </div>
                                <div class="form-group">
                                    <label for="name">Интересы</label>
                                    <textarea class="form-control" id="interest" rows="5" name="interest" placeholder="Опишите свои интересы" value=""><?= $user->getInterest() ?></textarea>
                                    <small id="interestHelp" class="form-text form-muted none">Интересы</small>
                                </div>
                                <div class="form-group py-2">
                                    <label for="name">О себе</label>
                                    <textarea class="form-control" id="description" rows="10" name="description" placeholder="Расскажите о себе" value=""><?= $user->getDescription() ?></textarea>
                                    <small id="aboutHelp" class="form-text form-muted none">О себе</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-secondary my-2">Редактировать</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/validation.js"> </script>
    <script src="../js/profileValidation.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>