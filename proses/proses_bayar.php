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

$message = "";

if (isset($_POST['bayar_validate'])) {
    if ($kembalian < 0) {
        $message = '<script>
            alert("Nominal uang tidak mencukupi");
            window.history.back();
        </script>';
    } else {
        // INSERT pembayaran
        $query = mysqli_query($conn, "INSERT INTO tabel_bayar (id_bayar, nominal_uang, total_bayar) 
                                      VALUES ('$kode_order', '$uang', '$total')");

        if ($query) {
            // UPDATE status meja jadi tersedia di tabel reservasi
            // Asumsi 'meja' adalah nomor meja yang ada di form
            $updateMeja = mysqli_query($conn, "UPDATE tabel_reservasi SET status = 0 WHERE no_meja = '$meja'");

            if ($updateMeja) {
                $message = '<script>
                    alert("Pembayaran Berhasil \nUang Kembalian RP. ' . $kembalian . '");
                    window.location.href = "../order_item.php?id_order=' . $kode_order . '";
                </script>';
            } else {
                $message = '<script>
                    alert("Pembayaran Berhasil, tapi gagal update status meja");
                    window.location.href = "../order_item.php?id_order=' . $kode_order . '";
                </script>';
            }
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
