<div class="container-fluid page-body-wrapper full-page-wrapper">
	<div class="content-wrapper align-items-center auth px-0">
		<div class="row w-100 mx-0">
			<div class="notif"><?= $this->session->flashdata('alert') ?></div>
			<div class="col-lg-4 mx-auto">
				<div class="auth-form-light text-left py-5 px-4 px-sm-5">
					<div class="brand-logo">
						<img src="<?= base_url('assets/skydash/') ?>images/logo.svg" alt="logo">
					</div>
					<h4>KAS BUKU</h4>
					<h6 class="font-weight-light">Silahkan login</h6>
					<form action="<?= base_url('home/log_in') ?>" method="post" class="pt-3">
						<div class="form-group">
							<input type="text" name="username" class="form-control form-control-lg <?= $this->session->flashdata('username') != null?'is-invalid':'' ?>" value="<?= $this->session->flashdata('username_val') != null? $this->session->flashdata('username_val') : '' ?>" id="exampleInputEmail1"
								placeholder="Username">
							<div class="invalid-feedback"><?= $this->session->flashdata('username') ?></div>
						</div>
						<div class="form-group">
							<input type="password" name="password" class="form-control form-control-lg <?= $this->session->flashdata('password') != null?'is-invalid':'' ?>"
								id="exampleInputPassword1" placeholder="Password">
							<div class="invalid-feedback"><?= $this->session->flashdata('password') ?></div>
						</div>
						<div class="mt-3">
							<button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Log In</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- content-wrapper ends -->
</div>