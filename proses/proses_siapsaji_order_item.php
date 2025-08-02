<?php
include "connect.php";
session_start();


// Ambil data dari form
$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$catatan = isset($_POST['catatan']) ? htmlentities($_POST['catatan']) : ""; 

// Ambil ID user dari session (pelayan)
$id_pelayan = $_SESSION['id']; // pastikan id sudah disimpan saat login

$message = "";

if (isset($_POST['siapsaji_order_item_validate'])) {
        // INSERT ke database
        $query = mysqli_query($conn, "UPDATE tabel_list_order SET catatan='$catatan', status=0 WHERE id_list_order = '$id'");

        if ($query) {
            $message = '<script>
                alert("Order siap disajikan");
                window.location.href = "../dapur.php";
            </script>';
        } else {
            $message = '<script>
                alert("gagal di siapkan' . mysqli_error($conn) . '");
                window.history.back();
            </script>';
        }
    }


echo $message;
?>
