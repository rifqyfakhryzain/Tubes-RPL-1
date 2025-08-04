<?php
session_start();
if (empty($_SESSION['username_dapoer'])) {
   header('location:login.php');
   exit();
}
include 'proses/connect.php';

$username = $_SESSION['username_dapoer'];
$query = mysqli_query($conn, "SELECT * FROM tabel_user WHERE username = '$username'");

if ($query) {
   $hasil = mysqli_fetch_assoc($query);

   if ($hasil && isset($hasil['username'])) {
      // Misal kamu ingin simpan ke variabel saja, bukan langsung tampil
      $namaPengguna = $hasil['username'];
      $nama = $hasil['nama'];
   }
}

?>

<!doctype html>
<html>

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <!-- Tailwind -->
   <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
   <!-- FlowBite -->
   <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
   <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</head>

<body class="min-h-screen flex flex-col">

   <!-- Navbar -->
   <?php include "header.php"; ?>
   <!-- End Navbar -->

   <!-- Sidebar -->
   <?php include "sidebar.php"; ?>
   <!-- EndSidebar -->
   <!-- Content -->
   <main class="flex-grow pt-16 p-4 sm:ml-64">
      <!-- Card Full -->
      <div class="w-full max-w-4xl mx-auto mt-10">
         <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-6 md:p-10 space-y-6">

            <!-- Judul About -->
            <h3 class="text-1xl font-bold text-grey-900 dark:text-white">Home</h3>

            <!-- Konten -->
            <div class="space-y-4">
               <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                  Selamat Datang, <?= htmlspecialchars($nama); ?> 👋
               </h2>
               <p class="text-gray-600 dark:text-gray-400">
                  Selamat datang di Dapoer Resto! Aplikasi ini membantu tim restoran dalam mengatur pesanan, mengelola menu, dan memantau operasional harian dengan
               </p>
            </div>

         </div>
      </div>

      <!-- Footer -->
      <?php include "footer.php"; ?>

   </main>
   <!-- End Content -->


</body>

</html>