<!DOCTYPE html>
<html lang="en">
<head>
    <metacharset="utf-8">
    <title>Главная</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
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
                        <a href="" class="nav-link active" aria-current="main">Главная</a>
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
                            <li><a class="dropdown-item" href="/profile">Безопасность</a></li>
                            <li><a class="dropdown-item" href="/profile">Архив</a></li>
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
            <div class="col-md-10 col-sm-12 bg-white p-3">
                <div class="row">
                    <form name="search" method="POST" action="" id="search">
                        <div class="row">
                            <div class="form-group py-2">
                                <input type="text" name="title" placeholder="Заголовок" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        Дополнительные параметры
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-5 col-sm-12">
                                                <div class="form-group py-2">
                                                    <input type="text" name="town" placeholder="Город" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group py-2">
                                                    <input type="date" name="date" placeholder="Дата" class="form-control">
                                                    <small id="dateHelp" class="form-text form-muted">Укажите дату</small>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12">
                                                <div class="form-group py-2">
                                                    <input type="time" name="time" class="form-control">
                                                    <small id="timeHelp" class="form-text form-muted">Укажите время</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-12">
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
                                            <div class="col-md-5 col-sm-12">
                                                <div class="form-group py-2">
                                                    <select class="form-select form-control" disabled>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                    <small id="categoryHelp" class="form-text form-muted">Подкатегория</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 d-grid text-end">
                                <button type="submit" class="btn btn-secondary my-2">Найти</button>
                            </div>
                        </div>
                    </form>
                </div>
                <hr class="separator mt-1">
                <div class="d-flex flex-row">
                    <div class="d-sm-inline-flex col-md-12">
                        Сортировать:
                        <div class="me-3 ms-3">
                            <a href="/profile/edit">Время</a>
                        </div>
                        <div class="me-3 ms-3">
                            <a href="/profile/edit" clas="me-3 ms-3" >Рейтинг</a>
                        </div>
                    </div>
                </div>
                <hr class="separator mt-1">
                <?php foreach ($events as $event) {?>
               <!-- <div class="row"> -->
                    <div class="col-md-12">
                        <h3><?= $event->getTitle() ?></h3>
                    </div>
                    <div class="d-sm-inline-flex col-md-12">
                        <div class="me-3">
                            Категория:
                        </div>
                        <div class="me-3">
                            <strong><?= $event->getCategory() ?></strong>
                        </div>
                        <div class="me-3">
                            Дата и время:
                        </div>
                        <div class="me-3">
                            <strong><?= $event->getDate() ?></strong>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p>
                            <a class="link-dark" data-bs-toggle="collapse" href="#collapseExample<?= $event->getId() ?>" role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Дополнительная информация
                            </a>
                        </p>
                        <div class="collapse" id="collapseExample<?= $event->getId() ?>">
                            <div class="d-sm-inline-flex col-md-12 mb-3">
                                <div class="me-3">
                                    Автор:
                                </div>
                                <div class="me-3">
                                    <a href="/profile/<?= $event->getAuthor()->getLogin() ?>">
                                        <?= $event->getAuthor()->getLogin() ?>
                                    </a>
                                </div>
                                <div class="me-3">
                                    Рейтинг:
                                </div>
                                <div class="me-3">
                                    <strong>5.0</strong>
                                </div>
                                <div class="me-3">
                                    Город:
                                </div>
                                <div>
                                    <strong><?= $event->getTown() ?></strong>
                                </div>
                            </div>
                            <div class="com-md-12 card card-body">
                                <?= $event->getDescription() ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <a href="#" role="button">Отправить запрос</a>
                        <div class="col-md-12">
                            <span class="text-primary">Статус запроса: Ожидает ответа</span>
                        </div>
                    </div>
                    <hr class="separator mt-1">
               <!-- </div> -->
                <?php } ?>
                <hr class="separator mt-1">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Виртуальная реальность Академгородок</h3>
                    </div>
                    <div class="d-sm-inline-flex col-md-12">
                        <div class="me-3">
                            Категория:
                        </div>
                        <div class="me-3">
                            <strong>Квесты</strong>
                        </div>
                        <div class="me-3">
                            Дата и время:
                        </div>
                        <div class="me-3">
                            <strong>12.08.22
                                12:00</strong>
                        </div>
                    </div>
                    <!--           <div class="d-sm-inline-flex col-md-12">
                                   <div class="me-3">
                                       Автор:
                                   </div>
                                   <div class="me-3">
                                       <a href="/profile/test7 class="me-3 ms-3">test7</a>
                                   </div>
                                   <div class="me-3">
                                       Рейтинг:
                                   </div>
                                   <div class="me-3">
                                       <strong>5.0</strong>
                                   </div>
                                   <div class="me-3">
                                       Город:
                                   </div>
                                   <div>
                                       <strong>Новосибирск</strong>
                                   </div>
                               </div> -->
                    <div class="col-md-12">
                        <p>
                            <a class="link-dark" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Дополнительная информация
                            </a>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <div class="d-sm-inline-flex col-md-12 mb-3">
                                <div class="me-3">
                                    Автор:
                                </div>
                                <div class="me-3">
                                    <a href="/profile/test7">test7</a>
                                </div>
                                <div class="me-3">
                                    Рейтинг:
                                </div>
                                <div class="me-3">
                                    <strong>5.0</strong>
                                </div>
                                <div class="me-3">
                                    Город:
                                </div>
                                <div>
                                    <strong>Новосибирск</strong>
                                </div>
                            </div>
                            <div class="com-md-12 card card-body">
                                Описание Некоторый заполнитель для компонента сворачивания. Эта панель по умолчанию скрыта, но открывается, когда пользователь активирует соответствующий триггер.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <a href="#" role="button">Отправить запрос</a>
                        <div class="col-md-12">
                            <span class="text-primary">Статус запроса: Ожидает ответа</span>
                        </div>
                    </div>
                    <hr class="separator mt-1">
                </div>
            </div>
        </div>
    </div>


    <?= !empty($user) ? 'Привет, ' . $user->getLogin() : 'Войдите на сайт' ?>
    <!-- <script src="js/registrationValidation.js"> </script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>