<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <i class="fas fa-fw fa-poll"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-Voting</div>
    </a>

    <!-- Join Tabel -->
    <?php
    $userId = $this->session->userdata('role_id');

    $queryMenu = "SELECT *
                    FROM `menu` JOIN `user_access_menu`
                    ON `menu`. `id_menu` = `user_access_menu`.`menu_id`
                    WHERE `user_access_menu`.`role_id` = $userId
                    ORDER BY `menu`.`order_by` ASC
                    ";

    $menu = $this->db->query($queryMenu)->result_Array();
    ?>

    <?php foreach ($menu as $m) : ?>
        <!-- Heading -->
        <div class="sidebar-heading">
            <?= $m['menu']; ?>
        </div>

        <?php
        $menuId = $m['id_menu'];
        $querySubmenu = "SELECT *
            FROM `submenu` JOIN `menu`
            ON `submenu`. `menu_id` = `menu`.`id_menu`
            WHERE `submenu`.`menu_id` = $menuId
            AND `submenu`.`is_active` = 1
            ";
        $submenu = $this->db->query($querySubmenu)->result_Array();
        ?>

        <?php foreach ($submenu as $sm) : ?>
            <!-- Nav Item - Dashboard -->
            <?php if ($title == $sm['submenu']) : ?>
                <li class="nav-item active sidebar-navItem">
                <?php else : ?>
                <li class="nav-item sidebar-navItem">
                <?php endif; ?>
                <a class="nav-link mb-0" href="<?= base_url($sm['url']); ?>">
                    <i class="<?= $sm['icon']; ?>"></i>
                    <span><?= $sm['submenu']; ?></span></a>
                </li>
            <?php endforeach; ?>
            <hr class="sidebar-divider">
        <?php endforeach; ?>


        <!-- Divider -->



        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item sidebar-navItem">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Halaman</h6>
                    <a class="collapse-item" href="<?= base_url(); ?>">Home</a>
                    <a class="collapse-item" href="<?= base_url('kandidat'); ?>">Kandidat</a>
                    <a class="collapse-item" href="<?= base_url('count'); ?>">Quick Count</a>
                </div>
            </div>
        </li>

        <li class="nav-item sidebar-navItem">
            <a class="nav-link mb-0" href="<?= base_url('home/logout'); ?>">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Log out</span></a>
        </li>


        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">