<?php
include "connect.php";

$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$nama_menu = isset($_POST['nama_menu']) ? htmlentities($_POST['nama_menu']) : "";
$keterangan = isset($_POST['keterangan']) ? htmlentities($_POST['keterangan']) : "";
$kategori = isset($_POST['kategori']) ? htmlentities($_POST['kategori']) : "";
$harga = isset($_POST['harga']) ? htmlentities($_POST['harga']) : "";

if (isset($_POST['edit_menu_validate'])) {
    if ($id == "") {
        echo "<script>alert('ID tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    // Query SQL
    $query_str = "UPDATE tabel_daftar_menu SET 
                    nama_menu='$nama_menu', 
                    keterangan='$keterangan', 
                    harga='$harga', 
                    kategori='$kategori'
                  WHERE id='$id'";

    $query = mysqli_query($conn, $query_str); // Eksekusi query

    if ($query) {
        echo "<script>alert('Menu berhasil diupdate.'); window.location.href='../menu.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate Menu: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
