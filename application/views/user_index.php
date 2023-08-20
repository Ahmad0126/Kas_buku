<div class="container-fluid pt-4 px-4 notifikasi">
	<?= $this->session->flashdata('alert'); ?>
</div>
<!-- Recent Sales Start -->
<div class="container-fluid pt-4 px-4">
	<div class="bg-light text-center rounded p-4">
		<div class="d-flex align-items-center justify-content-between mb-4">
			<h4 class="mb-0">Daftar User</h4>
			<a href="<?= base_url('user/tambah') ?>" class="btn btn-primary">Tambah</a>
		</div>
		<div class="table-responsive">
			<table class="table text-start align-middle table-bordered table-hover mb-0">
				<thead>
					<tr class="text-dark">
						<th scope="col">No</th>
						<th scope="col">Username</th>
						<th scope="col">Nama</th>
						<th scope="col">Level</th>
						<th scope="col">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					foreach($user as $fer): 
					?>
					<tr>
						<td><?= $no++ ?></td>
						<td><?= $fer->username ?></td>
						<td><?= $fer->nama ?></td>
						<td><?= $fer->level ?></td>
						<td>
							<a class="btn btn-sm btn-primary" href="<?= base_url('user/edit/').$fer->id_user ?>">Edit</a>
							<a class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')" href="<?= base_url('user/hapus_user/').$fer->id_user ?>">Hapus <i class="fa fa-trash"></i></a>
						</td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>