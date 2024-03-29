<div class="col-md-4 text-center">
    <a href="/profile/<?= $author->getLogin() ?>" role="button" id="">
        <?= $author->getLogin() ?>
    </a>
    <span> <?= $author->getRating() ?> (<?= $author->getNumberOfReviews() ?>) </span>
</div>
<div class="col-md-4">
    <div class="text-center
        <?php echo ($request->getStatus() == 'Запрос принят') ? 'text-success' :
        (($request->getStatus() == 'Запрос отклонен') ? 'text-danger' : '') ?>" id="requestStatusDiv<?= $number ?>">
    <span id="requestStatus<?= $number ?>"><?= $request->getStatus() ?></span>
    <span class="none" id="requestStatusChange<?= $number ?>"></span>
    </div>
</div>
<div class="col-md-4 text-center">
    <input type="hidden" value="<?= $request->getId() ?>" id="requestId<?= $number ?>">
    <a href="/sendRequest" role="button" id="accept<?= $number ?>">Принять</a>
    <span>/</span>
    <a href="/sendRequest" role="button" id="reject<?= $number ?>">Отклонить</a>
</div>