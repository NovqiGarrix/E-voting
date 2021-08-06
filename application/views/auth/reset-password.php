<section class="login">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 ">
                <img src="<?= base_url('assets/'); ?>img/forgot-pass.jpg" class="img-fluid img-auth">
            </div>
            <div class="col-lg-6 mx-auto my-auto">
                <div class="input-wrapper">
                    <img src="https://logincdn.msauth.net/shared/1.0/content/images/microsoft_logo_ee5c8d9fb6248c938fd0dc19370e90bd.svg" class="company-logo">
                    <h2>Reset Password</h2>
                    <div class="divider"></div>
                    <?= $this->session->flashdata('message'); ?>
                    <form action="<?= base_url('auth/changePassword'); ?>" method="POST">
                        <div class="password">
                            <input type="password" placeholder="New Password" name="pass1" class="inputField">
                            <div class="icon">
                                <i class="fa fa-lock"></i>
                            </div>
                            <small class="text-danger"><?= form_error('pass1'); ?></small>
                        </div>
                        <div class="password">
                            <input type="password" placeholder="Confirm Password" name="pass2" class="inputField">
                            <div class="icon">
                                <i class="fa fa-user-lock"></i>
                            </div>
                            <small class="text-danger"><?= form_error('pass2'); ?></small>
                        </div>
                        <button type="submit" class="loginBtn">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>