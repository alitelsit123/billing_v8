<?php if ($_SESSION['admin']) { ?>
  <section class="content">
    <div class="row">
      <div class="box box-primary box-solid">
        <div class="box-header">
          <h3 class="box-title">Data Pengguna</h3>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
          <a href="?page=pengguna&aksi=tambah" class="btn btn-info" style="margin-bottom: 10px;" title="">Tambah</a>

          <!-- Filter Section -->
          <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-3">
              <div class="form-group">
                <label>Filter Level:</label>
                <select class="form-control" id="filterLevel" onchange="filterTable()">
                  <option value="">-- Semua Level --</option>
                  <option value="admin">Admin</option>
                  <option value="kasir">Kasir</option>
                  <option value="user">User</option>
                  <option value="teknisi">Teknisi</option>
                </select>
              </div>
            </div>
          </div>

          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Username</th>
                  <th class="text-center">Nama</th>
                  <th class="text-center">Password</th>
                  <th class="text-center">Level</th>
                  <th class="text-center">Foto</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>

                <?php

                $no = 1;

                $sql = $koneksi->query("select * from tb_user");

                while ($data = $sql->fetch_assoc()) {


                ?>


                  <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <td class="text-center">
                      <?php echo $data['username']; ?>
                      <?php if ($data['level'] == 'kasir' && !empty($data['area_id'])) {
                        $areaQ = $koneksi->query("SELECT name FROM tb_area WHERE id = '" . $data['area_id'] . "'");
                        $areaN = $areaQ ? $areaQ->fetch_assoc() : null;
                        if ($areaN && $areaN['name']) {
                          echo '<br><small style="color:#007bff">(' . htmlspecialchars($areaN['name']) . ')</small>';
                        }
                      } ?>
                    </td>
                    <td class="text-center"><?php echo $data['nama_user'] ?></td>
                    <td class="text-center"><?php echo $data['password'] ?></td>
                    <td class="text-center"><?php echo $data['level'] ?></td>
                    <td class="text-center"><img src="images/<?php echo $data['foto'] ?>" widht="75" height="75" alt=""></td>
                    <td class="text-center">
                      <a href="?page=pengguna&aksi=ubah&id=<?php echo $data['id']; ?>&username=<?= $data['username'] ?>" class="btn btn-success" title=""><i class="fa fa-edit"></i> Ubah</a>
                      <a href="?page=pengguna&aksi=hapus&id=<?php echo $data['id']; ?>" class="btn btn-danger" title=""><i class="fa fa-trash"></i> Hapus</a>
                    </td>
                  </tr>


                <?php } ?>

              </tbody>

            </table>

          </div>
        </div>
      </div>
  </section>

  <script>
    function filterTable() {
      var filter = document.getElementById("filterLevel").value.toLowerCase();
      var table = document.getElementById("example1");
      var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

      for (var i = 0; i < rows.length; i++) {
        var levelCell = rows[i].getElementsByTagName("td")[4]; // Level column is at index 4
        if (levelCell) {
          var levelText = levelCell.textContent || levelCell.innerText;
          if (filter === "" || levelText.toLowerCase().indexOf(filter) > -1) {
            rows[i].style.display = "";
          } else {
            rows[i].style.display = "none";
          }
        }
      }
    }

    // Keep track of current filter when DataTable redraws
    $(document).ready(function() {
      var table = $('#example1').DataTable();

      $('#filterLevel').on('change', function() {
        var filterValue = this.value;
        if (filterValue === '') {
          table.column(4).search('').draw(); // Clear search on level column
        } else {
          table.column(4).search('^' + filterValue + '$', true, false).draw(); // Exact match search
        }
      });
    });
  </script>

<?php } else {
  echo "Anda Tidak Berhak Mengakses Halaman Ini";
} ?>