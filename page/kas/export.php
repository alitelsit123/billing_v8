<?php
session_start();
include '../../include/koneksi.php';
if ($_SESSION['admin'] && isset($_POST['export_data'])) {

  $export_type = $_POST['export_type'];
  $export_area = $_POST['export_area'];
  $export_kasir = $_POST['export_kasir'];
  $export_month = $_POST['export_month'];
  $export_year = $_POST['export_year'];
  $export_date = $_POST['export_date'];
  $export_date_from = $_POST['export_date_from'];
  $export_date_to = $_POST['export_date_to'];
  $export_format = $_POST['export_format'];

  // Build the query
  $query = "SELECT tb_kas.*, 
                     tb_tagihan.id_pelanggan,
                     tb_pelanggan.kasir_id,
                     tb_user.nama_user as kasir_nama,
                     tb_area.name as area_name 
              FROM tb_kas 
              LEFT JOIN tb_tagihan ON tb_tagihan.id_tagihan = tb_kas.id_tagihan
              LEFT JOIN tb_pelanggan ON tb_pelanggan.id_pelanggan = tb_tagihan.id_pelanggan
              LEFT JOIN tb_user ON tb_user.id = tb_pelanggan.kasir_id
              LEFT JOIN tb_area ON tb_area.id = tb_user.area_id 
              WHERE 1=1";

  // Add filters
  if ($export_type == 'pendapatan') {
    $query .= " AND tb_kas.penerimaan > 0";
  } elseif ($export_type == 'pengeluaran') {
    $query .= " AND tb_kas.pengeluaran > 0";
  }
  if (!empty($export_area)) {
    $query .= " AND tb_user.area_id = '$export_area'";
  }

  if (!empty($export_kasir)) {
    $query .= " AND tb_pelanggan.kasir_id = '$export_kasir'";
  }

  // Date filters (using OR logic)
  $dateConditions = array();

  // Specific date filter
  if (!empty($export_date)) {
    $dateConditions[] = "DATE(tb_kas.tgl_kas) = '$export_date'";
  }

  // Month and Year filter (combined)
  if ((!empty($export_month) || !empty($export_year)) && empty($export_date) && empty($export_date_from) && empty($export_date_to)) {
    $monthYearConditions = array();

    if (!empty($export_month)) {
      $monthYearConditions[] = "MONTH(tb_kas.tgl_kas) = '$export_month'";
    }

    if (!empty($export_year)) {
      $monthYearConditions[] = "YEAR(tb_kas.tgl_kas) = '$export_year'";
    }

    if (!empty($monthYearConditions)) {
      $dateConditions[] = "(" . implode(" AND ", $monthYearConditions) . ")";
    }
  }

  // Date range filter
  if ((!empty($export_date_from) || !empty($export_date_to)) && empty($export_date) && empty($export_month) && empty($export_year)) {
    $rangeConditions = array();

    if (!empty($export_date_from)) {
      $rangeConditions[] = "DATE(tb_kas.tgl_kas) >= '$export_date_from'";
    }

    if (!empty($export_date_to)) {
      $rangeConditions[] = "DATE(tb_kas.tgl_kas) <= '$export_date_to'";
    }

    if (!empty($rangeConditions)) {
      $dateConditions[] = "(" . implode(" AND ", $rangeConditions) . ")";
    }
  }

  // Add date conditions to query
  if (!empty($dateConditions)) {
    $query .= " AND (" . implode(" OR ", $dateConditions) . ")";
  }

  $query .= " ORDER BY tb_kas.tgl_kas DESC";

  $result = $koneksi->query($query);

  if ($result->num_rows > 0) {

    // Generate filename
    $filename = "data_kas_" . date('Y-m-d_H-i-s');

    if ($export_format == 'csv') {
      // CSV Export
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Pragma: public');

      $output = fopen('php://output', 'w');

      // Add UTF-8 BOM for proper Excel encoding
      fputs($output, "\xEF\xBB\xBF");

      // Header
      fputcsv($output, ['No', 'Tanggal', 'Kasir', 'Keterangan', 'Area', 'Kas Masuk', 'Kas Keluar'], ';');

      $no = 1;
      while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
          $no++,
          date('d/m/Y', strtotime($row['tgl_kas'])),
          $row['kasir_nama'] ?: '-',
          $row['area_name'] ?: '-',
          $row['keterangan'],
          number_format($row['penerimaan'], 0, ',', '.'),
          number_format($row['pengeluaran'], 0, ',', '.')
        ], ';');
      }

      fclose($output);
      exit;
    } elseif ($export_format == 'xlsx') {
      // Excel Export (simple HTML table that Excel can read)
      header('Content-Type: application/vnd.ms-excel; charset=utf-8');
      header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Pragma: public');

      echo '<html><head><meta charset="UTF-8"></head><body>';
      echo '<table border="1">';
      echo '<tr><th>No</th><th>Tanggal</th><th>Kasir</th><th>Keterangan</th><th>Area</th><th>Kas Masuk</th><th>Kas Keluar</th></tr>';

      $no = 1;
      while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $no++ . '</td>';
        echo '<td>' . date('d/m/Y', strtotime($row['tgl_kas'])) . '</td>';
        echo '<td>' . ($row['kasir_nama'] ?: '-') . '</td>';
        echo '<td>' . htmlspecialchars($row['keterangan']) . '</td>';
        echo '<td>' . ($row['area_name'] ?: '-') . '</td>';
        echo '<td>' . number_format($row['penerimaan'], 0, ',', '.') . '</td>';
        echo '<td>' . number_format($row['pengeluaran'], 0, ',', '.') . '</td>';
        echo '</tr>';
      }

      echo '</table>';
      echo '</body></html>';
      exit;
    }
  } else {
    echo "<script>
            alert('Tidak ada data untuk diekspor dengan filter yang dipilih.');
            window.close();
        </script>";
  }
} else {
  echo "<script>
        alert('Akses ditolak.');
        window.close();
    </script>";
}
