<?php
session_start();
if (empty($_SESSION['username_dapoer'])) {
   header('Location: login.php');
   exit();
}

if ($_SESSION['level_dapoer'] != 1) {
   // Jika bukan level 1, redirect ke halaman utama
   header('location: index.php');
   exit();
}

include 'proses/connect.php';

$username = $_SESSION['username_dapoer'];

// Data untuk header.php
$query_user = mysqli_query($conn, "SELECT * FROM tabel_user WHERE username = '$username'");
$hasil = mysqli_fetch_assoc($query_user);

// Data untuk tabel semua user
$result = [];
$query = mysqli_query($conn, "SELECT * FROM tabel_user");
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
            <h3 class="text-1xl font-bold text-grey-900 dark:text-white">Halaman User</h3>

            <!-- Konten -->
            <div class="relative overflow-x-auto">
               <div class="w-full flex justify-start sm:justify">
                  <!-- Button Tambah User -->
                  <button type="button" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                     class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 mb-5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 whitespace-nowrap">
                     Tambah User
                  </button>
               </div>

               <?php
               if (empty($result)) {
                  echo "Data user tidak ada";
               } else {



               ?>
                  <table id="search-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                     <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                           <th scope="col" class="px-6 py-3">
                              No
                           </th>
                           <th scope="col" class="px-6 py-3">
                              Nama
                           </th>
                           <th scope="col" class="px-6 py-3">
                              Username
                           </th>
                           <th scope="col" class="px-6 py-3">
                              Level
                           </th>
                           <th scope="col" class="px-6 py-3">
                              No HP
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
                              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                 <?= $no++; ?>
                              </th>
                              <td class="px-6 py-4">
                                 <?php echo $row['nama'] ?>
                              </td>
                              <td class="px-6 py-4">
                                 <?php echo $row['username'] ?>

                              </td>
                              <td class="px-6 py-4">
                                 <?php if ($row['level'] == 1) {
                                    echo 'Admin';
                                 } elseif ($row['level'] == 2) {
                                    echo 'Kasir';
                                 } elseif ($row['level'] == 3) {
                                    echo 'Pelayan';
                                 } elseif ($row['level'] == 4) {
                                    echo 'Dapur';
                                 }
                                 ?>
                              </td>
                              <td class="px-6 py-4">
                                 <?php echo $row['no_hp'] ?>
                              </td>
                              <td class="px-6 py-4">
                                 <div class="flex gap-2">
                                    <!-- Button Lihat -->
                                    <button type="button" data-modal-target="lihat-modal-<?php echo $row['id']; ?>" data-modal-toggle="lihat-modal-<?php echo $row['id']; ?>" class="flex items-center justify-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                       <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                          <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                          <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                       </svg>
                                    </button>



                                    <!-- Button Edit -->
                                    <button type="button" data-modal-target="edit-modal-<?php echo $row['id']; ?>" data-modal-toggle="edit-modal-<?php echo $row['id']; ?>" class="flex items-center justify-center gap-2 text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">
                                       <svg class="w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 5V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5M9 3v4a1 1 0 0 1-1 1H4m11.383.772 2.745 2.746m1.215-3.906a2.089 2.089 0 0 1 0 2.953l-6.65 6.646L9 17.95l.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z" />
                                       </svg>
                                    </button>

                                    <!-- Button Delete -->
                                    <button type="button" data-modal-target="popup-modal-<?= $row['id']; ?>" data-modal-toggle="popup-modal-<?= $row['id']; ?>" class="flex items-center justify-center gap-2 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                                       <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                          viewBox="0 0 24 24">
                                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                       </svg>
                                    </button>


                                    <!-- Button password
                                    <button type="button" class="flex items-center justify-center gap-2 text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-gray-500 dark:hover:bg-gray-600 focus:outline-none dark:focus:ring-gray-800">
                                       <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd" />
                                       </svg>
                                    </button> -->

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

   <!-- Modal Tambah USer -->
   <!-- Main modal -->
   <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-md max-h-full">
         <!-- Modal content -->
         <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
               <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                  Tambah User
               </h3>
               <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
               </button>
            </div>
            <!-- Modal body dan Form -->
            <form action="proses/proses.input.php" method="POST" class="p-4 md:p-5">
               <div class="grid gap-4 mb-4 grid-cols-2">
                  <!-- Nama -->
                  <div class="col-span-2">
                     <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                     <input type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nama" required="">
                  </div>
                  <!-- Username -->
                  <div class="col-span-2">
                     <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                     <input type="email" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Username" required="">
                  </div>
                  <!-- Password -->
                  <div class="col-span-2 sm:col-span-1">
                     <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                     <input type="name" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Password" required="">
                  </div>
                  <!-- Level -->
                  <div class="col-span-2 sm:col-span-1">
                     <label for="level" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Level User</label>
                     <select name="level" id="level" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="" disabled selected hidden>Pilih Level User</option>
                        <option value="1">Owner/Admin</option>
                        <option value="2">Kasir</option>
                        <option value="3">Pelayan</option>
                        <option value="4">Dapur</option>
                     </select>
                  </div>
                  <!-- No HP -->
                  <div class="col-span-2">
                     <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NO HP</label>
                     <input type="text" name="no_hp" id="no_hp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="N HP" required="">
                  </div>
                  <!-- Alamat -->
                  <div class="col-span-2">
                     <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Alamat</label>
                     <textarea name="alamat" id="alamat" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Alamat description here"></textarea>
                  </div>
               </div>
               <!-- SUbmit -->
               <button type="submit" name="input_user_validate" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                  </svg>
                  Tambah User
               </button>
            </form>
         </div>
      </div>
   </div>

   <?php
   foreach ($result as $row) { ?>
      <!-- Modal Lihat USer -->
      <!-- Main modal -->
      <div id="lihat-modal-<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
         <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
               <!-- Modal header -->
               <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                     Lihat User
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="lihat-modal-<?php echo $row['id']; ?>">
                     <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                     </svg>
                     <span class="sr-only">Close modal</span>
                  </button>
               </div>
               <!-- Modal body dan Form -->
               <form action="proses/proses.input.php" method="POST" class="p-4 md:p-5">
                  <div class="grid gap-4 mb-4 grid-cols-2">
                     <!-- Nama -->
                     <div class="col-span-2">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                        <input disabled type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nama" required="" value="<?php echo $row['nama'] ?>">
                     </div>
                     <!-- Username -->
                     <div class="col-span-2">
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                        <input disabled type="email" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Username" required="" value="<?php echo $row['username'] ?>">
                     </div>
                     <!-- Password -->
                     <div class="col-span-2 sm:col-span-1">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input disabled type="name" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Password" required="" value="<?php echo substr($row['password'], 0, 8); ?>">
                     </div>
                     <!-- Level -->
                     <div class="col-span-2 sm:col-span-1">
                        <label for="level" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Level User</label>
                        <input disabled name="level" id="level" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           value="<?php if ($row['level'] == 1) {
                                       echo 'Admin';
                                    } elseif ($row['level'] == 2) {
                                       echo 'Kasir';
                                    } elseif ($row['level'] == 3) {
                                       echo 'Pelayan';
                                    } elseif ($row['level'] == 4) {
                                       echo 'Dapur';
                                    }
                                    ?>">
                        </input>
                     </div>
                     <!-- No HP -->
                     <div class="col-span-2">
                        <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NO HP</label>
                        <input disabled type="text" name="no_hp" id="no_hp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="N HP" required="" value="<?php echo $row['no_hp'] ?>">
                     </div>
                     <!-- Alamat -->
                     <div class="col-span-2">
                        <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Alamat</label>
                        <textarea disabled name="alamat" id="alamat" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Alamat description here"> <?php echo $row['alamat']; ?></textarea>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   <?php } ?>

   <?php
   foreach ($result as $row) { ?>
      <!-- Modal Edit USer -->
      <!-- Main modal -->
      <div id="edit-modal-<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
         <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
               <!-- Modal header -->
               <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                     Edit User
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit-modal-<?php echo $row['id']; ?>">
                     <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                     </svg>
                     <span class="sr-only">Close modal</span>
                  </button>
               </div>
               <!-- Modal body dan Form -->
               <form action="proses/proses_edit.php" method="POST" class="p-4 md:p-5">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                  <div class="grid gap-4 mb-4 grid-cols-2">
                     <!-- Nama -->
                     <div class="col-span-2">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                        <input type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nama" required="" value="<?php echo $row['nama'] ?>">
                     </div>
                     <!-- Username -->
                     <div class="col-span-2">
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                        <input type="email" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Username" required="" value="<?php echo $row['username'] ?>">
                     </div>
                     <!-- Password -->
                     <div class="col-span-2 sm:col-span-1">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password (Opsional)</label>
                        <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Biarkan kosong jika tidak ingin mengganti">
                     </div>

                     <!-- Level -->
                     <div class="col-span-2 sm:col-span-1">
                        <label for="level" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Level User</label>
                        <!-- <input name="level" id="level" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"> -->
                        <select name="level" id="level" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

                           <?php
                           $data = array("Owner/Admin", "Kasir", "Pelayan", "Dapur");
                           foreach ($data as $key => $value) {
                              $level_value = $key + 1;
                              $selected = ($row["level"] == $level_value) ? "selected" : "";
                              echo "<option value='$level_value' $selected>$value</option>";
                           }
                           ?>

                        </select>



                     </div>
                     <!-- No HP -->
                     <div class="col-span-2">
                        <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NO HP</label>
                        <input type="text" name="no_hp" id="no_hp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="N HP" required="" value="<?php echo $row['no_hp'] ?>">
                     </div>
                     <!-- Alamat -->
                     <div class="col-span-2">
                        <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Alamat</label>
                        <textarea name="alamat" id="alamat" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Alamat description here"> <?php echo $row['alamat']; ?></textarea>
                     </div>
                     <!-- SUbmit -->
                     <button type="submit" name="edit_user_validate" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                           <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Edit User
                     </button>
                  </div>

               </form>
            </div>
         </div>
      </div>
   <?php } ?>



   <?php
   foreach ($result as $row) { ?>
      <!-- modal Delete -->
      <div id="popup-modal-<?= $row['id']; ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
         <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
               <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-<?= $row['id']; ?>">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
               </button>

               <form action="proses/proses_delete.php" method="POST" class="p-4 md:p-5">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                  <div class="p-4 md:p-5 text-center">
                     <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                     </svg>

                     <!-- Validasi Tidak bisa Hapus Akun Sendiri -->
                     <?php if ($row['username'] == $_SESSION['username_dapoer']): ?>
                        <h3 class="mb-5 text-lg font-normal text-red-600 dark:text-red-400">
                           Anda tidak bisa menghapus  .
                        </h3>
                     <?php else: ?>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                           Apakah anda yakin menghapus user
                           <span class="font-bold text-black dark:text-white"><?php echo $row['nama']; ?></span>
                        </h3>
                        <button data-modal-hide="popup-modal-<?= $row['id']; ?>" name="delete_user_validate" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                           Hapus
                        </button>
                     <?php endif; ?>

                     <button data-modal-hide="popup-modal-<?= $row['id']; ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                  </div>
            </div>
         </div>
         </form>
      </div>
   <?php } ?>
</body>

</html>