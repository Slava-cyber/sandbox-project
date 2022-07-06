<div class="row">
    <div class="col-md-3 border-right">
        <div class="d-flex flex-column align-items-center text-center py-5">
            <img class="rounded-circle" width="150px"
                 src="<?php echo ($user->getAvatar() != null) ? $user->getAvatar() : "/images/system/avatar_null.jpg"; ?>">
            <span class="font-weight-bold"><?= $user->getLogin() ?></span>
            <span class="text-black-50">Рейтинг: 0</span>
            <span class="text-black-50">Всего отзывов: 0</span>
            <a href="#" class="btn btn-secondary btn-sm" role="button" aria-disabled="true">Архив</a>
            <span> </span>
        </div>
    </div>
    <div class="col-md-9 justify-content-start p-5">
        <div class="row gy-2">
            <?php foreach ($data as $strong => $value) : ?>
                <div class="col-sm-12 justify-content-start mt-3">
                    <strong><?= $strong ?></strong>
                </div>
                <hr class="separator mt-0">
                <?php $i = 0 ?>
                <?php foreach ($value as $nameField => $input) : ?>
                    <?php if ($strong != 'Личная информация') : ?>
                        <div class="col-sm-3">
                            <strong><?= $nameField ?></strong>
                        </div>
                        <div class="col-sm-9 justify-content-start">
                            <?= $input ?>
                        </div>
                        <?php $i += 1 ?>
                    <?php else : ?>
                        <div class="col-sm-12">
                            <strong><?= $nameField ?></strong>
                        </div>
                        <div class="col-sm-12 justify-content-start">
                            <div class="text p-2">
                                <?= $input ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <div class="col-sm-12 text-end">
                <a href="/profile/edit" class="btn btn-secondary" role="button" aria-disabled="true">Редактировать
                    профиль</a>
            </div>
        </div>
    </div>
</div>
