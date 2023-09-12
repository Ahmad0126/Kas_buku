<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
	<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
		<a class="navbar-brand brand-logo mr-5" href="<?= base_url() ?>"><h3 class="text-bold">KAS BUKU</h3> </a>
		<a class="navbar-brand brand-logo-mini" href="<?= base_url() ?>"><img src="<?= base_url('assets/skydash/') ?>images/logo-mini.svg"
				alt="logo" /></a>
	</div>
	<div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
		<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
			<span class="icon-menu"></span>
		</button>
		<ul class="navbar-nav navbar-nav-right">
			<li class="nav-item nav-profile dropdown">
				<a class="d-flex nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
					<p style="margin-top: 0.5rem; margin-right: 1rem;"><?= $this->session->userdata('nama'); ?></p>
					<img src="<?= base_url('assets/skydash/') ?>images/faces/face28.jpg" alt="profile" />
				</a>
				<div class="dropdown-menu dropdown-menu-right navbar-dropdown"
					aria-labelledby="profileDropdown">
					<a class="dropdown-item" href="<?= base_url('home/profil') ?>">
						<i class="ti-settings text-primary"></i>
						Profil
					</a>
					<a class="dropdown-item" href="<?= base_url('logout') ?>">
						<i class="ti-power-off text-primary"></i>
						Logout
					</a>
				</div>
			</li>
		</ul>
		<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
			data-toggle="offcanvas">
			<span class="icon-menu"></span>
		</button>
	</div>
</nav>