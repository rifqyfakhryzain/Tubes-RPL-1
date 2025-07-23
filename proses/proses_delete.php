<?php
include "connect.php";

$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";

if (isset($_POST['delete_user_validate'])) {
    if ($id == "") {
        echo "<script>alert('ID tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    $query = mysqli_query($conn, "DELETE FROM tabel_user WHERE id = '$id'");

    if ($query) {
        echo "<script>alert('Data berhasil dihapus.'); window.location.href='../user.php';</script>";
    } else {
        echo "<script>alert('Gagal Menghapus data: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
?>
