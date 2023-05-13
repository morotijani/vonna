-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2023 at 08:23 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vonna`
--

-- --------------------------------------------------------

--
-- Table structure for table `bcfa_contact`
--

CREATE TABLE `bcfa_contact` (
  `id` bigint(20) NOT NULL,
  `contact_fname` varchar(100) DEFAULT NULL,
  `contact_lname` varchar(100) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `contact_message` text DEFAULT NULL,
  `contact_date_addded` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vonna_about`
--

CREATE TABLE `vonna_about` (
  `about_id` int(11) NOT NULL,
  `about_info` text NOT NULL,
  `about_street1` varchar(250) NOT NULL,
  `about_street2` varchar(250) NOT NULL,
  `about_country` varchar(250) NOT NULL,
  `about_state` varchar(250) NOT NULL,
  `about_city` varchar(250) NOT NULL,
  `about_phone` varchar(20) NOT NULL,
  `about_email` varchar(250) NOT NULL,
  `about_phone2` varchar(20) NOT NULL,
  `about_fax` varchar(50) NOT NULL,
  `about_facebook` varchar(500) DEFAULT NULL,
  `about_twitter` varchar(500) DEFAULT NULL,
  `about_instagram` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vonna_about`
--

INSERT INTO `vonna_about` (`about_id`, `about_info`, `about_street1`, `about_street2`, `about_country`, `about_state`, `about_city`, `about_phone`, `about_email`, `about_phone2`, `about_fax`, `about_facebook`, `about_twitter`, `about_instagram`) VALUES
(1, '<p><strong>Vonna </strong>is legally registered Enterprise which serves as a vehicle to adequately distribute comfort and satisfaction to Offices and Institutions when it comes to the need for Paper. We work in conjunction with paper Mill Factories to make various sizes of paper available at factory prices. Our Company is built to handle large supplies to Institutions such as Schools, Corporation as well as Enterprises who require the use of various forms of paper <strong>products</strong>.</p>', 'sdc', '', 'ghana', 'ashanti', 'kumasi', '0205775605', 'info@vonnagh.com', '0243357486', '1231', 'https://fb', 'https://tw', 'https://ig');

-- --------------------------------------------------------

--
-- Table structure for table `vonna_admin`
--

CREATE TABLE `vonna_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_fullname` varchar(255) NOT NULL,
  `admin_email` varchar(175) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_joined_date` datetime NOT NULL DEFAULT current_timestamp(),
  `admin_last_login` datetime DEFAULT NULL,
  `admin_permissions` varchar(255) NOT NULL,
  `admin_trash` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vonna_admin`
--

INSERT INTO `vonna_admin` (`admin_id`, `admin_fullname`, `admin_email`, `admin_password`, `admin_joined_date`, `admin_last_login`, `admin_permissions`, `admin_trash`) VALUES
(1, 'alhaji babson', 'admin@vonna.com', '$2y$10$v4l2WAtHTOZfR7WAeRMWlee6IR4z8DJN.qtcBCyCA8852SOu3pOKi', '2020-02-21 21:01:31', '2023-05-13 07:58:43', 'admin,editor', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vonna_contact`
--

CREATE TABLE `vonna_contact` (
  `contact_id` int(11) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_message` text NOT NULL,
  `contact_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vonna_faq`
--

CREATE TABLE `vonna_faq` (
  `id` bigint(20) NOT NULL,
  `faq_head` varchar(500) DEFAULT NULL,
  `faq_body` text DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vonna_faq`
--

INSERT INTO `vonna_faq` (`id`, `faq_head`, `faq_body`, `createdAt`, `updatedAt`) VALUES
(1, 'What is Vonna About?', 'Vonna is legally registered Enterprise which serves as a vehicle to adequately distribute comfort and satisfaction to Offices and Institutions when it comes to the need for Paper.', '2023-05-13 05:22:15', NULL),
(2, 'Does Vonna work with any paper mill factories?', 'Yes. We work in conjunction with paper Mill Factories to make various sizes of paper available at factory prices.', '2023-05-13 05:22:43', NULL),
(3, 'Their supplies', 'Our Company is built to handle large supplies to Institutions such as Schools, Corporation as well as Enterprises who require the use of various forms of paper products.', '2023-05-13 05:23:40', NULL),
(4, 'How to make an order?', 'Create and verify account, after log into your account and start making orders.', '2023-05-13 05:23:57', NULL),
(5, 'How to purchase product?', 'After a product order, you will make payment after delivery or before delivery either cash or digital.', '2023-05-13 05:24:12', NULL),
(6, 'del', 'del me', '2023-05-13 06:19:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vonna_orders`
--

CREATE TABLE `vonna_orders` (
  `id` bigint(20) NOT NULL,
  `orders_id` varchar(300) DEFAULT NULL,
  `orders_product` varchar(100) DEFAULT NULL,
  `orders_size` varchar(100) DEFAULT NULL,
  `orders_type` varchar(10) DEFAULT NULL,
  `orders_quantity` varchar(100) DEFAULT NULL,
  `orders_color` varchar(6) NOT NULL,
  `orders_userid` int(11) DEFAULT NULL,
  `orders_orderdate` datetime DEFAULT NULL,
  `orders_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vonna_user`
--

CREATE TABLE `vonna_user` (
  `user_id` int(11) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(50) DEFAULT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_occupation` varchar(250) DEFAULT NULL,
  `user_name_of_instituition` varchar(250) DEFAULT NULL,
  `user_postal_address` varchar(100) DEFAULT NULL,
  `user_physical_address` varchar(100) DEFAULT NULL,
  `user_size_of_instituition` varchar(100) NOT NULL,
  `user_country` varchar(255) DEFAULT NULL,
  `user_state` varchar(225) DEFAULT NULL,
  `user_city` varchar(225) DEFAULT NULL,
  `user_verified` tinyint(1) NOT NULL DEFAULT 0,
  `user_vericode` varchar(50) NOT NULL,
  `user_joined_date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_last_login` datetime DEFAULT NULL,
  `user_trash` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vonna_user_password_resets`
--

CREATE TABLE `vonna_user_password_resets` (
  `password_reset_id` int(11) NOT NULL,
  `password_reset_created_at` datetime DEFAULT NULL,
  `password_reset_user_id` int(11) NOT NULL,
  `password_reset_verify` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bcfa_contact`
--
ALTER TABLE `bcfa_contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_fname` (`contact_fname`),
  ADD KEY `contact_lname` (`contact_lname`),
  ADD KEY `contact_email` (`contact_email`),
  ADD KEY `contact_phone` (`contact_phone`),
  ADD KEY `contact_date_addded` (`contact_date_addded`);

--
-- Indexes for table `vonna_about`
--
ALTER TABLE `vonna_about`
  ADD PRIMARY KEY (`about_id`);

--
-- Indexes for table `vonna_admin`
--
ALTER TABLE `vonna_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `vonna_contact`
--
ALTER TABLE `vonna_contact`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `contact_firstname` (`contact_name`),
  ADD KEY `contact_email` (`contact_email`),
  ADD KEY `contact_date` (`contact_date`);

--
-- Indexes for table `vonna_faq`
--
ALTER TABLE `vonna_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vonna_orders`
--
ALTER TABLE `vonna_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_plainpaper_userid` (`orders_userid`),
  ADD KEY `order_plainpaper_orderdate` (`orders_orderdate`),
  ADD KEY `order_plainpaper_status` (`orders_status`),
  ADD KEY `order_plainpaper_size` (`orders_size`),
  ADD KEY `order_plainpaper_type` (`orders_type`),
  ADD KEY `orders_id` (`orders_id`);

--
-- Indexes for table `vonna_user`
--
ALTER TABLE `vonna_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_country` (`user_country`),
  ADD KEY `user_state` (`user_state`),
  ADD KEY `user_trash` (`user_trash`),
  ADD KEY `user_fullname` (`user_fullname`),
  ADD KEY `user_email` (`user_email`),
  ADD KEY `user_city` (`user_city`) USING BTREE,
  ADD KEY `occupation` (`user_occupation`),
  ADD KEY `postal_address` (`user_postal_address`),
  ADD KEY `name_of_instituition` (`user_name_of_instituition`),
  ADD KEY `physical_address` (`user_physical_address`),
  ADD KEY `user_verified` (`user_verified`),
  ADD KEY `user_phone` (`user_phone`);

--
-- Indexes for table `vonna_user_password_resets`
--
ALTER TABLE `vonna_user_password_resets`
  ADD PRIMARY KEY (`password_reset_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bcfa_contact`
--
ALTER TABLE `bcfa_contact`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vonna_about`
--
ALTER TABLE `vonna_about`
  MODIFY `about_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vonna_admin`
--
ALTER TABLE `vonna_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vonna_contact`
--
ALTER TABLE `vonna_contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vonna_faq`
--
ALTER TABLE `vonna_faq`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vonna_orders`
--
ALTER TABLE `vonna_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vonna_user`
--
ALTER TABLE `vonna_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vonna_user_password_resets`
--
ALTER TABLE `vonna_user_password_resets`
  MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
