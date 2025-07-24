<?php
include "connect.php";

$nama_menu = isset($_POST['nama_menu']) ? htmlentities($_POST['nama_menu']) : "";
$keterangan = isset($_POST['keterangan']) ? htmlentities($_POST['keterangan']) : "";
$kategori = isset($_POST['kategori']) ? htmlentities($_POST['kategori']) : "";
$harga = isset($_POST['harga']) ? htmlentities($_POST['harga']) : "";
// $alamat = isset($_POST['alamat']) ? htmlentities($_POST['alamat']) : "";
// $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : "";

$message = "";

// Cek apakah tombol submit ditekan
if (isset($_POST['input_menu_validate'])) {

    // Cek apakah username sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM tabel_daftar_menu WHERE nama_menu = '$nama_menu'");
    if (mysqli_num_rows($cek) > 0) {
        // Tampilkan alert kalau username duplikat
        $message = '<script>
            alert("Gagal: Nama Menu sudah digunakan, silakan pakai yang lain.");
            window.history.back();
        </script>';
    } else {
        // Jalankan query INSERT
        $query = mysqli_query($conn, "INSERT INTO tabel_daftar_menu (nama_menu, keterangan, kategori, harga) 
                                      VALUES ('$nama_menu', '$keterangan', '$kategori', '$harga')");

        if ($query) {
            $message = '<script>
                alert("Data berhasil dimasukkan.");
                window.location.href = "../menu.php";
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
