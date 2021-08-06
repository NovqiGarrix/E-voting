        <!-- Detail Kandidat -->
        <section class="detail-calonKandidat">
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <h3>Detail Kandidat</h3>
                        <p>Pelajari <span>Visi</span> dan <span>Misi</span> Kandidat sebelum memilih!</p>
                        <a href="<?= base_url('kandidat'); ?>" class="detailBtnKandidat">Daftar Kandidat</a>
                    </div>
                </div>
                <div class="row detail-text">
                    <div class="col-lg-4">
                        <div class="card">
                            <img src="<?= base_url('assets/'); ?>img/kandidat/<?= $kandidat['img']; ?>" class="card-img-top img-fluid">
                        </div>

                        <?php if ($time_pemilu) : ?>
                            <?php if ($time_pemilu['int_waktu'] < strtotime(date('d F Y')) && $time_pemilu['while_voting'] == 0) : ?>
                                <?php if ($voteSchool['voteTimes'] < 1) : ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        Pemilihan belum dimulai, kami akan mengirim notifkasi ke email kamu, jika pemilihan sudah dimulai
                                    </div>
                                <?php else : ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Pemilihan sudah berakhir, silahkan pergi halaman <a href="<?= base_url('count'); ?>">Quick Count</a> untuk melihat hasil sementara
                                    </div>
                                <?php endif; ?>
                            <?php else : ?>
                                <?php if (!$this->session->userdata('email')) : ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Silahkan <a href="<?= base_url('auth'); ?>">Login</a> terlebih dahulu sebelum Memilih
                                    </div>
                                <?php else : ?>
                                    <?php if ($user['is-voting']  > 0) : ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            Anda telah melakukan voting, silahkan pergi ke halaman <a href="<?= base_url('count'); ?>">Quick Count</a> untuk melihat hasil voting sementara
                                        </div>
                                    <?php else : ?>
                                        <button type="button" data-kandidat="<?= base64_encode($kandidat['Name']); ?>" data-slug="<?= base64_encode($kandidat['slug']); ?>" style="width: 100%;" class="detailVoteBtn votingButton mt-3">Vote</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="alert alert-success" role="alert">Pemilihan belum dimulai</div>
                        <?php endif; ?>

                        <div class="row waktu-pemilihan justify-content-center">
                            <div class="col-auto">
                                <div class="days timer">
                                    <h1>0</h1>
                                    <span>Hari</span>
                                </div>
                                <div class="hours timer">
                                    <h1>0</h1>
                                    <span>Jam</span>
                                </div>
                                <div class="minutes timer">
                                    <h1>0</h1>
                                    <span>Menit</span>
                                </div>
                                <div class="seconds timer">
                                    <h1>0</h1>
                                    <span>Detik</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-8">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row table-title">No. Urut</th>
                                        <td colspan="3"><?= $kandidat['noKandidat']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row table-title">Nama Lengkap</th>
                                        <td colspan="3"><?= $kandidat['Name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row table-title">Visi dan Misi</th>
                                        <td class="there-ul" colspan="3"><span>Visi</span> : <?= $kandidat['Visi']; ?><br>
                                            <span>Misi</span> :
                                            <ul><?= $kandidat['Misi']; ?></ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>