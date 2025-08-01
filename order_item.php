<?php
session_start();
if (empty($_SESSION['username_dapoer'])) {
    header('Location: login.php');
    exit();
}

include 'proses/connect.php';

$username = $_SESSION['username_dapoer'];

// Data untuk header.php
$query_user = mysqli_query($conn, "SELECT * FROM tabel_user WHERE username = '$username'");
$hasil = mysqli_fetch_assoc($query_user);

// Ambil ID order dari GET parameter
$id_order = isset($_GET['id_order']) ? intval($_GET['id_order']) : 0;

$menu_result = [];
$query_menu = mysqli_query($conn, "SELECT id, nama_menu FROM tabel_daftar_menu");

while ($row = mysqli_fetch_assoc($query_menu)) {
    $menu_result[] = $row;
}

$result = [];
$kode = '';
$meja = '';
$pelanggan = '';

if ($id_order > 0) {
    // Ambil informasi order (kode_order, meja, pelanggan)
    $q_info = mysqli_query($conn, "SELECT kode_order, meja, pelanggan FROM tabel_order WHERE id_order = $id_order");
    if ($info = mysqli_fetch_assoc($q_info)) {
        $kode = $info['kode_order'];
        $meja = $info['meja'];
        $pelanggan = $info['pelanggan'];
    }

    // Ambil detail list order + menu
    $query = mysqli_query($conn, "
        SELECT *, SUM(harga * jumlah) AS harganya 
        FROM tabel_order
        LEFT JOIN tabel_list_order ON tabel_list_order.kode_order = tabel_order.id_order
        LEFT JOIN tabel_daftar_menu ON tabel_daftar_menu.id = tabel_list_order.menu
        WHERE tabel_order.id_order = $id_order
        GROUP BY id_list_order
    ");

    while ($record = mysqli_fetch_assoc($query)) {
        $result[] = $record;
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

    <main class="flex-grow pt-16 p-4 sm:ml-64">
        <!-- Card Full -->
        <div class="w-[95%] mx-auto mt-10">
            <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-lg p-10 space-y-6">

                <!-- Judul About -->
                <h3 class="text-1xl font-bold text-grey-900 dark:text-white">Halaman Order Item</h3>

                <!-- Konten -->
                <div class="relative overflow-x-auto">
                    <div class="flex gap-4 mb-5">
                        <!-- Button Lihat -->
                        <a href="order.php">
                            <button type="button"
                                class="flex items-center justify-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
                                </svg>

                            </button>
                        </a>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 mb-5">
                        <!-- Input Kode Order -->
                        <div class="relative w-[200px]">
                            <input type="text" disabled name="kode_order" id="kode_order"
                                class="peer block w-full appearance-none rounded-lg border border-gray-300 bg-gray-50 px-2.5 pt-8 pb-2.5 text-sm text-gray-900 focus:border-blue-600 focus:outline-none focus:ring-0 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                                placeholder=" " value="<?php echo $kode; ?>" />
                            <label for="kode_order"
                                class="absolute left-2.5 top-2 z-10 origin-[0] scale-75 transform text-xl text-gray-500 duration-300 peer-placeholder-shown:translate-y-2.5 peer-placeholder-shown:scale-100 peer-focus:top-2 peer-focus:scale-75 peer-focus:text-blue-600 dark:text-gray-400 dark:peer-focus:text-blue-500">
                                Kode Order
                            </label>
                        </div>

                        <!-- Input Nomor Meja -->
                        <div class="relative w-[200px]">
                            <input type="text" disabled name="nomor_meja" id="nomor_meja"
                                class="peer block w-full appearance-none rounded-lg border border-gray-300 bg-gray-50 px-2.5 pt-8 pb-2.5 text-sm text-gray-900 focus:border-blue-600 focus:outline-none focus:ring-0 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                                placeholder=" " value="<?php echo $meja; ?>" />
                            <label for="nomor_meja"
                                class="absolute left-2.5 top-2 z-10 origin-[0] scale-75 transform text-xl text-gray-500 duration-300 peer-placeholder-shown:translate-y-2.5 peer-placeholder-shown:scale-100 peer-focus:top-2 peer-focus:scale-75 peer-focus:text-blue-600 dark:text-gray-400 dark:peer-focus:text-blue-500">
                                Meja
                            </label>
                        </div>
                        <!-- Input Nama Pelanggan -->
                        <div class="relative w-[200px]">
                            <input type="text" disabled name="nomor_meja" id="nomor_meja"
                                class="peer block w-full appearance-none rounded-lg border border-gray-300 bg-gray-50 px-2.5 pt-8 pb-2.5 text-sm text-gray-900 focus:border-blue-600 focus:outline-none focus:ring-0 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                                placeholder=" " value="<?php echo $pelanggan; ?>" />
                            <label for="nomor_meja"
                                class="absolute left-2.5 top-2 z-10 origin-[0] scale-75 transform text-xl text-gray-500 duration-300 peer-placeholder-shown:translate-y-2.5 peer-placeholder-shown:scale-100 peer-focus:top-2 peer-focus:scale-75 peer-focus:text-blue-600 dark:text-gray-400 dark:peer-focus:text-blue-500">
                                Pelanggan
                            </label>
                        </div>
                    </div>

                    <!-- Validasi Jika data menu tidak ada -->
                    <?php
                    if (empty($result)) {
                        echo "Data Menu tidak ada";
                    } else {



                    ?>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <!-- Menu -->
                                    <th scope="col" class="px-6 py-3">
                                        Menu
                                    </th>
                                    <!-- Harga -->
                                    <th scope="col" class="px-6 py-3">
                                        Harga
                                    </th>
                                    <!-- Jumlah Pesanan -->
                                    <th scope="col" class="px-6 py-3">
                                        Jumlah Pesanan
                                    </th>
                                    <!-- Catatan -->
                                    <th scope="col" class="px-6 py-3">
                                        Catatan
                                    </th>
                                    <!-- Total -->
                                    <th scope="col" class="px-6 py-3">
                                        Total
                                    </th>
                                    <!-- Aksi -->
                                    <th scope="col" class="px-6 py-3">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $total = 0;
                                foreach ($result as $row) {
                                ?>


                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <!-- Nama Menu -->
                                        <td class="px-6 py-4">
                                            <?php echo $row['nama_menu'] ?>
                                        </td>
                                        <!-- Harga -->
                                        <td class="px-6 py-4">
                                            <?php echo number_format($row['harga'], 0, ',', '.') ?>
                                        </td>
                                        <!-- Jumlah Pesanan -->
                                        <td class="px-6 py-4">
                                            <?php echo $row['jumlah'] ?>
                                        </td>
                                        <!-- Catatan -->
                                        <td class="px-6 py-4">
                                            <?php echo $row['catatan'] ?>
                                        </td>
                                        <!-- Total Harga -->
                                        <td class="px-6 py-4">
                                            <?php echo number_format($row['harganya'], 0, ',', '.') ?>
                                        </td>
                                        <!-- Aksi -->
                                        <td class="px-6 py-4">
                                            <div class="flex gap-2">
                                                <!-- Button Edit -->
                                                <button type="button" data-modal-target="edit-modal-<?php echo $row['id_list_order']; ?>" data-modal-toggle="edit-modal-<?php echo $row['id_list_order']; ?>" class="flex items-center justify-center gap-2 text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">
                                                    <svg class="w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 5V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5M9 3v4a1 1 0 0 1-1 1H4m11.383.772 2.745 2.746m1.215-3.906a2.089 2.089 0 0 1 0 2.953l-6.65 6.646L9 17.95l.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z" />
                                                    </svg>
                                                </button>

                                                <!-- Button Delete -->
                                                <button type="button" data-modal-target="popup-modal-<?= $row['id_list_order']; ?>" data-modal-toggle="popup-modal-<?= $row['id_list_order']; ?>" class="flex items-center justify-center gap-2 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                                                    <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                    </svg>
                                                </button>
                                            </div>


                                        </td>


                                    </tr>
                                <?php
                                    $total += $row['harganya'];
                                } ?>
                                <!-- Total Harga -->
                                <td class="px-6 py-4" colspan="4">
                                    <b>Total Harga</b>
                                </td>
                                <!-- Total Harga -->
                                <td class="px-6 py-4 font-bold">
                                    <?php echo number_format($total, 0, ',', '.') ?>
                                </td>
                            </tbody>
                        </table>
                        <div class="w-full flex justify-start sm:justify-end">
                            <!-- Button Tambah Item -->
                            <button type="button" data-modal-target="item-modal" data-modal-toggle="item-modal"
                                class="flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-4 py-2 mb-5 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 whitespace-nowrap">
                                <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                                </svg>
                                Item
                            </button>
                            <!-- Button Bayar Item -->
                            <button type="button" data-modal-target="bayar-modal" data-modal-toggle="bayar-modal"
                                class="flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-4 py-2 mb-5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 whitespace-nowrap">
                                <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                                </svg>
                                Bayar
                            </button>


                        </div>

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

    <!-- Modal Tambah Item -->
    <!-- Main modal -->
    <?php
    foreach ($result as $row) { ?>
        <div id="item-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Tambah Item
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="item-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body dan Form -->
                    <form action="proses/proses_input_order_item.php" method="POST" class="p-4 md:p-5">
                        <input type="hidden" name="kode_order" value="<?php echo $id_order; ?>">
                        <input type="hidden" name="meja" value="<?php echo $meja ?>">
                        <input type="hidden" name="pelanggan" value="<?php echo $pelanggan ?>">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <!-- Nama Menu-->
                            <div class="col-span-2">
                                <select name="menu" id="menu" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="" disabled selected hidden>Pilih Menu</option>
                                    <?php foreach ($menu_result as $row): ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['nama_menu'] ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                            <!-- Jumlah Porsi -->
                            <div class="col-span-2">
                                <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Porsi</label>
                                <input type="text" name="jumlah" id="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Jumlah Porsi" required="">
                            </div>
                            <!-- catatan -->
                            <div class="col-span-2">
                                <label for="catatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                                <input type="text" name="catatan" id="catatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Catatan" required="">
                            </div>
                        </div>
                        <!-- SUbmit -->
                        <button type="submit" name="input_order_item_validate" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Tambah Item
                        </button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    <?php } ?>

    <!-- Modal Bayar Item -->
    <!-- Main modal -->
    <?php
    foreach ($result as $row) { ?>
        <div id="bayar-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-4xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Pembayaran
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="bayar-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>



                    <!-- Modal Body  Form -->
                    <form action="proses/proses_input_order_item.php" method="POST" class="p-4 md:p-5">
                        <!-- Hidden input -->
                        <input type="hidden" name="kode_order" value="<?php echo $id_order; ?>">
                        <input type="hidden" name="meja" value="<?php echo $meja ?>">
                        <input type="hidden" name="pelanggan" value="<?php echo $pelanggan ?>">

                        <!-- Table wrapper -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                                    <tr>
                                        <th class="px-4 py-3 border-b">Menu</th>
                                        <th class="px-4 py-3 border-b">Harga</th>
                                        <th class="px-4 py-3 border-b">Jumlah</th>
                                        <th class="px-4 py-3 border-b">Catatan</th>
                                        <th class="px-4 py-3 border-b">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0;
                                    foreach ($result as $row) {
                                        $total += $row['harganya'];
                                    ?>
                                        <tr class="bg-white dark:bg-gray-800 border-b">
                                            <td class="px-4 py-3"><?php echo $row['nama_menu']; ?></td>
                                            <td class="px-4 py-3"><?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                            <td class="px-4 py-3"><?php echo $row['jumlah']; ?></td>
                                            <td class="px-4 py-3"><?php echo $row['catatan']; ?></td>
                                            <td class="px-4 py-3"><?php echo number_format($row['harganya'], 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr class="bg-gray-100 dark:bg-gray-800 font-semibold">
                                        <td colspan="4" class="px-4 py-3 text-right">Total Harga</td>
                                        <td class="px-4 py-3"><?php echo number_format($total, 0, ',', '.'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Input Nominal Uang -->
                        <div class="mt-4">
                            <label for="jumlah" class="block mb-2 text-2xl font-medium text-gray-900 dark:text-white"> Nominal Uang</label>
                            <div class="flex items-center">
                                <span class="text-3xl font-bold mr-2 dark:text-white">Rp.</span>
                                <input type="text" name="jumlah" id="jumlah" placeholder="Nominal Uang"
                                    class="w-full md:w-[200px] p-2.5 text-2xl text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="mt-6 flex justify-end">
                            <button type="submit" name="input_order_item_validate"
                                class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 11 0 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 11 0-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Bayar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>



    <?php
    foreach ($result as $row) { ?>
        <!-- Modal Edit Item -->
        <!-- Main modal -->
        <div id="edit-modal-<?php echo $row['id_list_order']; ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Edit Order
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit-modal-<?php echo $row['id_list_order']; ?>">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body dan Form -->
                    <form action="proses/proses_edit_order_item.php" method="POST" class="p-4 md:p-5">
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
                        <button type="submit" name="edit_order_item_validate" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Edit Item
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>



    <?php
    foreach ($result as $row) { ?>
        <!-- modal Delete -->
        <div id="popup-modal-<?= $row['id_list_order']; ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-<?= $row['id_list_order']; ?>">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>

                    <form action="proses/proses_delete_order_item.php" method="POST" class="p-4 md:p-5">
                        <input type="hidden" name="id" value="<?php echo $row['id_list_order']; ?>">
                        <input type="hidden" name="kode_order" value="<?php echo $id_order; ?>">

                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-1 text-lg font-normal text-gray-500 dark:text-gray-400">
                                Apakah anda yakin menghapus order
                            </h3>
                            <h3 class="mb-1 text-xl font-normal text-gray-500 dark:text-gray-400">
                                <span class="font-bold text-black dark:text-white">Menu : <?php echo $row['nama_menu']; ?></span>
                            </h3>
                            <h3 class="mb-5 text-xl font-normal text-gray-500 dark:text-gray-400">
                                <span class="font-bold text-black dark:text-white">Jumlah : <?php echo $row['jumlah']; ?></span>
                            </h3>
                            <button data-modal-hide="popup-modal-<?= $row['id_list_order']; ?>" name="delete_order_item_validate" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Hapus
                            </button>
                            <button data-modal-hide="popup-modal-<?= $row['id_list_order']; ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                        </div>
                </div>
            </div>
            </form>
        </div>
    <?php } ?>
</body>

</html>