    <section class="login register">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-4">
                    <img src="<?= base_url('assets/'); ?>img/register.jpg" class="img-fluid img-auth">
                </div>
                <div class="col-lg-6 mx-auto my-auto col-sm-4">
                    <div class="input-wrapper">
                        <img src="https://logincdn.msauth.net/shared/1.0/content/images/microsoft_logo_ee5c8d9fb6248c938fd0dc19370e90bd.svg" class="company-logo">
                        <h2>Pendaftaran Sekolah</h2>
                        <div class="divider"></div>
                        <?= $this->session->flashdata('message'); ?>
                        <?= form_open_multipart('auth/registerSchool'); ?>
                        <div class="nisn">
                            <input type="text" id="nisnField" value="<?= set_value('npsn') ?>" placeholder="NPSN" name="npsn" class="inputField nisnField">
                            <div class="icon">
                                <i class="fas fa-fw fa-address-card"></i>
                            </div>
                            <small class="text-danger"><?= form_error('npsn'); ?></small>
                        </div>
                        <div class="name">
                            <input type="text" id="nameField" value="<?= set_value('name') ?>" placeholder="Nama Sekolah" name="name" class="inputField nameField">
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
                            <input type="password" id="passwordField" value="<?= set_value('pass1') ?>" placeholder="Password" name="pass1" class="inputField email">
                            <div class="icon">
                                <i class="fa fa-fw fa-user-lock"></i>
                            </div>
                            <small class="text-danger"><?= form_error('pass1'); ?></small>
                        </div>
                        <div class="rPassword">
                            <input type="password" id="RepasswordField" value="<?= set_value('pass2') ?>" placeholder="Re-Enter Password" name="pass2" class="inputField email">
                            <div class="icon">
                                <i class="fa fa-fw fa-lock"></i>
                            </div>
                            <small class="text-danger"><?= form_error('pass2'); ?></small>
                        </div>
                        <div class="akreditasi-wrapper mb-2">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="akreditasiFile" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose File</label>
                            </div>
                            <small class="text-danger"><?= form_error('akreditasi-input') ?></small>

                            <p class="mt-2"><span class="text-danger">Note: </span>Upload scan akreditasi sekolah kamu</p>
                        </div>
                        <div class="daftarSekolah-option">
                            <select class="kelas" name="voteMethod">
                                <option selected class="option-kelas" value="">-- Metode Pendaftaran --</option>
                                <?php foreach ($voteMethod as $k) : ?>
                                    <option class="option-kelas" value="<?= url_title($k, '-', TRUE); ?>"><?= $k; ?></option>
                                <?php endforeach; ?>
                            </select>

                            <p><span class="text-danger">Note: </span>Anda masih dapat mengubah metode ini ketika selesai mendaftar</p>
                        </div>

                        <div class="checkbox checkbox-login">
                            <input class="form-check-input" checked type="checkbox" id="terms">
                            <label class="form-check-label" for="terms">
                                <h5>I Agree to Terms and Privacy Policy</h5>
                            </label>
                            <a href="<?= base_url('auth'); ?>" class="noAccount">Sudah Mendaftar?</a>
                        </div>

                        <button type="submit" class="loginBtn register-btn">Daftar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>