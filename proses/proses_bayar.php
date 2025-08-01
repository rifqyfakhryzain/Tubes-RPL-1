<?php
include "connect.php";
session_start();


// Ambil data dari form
$kode_order = isset($_POST['kode_order']) ? htmlentities($_POST['kode_order']) : "";
$meja = isset($_POST['meja']) ? htmlentities($_POST['meja']) : "";
$pelanggan = isset($_POST['pelanggan']) ? htmlentities($_POST['pelanggan']) : ""; 
$total = isset($_POST['total']) ? htmlentities($_POST['total']) : ""; 
$uang = isset($_POST['uang']) ? htmlentities($_POST['uang']) : ""; 
$kembalian = $uang - $total;

// // Ambil ID user dari session (pelayan)
// $id_pelayan = $_SESSION['id']; // pastikan id sudah disimpan saat login

$message = "";

if (isset($_POST['bayar_validate'])) {
    if ($kembalian<0) {
            $message = '<script>
            alert("Nominal uang tidak mencukupi");
            window.history.back();
        </script>';
    } else {
        // INSERT ke database
        $query = mysqli_query($conn, "INSERT INTO tabel_bayar (id_bayar,nominal_uang,total_bayar) 
                                      VALUES ('$kode_order', '$uang', '$total')");

        if ($query) {
            $message = '<script>
                alert("Pembayaran Berhasil \nUang Kembalian RP. '.$kembalian.'");
                window.location.href = "../order_item.php?id_order=' . $kode_order . '";
            </script>';
        } else {
            $message = '<script>
                alert("Pembayaran Gagal ' . mysqli_error($conn) . '");
                window.history.back();
            </script>';
        }
    }

    }



echo $message;
?>
