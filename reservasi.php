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
               <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                  Ini adalah halaman Reservas
               </h2>
               <p class="text-gray-600 dark:text-gray-400">
                  Empower Developers, IT Ops, and business teams to collaborate at high velocity. Respond to changes and deliver great customer and employee service experiences fast.
               </p>
               <a href="#" class="inline-flex items-center font-medium text-blue-600 hover:text-blue-800 dark:text-blue-500 dark:hover:text-blue-700">
                  Learn more
                  <svg class="w-2.5 h-2.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                  </svg>
               </a>
            </div>

         </div>
      </div>





      <!-- Footer -->
      <footer class="bg-white rounded-lg m-4">
         <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <span class="block text-sm text-gray-900 sm:text-center">
               © 2023 <a href="https://flowbite.com/" class="hover:underline">Flowbite™</a>. All Rights Reserved.
            </span>
         </div>
      </footer>

   </main>
   <!-- End Content -->


</body>

</html>