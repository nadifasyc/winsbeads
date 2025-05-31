-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Bulan Mei 2025 pada 06.48
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `winsbeads`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama`) VALUES
(1, 'Fairy Bracelet'),
(2, 'Rope Bracelet'),
(3, 'Phone Strap'),
(4, 'Bag Charm'),
(10, 'Keychain Photocard');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `ketersediaan_stok` enum('habis','tersedia') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `kategori_id`, `nama`, `harga`, `foto`, `detail`, `ketersediaan_stok`) VALUES
(6, 1, 'Pink Fairy', 17000, 'wins_beads_3633521115156483820.jpg', 'Pink Fairy Bracelet adalah gelang cantik dengan perpaduan manik-manik pink pastel dan tali rajut handmade yang halus.', 'tersedia'),
(7, 1, 'Red Fairy', 17000, 'wins_beads_3633521115165076966.jpg', 'Red Fairy Bracelet adalah gelang cantik dengan perpaduan manik-manik pink pastel dan tali rajut handmade yang halus.', 'tersedia'),
(8, 1, 'Brown Fairy', 17000, 'wins_beads_3633521115164868043.jpg', 'Brown Fairy Bracelet adalah gelang cantik dengan perpaduan manik-manik pink pastel dan tali rajut handmade yang halus.', 'tersedia'),
(9, 2, 'Blue My Melody', 22000, 'wins_beads_3574810575572214388.jpg', 'Gelang handmade berwarna biru lembut, dipadukan dengan charm lucu karakter My Melody yang menggemaskan.', 'tersedia'),
(10, 2, 'Pink My Melody', 22000, 'wins_beads_3574810575589028407.jpg', 'Gelang handmade berwarna pink lembut, dipadukan dengan charm lucu karakter My Melody yang menggemaskan.', 'tersedia'),
(11, 2, 'Moana Inspired', 25000, 'wins_beads_3571082649345316327.jpg', 'Gelang cantik bertema warna Moana, memadukan manik-manik biru laut, dan aksen coklat pasir yang terinspirasi dari semangat petualang di lautan.', 'tersedia'),
(12, 3, 'Pinky Green Strap', 27000, 'wins_beads_3571074895226494630.jpg', '', 'tersedia'),
(13, 3, 'Blue Phone Strap', 25000, 'wins_beads_3571075453907881549.jpg', '', 'tersedia'),
(14, 3, 'Pinkeu Ribbon Strap', 28000, 'wins_beads_3571074431671879044.jpg', '', 'tersedia'),
(16, 4, 'Nananana', 25000, 'wins_beads_3571071212900017011.jpg', '', 'tersedia'),
(17, 10, 'Nininini', 100000, 'wins_beads_3571077166894987032.jpg', '', 'tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2a$12$l9csEpo6pbuDUH6VtUhxeOjC73utV6.NXrmpfeJtzubf24l4Anueu');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nama` (`nama`),
  ADD KEY `kategori_produk` (`kategori_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `kategori_produk` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
