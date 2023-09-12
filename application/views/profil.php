<div class="container-fluid pt-4 px-4 notifikasi">
	<?= $this->session->flashdata('alert'); ?>
</div>
<div class="container-fluid pt-4 px-4">
	<div class="row">
		<div class="col-md-6 grid-margin stretch-card">
			<div class="card tale-bg">
				<div class="card-people pt-0">
					<img src="<?= base_url('assets/skydash/') ?>images/faces/face28.jpg" alt="people">
				</div>
			</div>
		</div>
		<div class="col-md-6 grid-margin transparent">
			<div class="row">
				<div class="col stretch-card transparent">
					<div class="card">
						<div class="card-body pb-0">
							<p class="fs-30 mb-2">Profil Anda</p>
							<form action="<?= base_url('home/update_user/').$user['id_user'] ?>"
                                method="post">
                                <div class="form-group mb-3">
                                    <label for="floatingInput">Username</label>
                                    <input type="text" name="username" class="form-control form-control-sm" placeholder="Username" id="floatingInput"
                                        value="<?= $user['username'] ?>" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="floatingSelect">Level</label>
                                    <select class="form-control form-control-sm" name="level" id="floatingSelect" disabled
                                        aria-label="Floating label select example">
                                        <option value="admin" <?= $user['level'] == 'admin' ? 'selected':''?>>Admin</option>
                                        <option value="user" <?= $user['level'] == 'user' ? 'selected':''?>>User</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="floatingPassword">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control form-control-sm" placeholder="Nama Lengkap" id="floatingPassword"
                                        value="<?= isset($user['nama'])? $user['nama']:''?>">
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm m-2">Simpan</button>
                            </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid pt-4 px-4">
	<div class="bg-light rounded h-100 p-4">
		<h6 class="mb-4">Ganti Password</h6>
		<form action="<?= base_url('home/update_pass/').$user['id_user'] ?>"
			method="post">
			<div class="form-group mb-3">
				<label for="floatingInput">Password Saat ini</label>
				<input type="password" name="pl" class="form-control <?= $this->session->flashdata('password') != null?'is-invalid':'' ?>" value="<?= $this->session->flashdata('pl_val') != null? $this->session->flashdata('pl_val') : '' ?>" placeholder="Password Saat ini" id="floatingInput">
                <div class="invalid-feedback"><?= $this->session->flashdata('password') ?></div>
            </div>
			<div class="form-group mb-3">
				<label for="floatingInput">Password Baru</label>
				<input type="password" name="password" class="form-control" value="<?= $this->session->flashdata('pp_val') != null? $this->session->flashdata('pp_val') : '' ?>" placeholder="Password Baru" id="floatingInput">
			</div>
			<div class="form-group mb-3">
				<label for="floatingPassword">Konfirmasi Password Baru</label>
				<input type="password" name="pk" class="form-control <?= $this->session->flashdata('konf') != null?'is-invalid':'' ?>" value="<?= $this->session->flashdata('pk_val') != null? $this->session->flashdata('pk_val') : '' ?>" placeholder="Konfirmasi Password Baru" id="floatingPassword">
                <div class="invalid-feedback"><?= $this->session->flashdata('konf') ?></div>
            </div>
			<button type="submit" class="btn btn-primary m-2">Ganti</button>
		</form>
	</div>
</div>
