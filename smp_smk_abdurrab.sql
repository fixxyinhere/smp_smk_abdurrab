-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2025 at 06:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smp_smk_abdurrab`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Elektronik', 'Peralatan elektronik seperti komputer, proyektor, dll', '2025-07-09 21:03:47', '2025-07-09 21:03:47'),
(2, 'Furniture', 'Meja, kursi, lemari, dll', '2025-07-09 21:03:47', '2025-07-09 21:03:47'),
(3, 'Alat Tulis', 'Pulpen, kertas, spidol, dll', '2025-07-09 21:03:47', '2025-07-09 21:03:47'),
(4, 'Olahraga', 'Alat-alat olahraga', '2025-07-09 21:03:47', '2025-07-09 21:03:47'),
(5, 'Laboratorium', 'Peralatan laboratorium', '2025-07-09 21:03:47', '2025-07-09 21:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `damage_reports`
--

CREATE TABLE `damage_reports` (
  `id` int(11) NOT NULL,
  `report_number` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `damage_type` enum('rusak_ringan','rusak_berat','hilang','lainnya') NOT NULL,
  `damage_description` text NOT NULL,
  `damage_location` varchar(255) DEFAULT NULL,
  `incident_date` date NOT NULL,
  `report_date` date NOT NULL,
  `quantity_damaged` int(11) DEFAULT 1,
  `estimated_cost` decimal(15,2) DEFAULT 0.00,
  `status` enum('pending','verified','approved','rejected','fixed','replaced') DEFAULT 'pending',
  `verified_by` int(11) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `priority` enum('low','medium','high','urgent') DEFAULT 'medium',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `damage_reports`
--

INSERT INTO `damage_reports` (`id`, `report_number`, `user_id`, `item_id`, `damage_type`, `damage_description`, `damage_location`, `incident_date`, `report_date`, `quantity_damaged`, `estimated_cost`, `status`, `verified_by`, `verified_at`, `admin_notes`, `image_path`, `priority`, `created_at`, `updated_at`) VALUES
(1, 'DMG0001', 3, 1, 'rusak_berat', 'Laptop tidak bisa menyala, mungkin kerusakan motherboard', 'Lab Komputer', '2025-07-09', '2025-07-10', 1, 0.00, 'pending', NULL, NULL, NULL, NULL, 'high', '2025-07-10 11:53:54', '2025-07-10 11:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `condition_status` enum('baik','rusak','hilang') DEFAULT 'baik',
  `location` varchar(255) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `price` decimal(15,2) DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `code`, `name`, `category_id`, `description`, `quantity`, `condition_status`, `location`, `purchase_date`, `price`, `image`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'BRG0001', 'Laptop Asus X441BA', 1, 'Laptop untuk keperluan administrasi', 2, 'baik', 'Ruang TU', '2023-01-15', 4500000.00, '1752097174_35ecbfa08f3401d5b91a.jpg', 1, '2025-07-09 21:03:47', '2025-07-11 03:10:42'),
(2, 'BRG0002', 'Proyektor Epson EB-X41', 1, 'Proyektor untuk presentasi', 3, 'baik', 'Ruang Multimedia', '2023-02-10', 3200000.00, NULL, 1, '2025-07-09 21:03:47', '2025-07-11 00:40:55'),
(3, 'BRG0003', 'Meja Guru', 2, 'Meja kayu untuk guru', 20, 'baik', 'Ruang Kelas', '2023-01-20', 750000.00, NULL, 1, '2025-07-09 21:03:47', '2025-07-11 00:40:55'),
(4, 'BRG0004', 'Kursi Siswa', 2, 'Kursi plastik untuk siswa', 100, 'baik', 'Ruang Kelas', '2023-01-25', 150000.00, NULL, 1, '2025-07-09 21:03:47', '2025-07-10 22:04:01'),
(5, 'BRG0005', 'Bola Sepak', 4, 'Bola sepak untuk olahraga', 10, 'baik', 'Gudang Olahraga', '2023-03-01', 200000.00, NULL, 1, '2025-07-09 21:03:47', '2025-07-09 21:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `loan_number` varchar(50) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `actual_return_date` date DEFAULT NULL,
  `status` enum('active','returned','overdue') DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `loan_number`, `request_id`, `user_id`, `loan_date`, `return_date`, `actual_return_date`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(4, 'LOAN0001', 11, 3, '2025-07-11', '2025-07-13', '2025-07-11', 'returned', '', '2025-07-10 21:57:17', '2025-07-11 00:38:04'),
(5, 'LOAN0002', 19, 3, '2025-07-11', '2025-07-13', '2025-07-11', 'returned', 'Silahkan di ambil', '2025-07-10 22:00:57', '2025-07-10 22:04:01'),
(6, 'LOAN0003', 20, 3, '2025-07-11', '2025-07-12', '2025-07-11', 'returned', 'Silahkan di ambil pada bagian SARPRAS', '2025-07-11 00:38:55', '2025-07-11 00:40:55'),
(7, 'LOAN0004', 21, 3, '2025-07-11', '2025-07-13', NULL, 'active', '2 hari', '2025-07-11 03:10:42', '2025-07-11 03:10:42');

-- --------------------------------------------------------

--
-- Table structure for table `loan_items`
--

CREATE TABLE `loan_items` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `condition_before` text DEFAULT NULL,
  `condition_after` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_items`
--

INSERT INTO `loan_items` (`id`, `loan_id`, `item_id`, `quantity`, `condition_before`, `condition_after`, `notes`, `created_at`, `updated_at`) VALUES
(4, 4, 1, 1, 'baik', 'baik', 'Test item untuk debugging', '2025-07-10 21:57:17', '2025-07-11 00:38:04'),
(5, 5, 2, 1, 'baik', 'baik', 'Izin', '2025-07-10 22:00:57', '2025-07-10 22:04:01'),
(6, 5, 4, 10, 'baik', 'baik', 'Izin', '2025-07-10 22:00:57', '2025-07-10 22:04:01'),
(7, 6, 2, 3, 'baik', 'baik', '', '2025-07-11 00:38:55', '2025-07-11 00:40:55'),
(8, 6, 3, 1, 'baik', 'baik', '', '2025-07-11 00:38:55', '2025-07-11 00:40:55'),
(9, 7, 1, 3, 'baik', NULL, 'hai hai hai', '2025-07-11 03:10:42', '2025-07-11 03:10:42');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `request_number` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_date` date NOT NULL,
  `purpose` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `request_number`, `user_id`, `request_date`, `purpose`, `status`, `approved_by`, `approved_at`, `notes`, `created_at`, `updated_at`) VALUES
(11, 'REQ2268', 3, '2025-07-10', 'Test permintaan untuk debugging sistem', 'approved', 1, '2025-07-10 00:42:14', '', '2025-07-10 07:41:09', '2025-07-10 00:42:14'),
(19, 'REQ2269', 3, '2025-07-11', 'saya ingin meminjam untuk keperluan praktikum siswa di laboratorium', 'approved', 1, '2025-07-10 22:00:05', 'Silahkan diambil di ruang sarpras', '2025-07-10 21:54:58', '2025-07-10 22:00:05'),
(20, 'REQ2270', 3, '2025-07-11', 'Saya butuh proyektor dan meja guru untuk diruang kelas XI A', 'approved', 1, '2025-07-11 00:38:27', 'Oke silahkan', '2025-07-11 00:37:24', '2025-07-11 00:38:27'),
(21, 'REQ2271', 3, '2025-07-11', 'untuk praktikum', 'approved', 1, '2025-07-11 03:10:13', 'oke, silahkan', '2025-07-11 03:09:40', '2025-07-11 03:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `request_items`
--

CREATE TABLE `request_items` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_items`
--

INSERT INTO `request_items` (`id`, `request_id`, `item_id`, `quantity`, `notes`, `created_at`, `updated_at`) VALUES
(3, 11, 1, 1, 'Test item untuk debugging', '2025-07-10 07:41:09', '2025-07-10 08:11:50'),
(9, 19, 2, 1, 'Izin', '2025-07-10 21:54:58', '2025-07-10 21:54:58'),
(10, 19, 4, 10, 'Izin', '2025-07-10 21:54:58', '2025-07-10 21:54:58'),
(11, 20, 2, 3, '', '2025-07-11 00:37:24', '2025-07-11 00:37:24'),
(12, 20, 3, 1, '', '2025-07-11 00:37:24', '2025-07-11 00:37:24'),
(13, 21, 1, 3, 'hai hai hai', '2025-07-11 03:09:40', '2025-07-11 03:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','kepsek','user') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `phone`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@smkabdurrab.com', '081234567890', 'admin', 'active', '2025-07-09 21:03:47', '2025-07-11 06:14:51'),
(2, 'kepsek', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Kepala Sekolah', 'kepsek@smkabdurrab.com', '081234567891', 'kepsek', 'active', '2025-07-09 21:03:47', '2025-07-11 06:14:51'),
(3, 'user', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'User Demo', 'user@smkabdurrab.com', '081234567892', 'user', 'active', '2025-07-09 21:03:47', '2025-07-11 06:14:51'),
(4, 'hafis', '$2y$10$vRrSYkCW3ruOBM7XlLhCye0VxLW84GBKLr2ElT/vm6d5gPYkNZ3/y', 'M Hafis', 'mhafis383@gmail.com', '088271209442', 'admin', 'active', '2025-07-09 14:47:09', '2025-07-11 06:15:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_reports`
--
ALTER TABLE `damage_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `report_number` (`report_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `verified_by` (`verified_by`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loan_number` (`loan_number`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `loan_items`
--
ALTER TABLE `loan_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_id` (`loan_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `request_number` (`request_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `request_items`
--
ALTER TABLE `request_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `damage_reports`
--
ALTER TABLE `damage_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `loan_items`
--
ALTER TABLE `loan_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `request_items`
--
ALTER TABLE `request_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `damage_reports`
--
ALTER TABLE `damage_reports`
  ADD CONSTRAINT `damage_reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `damage_reports_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `damage_reports_ibfk_3` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_items`
--
ALTER TABLE `loan_items`
  ADD CONSTRAINT `loan_items_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loan_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `request_items`
--
ALTER TABLE `request_items`
  ADD CONSTRAINT `request_items_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
