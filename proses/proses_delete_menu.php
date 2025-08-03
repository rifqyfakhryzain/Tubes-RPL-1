<?php
include "connect.php";

$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";

if (isset($_POST['delete_menu_validate'])) {
    if ($id == "") {
        echo "<script>alert('ID tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    $query = mysqli_query($conn, "DELETE FROM tabel_daftar_menu WHERE id = '$id'");

    if ($query) {
        echo "<script>alert('Menu berhasil dihapus.'); window.location.href='../menu.php';</script>";
    } else {
        echo "<script>alert('Gagal Menghapus Menu " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
