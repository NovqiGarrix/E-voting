<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>


    <div class="row">
        <div class="col-lg-4 col-xl-5">
            <?= form_open_multipart('Data_User/edit/' . $kandidat['slug']); ?>
            <input type="hidden" value="<?= $kandidat['NPSN']; ?>" name="npsn">
            <div class="form-group row">
                <div class="col-4">
                    <img src="<?= base_url('assets/img/kandidat/') . $kandidat['img']; ?>" class="imgKandidatAdmin img-thumnail" style="border-radius: 10px;">
                </div>
            </div>
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" value="<?= $kandidat['img']; ?>" name="imgProfile" class="custom-file-input" id="kandidatImg" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="kandidatImg">Choose file</label>
                </div>
            </div>
            <div class="form-group">
                <label for="submenu">No. Kandidat</label>
                <input type="text" value="<?= $kandidat['noKandidat']; ?>" name="no-kandidat" class="form-control" id="submenu">
                <small class="text-danger"><?= form_error('no-kandidat') ?></small>
            </div>
            <div class="form-group">
                <label for="icon">Nama Kandidat</label>
                <input type="text" value="<?= $kandidat['Name']; ?>" name="name" class="form-control" id="icon">
                <small class="text-danger"><?= form_error('name') ?></small>
            </div>
            <div class="form-group">
                <label for="visi">Visi</label>
                <textarea style="width: 100%;" class="text-area" name="visi" id="visi" cols="2" rows="5"><?= $kandidat['Visi']; ?></textarea>
                <small class="text-danger"><?= form_error('visi') ?></small>
            </div>
            <div class="form-group">
                <label for="editor_misi">Misi</label>
                <textarea id="editor_misi" name="misi"><?= $kandidat['Misi']; ?></textarea>
                <small class="text-danger"><?= form_error('misi') ?></small>
            </div>
            <a href="<?= base_url('Data_User'); ?>" class="btn btn-outline-primary">Kembali</a>
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