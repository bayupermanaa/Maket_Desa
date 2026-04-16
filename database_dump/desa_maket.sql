-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2026 at 09:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `desa_maket`
--

-- --------------------------------------------------------

--
-- Table structure for table `aparatur_desas`
--

CREATE TABLE `aparatur_desas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aparatur_desas`
--

INSERT INTO `aparatur_desas` (`id`, `nama`, `jabatan`, `foto`, `deskripsi`, `urutan`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Wikana', 'Sekdes', 'aparatur-desa/HP6uBOYTrYuFLvHXza2rRnZMLmS8DbjnyQaCxdNT.png', 'maju jaya selalu desa sejatera', 1, 1, '2026-04-14 22:33:48', '2026-04-14 22:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `artikels`
--

CREATE TABLE `artikels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artikels`
--

INSERT INTO `artikels` (`id`, `judul`, `slug`, `isi`, `gambar`, `is_published`, `created_at`, `updated_at`) VALUES
(1, 'Menagih Rasa Malu: Solusi Sengkarut Sampah di Bali', 'menagih-rasa-malu-solusi-sengkarut-sampah-di-bali', 'GUNUNGAN tumpukan sampah terbungkus kantong plastik yang menebar bau tak sedap telah menjadi pemandangan lumrah bagi warga Kota Denpasar dan Badung, Bali. Termasuk di sejumlah primadona kawasan pariwisata seperti Kuta dan Canggu. Tumpukan sampah bercampur bau menyengat akibat lama tak terangkut truk sampah itu bukan hanya mudah ditemukan di rumah-rumah warga, tetapi juga di sela trotoar, tanah kosong, bahkan telah memenuhi sejumlah selokan dan sungai. Tumpukan sampah di selokan dan sungai itu menyebabkan tersumbatnya saluran air, yang menjadi salah satu penyebab banjir beberapa waktu lalu di Denpasar, Kuta, dan sejumlah kawasan lainnya. Fenomena ini adalah kontras ironi antara citra Bali sebagai Pulau Dewata yang dipamerkan sebagai pulau tropis dengan pemandangan eksotis berbalut suasana budaya yang magis bagi pelancong dari seluruh dunia.\r\n\r\nSumber: https://nasional.kompas.com/read/2026/04/13/17030081/menagih-rasa-malu--solusi-sengkarut-sampah-di-bali?page=all.\r\n\r\nEditor : Ferril Dennys\r\n\r\nMembership: https://kmp.im/plus6\r\nDownload aplikasi: https://kmp.im/app6', 'artikel/XByyxAmIwyqVZVWaz97psZ4XYsD6e0mRl7APh2Ht.jpg', 1, '2026-04-15 19:43:19', '2026-04-15 19:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_08_175804_create_personal_access_tokens_table', 1),
(5, '2026_03_28_073412_add_role_and_nik_to_users_table', 1),
(6, '2026_04_02_185516_create_pengajuan_surats_table', 1),
(7, '2026_04_03_042357_create_settings_desa_table', 1),
(8, '2026_04_03_112403_add_video_profil_to_settings_desa_table', 1),
(9, '2026_04_03_134429_add_video_to_settings_desa', 1),
(10, '2026_04_11_025930_create_penduduks_table', 1),
(11, '2026_04_11_092455_create_aparatur_desas_table', 1),
(12, '2026_04_12_083936_add_kepala_desa_foto_to_settings_desa_table', 1),
(13, '2026_04_12_084241_fix_duplicate_columns_settings_desa', 1),
(14, '2026_04_13_051112_add_dashboard_fields_to_settings_desa_table', 1),
(15, '2026_04_15_115409_create_artikels_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penduduks`
--

CREATE TABLE `penduduks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rw` varchar(10) NOT NULL,
  `rt` varchar(10) NOT NULL,
  `dusun` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kode_keluarga` varchar(50) NOT NULL,
  `nama_kepala_keluarga` varchar(100) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `hubungan` varchar(50) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `usia` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `gol_darah` varchar(5) DEFAULT NULL,
  `kewarganegaraan` varchar(50) DEFAULT NULL,
  `suku` varchar(50) DEFAULT NULL,
  `pendidikan` varchar(50) DEFAULT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_surats`
--

CREATE TABLE `pengajuan_surats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `jenis_surat` varchar(255) NOT NULL,
  `keperluan` text NOT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `status` enum('Menunggu','Diproses','Disetujui','Ditolak') NOT NULL DEFAULT 'Menunggu',
  `keterangan` text DEFAULT NULL,
  `file_lampiran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('JPYKhkfzENjRC7vGjPCtloUDk546dqO7wLDQkWHj', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUFBWZEgxdENRaWpDVEFzYkV4eXRIRWVMbVpGdWNDRDhsc2NOeWhDdCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo0OiJyb2xlIjtzOjEwOiJhZG1pbl9kZXNhIjtzOjk6InVzZXJfbmFtZSI7czo1OiJhZG1pbiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Rhc2hib2FyZCI7fX0=', 1776311814);

-- --------------------------------------------------------

--
-- Table structure for table `settings_desa`
--

CREATE TABLE `settings_desa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_desa` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `kabupaten` varchar(255) DEFAULT NULL,
  `provinsi` varchar(255) DEFAULT NULL,
  `luas_wilayah` varchar(255) DEFAULT NULL,
  `kepadatan` varchar(255) DEFAULT NULL,
  `jumlah_penduduk` int(11) DEFAULT NULL,
  `video_profil` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `video_desa` varchar(255) DEFAULT NULL,
  `kepala_desa_foto` varchar(255) DEFAULT NULL,
  `nama_kepala_desa` varchar(255) DEFAULT NULL,
  `foto_kepala_desa` varchar(255) DEFAULT NULL,
  `jumlah_banjar` int(11) NOT NULL DEFAULT 0,
  `penduduk_baru_tahun_ini` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings_desa`
--

INSERT INTO `settings_desa` (`id`, `nama_desa`, `kecamatan`, `kabupaten`, `provinsi`, `luas_wilayah`, `kepadatan`, `jumlah_penduduk`, `video_profil`, `created_at`, `updated_at`, `video_desa`, `kepala_desa_foto`, `nama_kepala_desa`, `foto_kepala_desa`, `jumlah_banjar`, `penduduk_baru_tahun_ini`) VALUES
(1, 'Maket Desa', 'Blahbatuh', 'Gianyar', 'Bali', '12 km²', '284 jiwa/km²', 6720, NULL, '2026-04-12 00:51:34', '2026-04-15 04:12:07', 'https://www.youtube.com/embed/raxZ7QMI4Eg?si=JTeJF8RIEtR_RluF', 'kepala_desa/0N9NxWK8Ouqx9qjuGXigNZwkcNJU3Mm8eq8MJD72.png', 'I Ketut Sumarda', 'kepala_desa/rJLio9qppLTtNUhdazioC9yH6dH3nuZ35vttPW20.png', 7, 16);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'masyarakat',
  `nik` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aparatur_desas`
--
ALTER TABLE `aparatur_desas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artikels`
--
ALTER TABLE `artikels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `artikels_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penduduks`
--
ALTER TABLE `penduduks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengajuan_surats`
--
ALTER TABLE `pengajuan_surats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings_desa`
--
ALTER TABLE `settings_desa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nik_unique` (`nik`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_role_index` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aparatur_desas`
--
ALTER TABLE `aparatur_desas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `artikels`
--
ALTER TABLE `artikels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `penduduks`
--
ALTER TABLE `penduduks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan_surats`
--
ALTER TABLE `pengajuan_surats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings_desa`
--
ALTER TABLE `settings_desa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
