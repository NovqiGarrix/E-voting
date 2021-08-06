<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row mb-2">
        <div class="col-lg-6 col-xl-6">
            <a data-toggle="modal" data-target="#insertModal" href="" class="btn btn-primary">Add Menu</a>
        </div>
    </div>

    <div class="row mb-2 mt-2">
        <div class="col-lg-6 col-xl-6">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-6 col-xl-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Role Menu</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <?php $i = 1 ?>
                <tbody>
                    <?php foreach ($menu as $menu) : ?>
                        <tr>
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= $menu['menu']; ?></td>
                            <td>
                                <a href="<?= base_url('menu/edit/') . $menu['id']; ?>" class="badge badge-pill badge-warning">Edit</a>
                                <a href="<?= base_url('menu/delete/') . $menu['id_menu']; ?>" class="badge badge-pill badge-danger">Delete</a>
                            </td>
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
<div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertModalLabel">Add Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?= base_url('menu/insert'); ?>">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="menuId">ID Menu</label>
                        <input type="text" value="<?= $menuNum + 1; ?>" readonly name="menuIdInsert" class="form-control" id="menuId">
                        <small class="text-danger"><?= form_error('menuIdInsert'); ?></small>
                    </div>
                    <div class="form-group">
                        <label for="menuName">Menu Name</label>
                        <input type="text" name="menuNameInsert" class="form-control" id="menuName">
                        <small class="text-danger"><?= form_error('menuNameInsert'); ?></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Example select</label>
                        <select name="menuRoleId" class="form-control" id="exampleFormControlSelect1">
                            <option selected>--Role Id--</option>
                            <?php $userRole = $this->db->get('user_role')->result_array(); ?>
                            <?php foreach ($userRole as $ur) : ?>
                                <option value="<?= $ur['role_id'] ?>"><?= $ur['role_id'] ?></option>
                            <?php endforeach; ?>
                        </select>
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