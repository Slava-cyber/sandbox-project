<div class="row">
    <nav aria-label="Пример навигации по страницам">
        <ul class="pagination justify-content-center">
            <?php $i = 0 ?>
            <?php foreach ($pagination as $name => $link) : ?>
                <input type="hidden" id="<?= 'inputPage' . $i ?>" value="<?= $prefix . $link ?>">
                <li class="page-item <?php echo ($currentPage == $name) ? 'active' : '' ?>" id="<?= 'liPage' . $i ?>">
                    <a class="page-link" href="<?= $prefix . $link ?>"><?= $name ?></a>
                </li>
                <?php $i += 1 ?>
            <?php endforeach; ?>
        </ul>
    </nav>
</div>
