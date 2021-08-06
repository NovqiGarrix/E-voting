<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row mb-2">
        <div class="col-lg-6 col-xl-6">
            <a data-toggle="modal" data-target="#insertSubmenu" href="" class="btn btn-primary">Add Submenu</a>
        </div>
    </div>

    <div class="row mb-2 mt-2">
        <div class="col-lg-6 col-xl-6">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Submenu</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Url</th>
                        <th scope="col">Is Active</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <?php $i = 1; ?>
                <tbody>
                    <?php foreach ($submenu as $sm) : ?>
                        <tr>
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= $sm['menu']; ?></td>
                            <td><?= $sm['submenu']; ?></td>
                            <td><i class="<?= $sm['icon']; ?> text-primary mr-2"></i> <?= $sm['icon']; ?></td>
                            <td><?= $sm['url']; ?></td>
                            <td>

                                <?php if ($sm['is_active'] == 1) : ?>
                                    <?php $is_aktif = "checked='checked'"; ?>
                                <?php else : ?>
                                    <?php $is_aktif = ''; ?>
                                <?php endif; ?>

                                <div class="form-check">
                                    <input class="form-check-input" <?= $is_aktif; ?> data-slug="<?= $sm['slug']; ?>" data-is_active="<?= $sm['is_active']; ?>" type="checkbox" id="defaultCheck1">
                                </div>
                            </td>
                            <td>
                                <a href="<?= base_url('menu/submenuEdit/') . $sm['slug']; ?>" class="badge badge-warning">Edit</a>
                                <a href="<?= base_url('menu/submenuDelete/') . $sm['slug']; ?>" class="badge badge-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="insertSubmenu" tabindex="-1" aria-labelledby="insertSubmenuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertSubmenuLabel">Add Submenu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/insertSubmenu'); ?>" method="POST">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <select name="menu" class="custom-select" id="inputGroupSelect01">
                            <option selected>--Pilih Menu--</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id_menu']; ?>"><?= $m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Submenu Name</label>
                        <input name="submenu" type="text" class="form-control" id="submenu">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Icon</label>
                        <input name="icon" type="text" class="form-control" id="icon">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Url</label>
                        <input name="url" type="text" class="form-control" id="url">
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