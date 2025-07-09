<?php
$username = (isset($_POST['username'])) ?  htmlentities($_POST['username']) : "";
$password = (isset($_POST['password'])) ?  htmlentities($_POST['password']) : "";
if (!empty($_POST['submit_validasi'])) {
    if ($username == "rifqyfz678@gmail.com" && $password == "rifqy") {
        header('Location: ../index.php');
    } else { ?>
        <script>
            alert('Username atau password yang anda masukkan salah')
            window.location = '../login.php'
        </script>
<?php
    }
}

?>