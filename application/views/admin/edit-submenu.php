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
                <div class="input-group mb-3">
                    <select name="menu" class="custom-select" id="inputGroupSelect01">
                        <option value="" selected>--Pilih Menu--</option>
                        <?php foreach ($menu as $m) : ?>
                            <option value="<?= $m['id_menu']; ?>"><?= $m['menu']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="submenu">Submenu</label>
                    <input type="text" value="<?= $submenu['submenu']; ?>" name="submenu" class="form-control" id="submenu">
                </div>
                <div class="form-group">
                    <label for="icon">Icon</label>
                    <input type="text" value="<?= $submenu['icon']; ?>" name="icon" class="form-control" id="icon">
                </div>
                <div class="form-group">
                    <label for="url">Url</label>
                    <input type="text" value="<?= $submenu['url']; ?>" name="url" class="form-control" id="url">
                </div>
                <a href="<?= base_url('menu/submenu'); ?>" class="btn btn-outline-primary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>