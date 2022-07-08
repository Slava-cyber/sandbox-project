<!DOCTYPE html>
<html lang="en">
<head>
    <metacharset
    ="utf-8">
    <title><?= $page['title'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="profile <?php echo (isset($page['color'])) ? "profile-content" : ""?> ">
<?= $navbar ?>
<div class="container mt-5 mb-5 " <?php echo (isset($page['align'])) ? 'style="height:70vh"' : "" ?>>
    <div class="row justify-content-center
        <?php echo (isset($page['align'])) ? 'align-items-center" style="height:70vh"' : '"' ?>>
        <div class="col-sm-12 bg-white p-3
            <?php echo (isset($page['widthColumn'])) ? $page['widthColumn'] : 'col-md-10' ?>">
    <?php foreach ($content as $blockName => $blockValue) : ?>
        <?= $blockValue ?>
    <?php endforeach; ?>
</div>
</div>
</div>


<?php if (isset($js)) : ?>
    <?php foreach ($js as $script) : ?>
        <script src="<?= $script . '.js' ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<!-- <script src="js/registrationValidation.js"> </script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>