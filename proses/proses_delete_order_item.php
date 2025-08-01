<?php
include "connect.php";

$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$kode_order = isset($_POST['kode_order']) ? htmlentities($_POST['kode_order']) : "";


if (isset($_POST['delete_order_item_validate'])) {
    if ($id == "") {
        echo "<script>alert('ID tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    $message = "";

    $query = mysqli_query($conn, "DELETE FROM tabel_list_order WHERE id_list_order = '$id'");

        if ($query) {
            $message = '<script>
                alert("Item berhasil dihapus.");
                window.location.href = "../order_item.php?id_order=' . $kode_order . '";
            </script>';
        } else {
            $message = '<script>
                alert("gagal mengahpus item : ' . mysqli_error($conn) . '");
                window.history.back();
            </script>';
        }
}
echo $message;
?>
