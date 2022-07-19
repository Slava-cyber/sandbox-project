<div class="form-group py-2">
    <label for="login">Логин</label>
    <input type="text" class="form-control" name="login_sign_in"
           placeholder="Введите свой логин" id="login_sign_in"
           value="<?= (!empty($_POST['login_sign_in'])) ? $_POST['login_sign_in'] : '' ?>">
    <small id="loginHelp" class="form-text form-muted none"></small>
</div>
<div class="form-group py-2">
    <label for="password">Пароль</label>
    <input type="password" class="form-control" name="password" placeholder="Введите пароль" id="password">
    <small id="passwordHelp" class="form-text form-muted none"></small>
    <small id="php_error" class="form-text form-muted error">
        <?= (!empty($data['error'])) ? $data['error'] : '' ?>
    </small>
</div>