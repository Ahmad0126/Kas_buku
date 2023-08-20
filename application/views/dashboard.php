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
            <div class="bg-light rounded d-flex align-items-center justify-content-center p-4">
                <h4 class="mb-0">Rp <?= number_format($info['saldo']) ?></h4>
            </div>
        </div>
    </div>
</div>
<!-- Sign In End -->