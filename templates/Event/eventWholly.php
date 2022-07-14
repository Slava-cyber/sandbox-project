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
<div class="d-sm-inline-flex col-md-12">
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
        <strong><?= $event->getAuthor()->getRating() ?></strong>
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
<?php if ($user != null) : ?>
    <?php if ($request['possibility']) : ?>
        <input type="hidden" value="<?= $event->getId() ?>" id="eventId<?= $number ?>">
        <input type="hidden" value="<?php echo (isset($user)) ? $user->getId() : '' ?>" id="userId<?= $number ?>">
        <input type="hidden" value="<?= $event->getAuthor()->getId() ?>" id="eventAuthor<?= $number ?>">
        <div class="col-md-12 <?php echo ($request['data'] == null) ? "" : 'none' ?>" id="outRequestDiv<?= $number ?>">
            <a href="" role="button" id="outRequest<?= $number ?>">Отправить запрос</a>
        </div>
        <div class="col-md-12  <?php echo ($request['data'] == null) ? "none" : '' ?>"
             id="statusRequestDiv<?= $number ?>">
        <span class="text-primary <?php echo ($request['data']->getStatus() == 'Запрос принят') ? 'text-success' :
        (($request['data']->getStatus() == 'Запрос отклонен') ? 'text-danger' : 'text-dark') ?>">
            <?php echo ($request['data'] != null) ? $request['data']->getStatus() : 'Ожидает подтверждения' ?>
        </span>
        </div>
    <?php else : ?>
        <div class="col-md-12" id="">
            <a href="/event/<?= $event->getId() ?>/request" role="button" id="">Показать входящие запросы</a>
        </div>
    <?php endif; ?>
<?php endif; ?>
