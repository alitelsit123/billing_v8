<?php

$id = $_GET['id'];
$sk = $_GET['username'];

$sql = $koneksi->query("select * from tb_user where id='$id'");

$data = $sql->fetch_assoc();

?>

<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Ubah Data Pengguna</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo $data['username'] ?>">
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="text" class="form-control" name="password" value="<?php echo $data['password'] ?>">
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Nama</label>
            <input type="text" class="form-control" name="nama" value="<?php echo $data['nama_user'] ?>">
          </div>

          <div class="form-group">

            <label>Level :</label> <br>
            <select class="form-control" name="level" id="level" onchange="toggleAreaField()">

              <option value="admin" <?php if ($data['level'] == 'admin') {
                                      echo "selected";
                                    } ?>>Admin</option>
              <option value="teknisi" <?php if ($data['level'] == 'teknisi') {
                                        echo "selected";
                                      } ?>>teknisi</option>
              <option value="kasir" <?php if ($data['level'] == 'kasir') {
                                      echo "selected";
                                    } ?>>Kasir</option>
              <option value="user" <?php if ($data['level'] == 'user') {
                                      echo "selected";
                                    } ?>>user</option>
            </select>
          </div>

          <div class="form-group" id="areaField" style="<?php echo ($data['level'] == 'kasir') ? '' : 'display: none;'; ?>">
            <label>Area:</label>
            <select class="form-control select2" name="area_id" style="width: 100%;">
              <option value="">-- Pilih Area --</option>
              <?php
              $areaQuery = $koneksi->query("SELECT * FROM tb_area ORDER BY name ASC");
              while ($areaData = $areaQuery->fetch_assoc()) {
                $selected = ($areaData['id'] == $data['area_id']) ? 'selected' : '';
                echo "<option value='{$areaData['id']}' $selected>{$areaData['name']}</option>";
              }
              ?>
            </select>
          </div>

          <?php if (empty($data['id_pelanggan'])) { ?>
            <div class="form-group">
              <label for="additionalField">Nomor Telepon</label>
              <input type="number" class="form-control" name="additionalField" value="<?= $data['phone_number'] ?>" required>
            </div>
          <?php } ?>

          <div class="form-group">
            <label for="exampleInputPassword1">Foto</label>
            <label><img src="images/<?php echo $data['foto'] ?>" widht="100" height="100" alt=""></label>
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Ganti Foto</label>
            <input type="file" name="foto">
          </div>

          <div class="box-footer">
            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
          </div>
      </form>
    </div>

    <script>
      function toggleAreaField() {
        var level = document.getElementById('level').value;
        var areaField = document.getElementById('areaField');

        if (level === 'kasir') {
          areaField.style.display = 'block';
          // Initialize select2 when showing the field
          $('select[name="area_id"]').select2({
            placeholder: '-- Pilih Area --',
            allowClear: true
          });
        } else {
          areaField.style.display = 'none';
          // Reset area selection when not kasir
          $('select[name="area_id"]').val('').trigger('change');
        }
      }

      // Initialize select2 on page load if kasir is selected
      $(document).ready(function() {
        if ($('#level').val() === 'kasir') {
          $('select[name="area_id"]').select2({
            placeholder: '-- Pilih Area --',
            allowClear: true
          });
        }
      });
    </script>

    <?php

    if (isset($_POST['simpan'])) {

      $username = htmlspecialchars($_POST['username']);
      $nama = htmlspecialchars($_POST['nama']);
      $password = htmlspecialchars($_POST['password']);
      $level = htmlspecialchars($_POST['level']);
      $area_id = ($level == 'kasir' && !empty($_POST['area_id'])) ? $_POST['area_id'] : NULL;
      $noHP = $_POST['additionalField'] ?? NULL;
      $foto = $_FILES['foto']['name'];
      $lokasi = $_FILES['foto']['tmp_name'];

      $conPelanggan = $koneksi->query("SELECT * FROM tbl_penggunamikrotik");
      $checkUser = $conPelanggan->fetch_assoc();

      if ($checkUser['status'] == 'ya') {

        $sql_mikrotik = "SELECT * FROM tbl_mikrotik WHERE id_mikrotik = 1";
        $result = mysqli_query($koneksi, $sql_mikrotik);
        $row = mysqli_fetch_assoc($result);

        $API = new RouterosAPI();

        if ($API->connect($row['ip'], $row['username'], $row['password'])) {

          $getPPPId = $API->comm("/ppp/secret/print", array(
            "?name" => $sk,
          ));

          if (!empty($getPPPId)) {
            $pppId = $getPPPId[0]['.id'];

            // Mengubah profil PPP Secret berdasarkan ID
            $API->comm("/ppp/secret/set", array(
              ".id" => $pppId,
              "name" => $username,
              "password" => $password,
            ));
          } else {
            echo "PPP Secret dengan nama pengguna $nama tidak ditemukan.";
          }
        }
      }

      if (!empty($lokasi)) {
        move_uploaded_file($lokasi, "images/" . $foto);
        $sql = $koneksi->query("update tb_user set username='$username', password='$password', nama_user='$nama',  foto='$foto', level='$level', phone_number='$noHP', area_id=" . ($area_id ? "'$area_id'" : "NULL") . " where id='$id'");

        if ($sql) {
    ?>

          <script>
            setTimeout(function() {
              swal({
                title: 'Data Pengguna',
                text: 'Berhasil Diubah!',
                type: 'success'
              }, function() {
                window.location = '?page=pengguna';
              });
            }, 300);
          </script>

        <?php
        }
      } else {
        $sql = $koneksi->query("update  tb_user set username='$username', password='$password', nama_user='$nama', level='$level', phone_number='$noHP', area_id=" . ($area_id ? "'$area_id'" : "NULL") . " where id='$id'");

        if ($sql) {
        ?>

          <script>
            setTimeout(function() {
              swal({
                title: 'Data Pengguna',
                text: 'Berhasil Diubah!',
                type: 'success'
              }, function() {
                window.location = '?page=pengguna';
              });
            }, 300);
          </script>


    <?php
        }
      }
    }


    ?>