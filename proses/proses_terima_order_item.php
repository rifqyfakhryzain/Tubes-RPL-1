<?php
include "connect.php";
session_start();


// Ambil data dari form
$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$catatan = isset($_POST['catatan']) ? htmlentities($_POST['catatan']) : ""; 

// Ambil ID user dari session (pelayan)
$id_pelayan = $_SESSION['id']; // pastikan id sudah disimpan saat login

$message = "";

if (isset($_POST['terima_order_item_validate'])) {
        // INSERT ke database
        $query = mysqli_query($conn, "UPDATE tabel_list_order SET catatan='$catatan', status=1 WHERE id_list_order = '$id'");

        if ($query) {
            $message = '<script>
                alert("Berhasil diterima oleh dapur.");
                window.location.href = "../dapur.php";
            </script>';
        } else {
            $message = '<script>
                alert("Gagal di terima oleh dapur ' . mysqli_error($conn) . '");
                window.history.back();
            </script>';
        }
    }


echo $message;
?>
