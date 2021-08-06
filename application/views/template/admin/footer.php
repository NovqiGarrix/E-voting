<?php
$rowSQL = $this->db->query("SELECT MAX(jumlahSuara) AS jumlahSuara FROM `kandidat`;")->row_array();
$max = $rowSQL['jumlahSuara'];
$waktu_pemilu = $this->db->get('waktu_pemilu')->row_array();
?>

<script src="<?= base_url('assets/js/chart.min.js'); ?>"></script>
<!-- Bootstrap core JavaScript-->
<?php
$uri2 = $this->uri->segment(2, 0);
$uri1 = $this->uri->segment(1, 0);
?>
<?php if ($uri1 != 'admin' || $uri2) : ?>
  <script src="<?= base_url('assets/sbadmin2/'); ?>vendor/jquery/jquery.min.js"></script>
<?php endif; ?>
<script src="<?= base_url('assets/sbadmin2/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/sbadmin2/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/sbadmin2/'); ?>js/sb-admin-2.min.js"></script>


<!-- Urutan Pemilihan -->
<script>
  const eventClick = (event) => {
    switch (event.keyCode) {
      case 66:
        var sideBarToogle = document.getElementById('sidebarToggle');
        sideBarToogle.click();
        break;

      default:
        break;
    }
  }

  document.addEventListener('keydown', eventClick);

  $.ajax({
    url: "<?= base_url('Data_User/triggerFirstModal'); ?>",
    type: "POST",
    dataType: "JSON",
    data: {
      id: 'VqiiRixx',
    },
    success: (data) => {
      data == 'Show' && (showFirstModal());
    }
  });

  const showFirstModal = async () => {
    await $('#urutanPemilihanModal').modal('show');
  }
</script>

<!-- Datatable, Classic Editor, dan Form Validation -->
<script>
  if ($('#dataTablePemilih')) {
    $('#dataTablePemilih').DataTable();
  }

  ClassicEditor.create(document.querySelector('#editor_misi')).catch(error => {

  })

  $('#nisn').on('keyup', function() {
    $('#error_nisn').html('');
    const nisn = $(this).val();
    if (nisn == '') {
      $('#error_nisn').append('NISN harus diisi').fadeIn(400);

    } else
    if (isNaN(nisn) || nisn.length > 10 || nisn.length < 10) {
      $('#error_nisn').append('! Invalid NISN').fadeIn(400);
    } else {
      $('#error_nisn').fadeOut(400);
      return true;
    }
  })

  $('#nama').on('keyup', function() {
    $('#nama').html('');
    const nama = $(this).val();
    if (nama == '') {
      $('#error_nama').append('Nama tidak boleh kososng').fadeIn(500);
      return false;
    } else {
      $('#error_nama').fadeOut(400);
      return true;
    }
  })
</script>

<!-- Waktu Pemilu dan Copy to Clipboard -->
<script type="text/javascript">
  $('#form-waktu-pemilu').on('submit', function(e) {
    e.preventDefault();
    $('#waktu-pemilihModal').modal('hide');
    const time_pemilu = $('.form-group>input').val();
    const int_waktu = new Date(time_pemilu).getTime() / 1000;

    $.ajax({
      url: "<?= base_url('admin/updateTime') ?>",
      type: "post",
      data: {
        time_pemilu: time_pemilu,
        int_waktu_pemilu: int_waktu
      },
      success: function() {
        document.location.href = "<?= base_url('admin'); ?>"
      }
    })
  });

  // Copy to Clipboard
  $('.copyClipboardModal').on('click', () => {
    var inputLink = $('.copyClipboadInput');
    var inputTextLink = $('.copyClipboadInput').val();

    inputLink.select();

    try {
      document.execCommand('copy');
      $('.copyClipboadButton').html('Disalin');
      $('#shareLinkToast').toast('show');
      $('#shareLinkButton').modal('hide');

    } catch (error) {
      console.log(error)
    }
  })

  $('.download-button').on('click', function() {
    const downloadId = $(this).data('download_id');

    document.location.href = "<?= base_url('sekolah/downloadAkreditasi?') . 'acc=' ?>" + downloadId;
  });
</script>

<!-- Custom-file-input and Submenu Active -->
<script>
  $('.custom-file-input').on('change', function() {
    let filename = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass('selected').html(filename);
  });

  $('.check-input-role').on('click', function() {
    const menuId = $(this).data('menu_id');
    const roleId = $(this).data('role_id');

    $.ajax({
      url: "<?= base_url('dashboard/changeAccess'); ?>",
      type: "post",
      data: {
        menuId: menuId,
        roleId: roleId
      },
      success: function() {
        document.location.href = "<?= base_url('dashboard/accessRole/'); ?>" + roleId;
      }
    });
  });

  $('.form-check-input').on('click', function() {
    const slug = $(this).data('slug');
    const aktif = $(this).data('is_active');

    $.ajax({
      url: "<?= base_url('menu/is_activeSubmenu'); ?>",
      type: 'post',
      data: {
        slug: slug,
        aktif: aktif
      },
      success: function() {
        document.location.href = "<?= base_url('menu/submenu'); ?>"
      }
    });
  });
</script>

<!-- Waktu Pemilu -->
<script type="text/javascript">
  const pemilu = "<?= $waktu_pemilu['Waktu']; ?>";

  function waktu_special() {
    const waktu_pemilihan = new Date(pemilu);
    const currentDate = new Date();
    const selisih = (waktu_pemilihan - currentDate) / 1000;

    const day = Math.floor(selisih / 3600 / 24);
    const hour = Math.floor(selisih / 3600 % 24);
    const menit = Math.floor(selisih / 60) % 60;
    const detik = Math.floor(selisih % 60);

    $('.days>h1').html(day);
    $('.hours>h1').html(hour);
    $('.minutes>h1').html(formatTime(menit));
    $('.seconds>h1').html(formatTime(detik));
  }

  function formatTime(time) {
    return time < 10 ? (`0${time}`) : time;
  }

  const waktu_pemilihan = new Date(pemilu);
  const currentDate = new Date();
  const selisih = (waktu_pemilihan - currentDate) / 1000;

  if (selisih > 1) {
    waktu_special();
    setInterval(waktu_special, 1000);
    $('.days>.span-1').hide();
  } else {
    $.ajax({
      url: "<?= base_url('admin/handleVotingDone') ?>",
      type: 'post',
      data: {
        id: 'VqiiRixx'
      },
      success: () => {
        console.log();
      }

    });

    $('.days>h1').html('Pemilihan sudah berakhir').css({
      'font-size': '2rem'
    });

    $('.days>.span-2').hide()
    $('.hours').hide();
    $('.minutes').hide();
    $('.seconds').hide();
  }
</script>

<!-- Realtime Notifications -->
<script>
  getPusher();
  setInterval(getPusher, 5000);


  function getPusher() {
    $.ajax({
      url: "<?= base_url('admin/getNumList'); ?>",
      type: 'POST',
      dataType: 'json',
      data: {
        id: "garrixHere"
      },
      success: function(data) {

        // Badge nya
        $('.badge-counter').html(data)

        loadList();
      }
    });
  }

  function loadList() {
    $.ajax({
      url: "<?= base_url('admin/getLoadList') ?>",
      type: "POST",
      dataType: "JSON",
      data: {
        id: "garrixHere"
      },
      success: (data) => {
        const suaraMasuk = data;

        const parentList = $('.list-badge-notifikasi');
        parentList.html('');

        $.each(suaraMasuk, (i, data) => {
          const time = new Date(data.dateCreated);

          let listHtml = `
          <a class="dropdown-item d-flex align-items-center" href="#">
              <div class="mr-3">
                  <div class="icon-circle bg-primary">
                      <i class="fas fa-fw fa-vote-yea text-white"></i>
                  </div>
              </div>
              <div>
                  <div class="small text-gray-500">${time}</div>
                  <span class="font-weight-bold">${data.message}</span>
              </div>
          </a>`;
          parentList.append(listHtml);
        });

      }
    });
  }
</script>


</body>

</html>