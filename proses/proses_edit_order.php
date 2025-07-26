<?php
include "connect.php";

$id_order   = isset($_POST['id_order']) ? htmlentities($_POST['id_order']) : "";
$kode_order = isset($_POST['kode_order']) ? htmlentities($_POST['kode_order']) : "";
$meja       = isset($_POST['meja']) ? htmlentities($_POST['meja']) : "";
$pelanggan  = isset($_POST['pelanggan']) ? htmlentities($_POST['pelanggan']) : "";

if (isset($_POST['edit_order_validate'])) {
    if ($id_order == "") {
        echo "<script>alert('ID tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    // Query SQL
    $query_str = "UPDATE tabel_order SET 
                    kode_order='$kode_order', 
                    meja='$meja', 
                    pelanggan='$pelanggan' 
                  WHERE id_order='$id_order'";

    $query = mysqli_query($conn, $query_str);

    if ($query) {
        echo "<script>alert('Order berhasil diupdate.'); window.location.href='../order.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate Order " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
?>
