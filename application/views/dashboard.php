<!-- Sign In Start -->
<div class="container-fluid pt-4 px-4">
    <h2 class="text-center">Pemasukan</h2>
    <div class="row g-4 mb-2">
        <div class="col-sm-6 col-xl-4">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="mdi mdi-chart-line mdi-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pemasukan Hari ini</p>
                    <h6 class="mb-0">Rp <?= number_format($info['pm_hari']) ?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="mdi mdi-chart-bar mdi-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pemasukan Bulan ini</p>
                    <h6 class="mb-0">Rp <?= number_format($info['pm_bulan']) ?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="mdi mdi-calendar-multiple-check mdi-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Pemasukan</p>
                    <h6 class="mb-0">Rp <?= number_format($info['pm_total']) ?></h6>
                </div>
            </div>
        </div>
    </div>
    <h2 class="text-center">Pengeluaran</h2>
    <div class="row g-4 mb-2">
        <div class="col-sm-6 col-xl-4">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="mdi mdi-chart-line mdi-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pengeluaran Hari ini</p>
                    <h6 class="mb-0">Rp <?= number_format($info['pn_hari']) ?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="mdi mdi-chart-bar mdi-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pengeluaran Bulan ini</p>
                    <h6 class="mb-0">Rp <?= number_format($info['pn_bulan']) ?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="mdi mdi-calendar-multiple-check mdi-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Pengeluaran</p>
                    <h6 class="mb-0">Rp <?= number_format($info['pn_total']) ?></h6>
                </div>
            </div>
        </div>
    </div>
    <h2 class="text-center">Total saldo</h2>
    <div class="row g-4 mb-2">
        <div class="col">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <h4 class="mb-0">Rp <?= number_format($info['saldo']) ?></h4>
                <button data-toggle="modal" type="button" data-target="#tambahModal" class="btn btn-primary">Buat laporan <i class="mdi mdi-download"></i></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Buat Laporan</h5>
				<button class="btn-close" type="button" data-dismiss="modal" aria-label="Close"><i class="settings-close ti-close"></i></button>
			</div>
			<form action="<?= base_url('home/laporan')?>" method="post">
				<div class="modal-body">
                    <div class="form-floating mb-3">
                        <label for="pp">Yang dilaporkan</label>
                        <select name="pp" id="pp" class="form-control">
                            <option value="pm">Pemasukan</option>
                            <option value="pn">Pengeluaran</option>
                            <option value="pp">Pemasukan dan Pengeluaran</option>
                        </select>
					</div>
                    <div class="form-floating mb-3">
						<label for="floatingPassword">Tanggal Awal</label>
                        <input type="date" name="tanggal1" class="form-control" placeholder="Tanggal Awal" id="floatingPassword">
					</div>
					<div class="form-floating mb-3">
						<label for="floatingSelect">Tanggal Akhir</label>
						<input type="date" name="tanggal2" class="form-control" placeholder="Tanggal Akhir" id="floatingSelect">
					</div>
                    <div class="form-floating mb-3">
                        <label for="floatingInput">Username</label>
                        <select name="user" class="form-control" id="">
                            <option value="semua">Semua User</option>
                            <?php foreach($user as $fer){ ?>
                                <option value="<?= $fer->username ?>"><?= $fer->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary m-2">Buat</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Sign In End -->