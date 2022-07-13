<div class="col-md-3 text-center">
    <a href="/profile/<?= $user->getLogin() ?>" role="button" id="">
        <?= $user->getLogin() ?>
    </a>
    <span> 5.0 (10) </span>
</div>
<div class="col-md-6">
    <div class="text-center
        <?php echo ($request->getStatus() == 'Запрос принят') ? 'text-success' :
        (($request->getStatus() == 'Запрос отклонен') ? 'text-danger' : '') ?>" id="requestStatusDiv<?= $number ?>">
    <span id="requestStatus<?= $number ?>"><?= $request->getStatus() ?></span>
    <span class="none" id="requestStatusChange<?= $number ?>"></span>
    </div>
</div>
<div class="col-md-3 text-center">
    <input type="hidden" value="<?= $request->getId() ?>" id="requestId<?= $number ?>">
    <a href="/sendRequest" role="button" id="accept<?= $number ?>">Принять</a>
    <span>/</span>
    <a href="/sendRequest" role="button" id="reject<?= $number ?>">Отклонить</a>
</div>