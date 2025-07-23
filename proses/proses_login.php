<?php
session_start();
include "connect.php";

$username = isset($_POST['username']) ? htmlentities($_POST['username']) : "";
$password = isset($_POST['password']) ? htmlentities($_POST['password']) : "";

if (!empty($_POST['submit_validasi'])) {
    $query = mysqli_query($conn, "SELECT * FROM tabel_user WHERE username = '$username'");
    $hasil = mysqli_fetch_assoc($query);

    // Cek apakah user ditemukan dan password cocok
    if ($hasil && password_verify($password, $hasil['password'])) {
        $_SESSION['username_dapoer'] = $username;
        $_SESSION['level_dapoer'] = $hasil['level'];
        header('Location: ../index.php');
        exit;
    } else {
        echo "<script>
                alert('Username atau password yang anda masukkan salah');
                window.location = '../login.php';
              </script>";
    }
}
?>
