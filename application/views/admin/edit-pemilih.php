<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>


    <div class="row">
        <div class="col-lg-4 col-xl-5">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="submenu">NISN</label>
                    <input type="text" value="<?= $userEdit['NISN']; ?>" name="nisn" class="form-control" id="submenu">
                    <small class="text-danger"><?= form_error('nisn'); ?></small>
                </div>
                <div class="form-group">
                    <label for="icon">Nama</label>
                    <input type="text" value="<?= $userEdit['Name']; ?>" name="nama" class="form-control" id="icon">
                    <small class="text-danger"><?= form_error('nama'); ?></small>
                </div>
                <!-- Munculin Kelas guru dengan nama Wali kelas, menggunakan Select atau Form Input -->

                <?php if ($userEdit['role_id'] == 3) : ?>
                    <div class="form-group">
                        <label for="guru">Wali Kelas</label>
                        <input type="text" value="<?= $userEdit['Kelas']; ?>" class="form-control" id="guru">
                    </div>
                <?php else : ?>
                    <div class="input-group mb-3">
                        <select name="kelas" class="custom-select" id="inputGroupSelect01">

                            <?php foreach ($kelas as $kelas) : ?>

                                <?php if ($userEdit['Kelas'] == $kelas['kelasName']) : ?>
                                    <label for="kelas">Kelas</label>
                                    <option id="kelas" value="<?= $kelas['kelasName']; ?>" selected><?= $kelas['kelasName']; ?></option>
                                <?php else : ?>
                                    <label for="kelas">Kelas</label>
                                    <option id="kelas" value="<?= $kelas['kelasName']; ?>"><?= $kelas['kelasName']; ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
                <div class="input-group mb-3">
                    <select name="jenisKelamin" class="custom-select" id="inputGroupSelect01">
                        <?php foreach ($jenisKelamin as $jenisKelamin) : ?>
                            <?php if ($userEdit['jenisKelamin'] == $jenisKelamin) : ?>
                                <option value="<?= $jenisKelamin; ?>" selected><?= $jenisKelamin; ?></option>
                            <?php else : ?>
                                <option value="<?= $jenisKelamin; ?>"><?= $jenisKelamin; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <a href="<?= base_url('Data_User/pemilih'); ?>" class="btn btn-outline-primary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" untuk keluar</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('home/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>