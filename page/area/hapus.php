<?php if ($_SESSION['admin']) {

  $id = $_GET['id'];

  // Validasi ID
  if (!$id || !is_numeric($id)) {
    echo "
      <script>
          setTimeout(function() {
              swal({
                  title: 'Error',
                  text: 'ID area tidak valid!',
                  type: 'error'
              }, function() {
                  window.location = '?page=area';
              });
          }, 300);
      </script>
    ";
    exit;
  }

  // Cek apakah data area ada
  $cek = $koneksi->query("SELECT * FROM tb_area WHERE id = '$id'");
  if ($cek->num_rows == 0) {
    echo "
      <script>
          setTimeout(function() {
              swal({
                  title: 'Error',
                  text: 'Area tidak ditemukan!',
                  type: 'error'
              }, function() {
                  window.location = '?page=area';
              });
          }, 300);
      </script>
    ";
    exit;
  }

  // Hapus data
  $sql = $koneksi->query("DELETE FROM tb_area WHERE id = '$id'");

  if ($sql) {
    echo "
      <script>
          setTimeout(function() {
              swal({
                  title: 'Data Area',
                  text: 'Berhasil Dihapus!',
                  type: 'success'
              }, function() {
                  window.location = '?page=area';
              });
          }, 300);
      </script>
    ";
  } else {
    echo "
      <script>
          setTimeout(function() {
              swal({
                  title: 'Error',
                  text: 'Terjadi kesalahan saat menghapus data!',
                  type: 'error'
              }, function() {
                  window.location = '?page=area';
              });
          }, 300);
      </script>
    ";
  }
} else {
  echo "Anda Tidak Berhak Mengakses Halaman Ini";
}
