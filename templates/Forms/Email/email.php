<div class="row py-2">
    <h2>Email</h2>
    <hr class="separator mt-1">
</div>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="form-group py-2">
            <div class="pb-3">
                <label for="email">Укажите email для восстановления пароля:</label>
            </div>
            <input type="email" class="form-control" name="email"
                   placeholder="" value="<?php echo ($user->getEmail() != null) ? $user->getEmail() : '' ?>" id="email">
            <small id="emailHelp" class="form-text form-muted"></small>
        </div>
    </div>
</div>