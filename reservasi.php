<?php
session_start();
if (empty($_SESSION['username_dapoer'])) {
   header('Location: login.php');
   exit();
}

include 'proses/connect.php';

$username = $_SESSION['username_dapoer'];

// Data user login
$query_user = mysqli_query($conn, "SELECT * FROM tabel_user WHERE username = '$username'");
$hasil = mysqli_fetch_assoc($query_user);

// Ambil semua daftar menu
$menu_result = [];
$query_menu = mysqli_query($conn, "SELECT id, nama_menu FROM tabel_daftar_menu");
while ($row = mysqli_fetch_assoc($query_menu)) {
   $menu_result[] = $row;
}

// Ambil semua list order + info order + info menu
$result = [];

$query = mysqli_query(
   $conn,
   " SELECT * FROM tabel_reservasi

"
);



while ($record = mysqli_fetch_assoc($query)) {
   $result[] = $record;
}
?>





<!doctype html>
<html>

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />

   <!-- Tailwind CSS -->
   <script src="https://cdn.tailwindcss.com"></script>

   <!-- Flowbite CSS -->
   <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet" />

   <!-- Flowbite JS -->
   <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>

   <!-- Simple-DataTables (untuk Flowbite DataTable) -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" />
   <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" defer></script>

   <style>
      /* Tambahkan ini ke dalam <style> Anda */
      @media (max-width: 640px) {

         /* Optimalkan card container */
         .w-\[95\%\] {
            width: 100%;
            padding: 1rem;
         }

         /* Perbaikan tabel mobile */
         .relative.overflow-x-auto {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
         }

         #search-table {
            display: block;
            width: 100%;
         }

         #search-table thead {
            display: none;
            /* Sembunyikan header di mobile */
         }

         #search-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
         }

         #search-table tbody td {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 0.75rem;
            text-align: left;
         }


         #search-table tbody td::before {
            content: attr(data-label);
            font-weight: bold;
            text-align: left;
            margin-right: 1rem;
         }

         /* DataTables mobile optimization */
         .dataTable-wrapper {
            overflow-x: auto;
         }

         .dataTable-top,
         .dataTable-bottom {
            flex-direction: column;
            gap: 0.5rem;
         }

         .dataTable-input {
            width: 100% !important;
         }
      }
   </style>

</head>

<script>
   document.addEventListener("DOMContentLoaded", function() {
      const table = document.querySelector("#search-table");
      if (table) {
         // Tambahkan atribut data-label ke setiap td
         const headers = Array.from(table.querySelectorAll("thead th")).map(th => th.textContent.trim());
         table.querySelectorAll("tbody tr").forEach(row => {
            Array.from(row.querySelectorAll("td")).forEach((td, index) => {
               td.setAttribute("data-label", headers[index] || "");
            });
         });

         const datatable = new simpleDatatables.DataTable(table, {
            perPage: 5, // Kurangi item per halaman untuk mobile
            perPageSelect: [5, 10, 15],
            labels: {
               placeholder: "Cari meja...",
               searchTitle: "Cari dalam tabel",
               pageTitle: "Halaman {page}",
               perPage: "item per halaman",
               noRows: "Data tidak ditemukan",
               info: "Menampilkan {start} sampai {end} dari {rows} data",
               noResults: "Tidak ada hasil yang cocok dengan pencarian Anda",
            }
         });

         // ... (kode styling Tailwind yang sudah ada)
      }
   });
</script>



<body class="min-h-screen flex flex-col">

   <!-- Navbar -->
   <?php include "header.php"; ?>
   <!-- End Navbar -->

   <!-- Sidebar -->
   <?php include "sidebar.php"; ?>
   <!-- EndSidebar -->

   <main class="flex-grow pt-16 p-4 sm:ml-64">
      <!-- Card Full -->
      <div class="w-[95%] mx-auto mt-10">
         <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-lg p-10 space-y-6">

            <!-- Judul About -->
            <h3 class="text-1xl font-bold text-grey-900 dark:text-white">Halaman Reservasi Meja</h3>

            <!-- Konten -->
            <div class="relative overflow-x-auto">
               <!-- Validasi Jika data menu tidak ada -->
               <?php
               if (empty($result)) {
                  echo "<p class='text-red-500'>Data Menu tidak ada</p>";
               } else {
               ?>
                  <table id="search-table" class="min-w-full w-full text-sm text-left text-gray-500 dark:text-gray-400">
                     <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                           <!-- Menu -->
                           <th scope="col" class="px-6 py-3">
                              No
                           </th>
                           <!-- Harga -->
                           <th scope="col" class="px-6 py-3">
                              No Meja
                           </th>
                           <!-- Catatan -->
                           <th scope="col" class="px-6 py-3">
                              Catatan
                           </th>
                           <!-- Total -->
                           <th scope="col" class="px-6 py-3">
                              Status
                           </th>
                           <!-- Aksi -->
                           <th scope="col" class="px-6 py-3">
                              Aksi
                           </th>
                        </tr>
                     </thead>
                     <tbody>


                        <?php
                        $no = 1;
                        foreach ($result as $row) {
                        ?>


                           <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                 <?= $no++; ?>
                              </th>
                              <!-- No Meja -->
                              <td class="px-6 py-4">
                                 <?php echo $row['no_meja'] ?>
                              </td>
                              <!-- Catatan -->
                              <td class="px-6 py-4">
                                 <?php echo $row['catatan'] ?>
                              </td>
                              <!-- Status -->
                              <td class="px-6 py-4">
                                 <?php
                                 if ($row['status'] == 0) {
                                    echo '<span class="inline-block min-w-[130px] text-center px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300 whitespace-nowrap">
                                       Meja Tersedia
                                       </span>';
                                 } elseif ($row['status'] == 1) {
                                    echo '<span class="inline-block min-w-[130px] text-center px-3 py-1 text-sm font-semibold text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-300 whitespace-nowrap">
                                       Meja Penuh
                                       </span>';
                                 } else {
                                    echo '<span class="inline-block min-w-[130px] text-center px-3 py-1 text-sm font-semibold text-gray-800 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-gray-300 whitespace-nowrap">
                                       Status Tidak Dikenal
                                       </span>';
                                 }
                                 ?>
                              </td>
                              <!-- Aksi -->
                              <td class="px-6 py-4">
                                 <div class="flex gap-2">
                                    <?php
                                    $status = $row['status']; // Diambil dari tabel_list_order
                                    ?>
                                    <!-- Tombol Reservasi -->
                                    <button type="button"
                                       data-modal-target="meja-modal-<?php echo $row['id_meja']; ?>"
                                       data-modal-toggle="meja-modal-<?php echo $row['id_meja']; ?>"
                                       class="flex items-center justify-center gap-2 font-medium rounded-lg text-sm px-4 py-2
                                       <?php echo ($status == 0)
                                          ? 'text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800 focus:outline-none'
                                          : 'text-white bg-gray-400 cursor-not-allowed'; ?>"
                                       <?php echo ($status == 1) ? 'disabled' : ''; ?>>
                                       Reservasi
                                    </button>

                                    <!-- Tombol Selesai Reservasi -->
                                    <button type="button"
                                       data-modal-target="meja-tersedia-modal-<?php echo $row['id_meja']; ?>"
                                       data-modal-toggle="meja-tersedia-modal-<?php echo $row['id_meja']; ?>"
                                       class="flex items-center justify-center gap-2 font-medium rounded-lg text-sm px-4 py-2
                                       <?php echo ($status == 1)
                                          ? 'text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 focus:outline-none'
                                          : 'text-white bg-gray-400 cursor-not-allowed'; ?>"
                                       <?php echo ($status == 0) ? 'disabled' : ''; ?>>
                                       Selesai
                                    </button>
                                 </div>
                              </td>
                           </tr>
                        <?php

                        } ?>

                     </tbody>
                  </table>
                  <script>
                     document.addEventListener("DOMContentLoaded", function() {
                        const table = document.querySelector("#search-table");
                        if (!table) return;

                        const headers = Array.from(table.querySelectorAll("thead th")).map(th => th.textContent.trim());

                        table.querySelectorAll("tbody tr").forEach(row => {
                           row.querySelectorAll("td").forEach((td, i) => {
                              td.setAttribute("data-label", headers[i]);
                           });
                        });
                     });
                  </script>

               <?php
               }
               ?>
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




   <?php
   foreach ($result as $row) { ?>

      <!-- Modal terima Reservasi -->
      <!-- Main modal -->
      <div id="meja-modal-<?php echo $row['id_meja']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
         <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
               <!-- Modal header -->
               <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                     Reservasi
                  </h3>

                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="meja-modal-<?php echo $row['id_meja']; ?>">
                     <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                     </svg>
                     <span class="sr-only">Close modal</span>
                  </button>
               </div>
               <!-- Modal body dan Form -->
               <form action="proses/proses_terima_reservasi.php" method="POST" class="p-4 md:p-5">
                  <input type="hidden" name="id" value="<?php echo $row['id_meja'] ?>">
                  <div class="grid gap-4 mb-4 grid-cols-2">


                     <!-- Jumlah Porsi -->
                     <div class="col-span-2">
                        <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomer Meja</label>
                        <input type="text" disabled name="jumlah" id="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Jumlah Porsi" required="" value="<?php echo $row['no_meja'] ?>">
                     </div>
                     <!-- catatan -->
                     <div class="col-span-2">
                        <label for="catatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                        <input type="text" name="catatan" id="catatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Catatan" required="" value="<?php echo $row['catatan'] ?>">
                     </div>
                  </div>
                  <!-- SUbmit -->
                  <button type="submit" name="terima_reservasi_validate" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                     <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                     </svg>
                     Reservasi
                  </button>
               </form>
            </div>
         </div>
      </div>
   <?php } ?>

   <?php
   foreach ($result as $row) { ?>

      <!-- Modal selesai reservasi -->
      <!-- Main modal -->
      <div id="meja-tersedia-modal-<?php echo $row['id_meja']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
         <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
               <!-- Modal header -->
               <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                     Reservasi
                  </h3>

                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="meja-tersedia-modal-<?php echo $row['id_meja']; ?>">
                     <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                     </svg>
                     <span class="sr-only">Close modal</span>
                  </button>
               </div>
               <!-- Modal body dan Form -->
               <form action="proses/proses_selesai_reservasi.php" method="POST" class="p-4 md:p-5">
                  <input type="hidden" name="id" value="<?php echo $row['id_meja'] ?>">
                  <div class="grid gap-4 mb-4 grid-cols-2">


                     <!-- Nomer Meja -->
                     <div class="col-span-2">
                        <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomer Meja</label>
                        <input type="text" name="jumlah" id="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Jumlah Porsi" required="" value="<?php echo $row['no_meja'] ?>">
                     </div>
                     <!-- catatan -->
                     <div class="col-span-2">
                        <label for="catatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                        <input type="text" name="catatan" id="catatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Catatan" required="" value="<?php echo $row['catatan'] ?>">
                     </div>
                  </div>
                  <!-- SUbmit -->
                  <button type="submit" name="selesai_reservasi_validate" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                     <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                     </svg>
                     Selesai
                  </button>
               </form>
            </div>
         </div>
      </div>
   <?php } ?>




</body>

</html>