<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row mb-2">
        <div class="col-lg-6 col-xl-6">
            <a data-toggle="modal" data-target="#roleInsert" href="" class="btn btn-primary">Add Role</a>
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
                        <th scope="col">Role Id</th>
                        <th scope="col">Role Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <?php $i = 1 ?>
                <tbody>
                    <?php foreach ($role as $role) : ?>
                        <tr>
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= $role['role_id']; ?></td>
                            <td><?= $role['roleName']; ?></td>
                            <td>
                                <a href="<?= base_url('dashboard/editRole/') . $role['role_id']; ?>" class="badge badge-pill badge-warning">Edit</a>
                                <a href="<?= base_url('dashboard/deleteRole/') . $role['role_id']; ?>" class="badge badge-pill badge-danger">Delete</a>
                                <a href="<?= base_url('dashboard/accessRole/') . $role['role_id']; ?>" class="badge badge-pill badge-success">Access</a>
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
<div class="modal fade" id="roleInsert" tabindex="-1" aria-labelledby="roleInsertLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleInsertLabel">Add Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="menuId">ID Role</label>
                        <input type="text" value="<?= $roleNum + 1; ?>" readonly name="roleId" class="form-control" id="menuId">
                    </div>
                    <div class="form-group">
                        <label for="menuName">Role Name</label>
                        <input type="text" name="roleName" class="form-control" id="menuName">
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