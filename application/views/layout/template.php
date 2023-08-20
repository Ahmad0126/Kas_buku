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
	 	<?php require_once('_sidebar.php') ?>
		
        <!-- Content Start -->
        <div class="content">
			<?php require_once('_navbar.php') ?>

            <!-- Sale & Revenue Start -->
            <?= $contents ?>
            <!-- Sale & Revenue End -->

			<?php require_once('_footer.php') ?>
        </div>
        <!-- Content End -->
        <!-- Back to Top -->
    </div>
	<!-- JS script -->
    <?php require_once('_js.php') ?>
</body>

</html>
