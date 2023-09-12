<div class="container-fluid pt-4 px-4 notifikasi">
	<?= $this->session->flashdata('alert'); ?>
</div>
<!-- Recent Sales Start -->
<div class="container-fluid pt-4 px-4">
	<div class="bg-light text-center rounded p-4">
		<div class="d-flex align-items-center justify-content-between mb-4">
			<h4 class="mb-0">Daftar Pemasukan</h4>
			<button data-toggle="modal" type="button" data-target="#tambahModal" class="btn btn-primary">Tambah</button>
		</div>
		<div class="table-responsive">
			<table class="table text-start align-middle table-bordered table-hover mb-0">
				<thead>
					<tr class="text-dark">
						<th scope="col">No</th>
						<th scope="col">Tanggal</th>
						<th scope="col">Keterangan</th>
						<?php if($this->session->userdata('level') == 'admin'){ ?>
						<th scope="col">Username</th>
						<?php } ?>
						<th scope="col">Nominal</th>
						<th scope="col">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					foreach($transaksi as $fer): 
					?>
					<tr>
						<td><?= $no++ ?></td>
						<td><?= $fer->tanggal ?></td>
						<td><?= $fer->keterangan ?></td>
						<?php if($this->session->userdata('level') == 'admin'){ ?>
						<td><?= $fer->username ?></td>
						<?php } ?>
						<td>Rp <?= number_format($fer->nominal) ?></td>
						<td>
						<?php if($this->session->userdata('username') == $fer->username || $this->session->userdata('level') == 'admin'){ ?>
							<a class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" href="<?= base_url('pemasukan/hapus/').$fer->id_transaksi ?>">Hapus <i class="fa fa-trash"></i></a>
						<?php }else{ echo 'Tidak Ada'; } ?>
						</td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tambah Pemasukan</h5>
				<button class="btn-close" type="button" data-dismiss="modal" aria-label="Close"><i class="settings-close ti-close"></i></button>
			</div>
			<form action="<?= base_url('pemasukan/simpan')?>" method="post">
				<div class="modal-body">
					<div class="form-group mb-3">
						<label for="floatingInput">Keterangan</label>
						<textarea name="keterangan" class="form-control" placeholder="Keterangan" id="floatingInput"></textarea>
					</div>
					<div class="form-group mb-3">
						<label for="floatingPassword">Nominal</label>
						<input type="number" name="nominal" class="form-control" placeholder="Nominal" id="floatingPassword">
					</div>
					<div class="form-group mb-3">
						<label for="floatingSelect">Tanggal</label>
						<input type="date" name="tanggal" class="form-control" placeholder="Tanggal" id="floatingSelect">
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary m-2">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>