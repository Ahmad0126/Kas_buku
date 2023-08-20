<!-- Sign In Start -->
<div class="container-fluid pt-4 px-4">
    <h2 class="text-center">Pemasukan</h2>
    <div class="row g-4 mb-2">
        <div class="col-sm-6 col-xl-4">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pemasukan Hari ini</p>
                    <h6 class="mb-0">Rp <?= number_format($info['pm_hari']) ?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pemasukan Bulan ini</p>
                    <h6 class="mb-0">Rp <?= number_format($info['pm_bulan']) ?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
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
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pengeluaran Hari ini</p>
                    <h6 class="mb-0">Rp <?= number_format($info['pn_hari']) ?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pengeluaran Bulan ini</p>
                    <h6 class="mb-0">Rp <?= number_format($info['pn_bulan']) ?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
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
                <button data-bs-toggle="modal" type="button" data-bs-target="#tambahModal" class="btn btn-primary">Buat laporan <i class="fa fa-download"></i></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Buat Laporan</h5>
				<button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= base_url('home/laporan')?>" method="post">
				<div class="modal-body">
                    <div class="form-floating mb-3">
                        <select name="pp" id="pp" class="form-control">
                            <option value="pm">Pemasukan</option>
                            <option value="pn">Pengeluaran</option>
                            <option value="pp">Pemasukan dan Pengeluaran</option>
                        </select>
                        <label for="pp">Yang dilaporkan</label>
					</div>
                    <div class="form-floating mb-3">
                        <input type="date" name="tanggal1" class="form-control" placeholder="Tanggal Awal" id="floatingPassword">
						<label for="floatingPassword">Tanggal Awal</label>
					</div>
					<div class="form-floating mb-3">
						<input type="date" name="tanggal2" class="form-control" placeholder="Tanggal Akhir" id="floatingSelect">
						<label for="floatingSelect">Tanggal Akhir</label>
					</div>
                    <div class="form-floating mb-3">
                        <input type="text" name="user" id="floatingInput" class="form-control" placeholder="Username">
                        <label for="floatingInput">Username</label>
                    </div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary m-2">Buat</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Sign In End -->