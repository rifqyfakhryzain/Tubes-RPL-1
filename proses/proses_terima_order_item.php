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
        $query = mysqli_query($conn, "UPDATE tabel_list_order SET menu='$menu',jumlah='$jumlah',catatan='$catatan' WHERE id_list_order = '$id'");

        if ($query) {
            $message = '<script>
                alert("Data berhasil dimasukkan.");
                window.location.href = "../order_item.php?id_order=' . $kode_order . '";
            </script>';
        } else {
            $message = '<script>
                alert("Terjadi kesalahan: ' . mysqli_error($conn) . '");
                window.history.back();
            </script>';
        }
    }


echo $message;
?>
