<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <div class="importDataHelp">
            <a href="<?= base_url('Data_User/generateReportPemilih'); ?>" target="_blank" class="btn btn-sm shadow-sm btn-primary"><i class="fas fa-fw fa-download"></i> Generate Report</a> |
            <?php if ($userSchool['voteMethod'] = 'Import-menggunakan-excel') : ?>
                <a href="#" data-toggle="modal" data-target="#importData" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-upload fa-sm text-white-50"></i> Import Data Siswa</a>
            <?php endif; ?>
            <a href="" data-toggle="modal" data-target="#detailVoteMethod" class="btn btn-sm shadow-sm btn-outline-success">Help!</a>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-md-4">
            <form class="form-inline mr-auto mb-3 navbar-search shadow" action="" method="POST">
                <div style="width: 100%;" class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" name="cariPemilih" placeholder="Cari Pemilih" autocomplete="off" autofocus>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div> -->

    <div class="row">
        <div class="col-lg col-xl">
            <?= $this->session->flashdata('message'); ?>
            <div class="table-responsive">
                <table class="table table-striped" id="dataTablePemilih">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NISN</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Email</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Kandidat</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <?php $start = 1; ?>
                    <tbody>
                        <?php foreach ($users as $us) : ?>
                            <tr>
                                <th scope="row"><?= $start++; ?></th>
                                <td><?= $us['NISN']; ?></td>
                                <td><?= $us['Name']; ?></td>
                                <?php if ($us['role_id'] == 2) : ?>
                                    <td>[Kepala Sekolah]</td>
                                <?php elseif ($us['role_id'] == 3) : ?>
                                    <td>[Guru]</td>
                                <?php else : ?>
                                    <td><?= $us['Kelas']; ?></td>
                                <?php endif; ?>
                                <td><?= $us['Email']; ?></td>
                                <td><?= $us['jenisKelamin']; ?></td>
                                <?php if ($us['Kandidat'] == '') : ?>
                                    <td>Belum memilih</td>
                                <?php else : ?>
                                    <td><?= $us['Kandidat']; ?></td>
                                <?php endif; ?>
                                <td>
                                    <a href="<?= base_url('Data_User/editPemilih/') . $us['id']; ?>" class="badge badge-warning">Edit</a>
                                    <a href="<?= base_url('Data_User/deletePemilih/') . $us['id']; ?>" class="badge badge-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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

<!-- Modal Import Data Siswa  -->
<div class="modal fade" id="importData" tabindex="-1" aria-labelledby="importDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importDataLabel">Import Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('Data_User/importSiswa'); ?>
            <div class="modal-body">
                <a class="mb-3 btn btn-sm btn-outline-warning" href="<?= base_url('Data_User/downloadExampleExcel'); ?>"><i class="fas fa-fw fa-download"></i> Example</a>
                <div class="custom-file">
                    <input type="file" name="importSiswaField" accept=".xlsx, .xls" class="custom-file-input" id="inputDataSiswa">
                    <label class="custom-file-label" for="inputDataSiswa">Choose file</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<!-- Metode Pendaftaran Siswa -->
<!-- Modal -->
<div class="modal fade" id="detailVoteMethod" tabindex="-1" aria-labelledby="detailVoteMethodLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailVoteMethodLabel">Metode Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body importData-body">
                <p><span class="text-danger">Note: </span>Metode pemilihan hanya dapat dipilih salah satu, dalam suatu pemilihan</p>
                <div class="divider"></div>
                <h6>1. Import menggunakan Excel</h6>
                <ul>
                    <li>
                        <p>Metode pendaftaran ini, tidak membolehkan siswa nya untuk mendaftar sendiri, maka dari itu pihak guru yang akan mendaftarkan siswa nya menggunakan data excel yang dapat di import</p>
                    </li>
                </ul>
                <h6>2. Register Manual</h6>
                <ul>
                    <li>
                        <p>Metode pendaftaran, memperbolehkan siswa untuk melakukan pendaftaran manual. Di Sistem ini, siswa tidak akan dapat melakukan cloningan akun, karena pendaftaran nya menggunakan NISN dan setiap IP Address siswa tersebut akan direkam</p>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>