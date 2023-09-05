<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= $title ?></title>
	<style>
		.mdi-3x{
			font-size: 50px;
		}
	</style>
	<?php require_once('_css.php') ?>
</head>

<body>
	<div class="container-scroller">
		<!-- partial:partials/_navbar.html -->
		<?php require_once('_navbar.php') ?>
		<!-- partial -->
		<div class="container-fluid page-body-wrapper">
			<!-- partial:partials/_settings-panel.html -->
			<?php require_once('_setting.php') ?>
			<!-- partial -->
			<!-- partial:partials/_sidebar.html -->
			<?php require_once('_sidebar.php') ?>
			<!-- partial -->
			<div class="main-panel">
				<div class="content-wrapper">
                    <?= $contents ?>
				</div>
				<!-- content-wrapper ends -->
				<!-- partial:partials/_footer.html -->
				<?php require_once('_footer.php') ?>
				<!-- partial -->
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
	</div>
	<!-- container-scroller -->

	<?php require_once('_js.php') ?>
</body>

</html>
