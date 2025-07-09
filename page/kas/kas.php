<?php if ($_SESSION['admin']) { ?>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <div class="row">
    <div class="col-md-12">
      <!-- Advanced Tables -->
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          Data Kas Masuk dan Keluar
        </div>
        <div class="panel-body">
          <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-4">
              <label>Filter Type:</label>
              <select class="form-control" id="filterType">
                <option value="">-- Semua --</option>
                <option value="pendapatan">Pendapatan</option>
                <option value="pengeluaran">Pengeluaran</option>
              </select>
            </div>
            <div class="col-md-4">
              <label>Filter Area:</label>
              <select class="form-control select2" id="filterArea" style="width: 100%;">
                <option value="">-- Semua Area --</option>
                <?php
                $areaQuery = $koneksi->query("SELECT * FROM tb_area ORDER BY name ASC");
                while ($areaData = $areaQuery->fetch_assoc()) {
                  echo "<option value='{$areaData['id']}'>{$areaData['name']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-4">
              <label>Filter Kasir:</label>
              <select class="form-control select2" id="filterKasir" style="width: 100%;">
                <option value="">-- Semua Kasir --</option>
                <?php
                $kasirQuery = $koneksi->query("SELECT DISTINCT tb_user.id, tb_user.nama_user, tb_area.name as area_name 
                                              FROM tb_user 
                                              LEFT JOIN tb_area ON tb_area.id = tb_user.area_id 
                                              WHERE tb_user.level = 'kasir' 
                                              ORDER BY tb_user.nama_user ASC");
                while ($kasirData = $kasirQuery->fetch_assoc()) {
                  $displayName = $kasirData['nama_user'] . ($kasirData['area_name'] ? ' - ' . $kasirData['area_name'] : '');
                  echo "<option value='{$kasirData['id']}'>{$displayName}</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <!-- Second row for date filters -->
          <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-4">
              <label>Filter Tanggal:</label>
              <input type="date" class="form-control" id="filterTanggal" placeholder="Pilih Tanggal">
            </div>
            <div class="col-md-4">
              <label>Filter Bulan:</label>
              <select class="form-control" id="filterBulan">
                <option value="">-- Semua Bulan --</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
            </div>
            <div class="col-md-4">
              <label>Filter Tahun:</label>
              <select class="form-control" id="filterTahun">
                <option value="">-- Semua Tahun --</option>
                <?php
                $currentYear = date('Y');
                for ($year = $currentYear; $year >= ($currentYear - 5); $year--) {
                  echo "<option value='$year'>$year</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-12">
              <label>Filter Rentang Tanggal:</label>
              <div class="input-group">
                <input type="date" class="form-control" id="filterTanggalDari" placeholder="Dari">
                <span class="input-group-addon">s/d</span>
                <input type="date" class="form-control" id="filterTanggalSampai" placeholder="Sampai">
              </div>
            </div>
            <div class="col-md-2">
              <label>&nbsp;</label><br>
              <button type="button" class="btn btn-primary" id="applyFilter">
                <i class="fa fa-filter"></i> Filter
              </button>
              <button type="button" class="btn btn-default" id="resetFilter">
                <i class="fa fa-refresh"></i> Reset
              </button>
            </div>
          </div>

          <button type="button" class="btn btn-info" style="margin-bottom: 10px;" data-toggle="modal" data-target="#modal-default">
            <i class="fa fa-plus"></i> Tambah
          </button>
          <button type="button" class="btn btn-success" style="margin-bottom: 10px;" data-toggle="modal" data-target="#modal-export">
            <i class="fa fa-download"></i> Export
          </button>
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="example1">


              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Kasir</th>
                  <th>Area</th>
                  <th>Keterangan</th>
                  <th>Kas Masuk</th>
                  <th>Kas Keluar</th>
                  <th>Ubah</th>
                  <th>Hapus</th>
                </tr>
              </thead>
              <tbody>

                <?php

                $no = 1;

                $sql = $koneksi->query("SELECT tb_kas.*, 
                                              tb_tagihan.id_pelanggan,
                                              tb_pelanggan.kasir_id,
                                              tb_user.nama_user as kasir_nama,
                                              tb_area.name as area_name 
                                       FROM tb_kas 
                                       LEFT JOIN tb_tagihan ON tb_tagihan.id_tagihan = tb_kas.id_tagihan
                                       LEFT JOIN tb_pelanggan ON tb_pelanggan.id_pelanggan = tb_tagihan.id_pelanggan
                                       LEFT JOIN tb_user ON tb_user.id = tb_pelanggan.kasir_id
                                       LEFT JOIN tb_area ON tb_area.id = tb_user.area_id 
                                       ORDER BY tb_kas.id_kas DESC");

                while ($data = $sql->fetch_assoc()) {

                  $status = $data['status'];

                  $t_masuk = $data['penerimaan'];
                  $t_Keluar = $data['pengeluaran'];

                  $total_masuk = $total_masuk + $t_masuk;
                  $total_keluar = $total_keluar + $t_Keluar;
                  $saldo = $total_masuk - $total_keluar;


                ?>


                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo tglIndonesia2(date('d F Y', strtotime($data['tgl_kas']))) ?></td>
                    <td><?php echo $data['kasir_nama'] ?: '-' ?></td>
                    <td><?php echo $data['area_name'] ?: '-' ?></td>
                    <td><?php echo $data['keterangan'] ?></td>
                    <td align="right"><?php echo number_format($data['penerimaan'], 0, ",", ".") ?></td>
                    <td align="right"><?php echo number_format($data['pengeluaran'], 0, ",", ".") ?></td>

                    <?php if ($status == "1") { ?>
                      <td>

                        <a href="#" type="button" class="btn btn-info" data-toggle="modal" data-target="#mymodal<?php echo $data['id_kas']; ?>"><i class="fa fa-edit"></i> Ubah</a>

                      </td>

                      <td>
                        <form method="POST">

                          <input type="hidden" name="id_kas" value="<?php echo $data['id_kas']; ?>">

                          <button type="submit" name="hapus" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>

                        </form>
                      </td>

                    <?php } else { ?>

                      <td>

                        <a href="#" disabled="" class="btn btn-info"><i class="fa fa-edit"></i> Ubah</a>

                      </td>

                      <td>
                        <a href="#" disabled="" class="btn btn-danger"><i class="fa fa-danger"></i> Hapus</a>
                      </td>

                    <?php } ?>

                  </tr>

                  <div class="modal fade" id="mymodal<?php echo $data['id_kas']; ?>">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="box box-primary box-solid">
                          <div class="box-header with-border">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                            Ubah Data Kas
                          </div>
                          <div class="modal-body">

                            <form role="form" method="POST">
                              <?php

                              $id_kas = $data['id_kas'];

                              $sql1 = $koneksi->query("select * from tb_kas where id_kas='$id_kas'");

                              while ($data1 = $sql1->fetch_assoc()) {

                              ?>

                                <input type="hidden" name="id_kas" value="<?php echo $data1['id_kas']; ?>">
                                <div class="form-group">
                                  <label>Tanggal</label>
                                  <input required="" type="date" name="tgl_kas" class="form-control" value="<?php echo $data1['tgl_kas']; ?>">
                                </div>

                                <div class="form-group">
                                  <label>Keterangan</label>
                                  <input required="" type="text" name="keterangan" class="form-control" value="<?php echo $data1['keterangan']; ?>">
                                </div>

                                <div class="form-group">
                                  <label>Pamasukan</label>
                                  <input required="" type="text" autocomplete="off" name="penerimaan" class="form-control uang" value="<?php echo $data1['penerimaan']; ?>">
                                </div>

                                <div class="form-group">
                                  <label>Pengeluaran</label>
                                  <input required="" type="text" autocomplete="off" name="pengeluaran" class="form-control uang" value="<?php echo $data1['pengeluaran']; ?>">
                                </div>

                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>

                          </div>

                        <?php } ?>

                        </form>

                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>


                  <?php } ?>

                  <?php



                  if (isset($_POST['simpan'])) {
                    $id_kas_ubah = $_POST['id_kas'];
                    $tgl_kas = $_POST['tgl_kas'];
                    $keterangan = htmlspecialchars(strip_tags($_POST['keterangan']));
                    $penerimaan = htmlspecialchars(strip_tags($_POST['penerimaan']));
                    $pengeluaran = htmlspecialchars(strip_tags($_POST['pengeluaran']));

                    $penerimaan_oke = str_replace(".", "", $penerimaan);
                    $pengeluaran_oke = str_replace(".", "", $pengeluaran);

                    $sql = $koneksi->query("UPDATE tb_kas SET keterangan='$keterangan', tgl_kas='$tgl_kas', pengeluaran='$pengeluaran_oke', penerimaan='$penerimaan_oke' WHERE id_kas='$id_kas_ubah'");



                    if ($sql) {
                      echo "

                        <script>
                            setTimeout(function() {
                                swal({
                                    title: 'Data Kas',
                                    text: 'Berhasil Diubah!',
                                    type: 'success'
                                }, function() {
                                    window.location = '?page=kas';
                                });
                            }, 300);
                        </script>

                    ";
                    }
                  }

                  ?>

              </tbody>

              <tr>
                <td colspan="5" style="text-align: center; font-weight: bold; font-size: 16px">Total</td>
                <td align="right"><?php echo ($total_masuk !== null) ? number_format($total_masuk, 0, ",", ".") : '0'; ?></td>
                <td align="right"><?php echo ($total_keluar !== null) ? number_format($total_keluar, 0, ",", ".") : '0'; ?></td>
                <td colspan="2" align="center"></td>
              </tr>

              <tr>
                <td colspan="5" style="text-align: center; font-weight: bold; font-size: 16px">Saldo</td>
                <td colspan="2" align="center"><?php echo ($saldo !== null) ? number_format($saldo, 0, ",", ".") : '0'; ?></td>
                <td colspan="2" align="center"></td>
              </tr>


            </table>

          </div>
        </div>
      </div>


      <!-- AWAL MODAL EXPORT -->
      <div class="modal fade" id="modal-export">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="box box-success box-solid">
              <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                Export Data Kas
              </div>
              <div class="modal-body">
                <form role="form" method="POST" action="/page/kas/export.php" target="_blank" id="exportForm">
                  <input type="hidden" name="export_data" value="1">
                  <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" name="export_type" required>
                      <option value="semua" selected>Semua</option>
                      <option value="pendapatan">Pendapatan</option>
                      <option value="pengeluaran">Pengeluaran</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Area</label>
                    <select class="form-control select2" name="export_area" style="width: 100%;">
                      <option value="">-- Semua Area --</option>
                      <?php
                      $areaQuery = $koneksi->query("SELECT * FROM tb_area ORDER BY name ASC");
                      while ($areaData = $areaQuery->fetch_assoc()) {
                        echo "<option value='{$areaData['id']}'>{$areaData['name']}</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Kasir</label>
                    <select class="form-control select2" name="export_kasir" style="width: 100%;">
                      <option value="">-- Semua Kasir --</option>
                      <?php
                      $kasirQuery = $koneksi->query("SELECT DISTINCT tb_user.id, tb_user.nama_user, tb_area.name as area_name 
                                                    FROM tb_user 
                                                    LEFT JOIN tb_area ON tb_area.id = tb_user.area_id 
                                                    WHERE tb_user.level = 'kasir' 
                                                    ORDER BY tb_user.nama_user ASC");
                      while ($kasirData = $kasirQuery->fetch_assoc()) {
                        $displayName = $kasirData['nama_user'] . ($kasirData['area_name'] ? ' - ' . $kasirData['area_name'] : '');
                        echo "<option value='{$kasirData['id']}'>{$displayName}</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Bulan</label>
                        <select class="form-control" name="export_month">
                          <option value="">-- Semua Bulan --</option>
                          <option value="01">Januari</option>
                          <option value="02">Februari</option>
                          <option value="03">Maret</option>
                          <option value="04">April</option>
                          <option value="05">Mei</option>
                          <option value="06">Juni</option>
                          <option value="07">Juli</option>
                          <option value="08">Agustus</option>
                          <option value="09">September</option>
                          <option value="10">Oktober</option>
                          <option value="11">November</option>
                          <option value="12">Desember</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Tahun</label>
                        <select class="form-control" name="export_year">
                          <option value="">-- Semua Tahun --</option>
                          <?php
                          $currentYear = date('Y');
                          for ($year = $currentYear; $year >= ($currentYear - 5); $year--) {
                            echo "<option value='$year'>$year</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Tanggal Spesifik</label>
                        <input type="date" class="form-control" name="export_date" placeholder="Pilih Tanggal">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>&nbsp;</label><br>
                        <small class="text-muted">Kosongkan untuk semua tanggal</small>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Tanggal Dari</label>
                        <input type="date" class="form-control" name="export_date_from" placeholder="Dari Tanggal">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Tanggal Sampai</label>
                        <input type="date" class="form-control" name="export_date_to" placeholder="Sampai Tanggal">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Format</label>
                    <select class="form-control" name="export_format" required>
                      <option value="">-- Pilih Format --</option>
                      <option value="csv">CSV</option>
                      <option value="xlsx">Excel (XLSX)</option>
                    </select>
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="downloadBtn">
                      <i class="fa fa-download"></i> Export
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- AKHIR MODAL EXPORT -->

      <!-- AWAL TAMBAH DATA TAHUN AJARAN -->

      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                Tambah Kas
              </div>

              <?php $tgl = date('Y-m-d'); ?>

              <div class="modal-body">
                <form role="form" method="POST">
                  <div class="form-group">
                    <label>Tanggal</label>
                    <input required="" type="date" name="tgl_kas" class="form-control" value="<?php echo $tgl ?>">
                  </div>

                  <div class="form-group">
                    <label>Keterangan</label>
                    <input required="" type="text" name="keterangan" class="form-control">
                  </div>



                  <div class="form-group">
                    <label>Pamasukan</label>
                    <input required="" type="text" autocomplete="off" name="penerimaan" value="0" class="form-control uang">
                  </div>

                  <div class="form-group">
                    <label>Pengeluaran</label>
                    <input required="" type="text" autocomplete="off" name="pengeluaran" value="0" class="form-control uang">
                  </div>


                  <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>

                  </div>



                </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>



          <?php

          if (isset($_POST['tambah'])) {

            $tahun_ajaran = $_POST['tahun_ajaran'];
            $tgl_kas = $_POST['tgl_kas'];
            $keterangan = htmlspecialchars(strip_tags($_POST['keterangan']));
            $penerimaan2 = htmlspecialchars(strip_tags($_POST['penerimaan']));
            $pengeluaran2 = htmlspecialchars(strip_tags($_POST['pengeluaran']));

            $penerimaan_oke2 = str_replace(".", "", $penerimaan2);
            $pengeluaran_oke2 = str_replace(".", "", $pengeluaran2);

            $sql = $koneksi->query("INSERT INTO tb_kas (tgl_kas, keterangan, penerimaan, pengeluaran, status) VALUES ('$tgl_kas', '$keterangan', '$penerimaan_oke2', '$pengeluaran_oke2', 1) ");

            if ($sql) {
              echo "

                <script>
                    setTimeout(function() {
                        swal({
                            title: 'Data Kas',
                            text: 'Berhasil Disimpan!',
                            type: 'success'
                        }, function() {
                            window.location = '?page=kas';
                        });
                    }, 300);
                </script>

            ";
            }
          }

          ?>


          <!-- AKHIR TAMBAH DATA TAHUN AJARAN -->


          <?php


          if (isset($_POST['hapus'])) {
            $id_kas = $_POST['id_kas'];

            $sql = $koneksi->query("delete from tb_kas where id_kas='$id_kas'");

            if ($sql) {
              echo "

                <script>
                    setTimeout(function() {
                        swal({
                            title: 'Data Kas',
                            text: 'Berhasil Dihapus!',
                            type: 'success'
                        }, function() {
                            window.location = '?page=kas';
                        });
                    }, 300);
                </script>

            ";
            }
          }

          ?>


        <?php } else {
        echo "Anda Tidak Berhak Mengakses Halaman Ini";
      } ?>

        <script>
          $(document).ready(function() {
            // Initialize select2
            $('.select2').select2({
              placeholder: function() {
                return $(this).data('placeholder') || 'Pilih...';
              },
              allowClear: true
            });

            // Filter functionality
            $('#applyFilter').click(function() {
              var typeFilter = $('#filterType').val();
              var areaFilter = $('#filterArea').val();
              var kasirFilter = $('#filterKasir').val();
              var tanggalFilter = $('#filterTanggal').val();
              var bulanFilter = $('#filterBulan').val();
              var tahunFilter = $('#filterTahun').val();
              var tanggalDariFilter = $('#filterTanggalDari').val();
              var tanggalSampaiFilter = $('#filterTanggalSampai').val();

              var filteredTotalMasuk = 0;
              var filteredTotalKeluar = 0;

              $('#example1 tbody tr').each(function() {
                var row = $(this);
                var showRow = true;

                // Skip total and saldo rows
                if (row.find('td[colspan]').length > 0) {
                  return;
                }

                // Get date from row (assuming it's in column 2)
                var tanggalText = row.find('td:nth-child(2)').text().trim();
                var rowDate = null;

                // Parse Indonesian date format (e.g., "09 Juli 2025")
                if (tanggalText) {
                  var monthNames = {
                    'Januari': '01',
                    'Februari': '02',
                    'Maret': '03',
                    'April': '04',
                    'Mei': '05',
                    'Juni': '06',
                    'Juli': '07',
                    'Agustus': '08',
                    'September': '09',
                    'Oktober': '10',
                    'November': '11',
                    'Desember': '12'
                  };

                  var parts = tanggalText.split(' ');
                  if (parts.length >= 3) {
                    var day = parts[0].padStart(2, '0');
                    var month = monthNames[parts[1]];
                    var year = parts[2];
                    if (month) {
                      rowDate = year + '-' + month + '-' + day;
                    }
                  }
                }

                // Type filter
                if (typeFilter) {
                  var kasMasuk = parseFloat(row.find('td:nth-child(6)').text().replace(/[^0-9]/g, '')) || 0;
                  var kasKeluar = parseFloat(row.find('td:nth-child(7)').text().replace(/[^0-9]/g, '')) || 0;

                  if (typeFilter === 'pendapatan' && kasMasuk === 0) {
                    showRow = false;
                  }
                  if (typeFilter === 'pengeluaran' && kasKeluar === 0) {
                    showRow = false;
                  }
                }

                // Area filter
                if (areaFilter) {
                  var areaText = row.find('td:nth-child(4)').text().trim();
                  var selectedAreaText = $('#filterArea option:selected').text();

                  if (areaText !== selectedAreaText) {
                    showRow = false;
                  }
                }

                // Kasir filter
                if (kasirFilter) {
                  var kasirText = row.find('td:nth-child(3)').text().trim();
                  var selectedKasirText = $('#filterKasir option:selected').text().split(' - ')[0]; // Get only kasir name part

                  if (kasirText !== selectedKasirText) {
                    showRow = false;
                  }
                }

                // Date filters (using OR logic)
                if (rowDate) {
                  var dateMatch = false;

                  // Check if any date filter is applied
                  var hasDateFilters = tanggalFilter || bulanFilter || tahunFilter || tanggalDariFilter || tanggalSampaiFilter;

                  if (hasDateFilters) {
                    // Specific date filter
                    if (tanggalFilter && rowDate === tanggalFilter) {
                      dateMatch = true;
                    }

                    // Month and Year filter (combined)
                    if ((bulanFilter || tahunFilter) && !tanggalFilter && !tanggalDariFilter && !tanggalSampaiFilter) {
                      var monthYearMatch = true;

                      if (bulanFilter) {
                        var rowMonth = rowDate.split('-')[1];
                        if (rowMonth !== bulanFilter) {
                          monthYearMatch = false;
                        }
                      }

                      if (tahunFilter) {
                        var rowYear = rowDate.split('-')[0];
                        if (rowYear !== tahunFilter) {
                          monthYearMatch = false;
                        }
                      }

                      if (monthYearMatch) {
                        dateMatch = true;
                      }
                    }

                    // Date range filter
                    if ((tanggalDariFilter || tanggalSampaiFilter) && !tanggalFilter && !bulanFilter && !tahunFilter) {
                      var rangeMatch = true;

                      if (tanggalDariFilter && rowDate < tanggalDariFilter) {
                        rangeMatch = false;
                      }
                      if (tanggalSampaiFilter && rowDate > tanggalSampaiFilter) {
                        rangeMatch = false;
                      }

                      if (rangeMatch) {
                        dateMatch = true;
                      }
                    }

                    // If date filters are applied but no match found, hide row
                    if (!dateMatch) {
                      showRow = false;
                    }
                  }
                }

                if (showRow) {
                  row.show();

                  // Add to filtered totals
                  var kasMasuk = parseFloat(row.find('td:nth-child(6)').text().replace(/[^0-9]/g, '')) || 0;
                  var kasKeluar = parseFloat(row.find('td:nth-child(7)').text().replace(/[^0-9]/g, '')) || 0;
                  filteredTotalMasuk += kasMasuk;
                  filteredTotalKeluar += kasKeluar;
                } else {
                  row.hide();
                }
              });

              // Update total and saldo rows with filtered values
              var filteredSaldo = filteredTotalMasuk - filteredTotalKeluar;

              // Format numbers with thousands separator
              var formattedTotalMasuk = new Intl.NumberFormat('id-ID').format(filteredTotalMasuk);
              var formattedTotalKeluar = new Intl.NumberFormat('id-ID').format(filteredTotalKeluar);
              var formattedSaldo = new Intl.NumberFormat('id-ID').format(filteredSaldo);

              // Update the total row
              $('#example1 tbody tr').each(function() {
                var row = $(this);
                if (row.find('td:first').text() === 'Total' || row.find('td').eq(0).attr('colspan') == '5') {
                  if (row.find('td:first').text().includes('Total')) {
                    row.find('td:nth-child(2)').text(formattedTotalMasuk);
                    row.find('td:nth-child(3)').text(formattedTotalKeluar);
                  }
                }
              });

              // Update the saldo row
              $('#example1 tbody tr').each(function() {
                var row = $(this);
                if (row.find('td:first').text() === 'Saldo' || row.find('td').eq(0).attr('colspan') == '5') {
                  if (row.find('td:first').text().includes('Saldo')) {
                    row.find('td:nth-child(2)').text(formattedSaldo);

                    // Update saldo color based on positive/negative
                    var saldoCell = row.find('td:nth-child(2)');
                    if (filteredSaldo >= 0) {
                      saldoCell.css('color', '#28a745');
                    } else {
                      saldoCell.css('color', '#dc3545');
                    }
                  }
                }
              });
            });

            // Reset filter
            $('#resetFilter').click(function() {
              $('#filterType').val('');
              $('#filterArea').val('').trigger('change');
              $('#filterKasir').val('').trigger('change');
              $('#filterTanggal').val('');
              $('#filterBulan').val('');
              $('#filterTahun').val('');
              $('#filterTanggalDari').val('');
              $('#filterTanggalSampai').val('');
              $('#example1 tbody tr').show();

              // Recalculate original totals
              var originalTotalMasuk = 0;
              var originalTotalKeluar = 0;

              $('#example1 tbody tr').each(function() {
                var row = $(this);

                // Skip total and saldo rows
                if (row.find('td[colspan]').length > 0) {
                  return;
                }

                var kasMasuk = parseFloat(row.find('td:nth-child(6)').text().replace(/[^0-9]/g, '')) || 0;
                var kasKeluar = parseFloat(row.find('td:nth-child(7)').text().replace(/[^0-9]/g, '')) || 0;
                originalTotalMasuk += kasMasuk;
                originalTotalKeluar += kasKeluar;
              });

              var originalSaldo = originalTotalMasuk - originalTotalKeluar;

              // Format numbers
              var formattedTotalMasuk = new Intl.NumberFormat('id-ID').format(originalTotalMasuk);
              var formattedTotalKeluar = new Intl.NumberFormat('id-ID').format(originalTotalKeluar);
              var formattedSaldo = new Intl.NumberFormat('id-ID').format(originalSaldo);

              // Update the total row
              $('#example1 tbody tr').each(function() {
                var row = $(this);
                if (row.find('td:first').text() === 'Total' || row.find('td').eq(0).attr('colspan') == '5') {
                  if (row.find('td:first').text().includes('Total')) {
                    row.find('td:nth-child(2)').text(formattedTotalMasuk);
                    row.find('td:nth-child(3)').text(formattedTotalKeluar);
                  }
                }
              });

              // Update the saldo row
              $('#example1 tbody tr').each(function() {
                var row = $(this);
                if (row.find('td:first').text() === 'Saldo' || row.find('td').eq(0).attr('colspan') == '5') {
                  if (row.find('td:first').text().includes('Saldo')) {
                    row.find('td:nth-child(2)').text(formattedSaldo);

                    // Update saldo color
                    var saldoCell = row.find('td:nth-child(2)');
                    if (originalSaldo >= 0) {
                      saldoCell.css('color', '#28a745');
                    } else {
                      saldoCell.css('color', '#dc3545');
                    }
                  }
                }
              });
            }); // Download button handler with form submission
            $('#exportForm').on('submit', function(e) {
              // Validate required fields
              var exportType = $('select[name="export_type"]').val();
              var exportFormat = $('select[name="export_format"]').val();

              if (!exportType) {
                alert('Silakan pilih type terlebih dahulu.');
                e.preventDefault();
                return false;
              }

              if (!exportFormat) {
                alert('Silakan pilih format terlebih dahulu.');
                e.preventDefault();
                return false;
              }

              // Close modal after form submission
              setTimeout(function() {
                $('#modal-export').modal('hide');
              }, 500);

              return true;
            });
          });
        </script>