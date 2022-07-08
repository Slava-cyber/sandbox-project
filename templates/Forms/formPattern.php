<form name="<?= $info['name'] ?>" method="POST"
      action="<?php echo (isset($info['action'])) ? $info['action'] : '' ?>" id="<?= $info['name'] ?>">
    <h2 class="text-center"><?php echo (isset($info['title'])) ? $info['title'] : '' ?></h2>
    <?= $innerPart ?>
    <div class="row">
        <div class="col-md-12 <?php echo (isset($info['button']['position'])) ? 'text-' . $info['button']['position'] : '' ?>">
            <button type="submit"
                    class="btn btn-secondary my-2
                    <?php echo (isset($info['button']['size'])) ? 'w-' . $info['button']['size'] : '' ?>">
                <?= $info['button']['name'] ?>
            </button>
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