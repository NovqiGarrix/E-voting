    <section class="login register">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-4">
                    <img src="<?= base_url('assets/'); ?>img/register.jpg" class="img-fluid img-auth">
                </div>
                <div class="col-lg-6 mx-auto my-auto col-sm-4">
                    <div class="input-wrapper">
                        <img src="https://logincdn.msauth.net/shared/1.0/content/images/microsoft_logo_ee5c8d9fb6248c938fd0dc19370e90bd.svg" class="company-logo">
                        <h2>Pendaftaran Kepala Sekolah</h2>
                        <div class="divider"></div>
                        <?= $this->session->flashdata('message'); ?>
                        <form action="" method="POST" id="formInput">
                            <div class="name">
                                <input type="text" id="nameField" value="<?= set_value('kepsekName') ?>" placeholder="Nama Sekolah" name="kepsekName" class="inputField nameField">
                                <div class="icon">
                                    <i class="fas fa-fw fa-user"></i>
                                </div>
                                <small class="text-danger"><?= form_error('kepsekName'); ?></small>
                            </div>
                            <div class="email">
                                <input type="text" id="emailField" value="<?= set_value('kepsekEmail') ?>" placeholder="Email Address" name="kepsekEmail" class="inputField email">
                                <div class="icon">
                                    <i class="fa fa-fw fa-envelope"></i>
                                </div>
                                <small class="text-danger"><?= form_error('kepsekEmail'); ?></small>
                            </div>
                            <div class="password">
                                <input type="password" id="pass1Field" placeholder="Password" name="kepsekPass1" class="inputField pass1">
                                <div class="icon">
                                    <i class="fa fa-fw fa-lock"></i>
                                </div>
                                <small class="text-danger"><?= form_error('kepsekPass1'); ?></small>

                            </div>
                            <div class="rPassword">
                                <input type="password" id="pass2Field" placeholder="Repeat Password" name="kepsekPass2" class="inputField pass2">
                                <div class="icon">
                                    <i class="fas fa-fw fa-user-lock"></i>
                                </div>
                            </div>
                            <div class="jenisKelamin">
                                <select class="kelas" name="jenisKelamin">
                                    <?php foreach ($jenisKelamin as $jk) : ?>
                                        <option class="option-kelas" value="<?= $jk; ?>"><?= $jk; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="checkbox checkbox-login">
                                <input class="form-check-input" checked type="checkbox" id="terms">
                                <label class="form-check-label" for="terms">
                                    <h5>I Agree to Terms and Privacy Policy</h5>
                                </label>
                            </div>
                            <button type="submit" class="loginBtn register-btn">Daftar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>