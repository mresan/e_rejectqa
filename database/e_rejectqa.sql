-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 04:44 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_rejectqa`
--

-- --------------------------------------------------------

--
-- Table structure for table `departemen_list`
--

CREATE TABLE `departemen_list` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `name1` varchar(30) NOT NULL,
  `name2` varchar(30) NOT NULL,
  `name3` varchar(30) NOT NULL,
  `name4` varchar(30) NOT NULL,
  `email` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT ' 0 = Inactive, 1 = Active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departemen_list`
--

INSERT INTO `departemen_list` (`id`, `name`, `name1`, `name2`, `name3`, `name4`, `email`, `status`, `date_created`) VALUES
(3, 'PRODUKSI', 'Novi Lestari', 'Hari Setiawan', 'M. Ammar', 'Jaka Soeryanto', 'produksi_sdi@shindengen.co.id', 1, '2024-01-29 09:07:05'),
(6, 'SALES', 'Adrian Faisal', 'Kelik Pitoyo', 'M. Ammar', 'Jaka Soeryanto', 'sales_sdi@shindengen.co.id', 1, '2024-02-12 09:04:05'),
(7, 'PC RMWH', 'Omin Setiawan', 'Dicki Ari Jumanto', 'M. Ammar', 'Jaka Soeryanto', '-', 1, '2024-03-06 11:25:45'),
(8, 'PC FGWH', 'Nandang Rukmana', 'Dicki Ari Jumanto', 'M. Ammar', 'Jaka Soeryanto', '-', 1, '2024-03-06 11:26:40');

-- --------------------------------------------------------

--
-- Table structure for table `item_list`
--

CREATE TABLE `item_list` (
  `id` int(5) NOT NULL,
  `no_item` varchar(10) NOT NULL,
  `name_item` varchar(50) NOT NULL,
  `code_item` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT ' 1 = Active, 0 = Inactive',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `reject_id` int(30) NOT NULL,
  `item_id` int(30) NOT NULL,
  `type_item` varchar(15) NOT NULL,
  `no_lot` varchar(15) NOT NULL,
  `qty` float NOT NULL,
  `factor_mt` varchar(5) NOT NULL,
  `ket` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reject_list`
--

CREATE TABLE `reject_list` (
  `id` int(30) NOT NULL,
  `reject_no` varchar(100) NOT NULL,
  `departemen_id` int(30) NOT NULL,
  `notes` text NOT NULL,
  `status1` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Pending, 1 = Approved, 2 = Denied',
  `status2` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Pending, 1 = Approved, 2 = Denied',
  `status3` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Pending, 1 = Approved, 2 = Denied',
  `status0` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = OPEN, 1 = CLOSE',
  `date_created3` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'E-Reject'),
(6, 'short_name', 'Quality Assurance'),
(11, 'logo', 'uploads/1709706420_logo.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/1711072080_Untitled.jpg'),
(15, 'company_name', 'PT. Shindengen Indonesia'),
(16, 'company_email', '-'),
(17, 'company_address', 'Kawasan Greenland Industrial City (GIIC) Blok AD 02 Deltamas, Nagasari, Serang Baru, Kabupaten Bekasi 17330'),
(18, 'logmas', 'uploads/1709101320_logomas.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(5, 'Aan', 'Nasrulloh', 'anas', '827ccb0eea8a706c4c34a16891f84e7b', 'uploads/1709772480_admin.png', NULL, 1, '2024-02-12 10:35:42', '2024-03-07 07:48:41'),
(6, 'User', 'Produksi', 'user-prod', 'e4bf869ba3e57d9b7ce6ef1c61e6560b', 'uploads/1709706540_pic prod.png', NULL, 2, '2024-02-12 10:37:53', '2024-03-06 13:29:05'),
(10, 'Pimpinan', 'Produksi', 'pimp-prod', 'c9fa5d5b9750ea03fe5391c3770ff5cc', 'uploads/1709706480_pimp prod.png', NULL, 3, '2024-02-13 12:02:19', '2024-03-06 13:28:06'),
(11, 'User', 'QA', 'user-qa', '901e4b84326943040109004b2a222e4d', 'uploads/1709706540_pic qa.png', NULL, 4, '2024-02-13 13:53:10', '2024-03-06 13:29:17'),
(12, 'Pimpinan', 'QA', 'pimp-qa', '55986d4552a994d14d6081bfc921d7ca', 'uploads/1709706480_pimp qa.png', NULL, 5, '2024-02-13 13:57:26', '2024-03-06 13:28:16'),
(13, 'User', 'Sales', 'user-sales', '4201334aa9e1e186fe19b5799714c39f', 'uploads/1709706720_pic sales.png', NULL, 2, '2024-03-01 11:53:32', '2024-03-06 13:32:42'),
(14, 'Pimpinan', 'Sales', 'pimp-sales', '1a5fd64c077e0abdeae49d9538e997f0', 'uploads/1709706720_pimp sales.png', NULL, 3, '2024-03-01 13:07:16', '2024-03-06 13:32:32'),
(15, 'User', 'PC', 'user-pc', '073899a27af29239f555240b9c563ae1', 'uploads/1709706480_pic pc.png', NULL, 2, '2024-03-06 11:37:06', '2024-03-06 13:28:40'),
(16, 'Pimpinan', 'PC', 'pimp-pc', '234d1e254c4e6c50bc0121298691e4f5', 'uploads/1709706420_PIMP PC.png', NULL, 3, '2024-03-06 11:41:24', '2024-03-06 13:27:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departemen_list`
--
ALTER TABLE `departemen_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_list`
--
ALTER TABLE `item_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD KEY `part_no` (`item_id`) USING BTREE,
  ADD KEY `reject_id` (`reject_id`) USING BTREE;

--
-- Indexes for table `reject_list`
--
ALTER TABLE `reject_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departemen_id` (`departemen_id`) USING BTREE;

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departemen_list`
--
ALTER TABLE `departemen_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `item_list`
--
ALTER TABLE `item_list`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131127;

--
-- AUTO_INCREMENT for table `reject_list`
--
ALTER TABLE `reject_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`reject_id`) REFERENCES `reject_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reject_list`
--
ALTER TABLE `reject_list`
  ADD CONSTRAINT `reject_list_ibfk_1` FOREIGN KEY (`departemen_id`) REFERENCES `departemen_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
