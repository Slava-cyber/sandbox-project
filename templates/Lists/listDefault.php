<?php if (isset($info['title'])) : ?>
    <div class="row text-center">
        <h2><?= $info['title'] ?></h2>
    </div>
<?php endif; ?>

<?php if (isset($info['table'])) : ?>
    <div class="row mb-4">
        <?php foreach ($info['table']['data'] as $col) : ?>
            <div class="col-md-<?php echo 12 / $info['table']['countColumn'] ?> text-center">
                <strong><?= $col ?></strong>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>



<?php foreach ($arrayOfItem as $item): ?>
    <div class="row">
        <?= $item ?>
        <hr class="separator mt-1">
    </div>
<?php endforeach; ?>

