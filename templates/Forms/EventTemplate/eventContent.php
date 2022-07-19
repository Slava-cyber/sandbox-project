<div class="row">
    <div class="col-md-6">
        <div class="form-group py-2">
            <input type="text" name="town" class="form-control" id="town"
                   placeholder=""
                   value="<?php echo (!empty($_POST['town'])) ? $_POST['town'] : (($user != null && $user->getTown() != null) ? $user->getTown() : "Москва"); ?>">
            <small id="townHelp" class="form-text form-muted none">Город</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group py-2">
            <input type="datetime-local" name="datetime" class="form-control" id="datetime"
                   value="<?php echo (!empty($_POST['datetime'])) ? $_POST['datetime'] : '' ?>">
            <small id="datetimeHelp" class="form-text form-muted">Дата и время начала
                ивента:</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group py-2">
            <select class="form-select form-control" name="category" id="category"">
            <?php if ($info['page'] == 'main') : ?>
                <option value="">Выберите категорию</option>
            <?php endif; ?>
            <?php foreach ($data['category'] as $name) : ?>
                <option value="<?= $name ?>"
                    <?php echo (!empty($_POST['category']) && $name == $_POST['category']) ?
                        'selected="selected"' : '' ?>>
                    <?= $name ?>
                </option>
            <?php endforeach; ?>
            </select>
            <small id="categoryHelp" class="form-text form-muted">Категория</small>
        </div>
    </div>
    <?php if ($info['page'] != 'main') : ?>
        <div class="col-md-12">
            <div class="form-group py-2">
                    <textarea class="form-control" id="description" rows="5" name="description"
                              placeholder="Описание ивента" value=""></textarea>
                <small id="interestHelp" class="form-text form-muted none">Описание
                    ивента</small>
            </div>
        </div>
    <?php endif; ?>
</div>
