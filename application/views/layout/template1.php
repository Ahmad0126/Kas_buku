<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
	<?php require_once('_css.php') ?>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <?= $contents ?>
    </div>
	<!-- JS script -->
    <?php require_once('_js.php') ?>
</body>

</html>
