<?php
include "connect.php";

$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$nama = isset($_POST['nama']) ? htmlentities($_POST['nama']) : "";
$username = isset($_POST['username']) ? htmlentities($_POST['username']) : "";
$level = isset($_POST['level']) ? htmlentities($_POST['level']) : "";
$no_hp = isset($_POST['no_hp']) ? htmlentities($_POST['no_hp']) : "";
$alamat = isset($_POST['alamat']) ? htmlentities($_POST['alamat']) : "";
$password = isset($_POST['password']) ? htmlentities($_POST['password']) : "";

if (isset($_POST['edit_user_validate'])) {
    if ($id == "") {
        echo "<script>alert('ID tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    // Mulai query dasar
    $query_str = "UPDATE tabel_user SET 
                    nama='$nama', 
                    username='$username', 
                    level='$level', 
                    no_hp='$no_hp', 
                    alamat='$alamat'";

    // Jika password tidak kosong, update juga
    if (!empty($password)) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $query_str .= ", password='$password_hashed'";
    }

    $query_str .= " WHERE id=$id";

    $query = mysqli_query($conn, $query_str);

    if ($query) {
        echo "<script>alert('Data berhasil diupdate.'); window.location.href='../user.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
