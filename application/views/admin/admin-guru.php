<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row mb-2">
        <div class="col-lg-6 col-xl-6">
            <a data-toggle="modal" data-target="#guruInsert" href="" class="btn btn-primary">Tambah Guru</a>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-lg-6 col-xl-6">
            <?= $this->session->flashdata('message'); ?>

            <p class="mt-3"><span class="text-danger">Note:</span> Untuk kolom Wali Kelas, akan diisi otomatis ketika guru tersebut mendaftar</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-xl-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Guru</th>
                        <th scope="col">Wali Kelas</th>
                    </tr>
                </thead>
                <?php $i = 1 ?>
                <tbody>
                    <?php foreach ($guru as $guru) : ?>
                        <tr>
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= $guru['Name']; ?></td>
                            <?php if ($guru['Kelas'] == '') : ?>
                                <td class="text-danger">Unknown</td>
                            <?php else : ?>
                                <td><?= $guru['Kelas']; ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<!-- Modal --------------------------------------------------------------------------------------->

<!-- Insert Modal -->
<div class="modal fade" id="guruInsert" tabindex="-1" aria-labelledby="guruInsertLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="guruInsertLabel">Tambah Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="menuId">Nama Guru</label>
                        <input type="text" name="name" class="form-control" id="menuId">
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