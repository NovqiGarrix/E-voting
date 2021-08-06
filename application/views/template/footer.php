<footer class="footer">
    <h2>E-Voting&copy;</h2>
    <div class="social">
        <a href="https://www.facebook.com/novrianto23" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
        <a href="https://www.instagram.com/novqigarrix" target="_blank"><i class="fa fa-instagram fa-lg"></i></a>
        <a href=""><i class="fa fa-youtube fa-lg"></i></a>
    </div>

    <div class="bottom">
        <p>Copyright &copy; <?= date('Y'); ?> | E-Voting</p>
    </div>
</footer>

<?php
$pemilu = $this->db->get('waktu_pemilu')->row_array();
?>



<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
</script>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/d5c1b56994.js" crossorigin="anonymous"></script>



<!-- My Script -->
<script src="<?= base_url() ?>assets/js/script.js"></script>
<script>
    $('.votingButton').on('click', function() {
        const namaKandidat = $(this).data('kandidat');
        const slug = $(this).data('slug');

        $.ajax({
            url: "<?= base_url('kandidat/get_vote'); ?>",
            type: 'post',
            data: {
                kandidat: namaKandidat,
                slug: slug,
            },
            success: function() {
                document.location.href = "<?= base_url('count'); ?>";
            }
        });

        $(this).fadeOut(200);
    });


    // Waktu Pemilihan
    const pemilu = "<?= $pemilu['Waktu'] ?>";
    const time_pemilu = new Date(pemilu)
    const currentDate = new Date();
    const selisih = (time_pemilu - currentDate) / 1000;

    function timerCountdown() {
        const time_pemilu = new Date(pemilu)
        const currentDate = new Date();
        const selisih = (time_pemilu - currentDate) / 1000;

        const day = Math.floor(selisih / 3600 / 24);
        const hour = Math.floor(selisih / 3600 % 24);
        const menit = Math.floor(selisih / 60 % 60);
        const detik = Math.floor(selisih % 60);

        $('.days>h1').html(day);
        $('.hours>h1').html(hour);
        $('.minutes>h1').html(menit);
        $('.seconds>h1').html(detik);
    }

    if (selisih > 0) {
        timerCountdown();
        setInterval(timerCountdown, 1000)
    } else {
        $('.waktu-pemilihan').hide();
    }

    function quickCount() {
        $.ajax({
            url: "<?= base_url('count/quickCount') ?>",
            type: 'POST',
            data: {
                id: 'id'
            },
            dataType: 'JSON',
            success: function(data) {
                $('.quick-count-voting').html('');

                $.each(data, function(i, data) {
                    let html = '<div class="col-xl-4 col-md-7 mb-4"><div class="card border-left-primary shadow"><div class="card-body"><div class="row align-items-center voting-text"><div class="col-8 mr-2"><p style="font-size: 12px;" class="text-primary mb-1">' + data.Name + '</p><h4 class="dataSuara">' + data.jumlahSuara + ' Suara</h4></div><div class="col-auto voting-icon"><i class="fas fa-fw fa-user-friends fa-3x text-gray-300"></i></div></div></div></div></div>';

                    $('.quick-count-voting').append(html);
                })
            }
        })
    }

    setInterval(quickCount, 3000);

    quickCount();
</script>

</body>

</html>