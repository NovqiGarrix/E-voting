<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <a href="<?= base_url('sekolah/exportPDFunApproved'); ?>" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <div class="row">
        <div class="col-lg col-xl">
            <table class="table table-striped" id="dataTablePemilih">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">NPSN</th>
                        <th scope="col">Email</th>
                        <th scope="col">Vote Method</th>
                        <th scope="col">Akreditasi File</th>
                        <th scope="col">Approval</th>
                    </tr>
                </thead>
                <?php $i = 1; ?>
                <tbody class="lazyLoadBody">
                    <?php foreach ($schools as $school) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $school['Name']; ?></td>
                            <td><?= $school['NPSN']; ?></td>
                            <td><?= $school['Email']; ?></td>
                            <td><?= $school['voteMethod']; ?></td>
                            <td><?= $school['akreditasi']; ?> <a class="download-button" href="#" data-download_id="<?= $school['akreditasi']; ?>"><i class="fas fa-fw fa-download"></i></a></td>
                            <?php if ($school['approve'] == 0) : ?>
                                <td><a href="<?= base_url('sekolah/approveSchool/') . $school['id'] . '/' . urlencode(base64_encode('accept')) ?>" class="btn btn-sm btn-primary approve-button">Approve</a> <a href="<?= base_url('sekolah/approveSchool/') . $school['id'] . '/' . urlencode(base64_encode('reject')) ?>" class="btn btn-sm btn-outline-primary">Reject</a></td>

                            <?php else : ?>
                                <td>Approved <i class="fas fa-fw fa-check"></i></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>