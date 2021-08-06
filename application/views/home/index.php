<div class="home-content">
    <!-- Text -->
    <div class="home-text">
        <?php $getUser = $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(); ?>

        <h5 class="hello-name">Hello, <?= $getUser['Name']; ?> <img width="45" class="rounded-circle" src="<?= base_url('assets/img/' . $getUser['img']); ?>" alt="<?= $getUser['img']; ?>"></h5>
        <h1>E-Voting
            <h2>Pemilihan Ketua Osis</h2>
        </h1>
        <p>Ayo, Daftarkan sekolah kamu untuk melakukan voting secara Online, dan pastinya Realtime</p>

        <!-- Login Btn -->
        <div class="home-btn">
            <?php if ($this->session->userdata('email')) : ?>
                <a href="<?= base_url('kandidat'); ?>" style="font-size: 13px;" class="btn-login">Lihat Kandidat</a>
                <a href="<?= base_url('count'); ?>" style="font-size: 13px;" class="btn-kandidat">Quick Count</a>
            <?php else : ?>
                <a href="<?= base_url('auth'); ?>" class="btn-login">Log In</a>
                <a href="<?= base_url('kandidat'); ?>" class="btn-kandidat">Lihat Kandidat</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="home-img">
        <img src="<?= base_url('assets/img/home-img.png') ?>" class="home-image">
    </div>
</div>
</section>

<section class="voting" id="quick-count">
    <?php if (!$this->session->userdata('email')) : ?>
        <div class="schoolCounting">
            <div class="schoolCounting-row">
                <div class="schoolCounting-column">
                    <div class="divider-counter"></div>

                    <p>Users and Counting</p>
                    <h2><?= $pemilih; ?></h2>
                </div>
                <div class="schoolCounting-column">
                    <div class="divider-counter"></div>

                    <p>School using E-Voting</p>
                    <h2><?= $schoolsRow; ?></h2>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="container mb-5">
            <div class="row justify-content-center voting-wrapper">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow">
                        <div class="card-body">
                            <div class="row align-items-center voting-text mt-2">
                                <div class="col mr-2">
                                    <p class="text-primary">Jumlah Pemilih</p>
                                    <h4><?= $pemilih; ?> Orang</h4>
                                </div>
                                <div class="col-auto voting-icon">
                                    <i class="fas fa-fw fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow">
                        <div class="card-body">
                            <div class="row align-items-center voting-text mt-2">
                                <div class="col mr-2">
                                    <p class="text-success">Jumlah Kandidat</p>
                                    <h4><?= $kandidat; ?> Orang</h4>
                                </div>
                                <div class="col-auto voting-icon">
                                    <i class="fas fa-fw fa-user-friends fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow">
                        <div class="card-body">
                            <div class="row align-items-center voting-text mt-2">
                                <div class="col mr-2">
                                    <p class="text-info text-small" style="font-size: 10px;">Pemilih Sudah Memilih</p>
                                    <?php if ($pemilihDone < 1) : ?>
                                        <h4>Belum ada</h4>
                                    <?php else : ?>
                                        <h4><?= $pemilihDone; ?> Orang</h4>
                                    <?php endif; ?>

                                </div>
                                <div class="col-auto voting-icon">
                                    <i class="fas fa-fw fa-user-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow">
                        <div class="card-body">
                            <div class="row align-items-center voting-text mt-2">
                                <div class="col mr-2">
                                    <p class="text-warning text-small" style="font-size: 10px;">Pemilih Belum Memilih
                                    </p>
                                    <?php if ($pemilihBelum < 1) : ?>
                                        <h4>Tidak Ada</h4>
                                    <?php else : ?>
                                        <h4><?= $pemilihBelum; ?> Orang</h4>
                                    <?php endif; ?>
                                </div>
                                <div class="col-auto voting-icon">
                                    <i class="fas fa-fw fa-user-times fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
    </div>
</section>

<section class="service">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h2>Apa itu E-Voting?</h2>
            <div class="row">
                <div class="divider"></div>
            </div>
            <p>E-Voting Pemilihan Ketua Osis adalah aplikasi pemilihan suara untuk memilih calon ketua Osis yang
                baru secara online.
                <span class="hide-paragraph">Dengan aplikasi ini maka, kamu bisa memilih calon ketua osis yang baru di
                    sekolah kamu dengan hanya 1 klick. Sangat berguna dimasa pandemi Virus Corona saat ini</span>
            </p>
            <button type="submit" class="outline-btn show-btn">Lihat Selengkapnya</button>
        </div>
    </div>
</section>

<!-- Cara Menggunakan E-VOTING -->
<section class="how mb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 how-text">
                <h2>Cara Mengikuti Voting</h2>
                <p>Pastikan kamu sudah memiliki akun dan sudah terdaftar di sistem E-Voting ini. Jika belum silahkan
                    <a href="<?= base_url('auth/register'); ?>" class="linkDaftar">mendaftar</a> terlebih dahulu
                </p>
                <ul>
                    <li><i class="far fa-fw fa-check-circle fa-lg"></i>Login
                    </li>
                    <li><i class="far fa-fw fa-check-circle fa-lg"></i>Pilih menu kandidat
                    </li>
                    <li><i class="far fa-fw fa-check-circle fa-lg"></i>Klick detail pada kandidat yang kamu pilih
                    </li>
                    <li><i class="far fa-fw fa-check-circle fa-lg"></i>Klick tombol voting
                    </li>
                    <li><i class="far fa-fw fa-check-circle fa-lg"></i>Selesaii
                    </li>
                </ul>
            </div>
            <div class="col-lg-6 how-img img-fluid" style="width: 400px; height: 300px;">
                <img style="width: 100%; height: 100%;" src="<?= base_url('assets/'); ?>img/home-img.png" class="img-fluid">
            </div>
        </div>
    </div>
</section>