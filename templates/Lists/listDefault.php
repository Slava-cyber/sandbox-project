<?php if (isset($info['title'])) : ?>
    <div class="row text-center">
        <h2><?= $info['title'] ?></h2>
    </div>
<?php endif; ?>

<?php foreach ($arrayOfItem as $item): ?>
    <div class="row">
        <?= $item ?>
        <hr class="separator mt-1">
    </div>
<?php endforeach; ?>

