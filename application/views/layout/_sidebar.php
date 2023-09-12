<?php $menu = $this->uri->segment(1); ?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
	<ul class="nav">
		<li class="nav-item <?= $menu == null || $menu == 'home' ? 'active' : '' ?>">
			<a class="nav-link" href="<?= base_url() ?>">
				<i class="icon-grid menu-icon"></i>
				<span class="menu-title">Dashboard</span>
			</a>
		</li>
		<li class="nav-item <?= $menu == 'pemasukan'? 'active' : '' ?>">
			<a class="nav-link" href="<?= base_url('pemasukan') ?>">
				<i class="icon-paper menu-icon"></i>
				<span class="menu-title">Pemasukan</span>
			</a>
		</li>
		<li class="nav-item <?= $menu == 'pengeluaran'? 'active' : '' ?>">
			<a href="<?= base_url('pengeluaran') ?>" class="nav-link">
				<i class="icon-bar-graph menu-icon"></i>
				<span class="menu-title">Pengeluaran</span>
			</a>
		</li>
		<?php if($this->session->userdata('level')=='admin'){ ?>
		<li class="nav-item <?= $menu == 'user'? 'active' : '' ?>">
			<a class="nav-link" href="<?= base_url('user') ?>">
				<i class="icon-head menu-icon"></i>
				<span class="menu-title">User</span>
			</a>
		</li>
		<?php } ?>
	</ul>
</nav>