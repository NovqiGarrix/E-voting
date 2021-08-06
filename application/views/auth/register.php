    <section class="login register">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-4">
                    <img src="<?= base_url('assets/'); ?>img/register.jpg" class="img-fluid img-auth">
                </div>
                <div class="col-lg-6 mx-auto my-auto col-sm-4">
                    <div class="input-wrapper">
                        <img src="https://logincdn.msauth.net/shared/1.0/content/images/microsoft_logo_ee5c8d9fb6248c938fd0dc19370e90bd.svg" class="company-logo">
                        <h2>Daftar</h2>
                        <div class="divider"></div>
                        <?= $this->session->flashdata('message'); ?>
                        <form action="<?= base_url('auth/register'); ?>" method="POST" id="formInput">
                            <?php if ($this->input->get('nvnn')) : ?>
                                <div class="npsn">
                                    <input type="text" id="npsnField" value="<?= urldecode(base64_decode($this->input->get('nvnn'))); ?>" readonly name="npsn" class="inputField npsn_field_input">
                                    <div class="icon">
                                        <i class="fas fa-fw fa-address-book"></i>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="npsn">
                                    <input type="text" id="npsnField" value="<?= set_value('npsn') ?>" placeholder="NPSN" name="npsn" class="inputField npsn_field_input">
                                    <div class="icon">
                                        <i class="fas fa-fw fa-address-book"></i>
                                    </div>
                                    <small class="text-danger"><?= form_error('npsn'); ?></small>
                                </div>
                            <?php endif; ?>
                            <div class="nisn">
                                <input type="text" id="nisnField" value="<?= set_value('nisn') ?>" placeholder="NISN" name="nisn" class="inputField nisnField">
                                <div class="icon">
                                    <i class="fas fa-fw fa-address-card"></i>
                                </div>
                                <small class="text-danger"><?= form_error('nisn'); ?></small>
                            </div>
                            <div class="name">
                                <input type="text" id="nameField" value="<?= set_value('name') ?>" placeholder="Full Name" name="name" class="inputField nameField">
                                <div class="icon">
                                    <i class="fas fa-fw fa-user"></i>
                                </div>
                                <small class="text-danger"><?= form_error('name'); ?></small>

                            </div>

                            <div class="email">
                                <input type="text" id="emailField" value="<?= set_value('email') ?>" placeholder="Email Address" name="email" class="inputField email">
                                <div class="icon">
                                    <i class="fa fa-fw fa-envelope"></i>
                                </div>
                                <small class="text-danger"><?= form_error('email'); ?></small>

                            </div>
                            <div class="password">
                                <input type="password" id="pass1Field" placeholder="Password" name="pass1" class="inputField pass1">
                                <div class="icon">
                                    <i class="fa fa-fw fa-lock"></i>
                                </div>
                                <small class="text-danger"><?= form_error('pass1'); ?></small>
                            </div>
                            <div class="rPassword">
                                <input type="password" id="pass2Field" placeholder="Repeat Password" name="pass2" class="inputField pass2">
                                <div class="icon">
                                    <i class="fas fa-fw fa-user-lock"></i>
                                </div>
                                <small class="text-danger"><?= form_error('pass2'); ?></small>

                            </div>
                            <div class="row kelasOption">
                                <div class="col-4">
                                    <select class="kelas" name="kelas">
                                        <?php foreach ($kelas as $k) : ?>
                                            <option class="option-kelas" value="<?= $k; ?>"><?= $k; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select class="kelas" name="jurusan">
                                        <?php foreach ($jurusan as $j) : ?>
                                            <option class="option-kelas" value="<?= $j; ?>"><?= $j; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select class="kelas" name="noKelas">
                                        <?php foreach ($noKelas as $nk) : ?>
                                            <option class="option-kelas" value="<?= $nk; ?>"><?= $nk; ?></option>
                                        <?php endforeach; ?>
                                    </select>
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
                                <a href="<?= base_url('auth'); ?>" class="noAccount">Sudah Mendaftar?</a>
                            </div>
                            <button type="submit" class="loginBtn register-btn">Daftar</button>
                            <a class="btnDaftarSekolah" href="<?= base_url('auth/registerSchool'); ?>">Pendaftaran Sekolah</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>