<!-- Kandidat -->
<section class="kandidat-daftar">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h3>Calon Ketua & Wakil Ketua Osis</h3>
                <p>Pelajari <span>Visi</span> dan <span>Misi</span> Kandidat sebelum memilih!</p>
                <div class="divider2"></div>
            </div>

        </div>
        <div class="row kandidat-wrapper">
            <?php foreach ($kandidat as $k) : ?>
                <div class="col-sm col-md-4 col-lg-3 k-container">
                    <h4><?= $k['noKandidat']; ?></h4>
                    <div class="card">
                        <img src="<?= base_url('assets/'); ?>img/kandidat/<?= $k['img']; ?>" class="card-img-top img-fluid">
                        <div class="card-body">
                            <h5 class="card-title"><?= $k['Name']; ?></h5>
                            <p class="card-text"><span>Visi</span> : <?= $k['Visi']; ?></p>
                            <a href="<?= base_url('kandidat/detailKandidat/' . $k['slug']); ?>" class="kandidat-btn">Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>