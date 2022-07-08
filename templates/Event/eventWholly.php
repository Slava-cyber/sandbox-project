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
        <strong>5.0</strong>
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
<div class="col-md-12">
    <a href="#" role="button">Отправить запрос</a>
    <div class="col-md-12">
        <span class="text-primary">Статус запроса: Ожидает ответа</span>
    </div>
</div>