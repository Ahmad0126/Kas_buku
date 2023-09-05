<!DOCTYPE html>
<html lang="en">

<head>
    <!-- plugins:css -->
	<link rel="stylesheet" href="<?= base_url('assets/skydash/') ?>vendors/feather/feather.css">
	<link rel="stylesheet" href="<?= base_url('assets/skydash/') ?>vendors/ti-icons/css/themify-icons.css">
	<link rel="stylesheet" href="<?= base_url('assets/skydash/') ?>vendors/css/vendor.bundle.base.css">
	<!-- endinject -->
	<!-- Plugin css for this page -->
	<!-- End plugin css for this page -->
	<!-- inject:css -->
	<link rel="stylesheet" href="<?= base_url('assets/skydash/') ?>css/vertical-layout-light/style.css">
	<!-- endinject -->
	<link rel="shortcut icon" href="<?= base_url('assets/skydash/') ?>images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <?= $contents ?>
    </div>
	<!-- plugins:js -->
	<script src="<?= base_url('assets/skydash/') ?>vendors/js/vendor.bundle.base.js"></script>
	<!-- endinject -->
	<!-- Plugin js for this page -->
	<!-- End plugin js for this page -->
	<!-- inject:js -->
	<script src="<?= base_url('assets/skydash/') ?>js/off-canvas.js"></script>
	<script src="<?= base_url('assets/skydash/') ?>js/hoverable-collapse.js"></script>
	<script src="<?= base_url('assets/skydash/') ?>js/template.js"></script>
	<script src="<?= base_url('assets/skydash/') ?>js/settings.js"></script>
	<script src="<?= base_url('assets/skydash/') ?>js/todolist.js"></script>
	<!-- endinject -->
</body>

</html>
