<?php
include "connect.php";

$nama = isset($_POST['nama']) ? htmlentities($_POST['nama']) : "";
$username = isset($_POST['username']) ? htmlentities($_POST['username']) : "";
$level = isset($_POST['level']) ? htmlentities($_POST['level']) : "";
$no_hp = isset($_POST['no_hp']) ? htmlentities($_POST['no_hp']) : "";
$alamat = isset($_POST['alamat']) ? htmlentities($_POST['alamat']) : "";
$password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : "";

$message = "";

// Cek apakah tombol submit ditekan
if (isset($_POST['input_user_validate'])) {

    // Cek apakah username sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM tabel_user WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        // Tampilkan alert kalau username duplikat
        $message = '<script>
            alert("Gagal: Username sudah digunakan, silakan pakai yang lain.");
            window.history.back();
        </script>';
    } else {
        // Jalankan query INSERT
        $query = mysqli_query($conn, "INSERT INTO tabel_user (nama, username, password, level, no_hp, alamat) 
                                      VALUES ('$nama', '$username', '$password', '$level', '$no_hp', '$alamat')");

        if ($query) {
            $message = '<script>
                alert("Data berhasil dimasukkan.");
                window.location.href = "../user.php";
            </script>';
        } else {
            $message = '<script>
                alert("Terjadi kesalahan: ' . mysqli_error($conn) . '");
                window.history.back();
            </script>';
        }
    }
}

echo $message;
?>
