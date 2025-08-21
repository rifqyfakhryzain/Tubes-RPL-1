   <?php
   session_start();
   if (empty($_SESSION['username_dapoer'])) {
      header('Location: login.php');
      exit();
   }

   // if ($_SESSION['level_dapoer'] != 1) {
   //    // Jika bukan level 1, redirect ke halaman utama
   //    header('location: index.php');
   //    exit();
   // }

   include 'proses/connect.php';
   date_default_timezone_set('Asia/Jakarta');

   $username = $_SESSION['username_dapoer'];

   // Data untuk header.php
   $query_user = mysqli_query($conn, "SELECT * FROM tabel_user WHERE username = '$username'");
   $hasil = mysqli_fetch_assoc($query_user);

   // Data untuk tabel semua user
   $result = [];
   $query = mysqli_query($conn, "SELECT tabel_order.*,tabel_bayar.*,nama, SUM(harga*jumlah) AS harganya FROM tabel_order
   LEFT JOIN tabel_user ON tabel_user.id = tabel_order.pelayan
   LEFT JOIN tabel_list_order ON tabel_list_order.kode_order = tabel_order.id_order
   LEFT JOIN tabel_daftar_menu ON tabel_daftar_menu.id = tabel_list_order.menu
   LEFT JOIN tabel_bayar ON tabel_bayar.id_bayar = tabel_order.id_order

   GROUP BY id_order ORDER BY waktu_order DESC");
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
   </head>


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
               <h3 class="text-1xl font-bold text-grey-900 dark:text-white">Halaman Report</h3>

               <!-- Konten -->
               <div class="relative overflow-x-auto">
                  <?php
                  if (empty($result)) {
                     echo "<p class='text-red-500'>Data Menu tidak ada</p>";
                  } else {



                  ?>
                     <table id="search-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                           <tr>
                              <th scope="col" class="px-6 py-3">
                                 No
                              </th>
                              <th scope="col" class="px-6 py-3">
                                 Kode Order
                              </th>
                              <th scope="col" class="px-6 py-3">
                                 Waktu Order
                              </th>
                              <th scope="col" class="px-6 py-3">
                                 Waktu Bayar
                              </th>
                              <th scope="col" class="px-6 py-3">
                                 Pelanggan
                              </th>
                              <th scope="col" class="px-6 py-3">
                                 Meja
                              </th>
                              <th scope="col" class="px-6 py-3">
                                 Total Harga
                              </th>
                              <th scope="col" class="px-6 py-3">
                                 Pelayan
                              </th>
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
                                 <!-- Nomer -->
                                 <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= $no++; ?>
                                 </th>
                                 <!-- Kode Order -->
                                 <td class="px-6 py-4">
                                    <?php echo $row['kode_order'] ?>
                                 </td>


                                 <!-- Waktu Order -->
                                 <td class="px-6 py-4">
                                    <?php echo $row['waktu_order'] ?>
                                 </td>

                                 <!-- Pelanggan -->
                                 <td class="px-6 py-4">
                                    <?php echo $row['waktu_bayar'] ?>
                                 </td>
                                 <!-- Total Harga -->
                                 <td class="px-6 py-4">
                                    <?php echo $row['pelanggan'] ?>
                                 </td>
                                 <!-- Pelayan -->
                                 <td class="px-6 py-4">
                                    <?php echo $row['no_meja'] ?>
                                 </td>
                                 <!-- Total Harga -->
                                 <td class="px-6 py-4">
                                    <?php echo $row['harganya'] ?>
                                 </td>
                                 <!-- Pelayan  -->
                                 <td class="px-6 py-4">
                                    <?php echo $row['nama'] ?>
                                 </td>
                                 <!-- Aksi -->
                                 <!-- Aksi -->
                                 <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                       <?php if (!empty($row['waktu_bayar'])): ?>
                                          <!-- Button Aktif -->
                                          <a href="order_item.php?id_order=<?php echo $row['id_order']; ?>">
                                             <button type="button"
                                                class="flex items-center justify-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                                <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                   <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                   <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                             </button>
                                          </a>
                                       <?php else: ?>
                                          <!-- Button Non-Aktif (Disabled) -->
                                          <button type="button"
                                             class="flex items-center justify-center gap-2 text-white bg-gray-400 cursor-not-allowed font-medium rounded-lg text-sm px-4 py-2 dark:bg-gray-500"
                                             disabled>
                                             <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                             </svg>
                                          </button>
                                       <?php endif; ?>
                                       <?php $dibayar = !empty($row['id_bayar']); ?>
                                    </div>
                                 </td>




                              </tr>
                           <?php
                           } ?>
                        </tbody>
                     </table>

                  <?php
                  }
                  ?>
               </div>


            </div>
         </div>

         <!-- Footer -->
         <?php include "footer.php"; ?>


      </main>
   </body>

   </html>