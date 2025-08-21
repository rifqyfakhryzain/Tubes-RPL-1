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

$query = mysqli_query($conn, "
SELECT 
    tabel_order.kode_order, 
    tabel_order.no_meja, 
    tabel_order.pelanggan,
    tabel_order.waktu_order,
    tabel_list_order.id_list_order,
    tabel_list_order.menu,
    tabel_list_order.jumlah, 
    tabel_list_order.catatan, 
    tabel_list_order.status, 
    tabel_daftar_menu.nama_menu
FROM tabel_order
LEFT JOIN tabel_list_order 
    ON tabel_order.id_order = tabel_list_order.kode_order
LEFT JOIN tabel_daftar_menu 
    ON tabel_list_order.menu = tabel_daftar_menu.id
ORDER BY tabel_order.waktu_order DESC
");

$result = [];
while ($row = mysqli_fetch_assoc($query)) {
    $result[] = $row;
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

    <!-- Css Mobile -->
   <link rel="stylesheet" href="asset/css/mobile.css">

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
                <h3 class="text-1xl font-bold text-grey-900 dark:text-white">Halaman Order Item</h3>

                <!-- Konten -->
                <div class="relative overflow-x-auto">
                    <!-- Validasi Jika data menu tidak ada -->
                    <?php
                    if (empty($result)) {
                        echo "<p class='text-red-500'>Data Menu tidak ada</p>";
                    } else {
                    ?>
                        <table id="search-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <!-- No -->
                                    <th scope="col" class="px-6 py-3">
                                        No
                                    </th>
                                    <!-- Kode Order -->
                                    <th scope="col" class="px-6 py-3">
                                        Kode Order
                                    </th>
                                    <!-- Waktu Order -->
                                    <th scope="col" class="px-6 py-3">
                                        Waktu Order
                                    </th>
                                    <!-- Menu -->
                                    <th scope="col" class="px-6 py-3">
                                        Menu
                                    </th>
                                    <!-- Jumlah -->
                                    <th scope="col" class="px-6 py-3">
                                        Jumlah
                                    </th>
                                    <!-- Catatan -->
                                    <th scope="col" class="px-6 py-3">
                                        Catatan
                                    </th>
                                    <!-- Status -->
                                    <th scope="col" class="px-6 py-3">
                                        Ststus
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
                                    // if ($row['id_list_order'] == 0) continue;
                                ?>


                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <!-- No -->
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
                                        <!-- Nama Menu -->
                                        <td class="px-6 py-4">
                                            <?php echo $row['nama_menu'] ?>
                                        </td>
                                        <!-- Jumlah -->
                                        <td class="px-6 py-4">
                                            <?php echo $row['jumlah'] ?>
                                        </td>
                                        <!-- Catatan -->
                                        <td class="px-6 py-4">
                                            <?php echo $row['catatan'] ?>
                                        </td>
                                        <!-- Status -->
                                        <td class="px-6 py-4">
                                            <?php
                                            if ($row['status'] == 0) {
                                                echo '<span class="inline-block min-w-[130px] text-center px-3 py-1 text-sm font-semibold text-white bg-green-600 rounded-full whitespace-nowrap">
                                                Belum Masuk Ke Dapur
                                                </span>';
                                            } elseif ($row['status'] == 1) {
                                                echo '<span class="inline-block min-w-[130px] text-center px-3 py-1 text-sm font-semibold text-white bg-yellow-500 rounded-full whitespace-nowrap">
                                                Masuk ke Dapur
                                                </span>';
                                            } elseif ($row['status'] == 2) {
                                                echo '<span class="inline-block min-w-[130px] text-center px-3 py-1 text-sm font-semibold text-white bg-blue-500 rounded-full whitespace-nowrap">
                                                Siap DiSajikan
                                                </span>';
                                            }
                                            ?>
                                        </td>
                                        </td>
                                        <!-- Aksi -->

                                        <td class="px-6 py-4">
                                            <div class="flex gap-2">
                                                <?php
                                                $status = $row['status'];
                                                ?>

                                                <!-- Cek Jumlah dan nama menu -->
                                                <?php
                                                $status = $row['status'];
                                                $jumlah = intval($row['jumlah']); // konversi ke integer

                                                // Disable tombol jika status = 2 (Siap Disajikan)
                                                if ($status == 2) {
                                                    $disableTerima = 'disabled';
                                                    $disableSaji = 'disabled';
                                                    $kelasTerima = 'text-white bg-gray-400 cursor-not-allowed';
                                                    $kelasSaji = 'text-white bg-gray-400 cursor-not-allowed';
                                                } else {
                                                    $disableTerima = ($status == 1 || $jumlah == 0) ? 'disabled' : '';
                                                    $disableSaji   = ($status == 0 || $jumlah == 0) ? 'disabled' : '';

                                                    $kelasTerima = ($status == 0 && $jumlah > 0)
                                                        ? 'text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 focus:outline-none'
                                                        : 'text-white bg-gray-400 cursor-not-allowed';

                                                    $kelasSaji = ($status == 1 && $jumlah > 0)
                                                        ? 'text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 focus:outline-none'
                                                        : 'text-white bg-gray-400 cursor-not-allowed';
                                                }
                                                ?>

                                                <!-- Tombol TERIMA -->
                                                <button type="button"
                                                    data-modal-target="terima-modal-<?php echo $row['id_list_order']; ?>"
                                                    data-modal-toggle="terima-modal-<?php echo $row['id_list_order']; ?>"
                                                    class="flex items-center justify-center gap-2 font-medium rounded-lg text-sm px-4 py-2 <?php echo $kelasTerima; ?>"
                                                    <?php echo $disableTerima; ?>>
                                                    Terima
                                                </button>

                                                <!-- Tombol SIAP SAJI -->
                                                <button type="button"
                                                    data-modal-target="siapsaji-modal-<?php echo $row['id_list_order']; ?>"
                                                    data-modal-toggle="siapsaji-modal-<?php echo $row['id_list_order']; ?>"
                                                    class="flex items-center justify-center gap-2 font-medium rounded-lg text-sm px-4 py-2 <?php echo $kelasSaji; ?>"
                                                    <?php echo $disableSaji; ?>>
                                                    Siap Saji
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                        <!-- Tampilan Mobile Js -->
                        <script src="asset/js/mobile.js"></script>
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

        <!-- Modal terima Item -->
        <!-- Main modal -->
        <div id="terima-modal-<?php echo $row['id_list_order']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Dapur
                        </h3>

                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="terima-modal-<?php echo $row['id_list_order']; ?>">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body dan Form -->
                    <form action="proses/proses_terima_order_item.php" method="POST" class="p-4 md:p-5">
                        <input type="hidden" name="id" value="<?php echo $row['id_list_order'] ?>">
                        <input type="hidden" name="kode_order" value="<?php echo $id_order; ?>">
                        <input type="hidden" name="meja" value="<?php echo $meja ?>">
                        <input type="hidden" name="pelanggan" value="<?php echo $pelanggan ?>">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <!-- Nama Menu-->
                            <div class="col-span-2">
                                <select name="menu" id="menu" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="" disabled selected hidden>Pilih Menu</option>
                                    <?php $menu_terpilih = $row['menu']; ?>

                                    <?php foreach ($menu_result as $menuRow): ?>
                                        <option value="<?= $menuRow['id'] ?>" <?= ($menuRow['id'] == $menu_terpilih) ? 'selected' : '' ?>>
                                            <?= $menuRow['nama_menu'] ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <!-- Jumlah Porsi -->
                            <div class="col-span-2">
                                <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Porsi</label>
                                <input type="text" name="jumlah" id="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Jumlah Porsi" required="" value="<?php echo $row['jumlah'] ?>">
                            </div>
                            <!-- catatan -->
                            <div class="col-span-2">
                                <label for="catatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                                <input type="text" name="catatan" id="catatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Catatan" required="" value="<?php echo $row['catatan'] ?>">
                            </div>
                        </div>
                        <!-- SUbmit -->
                        <button type="submit" name="terima_order_item_validate" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Terima
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php
    foreach ($result as $row) { ?>

        <!-- Modal Siap Saji -->
        <!-- Main modal -->
        <div id="siapsaji-modal-<?php echo $row['id_list_order']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Dapur
                        </h3>

                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="siapsaji-modal-<?php echo $row['id_list_order']; ?>">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body dan Form -->
                    <form action="proses/proses_siapsaji_order_item.php" method="POST" class="p-4 md:p-5">
                        <input type="hidden" name="id" value="<?php echo $row['id_list_order'] ?>">
                        <input type="hidden" name="kode_order" value="<?php echo $id_order; ?>">
                        <input type="hidden" name="meja" value="<?php echo $meja ?>">
                        <input type="hidden" name="pelanggan" value="<?php echo $pelanggan ?>">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <!-- Nama Menu-->
                            <div class="col-span-2">
                                <select name="menu" id="menu" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="" disabled selected hidden>Pilih Menu</option>
                                    <?php $menu_terpilih = $row['menu']; ?>

                                    <?php foreach ($menu_result as $menuRow): ?>
                                        <option value="<?= $menuRow['id'] ?>" <?= ($menuRow['id'] == $menu_terpilih) ? 'selected' : '' ?>>
                                            <?= $menuRow['nama_menu'] ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <!-- Jumlah Porsi -->
                            <div class="col-span-2">
                                <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Porsi</label>
                                <input type="text" name="jumlah" id="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Jumlah Porsi" required="" value="<?php echo $row['jumlah'] ?>">
                            </div>
                            <!-- catatan -->
                            <div class="col-span-2">
                                <label for="catatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                                <input type="text" name="catatan" id="catatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Catatan" required="" value="<?php echo $row['catatan'] ?>">
                            </div>
                        </div>
                        <!-- SUbmit -->
                        <button type="submit" name="siapsaji_order_item_validate" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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