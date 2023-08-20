<!-- Sign In Start -->
<div class="container-fluid">
	<div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
		<div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
			<div class="notif"><?= $this->session->flashdata('alert') ?></div>
			<div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
				<form action="<?= base_url('home/log_in') ?>" method="post">
					<div class="d-flex align-items-center justify-content-between mb-3">
						<a href="<?= base_url() ?>" class="">
							<h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>KAS BUKU</h3>
						</a>
						<h3>Log In</h3>
					</div>
					<div class="form-floating mb-3">
						<input name="username" type="text" class="form-control <?= $this->session->flashdata('username') != null?'is-invalid':'' ?>" id="floatingInput"
							placeholder="Masukkan Username" value="<?= $this->session->flashdata('username_val') ?>">
						<label for="floatingInput">Username</label>
                        <div class="invalid-feedback"><?= $this->session->flashdata('username') ?></div>
					</div>
					<div class="form-floating mb-4">
						<input name="password" type="password" class="form-control <?= $this->session->flashdata('password') != null?'is-invalid':'' ?>" id="floatingPassword"
							placeholder="Masukkan Password">
						<label for="floatingPassword">Password</label>
                        <div class="invalid-feedback"><?= $this->session->flashdata('password') ?></div>
					</div>
					<button type="submit" class="btn btn-primary py-3 w-100 mb-4">Log In</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Sign In End -->
