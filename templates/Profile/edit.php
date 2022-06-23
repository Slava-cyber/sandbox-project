<!DOCTYPE html>
<html lang="en">
<head>
    <metacharset="utf-8">
    <title>Профиль</title>
    <meta bane="viewport" content="width=device-width, initial-scale=1">
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
                    <a href="" class="nav-link active" aria-current="main">Главная</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Текущие ивенты</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Создать ивент</a>
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
            <form name="registration" method="POST" action="" id="registration">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="d-flex flex-column align-items-center text-center py-5">
                            <div class="profile-img">
                                <img src="/images/system/cat.jpg" width="150px" alt=""/>
                                <div class="file btn btn-lg btn-primary">
                                    <label>Change Photo</label>
                                    <input type="file" name="file" class="file"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold">Edogaru</span><span class="text-black-50">edogaru@mail.com.my</span><span> </span></div>-->
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
                                   value="<?= $user->getName() ?>">
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
                            <input type="text" name="name" class="form-control" placeholder="Введите имя" id="town"
                                   value="<?= $user->getName() ?>">
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
                            <input type="text" name="name" class="form-control"  placeholder="Введите номер телефона" id="phoneNumber">
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
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                          value="<?= $user->getTown() ?>">

                                </textarea>
                               <!--     <input type="text" name="surname" class="form-control" placeholder="Введите имя" id="surname"> -->
                                <small id="interestHelp" class="form-text form-muted none">Интересы</small>
                            </div>
                            <div class="form-group py-2">
                                <label for="name">О себе</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="10"
                                          value="<?= $user->getName() ?>">

                                </textarea>
                                <!--     <input type="text" name="surname" class="form-control" placeholder="Введите имя" id="surname"> -->
                                <small id="aboutHelp" class="form-text form-muted none">О себе</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-end">
                        <a href="/profile/edit" class="btn btn-secondary" role="button" aria-disabled="true">Редактировать профиль</a>
                    </div>
                </div>


               <!-- <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Name</label><input type="text" class="form-control" placeholder="first name" value=""></div>
                        <div class="col-md-6"><label class="labels">Surname</label><input type="text" class="form-control" value="" placeholder="surname"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Mobile Number</label><input type="text" class="form-control" placeholder="enter phone number" value=""></div>
                        <div class="col-md-12"><label class="labels">Address Line 1</label><input type="text" class="form-control" placeholder="enter address line 1" value=""></div>
                        <div class="col-md-12"><label class="labels">Address Line 2</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
                        <div class="col-md-12"><label class="labels">Postcode</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
                        <div class="col-md-12"><label class="labels">State</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
                        <div class="col-md-12"><label class="labels">Area</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
                        <div class="col-md-12"><label class="labels">Email ID</label><input type="text" class="form-control" placeholder="enter email id" value=""></div>
                        <div class="col-md-12"><label class="labels">Education</label><input type="text" class="form-control" placeholder="education" value=""></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6"><label class="labels">Country</label><input type="text" class="form-control" placeholder="country" value=""></div>
                        <div class="col-md-6"><label class="labels">State/Region</label><input type="text" class="form-control" value="" placeholder="state"></div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Save Profile</button></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center experience"><span>Edit Experience</span><span class="border px-3 p-1 add-experience"><i class="fa fa-plus"></i>&nbsp;Experience</span></div><br>
                    <div class="col-md-12"><label class="labels">Experience in Designing</label><input type="text" class="form-control" placeholder="experience" value=""></div> <br>
                    <div class="col-md-12"><label class="labels">Additional Details</label><input type="text" class="form-control" placeholder="additional details" value=""></div>
                </div>
            </div>-->
        </div>
    </div>
</div>

<!-- <script src="js/registrationValidation.js"> </script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>