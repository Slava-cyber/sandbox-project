<?php foreach ($data as $nameField => $value) : ?>
    <?php if ($nameField == 'sex') : ?>
        <div class="form-group py-2">
            <label>Укажите ваш пол</label>
            <div class="form-check">
                <input type="radio" class="form-check-input" id="Male" name="sex" value="Мужской" checked>
                <label for="Male" class="form-check-label">Мужской</label><br/>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" id="Female" name="sex" value="Женский">
                <label for="Female" class="form-check-label">Женский</label><br/>
            </div>
        </div>
    <?php elseif ($nameField == 'date_of_birth') : ?>
        <div class="form-group py-2">
            <label for="birth_date">Дата рождения</label>
            <input type="date" class="form-control" name="date_of_birth" placeholder="Выберите дату рождения"
                   min="<?= date('Y-m-d', $value['min']) ?>" max="<?= date('Y-m-d', $value['max']) ?>" id="date_of_birth">
            <small id="birthHelp" class="form-text form-muted">Выберите дату рождения</small>
        </div>
    <?php elseif ($nameField != 'error') : ?>
        <div class="form-group py-2">
            <label for="<?= $nameField ?>"><?= $value['label'] ?></label>
            <input type="<?= $value['type'] ?>" name="<?= $nameField ?>"
                   class="form-control" placeholder="<?= $value['placeholder'] ?>" id="<?= $nameField ?>">
            <small id="<?= $nameField . 'Help' ?>" class="form-text form-muted none">Введите имя</small>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<div class="form-group my-2" name="error" style="box-shadow: 0 0 1px red;" id="php_error">
    <?php if (!empty($data['error'])): ?> <?= $data['error'] ?><?php endif; ?>
</div>
