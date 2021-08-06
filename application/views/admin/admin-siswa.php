<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <a href="<?= base_url('guru/report'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-fw fa-share fa-sm text-white-50"></i> Kirim Laporan Data Siswa</a>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg col-xl">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">NISN</th>
                        <th scope="col">Nama Siswa</th>
                        <th scope="col">Email</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Kandidat</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <?php $i = 1; ?>
                <tbody>
                    <?php if ($siswa) : ?>
                        <?php foreach ($siswa as $s) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= $s['NISN']; ?></td>
                                <td><?= $s['Name']; ?></td>
                                <td><?= $s['Email']; ?></td>
                                <td><?= $s['Kelas']; ?></td>
                                <td><?= $s['jenisKelamin']; ?></td>
                                <?php if ($s['is-voting'] == 0) : ?>
                                    <td class="text-danger">Belum memilih</td>
                                <?php else : ?>
                                    <td><?= $s['Kandidat']; ?></td>
                                <?php endif; ?>
                                <td>
                                    <a href="<?= base_url('guru/editSiswa/') . $s['NISN']; ?>" class="badge badge-warning"><i class="fas fa-fw fa-user-edit"></i> Edit</a>
                                    <a href="<?= base_url('guru/deleteSiswa/') . $s['NISN']; ?>" class="badge badge-danger"><i class="fas fa-fw fa-user-times"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><span class="text-danger">Note:</span> Belum ada siswa/i <span style="font-style: italic;" class="text-primary"><?= $kelas; ?></span> yang mendaftar</tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>