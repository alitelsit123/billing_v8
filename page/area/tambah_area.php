<?php if ($_SESSION['admin']) { ?>

  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          Tambah Area
        </div>
        <div class="panel-body">

          <?php
          if (isset($_POST['simpan'])) {
            $name = trim($_POST['name']);

            // Validasi input
            if (empty($name)) {
              echo "<div class='alert alert-danger'>Nama area tidak boleh kosong!</div>";
            } else {
              // Cek apakah nama area sudah ada
              $cek = $koneksi->query("SELECT * FROM tb_area WHERE name = '" . $koneksi->real_escape_string($name) . "'");

              if ($cek->num_rows > 0) {
                echo "<div class='alert alert-danger'>Nama area sudah ada!</div>";
              } else {
                $sql = $koneksi->query("INSERT INTO tb_area (name) VALUES ('" . $koneksi->real_escape_string($name) . "')");

                if ($sql) {
                  echo "
                    <script>
                        setTimeout(function() {
                            swal({
                                title: 'Data Area',
                                text: 'Berhasil Ditambahkan!',
                                type: 'success'
                            }, function() {
                                window.location = '?page=area';
                            });
                        }, 300);
                    </script>
                  ";
                } else {
                  echo "<div class='alert alert-danger'>Terjadi kesalahan saat menyimpan data!</div>";
                }
              }
            }
          }
          ?>

          <form method="post" action="">
            <div class="form-group">
              <label for="name">Nama Area <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama area" required>
            </div>

            <div class="form-group">
              <button type="submit" name="simpan" class="btn btn-success">
                <i class="fa fa-save"></i> Simpan
              </button>
              <a href="?page=area" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
              </a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

<?php } else {
  echo "Anda Tidak Berhak Mengakses Halaman Ini";
} ?>