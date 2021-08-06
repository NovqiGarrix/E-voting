<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <div class="resetSystemShare">
            <a href="<?= base_url('admin/reset'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-fw fa-circle-notch fa-sm text-white-50"></i> Reset System</a>
            <a href="#" data-toggle="modal" data-target="#shareLinkButton" class="d-none d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm"><i class="fas fa-fw fa-share-alt fa-sm text-outline-50"></i> Bagikan</a>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-4">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="row justify-content-center align-items-center edit-waktu-pemilihan">
        <div class="col-auto mb-3">
            <div class="editButton">
                <div class="waktu-pemilihModal">
                    <a data-toggle="modal" data-target="#waktu-pemilihModal" href=""><i class="fas fa-fw fa-edit fa-1x"></i></a>
                    <p>Waktu Pemilihan</p>
                </div>
                <div class="waktu-pemilihModal">
                    <a href="<?= base_url('admin/handleStopVoting?') . 'q=' . urlencode(base64_encode('VqiiRixx')) ?>"><i class="fas fa-fw fa-edit fa-1x"></i></a>
                    <p>Stop Voting</p>
                </div>
                <?php if ($waktu_pemilu['while_voting'] < 1) : ?>
                    <div class="token-daftarModal changeVoteMethod">
                        <a data-toggle="modal" data-target="#changeVoteMethod" href=""><i class="fas fa-fw fa-user-edit fa-1x"></i></a>
                        <p>Metode Pendaftaran</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row waktu-pemilih justify-content-center">
        <div class="col-auto">
            <div class="days timer">
                <h1 class="text-primary">0</h1>
                <?php if ($waktu_pemilu['while_voting'] == 1) : ?>
                    <span class="span-1">Kandidat yang menang adalah <?= $winner['Name']; ?></span>
                <?php endif; ?>
                <span class="span-2">Hari</span>
            </div>
            <div class="hours timer">
                <h1 class="text-primary">0</h1>
                <span>Jam</span>
            </div>
            <div class="minutes timer">
                <h1 class="text-primary">0</h1>
                <span>Menit</span>
            </div>
            <div class="seconds timer">
                <h1 class="text-primary">0</h1>
                <span>Detik</span>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Pemilih</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 jumlahPemilih"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Kandidat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 jumlahKandidat"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div style="font-size: 11px;" class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Pemilih Sudah Memilih</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 jumlah-pemilih-done"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div style="font-size: 11px;" class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Pemilih Belum Memilih</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 jumlah-pemilih-havent"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-user-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Count -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-2">
            <h1 class="h5 text-gray-800 mb-0">Quick Count</h1>
        </div>
    </div>
    <div class="row" id="dataKandidatJs">
    </div>

    <div class="row">
        <div class="col-lg col-xl">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>




</div>

</div>
<!-- End of Content Wrapper -->

</div>

<!-- Modal -->
<div class="modal fade" id="waktu-pemilihModal" tabindex="-1" aria-labelledby="waktu-pemilihModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="waktu-pemilihModalLabel">Edit Waktu Pemilihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form-waktu-pemilu">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="waktu-pemilih">Waktu Pemilihan</label>
                        <input type="text" autocomplete="false" autofocus placeholder="Ex: 23 Nov 2020" class="form-control" id="waktu-pemilih">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Token Modal -->
<div class="modal fade" id="token-daftarModal" tabindex="-1" aria-labelledby="token-daftarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="token-daftarModalLabel">Token Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form-token-pendaftaran" action="<?= base_url('admin/setTokenPendaftaran'); ?>">
                <div class="modal-body">
                    <?php if ($tokenOld) : ?>
                        <p class="text-warning">Token saat ini : <?= $tokenOld['token']; ?></p>
                    <?php endif ?>
                    <div class="form-group">
                        <label for="waktu-pemilih">Token</label>
                        <input type="text" autocomplete="false" name="token-daftar" autofocus placeholder="Ex: 00sma52311" class="form-control" id="token-daftar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" untuk keluar</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('home/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Metode Pendaftaran -->
<div class="modal fade" id="changeVoteMethod" tabindex="-1" aria-labelledby="changeVoteMethodLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeVoteMethodLabel">Metode Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/handleChangeVoteMethod'); ?>" class="changeVoteMethod" method="post">
                <div class="modal-body importData-body">
                    <p><span class="text-danger">Note: </span>Metode pemilihan hanya dapat dipilih salah satu, dalam suatu pemilihan</p>
                    <a href="" style="margin-top: -.6rem;" data-toggle="modal" data-target="#detailVoteMethod" class="btn btn-sm shadow-sm btn-outline-primary mb-3">Help!</a>
                    <div class="input-group mb-3">
                        <select class="custom-select" id="inputGroupSelect02" name="metode-pendaftaran">
                            <?php foreach ($voteMethod as $vm) : ?>
                                <?php if ($schoolData['voteMethod'] == url_title($vm, '-', TRUE)) : ?>
                                    <option selected value="<?= url_title($vm, '-', true) ?>"><?= $vm ?></option>
                                <?php else : ?>
                                    <option value="<?= url_title($vm) ?>"><?= $vm ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <div class="input-group-append">
                            <label class="input-group-text" for="inputGroupSelect02">Options</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Metode Pendaftaran Siswa -->
<!-- Modal -->
<div class="modal fade" id="detailVoteMethod" tabindex="-1" aria-labelledby="detailVoteMethodLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailVoteMethodLabel">Metode Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body importData-body">
                <p><span class="text-danger">Note: </span>Metode pemilihan hanya dapat dipilih salah satu, dalam suatu pemilihan</p>
                <div class="divider"></div>
                <h6>1. Import menggunakan Excel</h6>
                <ul>
                    <li>
                        <p>Metode pendaftaran ini, tidak membolehkan siswa nya untuk mendaftar sendiri, maka dari itu pihak guru yang akan mendaftarkan siswa nya menggunakan data excel yang dapat di import</p>
                    </li>
                </ul>
                <h6>2. Register Manual</h6>
                <ul>
                    <li>
                        <p>Metode pendaftaran, memperbolehkan siswa untuk melakukan pendaftaran manual. Di Sistem ini, siswa tidak akan dapat melakukan cloningan akun, karena pendaftaran nya menggunakan NISN dan setiap IP Address siswa tersebut akan direkam</p>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Share ke Siswa -->
<!-- Modal -->
<div class="modal fade" id="shareLinkButton" tabindex="-1" aria-labelledby="shareLinkButtonLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareLinkButtonLabel">Bagikan Link Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body copyClipboardModal">
                <?php $npsn = urlencode(base64_encode($this->session->userdata('npsn')));
                $link = base_url('auth/register?' . 'nvnn=' . $npsn); ?>
                <div class="input-group mb-3">
                    <input type="text" class="form-control copyClipboadInput" readonly value="<?= $link; ?>" aria-label="Recipient's username" aria-describedby="copyClipboard">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary copyClipboadButton" type="button" id="copyClipboard">Salin</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
    <div id="shareLinkToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">
        <div class="toast-header">
            <i class="rounded mr-2 text-primary fas fa-fw fa-bell"></i>
            <strong class="mr-auto">Notifications</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <h6 class="text-primary">Link berhasil disalin</h6>
        </div>
    </div>
</div>


<script src="<?= base_url('assets/sbadmin2/'); ?>vendor/jquery/jquery.min.js"></script>

<script>
    function loadKandidat() {
        $.ajax({
            url: "<?= base_url('admin/getSuara'); ?>",
            type: 'POST',
            dataType: 'JSON',
            data: {
                id: "garrixHere"
            },
            success: function(data) {
                $('#dataKandidatJs').html('');

                $.each(data, function(i, data) {
                    let menu = data;
                    $.each(menu, function(i, data) {
                        $('#dataKandidatJs').append('<div class="col-xl-3 col-md-6 mb-4"><div class="card border-left-primary shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">' + data.Name + '</div><div class="h5 mb-0 font-weight-bold text-gray-800">' + data.jumlahSuara + ' Suara</div></div><div class="col-auto"><i class="fas fa-fw fa-user-friends fa-2x text-gray-300"></i></div></div></div></div></div>');
                    })
                })
            }
        })
    }
    loadKandidat();
    // Load Card
    $.ajax({
        url: "<?= base_url('admin/getPemilihCard') ?>",
        type: "POST",
        dataType: "JSON",
        data: {
            id: "garrixHere"
        },
        success: (data) => {
            $('.jumlahPemilih').html('');
            $('.jumlahKandidat').html('');
            $('.jumlah-pemilih-done').html('');
            $('.jumlah-pemilih-havent').html('');

            const jumlahPemilih = data.pemilih;
            const jumlahKandidat = data.kandidat;
            const pemilihSudah = data.pemilihSudah;
            const pemilihBelum = data.pemilihBelum;

            $('.jumlahPemilih').append(jumlahPemilih + ' Orang');
            $('.jumlahKandidat').append(jumlahKandidat + ' Paslon');
            $('.jumlah-pemilih-done').append(pemilihSudah + ' Orang');
            $('.jumlah-pemilih-havent').append(pemilihBelum + ' Orang');
        }
    });
</script>