<div class="row" id="label">
    <h6 class="text-center"><?php echo (isset($info['label'])) ? $info['label'] : '' ?></h6>
</div>
<div class="row" id="beforeSend">
    <div class="form-group py-2">
        <label for="login">Логин</label>
        <input type="text" class="form-control" name="login" id="loginField" value="">
    </div>
    <div class="form-group py-2">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" id="emailField" value="">
        <small id="error" class="form-text form-muted none"></small>
    </div>
</div>
<div class="row none" id="success">
    <h6>Успешно! Письмо с новыми данными для входа отправлено на почту</h6>
</div>
<div class="row none" id="fail">
    <h2>К сожалению  что-то пошлло не так, пожалуйстаб повторите процедуру  позже</h2>
</div>
