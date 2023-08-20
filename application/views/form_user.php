<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">Form pendaftaran</h6>
        <form action="<?= isset($user)? base_url('user/update_user/').$user['id_user']: base_url('user/simpan')?>" method="post">
            <div class="form-floating mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" id="floatingInput" <?= isset($user['username'])? 'value='.$user['username'].' disabled':''?>>
                <label for="floatingInput">Username</label>
            </div>
            <?php if(!isset($user['password'])): ?>
            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" id="floatingInput">
                <label for="floatingInput">Password</label>
            </div>
            <?php endif ?>
            <div class="form-floating mb-3">
                <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" id="floatingPassword" value="<?= isset($user['nama'])? $user['nama']:''?>">
                <label for="floatingPassword">Nama Lengkap</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" name="level" id="floatingSelect" aria-label="Floating label select example">
                    <option value="admin" <?= isset($user) && $user['level'] == 'admin' ? 'selected':''?>>Admin</option>
                    <option value="user" <?= isset($user) && $user['level'] == 'user' ? 'selected':''?>>User</option>
                </select>
                <label for="floatingSelect">Level</label>
            </div>
            <button type="submit" class="btn btn-primary m-2">Simpan</button>
        </form>
    </div>
</div>