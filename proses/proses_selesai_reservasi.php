<?php
include "connect.php";
session_start();


// Ambil data dari form
$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$catatan = isset($_POST['catatan']) ? htmlentities($_POST['catatan']) : "";

// Ambil ID user dari session (pelayan)
$id_pelayan = $_SESSION['id']; // pastikan id sudah disimpan saat login

$message = "";

if (isset($_POST['selesai_reservasi_validate'])) {
    // INSERT ke database
    $query = mysqli_query($conn, "UPDATE tabel_reservasi SET catatan='$catatan', status=0 WHERE id_meja = '$id'");

    if ($query) {
        $message = '<script>
                alert("Terimakasih Telah Melakukan Reservasi ");
                window.location.href = "../reservasi.php";
            </script>';
    } else {
        $message = '<script>
                alert("gagal Coba Lagi' . mysqli_error($conn) . '");
                window.history.back();
            </script>';
    }
}


echo $message;
