<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <a data-toggle="modal" data-target="#kelasModal" href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Tambah Kelas</a>
    </div>

    <div class="row">
        <div class="col-lg-l4 col-xl-5">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 col-xl">
            <div class="row">
                <div class="col">
                    <p><span class="text-danger">Note: </span>Untuk kolom Wali Kelas, akan diisi otomatis ketika guru tersebut mendaftar</p>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">Wali Kelas</th>
                        <th scope="col">Jumlah Siswa</th>
                        <th scope="col">Terpenuhi</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($kelas as $kelas) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $kelas['kelasName']; ?></td>
                            <td><?= $kelas['wali_kelas']; ?></td>
                            <?php if ($kelas['jumlahSiswa'] == 0) : ?>
                                <td>Tidak ada</td>
                            <?php else : ?>
                                <td><?= $kelas['jumlahSiswa']; ?> Siswa</td>
                            <?php endif; ?>
                            <td>
                                <?php $selisihNya = $kelas['seluruhSiswa'] - $kelas['jumlahSiswa']; ?>
                                <?php if ($kelas['jumlahSiswa'] == $kelas['seluruhSiswa']) : ?>
                                    <i class="fas fa-fw fa-check-circle text-primary"></i>
                                <?php else : ?>
                                    <p class="text-danger"><?= $selisihNya; ?> Siswa belum mendaftar</p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="" class="badge badge-warning">Edit</a>
                                <a href="<?= base_url('Data_User/deleteKelas/') . $kelas['slug']; ?>" class="badge badge-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="kelasModal" tabindex="-1" aria-labelledby="kelasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kelasModalLabel">Tambah Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Data_User/insertKelas'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" value="<?= $kelasNum + 1; ?>" name="orderBy">
                    </div>
                    <div class="form-group">
                        <label for="seluruhSiswa">Jumlah seluruh siswa</label>
                        <input type="number" class="form-control" id="seluruhSiswa" name="seluruhSiswa">
                    </div>
                    <div class="input-group mb-3">
                        <select class="custom-select" id="jurusan" name="kelasName">
                            <option value="" selected>-- Kelas --</option>
                            <?php foreach ($kelasName as $kelasName) : ?>
                                <option value="<?= $kelasName; ?>"><?= $kelasName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <select class="custom-select" id="jurusan" name="jurusan">
                            <option value="" selected>-- Jurusan --</option>
                            <?php foreach ($jurusan as $j) : ?>
                                <option value="<?= $j; ?>"><?= $j; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <select class="custom-select" id="jurusan" name="numKelas">
                            <option value="" selected>-- Nomor Kelas --</option>
                            <?php foreach ($numKelas as $nK) : ?>
                                <option value="<?= $nK; ?>"><?= $nK; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah kelas</button>
                </div>
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