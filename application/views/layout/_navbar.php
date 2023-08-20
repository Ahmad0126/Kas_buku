<!-- Navbar Start -->
<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
	<a href="<?= base_url() ?>" class="navbar-brand d-flex d-lg-none me-4">
		<h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
	</a>
	<a href="#" class="sidebar-toggler flex-shrink-0">
		<i class="fa fa-bars"></i>
	</a>
	<form class="d-none d-md-flex ms-4">
		<input class="form-control border-0" type="search" placeholder="Search">
	</form>
	<div class="navbar-nav align-items-center ms-auto">
		<div class="nav-item dropdown">
			<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
				<img class="rounded-circle me-lg-2" src="<?= base_url('assets/dashmin/') ?>img/user.jpg" alt="" style="width: 40px; height: 40px;">
				<span class="d-none d-lg-inline-flex"><?= $this->session->userdata('nama') ?></span>
			</a>
			<div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
				<a href="#" class="dropdown-item">My Profile</a>
				<a href="#" class="dropdown-item">Settings</a>
				<a href="<?= base_url('logout') ?>" data-bs-toggle="modal" data-bs-target="#logoutModal" class="dropdown-item">Log Out</a>
			</div>
		</div>
	</div>
</nav>
<!-- Navbar End -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
				<button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">Klik "Logout" jika Anda yakin ingin keluar.</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
				<a href="<?= base_url('logout') ?>" class="btn btn-danger">Log Out</a>
			</div>
		</div>
	</div>
</div>
