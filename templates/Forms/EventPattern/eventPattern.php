<div class="row">
    <div class="form-group py-2">
        <input type="text" name="title" class="form-control" placeholder="Заголовок" id="title"
               value="<?php echo (!empty($_POST['title'])) ? $_POST['title'] : ''?>">
        <small id="titleHelp" class="form-text form-muted none">Заголовок</small>
    </div>
</div>
<?php if ($info['page'] == 'main') : ?>
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                    aria-controls="panelsStayOpen-collapseOne">
                Дополнительные параметры
            </button>
        </h2>
        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse"
             aria-labelledby="panelsStayOpen-headingOne">
            <div class="accordion-body">
                <?= $innerPart ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <?= $innerPart ?>
<?php endif; ?>