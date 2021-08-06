<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Poppins Font-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;0,700;1,200&display=swap" rel="stylesheet">

    <!-- Another Font -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">

    <!-- Style Css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/home.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/detail-kandidat.css">

    <title><?= $title; ?></title>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <section class="main">
        <nav class="fixed-top">
            <!-- Logo Brand -->
            <?php if ($this->session->userdata('email')) : ?>
                <div class="logo-brand">
                    <div class="row flex-row align-items-center">
                        <div class="col-lg">
                            <a href="<?= base_url('Data_User'); ?>" class="logo">e-Voting</a>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <a href="<?= base_url('admin'); ?>" class="logo">e-Voting</a>
            <?php endif; ?>

            <!-- Humburger Btn -->
            <input type="checkbox" id="menu-btn" class="menu-btn">
            <label class="menu-icon" for="menu-btn">
                <span class="nav-icon"></span>
            </label>
            <!-- Menu -->
            <ul class="menu">
                <li><a class="listNav" href="<?= base_url(); ?>">Home</a></li>
                <li><a class="listNav quick-count" href="<?= base_url('count'); ?>">Quick Count</a></li>
                <li><a class="listNav" href="<?= base_url('kandidat'); ?>">Kandidat</a></li>
                <?php if ($this->session->userdata('email')) : ?>
                    <a href="<?= base_url('home/logout'); ?>" class="sign-in">Log Out</a>
                <?php else : ?>
                    <a href="<?= base_url('auth/register'); ?>" class="sign-in">DAFTAR</a>
                <?php endif; ?>
            </ul>

        </nav>