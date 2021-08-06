<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <a href="#" data-toggle="modal" data-target="#kandidatModalInsert" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-fw mr-2 fa-user-plus fa-sm text-white-50"></i>Tambah Kandidat</a>
    </div>

    <div class="row">
        <div class="col-lg-4 col-xl-4">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Foto</th>
                            <th scope="col">No. Kandidat</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Visi</th>
                            <th scope="col">Misi</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <?php $i = 1; ?>
                    <tbody>
                        <?php foreach ($kandidat as $k) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td>
                                    <div class="card">
                                        <div class="imgKandidatAdmin">
                                            <img class="my-auto" src="<?= base_url('assets/img/kandidat/') . $k['img']; ?>">
                                        </div>
                                    </div>
                                </td>
                                <td class="text-primary font-weight-bold">#<?= $k['noKandidat']; ?></td>
                                <td><?= $k['Name']; ?></td>
                                <td style="width: 30%"><?= $k['Visi']; ?></td>
                                <td>
                                    <?= $k['Misi']; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('Data_User/edit/') . $k['slug']; ?>" class="badge badge-warning">Edit</a>
                                    <a href="<?= base_url('Data_User/deleteKandidat/') . $k['slug'] . '/' . $k['NPSN']; ?>" class="badge badge-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (empty($kandidat)) : ?>
                    <div class="alert alert-danger" role="alert">Belum ada kandidat</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="kandidatModalInsert" tabindex="-1" aria-labelledby="kandidatModalInsertLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kandidatModalInsertLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('Data_User/insertKandidat'); ?>
            <input type="hidden" value="<?= $this->session->userdata('npsn'); ?>" name="npsn">
            <div class="modal-body">
                <div class="form-group">
                    <label for="noKandidat">No. Kandidat</label>
                    <input type="text" readonly value="<?= $kandidatRow + 1 ?>" name="noKandidat" class="form-control" id="noKandidat">
                </div>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" name="imgKandidat" class="custom-file-input" id="kandidatImg" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="kandidatImg">Choose file</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="namaKandidat">Nama Kandidat</label>
                    <input type="text" name="namaKandidat" class="form-control" id="namaKandidat">
                </div>
                <div class="form-group">
                    <label for="visi">Visi</label>
                    <textarea class="text-area" name="visi" id="visi" rows="5" style="width: 100%;"></textarea>
                </div>
                <div class="form-group">
                    <label for="editor_misi">Misi</label>
                    <textarea style="width: 100%;" id="editor_misi" name="misi" rows="5"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- First Modal -->
<div class="modal fade" id="urutanPemilihanModal" tabindex="-1" aria-labelledby="urutanPemilihanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bold" id="urutanPemilihanModalLabel">Urutan Pemilihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Horizontal Steppers -->
                <div class="row">
                    <div class="col-md-12">

                        <!-- Stepers Wrapper -->
                        <ul class="stepper stepper-horizontal">

                            <!-- First Step -->
                            <li class="completed">
                                <a href="#!">
                                    <span class="circle">1</span>
                                    <span class="label">First step</span>
                                </a>
                            </li>

                            <!-- Second Step -->
                            <li class="active">
                                <a href="#!">
                                    <span class="circle">2</span>
                                    <span class="label">Second step</span>
                                </a>
                            </li>

                            <!-- Third Step -->
                            <li class="warning">
                                <a href="#!">
                                    <span class="circle"><i class="fas fa-exclamation"></i></span>
                                    <span class="label">Third step</span>
                                </a>
                            </li>

                        </ul>
                        <!-- /.Stepers Wrapper -->

                    </div>
                </div>
                <!-- /.Horizontal Steppers -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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