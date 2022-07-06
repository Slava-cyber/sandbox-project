<form name="<?= $info['name'] ?>" method="POST" action="" id="<?= $info['name'] ?>">
    <h2 class="text-center"><?php echo (isset($info['title'])) ? $info['title'] : '' ?></h2>
    <?= $innerPart ?>
    <div class="row
        <?php echo (isset($info['button']['position'])) ? 'justify-content-' . $info['button']['position'] : '' ?>">
        <div class="col-md-<?php echo (isset($info['button']['size'])) ? $info['button']['size'] : '2' ?> d-grid">
            <button type="submit" class="btn btn-secondary my-2"><?= $info['button']['name'] ?></button>
        </div>
    </div>
    <?php if (isset($info['link'])) : ?>
        <div class="col-sm-12 col-md-8 w-100 text-center">
            <?= $info['link']['label'] ?> <a href="<?= $info['link']['link'] ?>"><?= $info['link']['name'] ?></a>
        </div>
    <?php endif; ?>
    <?php if (isset($info['separator'])) : ?>
        <hr class="separator mt-1">
    <?php endif; ?>
</form>