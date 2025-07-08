<?php if ($_SESSION['admin']) { ?>

  <div class="row">
    <div class="col-md-12">
      <!-- Advanced Tables -->
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          Data Area
        </div>
        <div class="panel-body">
          <a href="?page=area&aksi=tambah_area" type="button" class="btn btn-info" style="margin-bottom: 10px;">
            <i class="fa fa-plus"></i> Tambah Area
          </a>

          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="example1">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Nama Area</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $no = 1;
                $sql = $koneksi->query("SELECT * FROM tb_area ORDER BY id DESC");

                while ($data = $sql->fetch_assoc()) {
                ?>
                  <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($data['name']); ?></td>
                    <td class="text-center">
                      <a href="?page=area&aksi=ubah_area&id=<?= $data['id']; ?>" type="button" class="btn btn-info btn-sm">
                        <i class="fa fa-edit"></i> Ubah
                      </a>
                      <a href="?page=area&aksi=hapus&id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus area ini?')">
                        <i class="fa fa-trash"></i> Hapus
                      </a>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php } else {
  echo "Anda Tidak Berhak Mengakses Halaman Ini";
} ?>