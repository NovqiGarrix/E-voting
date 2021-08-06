<section class="login">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 ">
                <img src="<?= base_url('assets/'); ?>img/loginBg.jpg" class="img-fluid img-auth">
            </div>
            <div class="col-lg-6 mx-auto my-auto">
                <div class="input-wrapper">
                    <img src="https://logincdn.msauth.net/shared/1.0/content/images/microsoft_logo_ee5c8d9fb6248c938fd0dc19370e90bd.svg" class="company-logo">
                    <h2>Masuk</h2>
                    <div class="divider"></div>
                    <?= $this->session->flashdata('message'); ?>
                    <form action="" method="POST">
                        <div class="email">
                            <input type="text" value="<?= set_value('email') ?>" placeholder="Email Address / NISN" name="email" class="inputField">
                            <div class="icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <small class="text-danger"><?= form_error('email'); ?></small>
                        </div>
                        <div class="password">
                            <input type="password" placeholder="Password" name="password" class="inputField">
                            <div class="icon">
                                <i class="fa fa-lock sm"></i>
                            </div>
                            <small class="text-danger"><?= form_error('password'); ?></small>
                        </div>
                        <div class="checkbox">
                            <a href="<?= base_url('auth/forgotPassword'); ?>"><small class="forgot-pass">Lupa password</small></a>
                            <a href="<?= base_url('auth/register'); ?>" class="noAccount">Belum Memiliki Akun?</a>
                        </div>
                        <button type="submit" class="loginBtn">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>