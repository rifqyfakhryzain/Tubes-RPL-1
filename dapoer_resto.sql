-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Agu 2025 pada 07.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dapoer_resto`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_bayar`
--

CREATE TABLE `tabel_bayar` (
  `id_bayar` int(11) NOT NULL,
  `nominal_uang` int(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `waktu_bayar` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_daftar_menu`
--

CREATE TABLE `tabel_daftar_menu` (
  `id` int(11) NOT NULL,
  `nama_menu` varchar(30) NOT NULL,
  `keterangan` varchar(30) NOT NULL,
  `kategori` int(11) NOT NULL,
  `harga` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_daftar_menu`
--

INSERT INTO `tabel_daftar_menu` (`id`, `nama_menu`, `keterangan`, `kategori`, `harga`) VALUES
(1, 'Nasi Goreng', 'Nasi Goreng Mantap', 1, '35000'),
(2, 'Pempek Palembang', 'Pempek', 1, '25000'),
(3, 'Bakso', 'Bakso Viral', 1, '25000'),
(4, 'Gado Gado', 'Gado Gado Asli', 1, '20000'),
(5, 'Nasi Liwet Ayam', 'Ayam Tiren', 1, '40000'),
(6, 'Sate', 'Sate Maranggi', 1, '33000'),
(7, 'Soto', 'Soto Special', 1, '30000'),
(8, 'Gurame', 'Gurame Terbang', 1, '23000'),
(9, 'Mie Aceh', 'Asli', 1, '20000'),
(10, 'Rawon', 'Rawon Asli Yogyakarta', 1, '25000'),
(11, 'Kopi Hitam', 'Kopi ABC', 2, '5000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_list_order`
--

CREATE TABLE `tabel_list_order` (
  `id_list_order` int(11) NOT NULL,
  `menu` int(10) NOT NULL,
  `kode_order` int(11) NOT NULL,
  `kategori` int(11) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `catatan` varchar(30) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_order`
--

CREATE TABLE `tabel_order` (
  `id_order` int(11) NOT NULL,
  `kode_order` varchar(50) NOT NULL,
  `pelanggan` varchar(30) NOT NULL,
  `no_meja` int(11) NOT NULL,
  `pelayan` int(1) NOT NULL,
  `waktu_order` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_reservasi`
--

CREATE TABLE `tabel_reservasi` (
  `id_meja` int(11) NOT NULL,
  `no_meja` int(11) NOT NULL,
  `catatan` varchar(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_reservasi`
--

INSERT INTO `tabel_reservasi` (`id_meja`, `no_meja`, `catatan`, `status`) VALUES
(1, 1, 'Untuk 2 Orang', 0),
(2, 2, 'Untuk 2 Orang', 0),
(3, 3, 'Untuk 2 Orang', 0),
(4, 4, 'Untuk 2 Orang', 0),
(5, 5, 'Untuk 2 Orang', 0),
(6, 6, 'Untuk 2 Orang', 0),
(7, 7, 'Untuk 2 Orang', 0),
(8, 8, 'Untuk 2 Orang', 0),
(9, 9, 'Untuk 2 Orang', 0),
(10, 10, 'Untuk 2 Orang', 0),
(11, 11, 'Untuk 4 Orang', 0),
(12, 12, 'Untuk 4 Orang', 0),
(13, 13, 'Untuk 4 Orang', 0),
(14, 14, 'Untuk 4 Orang', 0),
(15, 15, 'Untuk 4 Orang', 0),
(16, 16, 'Untuk 4 Orang', 0),
(17, 17, 'Untuk 4 Orang', 0),
(18, 18, 'Untuk 4 Orang', 0),
(19, 19, 'Untuk 4 Orang', 0),
(20, 20, 'Untuk 4 Orang', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_user`
--

CREATE TABLE `tabel_user` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` int(1) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_user`
--

INSERT INTO `tabel_user` (`id`, `nama`, `username`, `password`, `level`, `no_hp`, `alamat`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$OEuSxKdq0fgPdcnXzx/1vuG.MzydUd1zQ/RW.Z72ZIbIgnXCJPGL.', 1, '081222074013', '  Bandung'),
(2, 'kasir', 'kasir@gmail.com', '$2y$10$Xz9AW6P5.6f9bA54McRm/.bqyRI9IbR1h5VsSixlVv6pXMAC562RS', 2, '081321125584', ' Majalaya'),
(3, 'pelayan', 'pelayan@gmail.com', '$2y$10$MdrJH82mSZ9p0ehqrfbSre6cinqjNjTPpEM8tM7ihv6GwhZ00IjAu', 3, '081222074013', '  Kp Bojongwaru, Majalaya, Kabupaten Bandung'),
(4, 'dapur', 'dapur@gmail.com', '$2y$10$aR5KXunRAMA3LleLL5m9EesCDzg5sZES3oJwhZINhP60ge3kcY.Qu', 4, '081222074013', ' -'),
(5, 'Rifqy', 'rifqy@dapoer.com', '$2y$10$zc3XuChRbWcNrLFR2oy22.1tVPJ/smxgA5.ZxaNIa.GLD5/2hYpfC', 1, '081222074013', '  Kp Bojongwaru');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tabel_bayar`
--
ALTER TABLE `tabel_bayar`
  ADD PRIMARY KEY (`id_bayar`);

--
-- Indeks untuk tabel `tabel_daftar_menu`
--
ALTER TABLE `tabel_daftar_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_menu` (`nama_menu`);

--
-- Indeks untuk tabel `tabel_list_order`
--
ALTER TABLE `tabel_list_order`
  ADD PRIMARY KEY (`id_list_order`),
  ADD KEY `menu` (`menu`),
  ADD KEY `order` (`kode_order`),
  ADD KEY `hayo` (`kategori`);

--
-- Indeks untuk tabel `tabel_order`
--
ALTER TABLE `tabel_order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `Pelayan` (`pelayan`),
  ADD KEY `meja` (`no_meja`);

--
-- Indeks untuk tabel `tabel_reservasi`
--
ALTER TABLE `tabel_reservasi`
  ADD PRIMARY KEY (`id_meja`);

--
-- Indeks untuk tabel `tabel_user`
--
ALTER TABLE `tabel_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tabel_daftar_menu`
--
ALTER TABLE `tabel_daftar_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tabel_list_order`
--
ALTER TABLE `tabel_list_order`
  MODIFY `id_list_order` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tabel_order`
--
ALTER TABLE `tabel_order`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tabel_reservasi`
--
ALTER TABLE `tabel_reservasi`
  MODIFY `id_meja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `tabel_user`
--
ALTER TABLE `tabel_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tabel_list_order`
--
ALTER TABLE `tabel_list_order`
  ADD CONSTRAINT `hayo` FOREIGN KEY (`kategori`) REFERENCES `tabel_daftar_menu` (`id`),
  ADD CONSTRAINT `kategori` FOREIGN KEY (`menu`) REFERENCES `tabel_daftar_menu` (`id`),
  ADD CONSTRAINT `menu` FOREIGN KEY (`menu`) REFERENCES `tabel_daftar_menu` (`id`);

--
-- Ketidakleluasaan untuk tabel `tabel_order`
--
ALTER TABLE `tabel_order`
  ADD CONSTRAINT `meja` FOREIGN KEY (`no_meja`) REFERENCES `tabel_reservasi` (`id_meja`),
  ADD CONSTRAINT `pelayan` FOREIGN KEY (`pelayan`) REFERENCES `tabel_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
