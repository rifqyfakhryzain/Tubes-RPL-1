<?php
include "../connect.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $query = mysqli_query($conn, "DELETE FROM tabel_user WHERE id = $id");

    if ($query) {
        echo "<script>
                alert('Data berhasil dihapus');
                window.location.href='../user.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('ID tidak valid');
            window.history.back();
          </script>";
}
?>
