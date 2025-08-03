<?php
include "connect.php";

$id_order   = isset($_POST['id_order']) ? htmlentities($_POST['id_order']) : "";
$kode_order = isset($_POST['kode_order']) ? htmlentities($_POST['kode_order']) : "";
$no_meja       = isset($_POST['no_meja']) ? htmlentities($_POST['no_meja']) : "";
$pelanggan  = isset($_POST['pelanggan']) ? htmlentities($_POST['pelanggan']) : "";

if (isset($_POST['edit_order_validate'])) {
    if ($id_order == "") {
        echo "<script>alert('ID tidak ditemukan.'); window.history.back();</script>";
        exit;
    }

    // Ambil nomor meja lama
    $query_old_meja = mysqli_query($conn, "SELECT no_meja FROM tabel_order WHERE id_order = '$id_order'");
    $old_data = mysqli_fetch_assoc($query_old_meja);
    $old_meja = $old_data['no_meja'];

    // Update data order
    $query_str = "UPDATE tabel_order SET 
                    kode_order='$kode_order', 
                    no_meja='$no_meja', 
                    pelanggan='$pelanggan' 
                  WHERE id_order='$id_order'";
    $query = mysqli_query($conn, $query_str);

    if ($query) {
        // Update meja baru jadi status 1 (penuh)
        $updateNewMeja = mysqli_query($conn, "UPDATE tabel_reservasi SET status = 1 WHERE id_meja = '$no_meja'");

        // Update meja lama jadi status 0 (kosong), tapi hanya kalau beda meja
        if ($old_meja != $no_meja) {
            $updateOldMeja = mysqli_query($conn, "UPDATE tabel_reservasi SET status = 0 WHERE id_meja = '$old_meja'");
        }

        echo "<script>alert('Order berhasil diupdate.'); window.location.href='../order.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate Order " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
