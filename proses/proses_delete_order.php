<?php
include "connect.php";

$id_order = isset($_POST['id_order']) ? htmlentities($_POST['id_order']) : "";

if (isset($_POST['delete_order_validate'])) {
    if ($id_order == "") {
        echo "<script>alert('ID tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    $query = mysqli_query($conn, "DELETE FROM tabel_order WHERE id_order = '$id_order'");

    if ($query) {
        echo "<script>alert('Order berhasil dihapus.'); window.location.href='../order.php';</script>";
    } else {
        echo "<script>alert('Gagal Menghapus Order " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
