<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="d-flex flex-column align-items-center text-center py-5">
            <div class="profile-img">
                <img class="rounded-circle image" id="image"
                     src="<?php echo ($user->getAvatar() != null) ? $user->getAvatar() : "/images/system/avatar_null.jpg"; ?>"
                     width="200px" alt=""/>
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
<?php foreach ($data as $strong => $value) : ?>
    <div class="mt-2">
        <strong><?= $strong ?></strong>
        <hr class="separator mt-0">
    </div>
    <div class="row justify-content between">
        <?php if ($strong != 'Личная информация') : ?>
            <?php foreach ($value as $nameField => $input) : ?>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group py-2">
                        <label for="name"><?= $input['label'] ?></label>
                        <input type="<?= $input['type'] ?>" name="<?= $nameField ?>"
                               class="form-control" placeholder="<?= $input['placeholder'] ?>" id="<?= $nameField?>"
                           value="<?= $input['value'] ?>">
                        <small id="<?= $nameField . 'Help' ?>" class="form-text form-muted none">Имя</small>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <?php foreach ($value as $nameField => $input) : ?>
                <div class="form-group py-2">
                    <label for="name"><?= $input['label'] ?></label>
                    <textarea class="form-control" id="<?= $nameField ?>" rows="<?= $input['rows'] ?>" name="<?= $nameField ?>"
                              placeholder="<?= $input['placeholder'] ?>" value=""><?= $input['value'] ?></textarea>
                    <small id="<?= $nameField . 'Help' ?>" class="form-text form-muted none">Интересы</small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endforeach; ?>