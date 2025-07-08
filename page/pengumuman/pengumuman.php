<?php if ($_SESSION['admin']) { ?>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

  <?php

  $sql_token = "SELECT * FROM tbl_token WHERE id_token = 1"; // Sesuaikan dengan query yang sesuai
  $result = mysqli_query($koneksi, $sql_token);
  $row = mysqli_fetch_assoc($result);
  $authorizationToken = $row['token'];

  $sql_pelanggan = "SELECT no_telp FROM tb_pelanggan";
  $result = mysqli_query($koneksi, $sql_pelanggan);

  $sql_informasi = $koneksi->query("SELECT * FROM tbl_informasi");
  $informasi = $sql_informasi->fetch_assoc();

  ?>

  <div class="row">
    <!-- right column -->
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Papan Pengumuman Pelanggan</h3>
        </div>
        <div class="box-body">
          <p style="color: red;"><i>*Mengirim Pengumuman Ke Pelanggan Ketika Membuka Halaman Tagihan</i></p>
          <p style="color: red;"><i>*Setelah Bagikan Informasi Di Tekan, Harap Tunggu Sampai Ada Notif Berhasil</i>
          <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_informasi" value="<?= $informasi['id_informasi'] ?>">
            <div class="form-group">
              <label for="exampleInputEmail1">Judul Pengumuman</label>
              <input type="text" class="form-control" name="judul_informasi" placeholder="Contoh: Perubahan Tanggal Pembayaran" value="<?= $informasi['judul_informasi'] ?>">
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Isi Pengumuman</label>
              <textarea class="form-control" rows="10" name="isi_informasi" placeholder="Contoh: Perubahan Pembayaran Pada Tanggal 00-00-0000"><?= $informasi['isi_informasi'] ?></textarea>
            </div>

            <div class="box-footer">
              <button type="submit" name="simpan_informasi" class="btn btn-primary">Bagikan Informasi</button>
              <button type="submit" name="hapus_informasi" class="btn btn-primary">Hapus Informasi </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- left column -->
    <div class="col-md-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Pesan Siaran Whatsapp</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form method="POST" enctype="multipart/form-data">
          <div class="box-body">
            <p style="color: red;"><i>*Mengirim Pesan Siaran Ke Pelanggan Berdasarkan Filter yang Dipilih</i></p>
            <p style="color: red;"><i>*Setelah Kirim Pesan Di Tekan, Harap Tunggu Sampai Ada Notif Berhasil</i></p>

            <!-- Filter Section -->
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">Filter Penerima Pesan</h4>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Filter Area</label>
                      <select class="form-control select2" name="filter_area" style="width: 100%;">
                        <option value="">-- Semua Area --</option>
                        <?php
                        $areaQuery = $koneksi->query("SELECT DISTINCT tb_area.id, tb_area.name 
                                                                             FROM tb_area 
                                                                             INNER JOIN tb_user ON tb_user.area_id = tb_area.id 
                                                                             INNER JOIN tb_pelanggan ON tb_pelanggan.kasir_id = tb_user.id 
                                                                             ORDER BY tb_area.name ASC");
                        while ($areaData = $areaQuery->fetch_assoc()) {
                          echo "<option value='{$areaData['id']}'>{$areaData['name']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Filter Status Bayar</label>
                      <select class="form-control" name="filter_status_bayar">
                        <option value="">-- Semua Status --</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Blokir">Blokir</option>
                        <option value="Isolir">Isolir</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Filter Paket</label>
                      <select class="form-control select2" name="filter_paket" style="width: 100%;">
                        <option value="">-- Semua Paket --</option>
                        <?php
                        $paketQuery = $koneksi->query("SELECT DISTINCT tb_paket.id_paket, tb_paket.nama_paket 
                                                                              FROM tb_paket 
                                                                              INNER JOIN tb_pelanggan ON tb_pelanggan.paket = tb_paket.id_paket 
                                                                              ORDER BY tb_paket.nama_paket ASC");
                        while ($paketData = $paketQuery->fetch_assoc()) {
                          echo "<option value='{$paketData['id_paket']}'>{$paketData['nama_paket']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Filter ODP</label>
                      <select class="form-control select2" name="filter_odp" style="width: 100%;">
                        <option value="">-- Semua ODP --</option>
                        <?php
                        $odpQuery = $koneksi->query("SELECT DISTINCT odp FROM tb_pelanggan WHERE odp IS NOT NULL AND odp != '' ORDER BY odp ASC");
                        while ($odpData = $odpQuery->fetch_assoc()) {
                          echo "<option value='{$odpData['odp']}'>{$odpData['odp']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6" style="display: none;;">
                    <div class="form-group">
                      <label>Filter Jatuh Tempo</label>
                      <select class="form-control" name="filter_jatuh_tempo">
                        <option value="">-- Semua --</option>
                        <option value="akan_jatuh_tempo">Akan Jatuh Tempo (1-7 Hari)</option>
                        <option value="sudah_lewat">Sudah Lewat Jatuh Tempo</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>&nbsp;</label><br>
                      <button type="button" class="btn btn-info" id="previewPenerima">
                        <i class="fa fa-eye"></i> Preview Penerima
                      </button>
                    </div>
                  </div>
                </div>

                <div id="previewResults" style="display: none;">
                  <div class="alert alert-info">
                    <strong>Jumlah Penerima: </strong><span id="jumlahPenerima">0</span> pelanggan
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Judul Pesan</label>
              <input type="text" class="form-control" name="judul_siaran" placeholder="Contoh: Sedang Gangguan" required>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Isi Pesan</label>
              <textarea class="form-control" rows="10" name="isi_siaran" placeholder="Contoh: Mohon Maaf Sedang Terjadi Gangguan Koneksi Internet" required></textarea>
            </div>

          </div>
          <div class="box-footer">
            <button type="submit" name="simpan_pesan_siaran" class="btn btn-primary">Kirim Pesan</button>
          </div>
        </form>
      </div>
    </div>

  </div>


  <?php
  if (isset($_POST['hapus_informasi'])) {

    $id_informasi = $_POST['id_informasi'];
    if (!empty($id_informasi)) {
      $sql_informasi = $koneksi->query("DELETE FROM tbl_informasi WHERE id_informasi = $id_informasi");
      $message = "Berhasil Menghapus Informasi";
      if ($sql_informasi) {
  ?>
        <script>
          setTimeout(function() {
            swal({
              title: 'Berhasil',
              text: '<?php echo $message; ?>',
              type: 'success'
            }, function() {
              window.location = '?page=pengumuman';
            });
          }, 300);
        </script>
  <?php
      }
    }
  }
  ?>


  <?php
  if (isset($_POST['simpan_informasi'])) {

    $judul_informasi = $_POST['judul_informasi'];
    $isi_informasi = $_POST['isi_informasi'];

    if (!empty($judul_informasi) && !empty($isi_informasi)) {
      $cek_informasi = $koneksi->query("SELECT * FROM tbl_informasi");
      $row = $cek_informasi->fetch_assoc();

      if ($row) {
        // Jika data token sudah ada, lakukan UPDATE
        $informasi = $koneksi->query("UPDATE tbl_informasi SET judul_informasi='$judul_informasi', isi_informasi='$isi_informasi'");
        $message = 'Informasi Berhasil Di Update!';
      } else {
        // Jika data token belum ada, lakukan INSERT
        $informasi = $koneksi->query("INSERT INTO tbl_informasi (judul_informasi, isi_informasi) VALUES ('$judul_informasi', '$isi_informasi')");
        $message = 'Berhasil Menambah Informasi!';
      }

      if ($informasi) {
  ?>
        <script>
          setTimeout(function() {
            swal({
              title: 'Berhasil',
              text: '<?php echo $message; ?>',
              type: 'success'
            }, function() {
              window.location = '?page=pengumuman';
            });
          }, 300);
        </script>
  <?php
      }
    }
  }
  ?>


  <?php
  // Handle preview penerima request
  if (isset($_POST['preview_penerima'])) {
    $filter_area = $_POST['filter_area'];
    $filter_status_bayar = $_POST['filter_status_bayar'];
    $filter_paket = $_POST['filter_paket'];
    $filter_odp = $_POST['filter_odp'];
    $filter_jatuh_tempo = $_POST['filter_jatuh_tempo'];

    // Build query with filters
    $query = "SELECT COUNT(DISTINCT tb_pelanggan.id_pelanggan) as total 
                  FROM tb_pelanggan 
                  LEFT JOIN tb_user ON tb_user.id = tb_pelanggan.kasir_id 
                  LEFT JOIN tb_area ON tb_area.id = tb_user.area_id 
                  LEFT JOIN tb_paket ON tb_paket.id_paket = tb_pelanggan.paket 
                  LEFT JOIN tb_tagihan ON tb_tagihan.id_pelanggan = tb_pelanggan.id_pelanggan 
                  WHERE tb_pelanggan.no_telp IS NOT NULL AND tb_pelanggan.no_telp != ''";

    if (!empty($filter_area)) {
      $query .= " AND tb_user.area_id = '$filter_area'";
    }
    if (!empty($filter_status_bayar)) {
      $query .= " AND tb_pelanggan.status = '$filter_status_bayar'";
    }
    if (!empty($filter_paket)) {
      $query .= " AND tb_pelanggan.id_paket = '$filter_paket'";
    }
    if (!empty($filter_odp)) {
      $query .= " AND tb_pelanggan.odp = '$filter_odp'";
    }
    if (!empty($filter_jatuh_tempo)) {
      if ($filter_jatuh_tempo == 'akan_jatuh_tempo') {
        $query .= " AND tb_pelanggan.jatuh_tempo BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
      } elseif ($filter_jatuh_tempo == 'sudah_lewat') {
        $query .= " AND tb_pelanggan.jatuh_tempo < CURDATE()";
      }
    }

    $result = $koneksi->query($query);
    // if (!$result) {
    //   // Show SQL error
    //   die("Query failed: " . $koneksi->error . "<br>Query: " . $query);
    // }
    $row = $result->fetch_assoc();

    echo json_encode(['count' => $row['total']]);
    exit;
  }
  ?>

  <?php
  if (isset($_POST['simpan_pesan_siaran'])) {

    $judul_siaran = htmlspecialchars(strip_tags($_POST['judul_siaran']));
    $isi_siaran = htmlspecialchars(strip_tags($_POST['isi_siaran']));

    // Get filter values
    $filter_area = $_POST['filter_area'];
    $filter_status_bayar = $_POST['filter_status_bayar'];
    $filter_paket = $_POST['filter_paket'];
    $filter_odp = $_POST['filter_odp'];
    $filter_jatuh_tempo = $_POST['filter_jatuh_tempo'];

    $curl = curl_init();

    $headers = array(
      'Authorization: ' . $authorizationToken,
      'Content-Type: application/x-www-form-urlencoded',
    );

    // Build query with filters
    $query = "SELECT DISTINCT tb_pelanggan.no_telp 
                  FROM tb_pelanggan 
                  LEFT JOIN tb_user ON tb_user.id = tb_pelanggan.kasir_id 
                  LEFT JOIN tb_area ON tb_area.id = tb_user.area_id 
                  LEFT JOIN tb_paket ON tb_paket.id_paket = tb_pelanggan.paket 
                  LEFT JOIN tb_tagihan ON tb_tagihan.id_pelanggan = tb_pelanggan.id_pelanggan 
                  WHERE tb_pelanggan.no_telp IS NOT NULL AND tb_pelanggan.no_telp != ''";

    if (!empty($filter_area)) {
      $query .= " AND tb_user.area_id = '$filter_area'";
    }
    if (!empty($filter_status_bayar)) {
      $query .= " AND tb_pelanggan.status = '$filter_status_bayar'";
    }
    if (!empty($filter_paket)) {
      $query .= " AND tb_pelanggan.paket = '$filter_paket'";
    }
    if (!empty($filter_odp)) {
      $query .= " AND tb_pelanggan.odp = '$filter_odp'";
    }
    if (!empty($filter_jatuh_tempo)) {
      if ($filter_jatuh_tempo == 'akan_jatuh_tempo') {
        $query .= " AND tb_pelanggan.jatuh_tempo BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
      } elseif ($filter_jatuh_tempo == 'sudah_lewat') {
        $query .= " AND tb_pelanggan.jatuh_tempo < CURDATE()";
      }
    }

    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_assoc($result)) {
      $no_telp = $row['no_telp'];

      $data = array(
        'target' => $no_telp,
        'message' => "***" . $judul_siaran . "***" . "\n\n" . $isi_siaran,
        'delay' => 2,
        'countryCode' => '62',
      );

      $postFields = http_build_query($data);

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postFields, // Menggunakan URL-encoded data
        CURLOPT_HTTPHEADER => $headers,
      ));

      $response = curl_exec($curl);

      // Tunggu beberapa detik sebelum mengirim pesan berikutnya (opsional)
      sleep(2); // Misalnya, tunggu 2 detik antara pengiriman pesan
    }

    curl_close($curl);

    if (!empty($judul_siaran) && !empty($isi_siaran)) {
      $sql_pesan_siaran = $koneksi->query("INSERT INTO tbl_pesan_siaran (judul_pesan_siaran, isi_pesan) VALUES ('$judul_siaran', '$isi_siaran')");
      $message = 'Berhasil Mengirim Pesan Siaran';
      if ($sql_pesan_siaran) {
  ?>
        <script>
          setTimeout(function() {
            swal({
              title: 'Berhasil',
              text: '<?php echo $message; ?>',
              type: 'success'
            }, function() {
              window.location = '?page=pengumuman';
            });
          }, 300);
        </script>
<?php
      }
    }
  }
} else {
  echo "Anda Tidak Berhak Mengakses Halaman Ini";
}
?>

<script>
  $(document).ready(function() {
    // Initialize select2
    $('.select2').select2({
      placeholder: function() {
        return $(this).data('placeholder') || 'Pilih...';
      },
      allowClear: true
    });

    // Preview penerima functionality
    $('#previewPenerima').click(function() {
      var filterArea = $('select[name="filter_area"]').val();
      var filterStatusBayar = $('select[name="filter_status_bayar"]').val();
      var filterPaket = $('select[name="filter_paket"]').val();
      var filterOdp = $('select[name="filter_odp"]').val();
      var filterJatuhTempo = $('select[name="filter_jatuh_tempo"]').val();

      $.ajax({
        url: '?page=pengumuman&action=preview',
        type: 'POST',
        data: {
          filter_area: filterArea,
          filter_status_bayar: filterStatusBayar,
          filter_paket: filterPaket,
          filter_odp: filterOdp,
          filter_jatuh_tempo: filterJatuhTempo,
          preview_penerima: 1
        },
        success: function(response) {
          const matches = response.match(/\{"count[^}]*\}/g);
          var result = JSON.parse(matches[0]);
          $('#jumlahPenerima').text(result.count);
          $('#previewResults').show();
        },
        error: function() {
          alert('Terjadi kesalahan saat memuat preview');
        }
      });
    });
  });
</script>