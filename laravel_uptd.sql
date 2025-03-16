-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 07, 2024 at 09:13 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_uptd`
--

-- --------------------------------------------------------

--
-- Table structure for table `kabupaten`
--

CREATE TABLE `kabupaten` (
  `id` int(11) NOT NULL,
  `nama_kabupaten` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kabupaten`
--

INSERT INTO `kabupaten` (`id`, `nama_kabupaten`, `created_at`, `updated_at`) VALUES
(1, 'Dairi', '2024-12-05 02:53:47', '2024-12-05 02:53:47');

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL,
  `kabupaten_id` int(11) NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `kabupaten_id`, `nama_kecamatan`, `created_at`, `updated_at`) VALUES
(1, 1, 'Berampu', '2024-12-05 08:23:19', '2024-12-05 08:23:19'),
(2, 1, 'Gunung Sitember', '2024-12-05 08:23:27', '2024-12-05 08:23:27'),
(3, 1, 'Lae Parira', '2024-12-05 08:23:35', '2024-12-05 08:23:35'),
(4, 1, 'Parbuluan', '2024-12-05 08:23:42', '2024-12-05 08:23:42'),
(5, 1, 'Pegagan Hilir', '2024-12-05 08:23:48', '2024-12-05 08:23:48'),
(6, 1, 'Sidikalang', '2024-12-05 08:23:55', '2024-12-05 08:23:55');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `petugas_id` int(11) NOT NULL,
  `wilayah_kerja_id` int(11) NOT NULL,
  `tanaman_id` int(11) NOT NULL,
  `opt_id` int(11) NOT NULL,
  `luas_terserang` decimal(10,2) DEFAULT NULL,
  `tingkat_kerusakan` enum('ringan','sedang','berat','puso') DEFAULT NULL,
  `tanggal_laporan` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `petugas_id`, `wilayah_kerja_id`, `tanaman_id`, `opt_id`, `luas_terserang`, `tingkat_kerusakan`, `tanggal_laporan`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '0.20', 'ringan', '2024-12-07', NULL, '2024-12-07 01:02:13', '2024-12-07 01:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `opt`
--

CREATE TABLE `opt` (
  `id` int(11) NOT NULL,
  `nama_opt` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `opt`
--

INSERT INTO `opt` (`id`, `nama_opt`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Layu Bakteri', 'Penyakit layu bakteri dapat ditemukan pada berbagai Jenis temu- temuan lainnya, seperti temu mangga, temu putih, jahe, kunyit, kencur, temulawak, bangle, lempuyang, terung-terungan seperti tomat, terung, kentang, cabai, tembakau serta tanaman lainnya seperti nilam dan kacang tanah. Dengan gejala yang khasnya yakni daun menguning dan menggulung, dimulai dari daun yang lebih tua kemudian diikuti daun yang lebih muda, selanjutnya sampai semua helai daun kuning dan akhirnya mati. Pada bagian pangkal batang terlihat gejala cekung basah dan garis-garis hitam atau abu-abu sepanjang batang. Kalau potongan pangkal batang atau rimpang dipijit dengan tangan akan mengeluarkan lendim berwarna putih seperti air susu.', '2024-12-06 23:37:16', '2024-12-06 23:37:16'),
(2, 'Busuk Umbi', 'Penyakit busuk umbi pada tanaman jahe yang disebabkan oleh Pythium sp. Sering menimbulkan kerusakan yang fatal. Gejala berawal dengan mengeringnya daun-daun, sedang pangkal batang dan umbi membusuk. Penyakit umumnya terdapat pada tanaman yang telah berumur 3 bulan atau lebih. Pengendalian penyakit busuk umbi Pythium dapat dilakukan dengan pergiliran tanaman serta eradikasi tanaman sakit.', '2024-12-06 23:37:35', '2024-12-06 23:37:35');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id` int(11) NOT NULL,
  `kabupaten_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `wilayah_kerja_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `kabupaten_id`, `user_id`, `wilayah_kerja_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '2024-12-05 10:59:04', '2024-12-05 08:29:35');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tanaman`
--

CREATE TABLE `tanaman` (
  `id` int(11) NOT NULL,
  `nama_tanaman` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tanaman`
--

INSERT INTO `tanaman` (`id`, `nama_tanaman`, `created_at`, `updated_at`) VALUES
(1, 'Jahe', '2024-12-06 23:27:44', '2024-12-06 23:27:44'),
(2, 'Kunyit', '2024-12-06 23:27:55', '2024-12-06 23:27:55'),
(3, 'Kencur', '2024-12-06 23:28:07', '2024-12-06 23:28:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('Administrator','Admin Provinsi','Kordinator Kabupaten','Petugas Lapangan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Petugas Lapangan',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kabupaten_id` int(11) NOT NULL DEFAULT 0,
  `faces` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `level`, `remember_token`, `last_login`, `kabupaten_id`, `faces`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$.zyv.mN4ewS36HGJcBDXWua88yylf2MwZRK3603IZfRfoNZhJEvHy', 'Admin Provinsi', NULL, '2024-12-06 23:09:48', 0, 'default.png', '2024-10-20 08:44:16', '2024-12-06 23:09:48'),
(2, 'Muhammad Edi', 'm_edi@gmail.com', '$2y$10$.zyv.mN4ewS36HGJcBDXWua88yylf2MwZRK3603IZfRfoNZhJEvHy', 'Petugas Lapangan', NULL, '2024-12-07 00:31:09', 1, 'default.png', '2024-10-20 08:44:16', '2024-12-07 00:31:09'),
(3, 'Kordinator', 'kordinator@gmail.com', '$2y$10$.zyv.mN4ewS36HGJcBDXWua88yylf2MwZRK3603IZfRfoNZhJEvHy', 'Kordinator Kabupaten', NULL, '2024-12-07 00:07:04', 1, 'default.png', '2024-10-20 08:44:16', '2024-12-07 00:07:04');

-- --------------------------------------------------------

--
-- Table structure for table `verifikasi`
--

CREATE TABLE `verifikasi` (
  `id` int(11) NOT NULL,
  `laporan_id` int(11) NOT NULL,
  `verifikator_id` int(11) NOT NULL,
  `status` enum('diterima','ditolak','menunggu') DEFAULT 'menunggu',
  `catatan` text DEFAULT NULL,
  `tanggal_verifikasi` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wilayah_kerja`
--

CREATE TABLE `wilayah_kerja` (
  `id` int(11) NOT NULL,
  `kecamatan_id` int(11) NOT NULL,
  `nama_daerah` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wilayah_kerja`
--

INSERT INTO `wilayah_kerja` (`id`, `kecamatan_id`, `nama_daerah`, `created_at`, `updated_at`) VALUES
(1, 6, 'Sidiangkat', '2024-12-05 08:25:13', '2024-12-05 08:25:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kabupaten`
--
ALTER TABLE `kabupaten`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kabupaten_id` (`kabupaten_id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opt`
--
ALTER TABLE `opt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tanaman`
--
ALTER TABLE `tanaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verifikasi`
--
ALTER TABLE `verifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wilayah_kerja`
--
ALTER TABLE `wilayah_kerja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kecamatan_id` (`kecamatan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kabupaten`
--
ALTER TABLE `kabupaten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `opt`
--
ALTER TABLE `opt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tanaman`
--
ALTER TABLE `tanaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `verifikasi`
--
ALTER TABLE `verifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wilayah_kerja`
--
ALTER TABLE `wilayah_kerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD CONSTRAINT `kecamatan_ibfk_1` FOREIGN KEY (`kabupaten_id`) REFERENCES `kabupaten` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wilayah_kerja`
--
ALTER TABLE `wilayah_kerja`
  ADD CONSTRAINT `wilayah_kerja_ibfk_1` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
