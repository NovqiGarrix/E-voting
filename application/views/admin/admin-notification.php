<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
  </div>

  <div class="row">
    <div class="col-lg-auto">
      <p><span class="text-warning">Jumlah Suara Masuk : </span><?= $jumlahSuaraMasuk; ?></p>
    </div>
  </div>

  <div class="row">
    <div class="col-lg col-xl">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Waktu</th>
            <th scope="col">Pesan</th>
          </tr>
        </thead>
        <?php $i = 1; ?>
        <tbody>
          <?php foreach ($suaraMasuk as $sm) : ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><?= date('d F Y | H:i:s', strtotime($sm['dateCreated'])); ?></td>
              <td><?= $sm['message']; ?> </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php if (empty($suaraMasuk)) : ?>
        <div class="alert alert-danger" role="alert">Belum ada suara masuk</div>
      <?php endif; ?>
    </div>
  </div>
</div>

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