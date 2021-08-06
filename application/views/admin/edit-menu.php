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
                    <label for="exampleInputEmail1">Menu Id</label>
                    <input type="text" value="<?= $menu['id_menu']; ?>" name="menuId" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Menu Name</label>
                    <input type="text" value="<?= $menu['menu']; ?>" name="menuName" class="form-control" id="exampleInputPassword1">
                </div>
                <?php
                $order_by = $this->db->get('menu')->num_rows();

                ?>
                <input type="hidden" value="<?= $order_by + 1 ?>" name="order-by">
                <a href="<?= base_url('menu'); ?>" class="btn btn-outline-primary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>