-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2023 at 09:59 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodie_fizz`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `address` text NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `added_on` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `address`, `customer_id`, `added_on`) VALUES
(11, 'check#33, Check nagri, Karachi.', '4', '2023-05-30 16:51:04'),
(14, 'House#11 (near choti market), Block#11, Area#37-B, Noor Manzil, Landhi#1, Karachi.', '6', '2023-06-01 04:23:40'),
(15, 'Practice Landhi, Karachi.', '2', '2023-06-02 05:27:23'),
(16, '48 check, Karachi.', '3', '2023-06-02 05:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `admin_panel_credential`
--

CREATE TABLE `admin_panel_credential` (
  `id` int(11) NOT NULL,
  `email` varchar(500) NOT NULL,
  `general_password` varchar(1000) NOT NULL,
  `supervisor_password` varchar(1000) NOT NULL,
  `code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_panel_credential`
--

INSERT INTO `admin_panel_credential` (`id`, `email`, `general_password`, `supervisor_password`, `code`) VALUES
(1, 'azam78454@gmail.com', '$2y$10$XCtdA1.ky5k2RTu6WMvVIO7DQPJ9NQVCUn78jlJKx/XwaGTAOHqNS', '$2y$10$V9mWr/DUNxNdR4ZOlKKHNu5QxRLIpsrvz7m23SNFS.FqzgTCP7vLi', 'zO3Nn44MaFdf21THQE54K6BCSJva2py0qCrsmBRVnbAJSpp77J');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` varchar(80) NOT NULL,
  `item_id` varchar(80) NOT NULL,
  `quantity` varchar(80) NOT NULL,
  `added_on` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `status` varchar(100) NOT NULL,
  `added_on` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `image_path`, `status`, `added_on`) VALUES
(8, 'wded', 'src/dynamic/categories_image/wded@13_13_30-2023_04_29.png', 'active', '2023-04-29 13:13:30'),
(10, 'Pizza', 'src/dynamic/categories_image/Pizza@13_13_50-2023_04_29.jpg', 'active', '2023-04-29 13:13:50'),
(11, 'Broast', 'src/dynamic/categories_image/Broast@13_29_46-2023_04_29.jpg', 'disabled', '2023-04-29 13:29:46'),
(13, 'Roll', 'src/dynamic/categories_image/Roll@16_31_48-2023_04_29.jpg', 'active', '2023-04-29 16:31:48'),
(15, 'Burger', 'src/dynamic/categories_image/Burger@03_39_06-2023_05_01.jpg', 'active', '2023-05-01 03:39:06'),
(16, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_26-2023_05_02.jpg', 'active', '2023-05-02 03:37:26'),
(17, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_29-2023_05_02.jpg', 'active', '2023-05-02 03:37:29'),
(18, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_30-2023_05_02.jpg', 'active', '2023-05-02 03:37:30'),
(19, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_31-2023_05_02.jpg', 'active', '2023-05-02 03:37:31'),
(20, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_31-2023_05_02.jpg', 'active', '2023-05-02 03:37:31'),
(21, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_32-2023_05_02.jpg', 'active', '2023-05-02 03:37:32'),
(22, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_33-2023_05_02.jpg', 'active', '2023-05-02 03:37:33'),
(23, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_33-2023_05_02.jpg', 'active', '2023-05-02 03:37:33'),
(24, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_34-2023_05_02.jpg', 'active', '2023-05-02 03:37:34'),
(25, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_34-2023_05_02.jpg', 'active', '2023-05-02 03:37:34'),
(26, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_34-2023_05_02.jpg', 'active', '2023-05-02 03:37:34'),
(27, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_35-2023_05_02.jpg', 'active', '2023-05-02 03:37:35'),
(28, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_35-2023_05_02.jpg', 'active', '2023-05-02 03:37:35'),
(29, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_36-2023_05_02.jpg', 'active', '2023-05-02 03:37:36'),
(30, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_36-2023_05_02.jpg', 'active', '2023-05-02 03:37:36'),
(31, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_36-2023_05_02.jpg', 'active', '2023-05-02 03:37:36'),
(32, 'Sandwich', 'src/dynamic/categories_image/Sandwich@03_37_37-2023_05_02.jpg', 'active', '2023-05-02 03:37:37'),
(33, 'Pasta', 'src/dynamic/categories_image/Pasta@03_39_50-2023_05_02.png', 'active', '2023-05-02 03:39:50'),
(34, 'Pasta', 'src/dynamic/categories_image/Pasta@03_39_52-2023_05_02.png', 'active', '2023-05-02 03:39:52'),
(35, 'Pasta', 'src/dynamic/categories_image/Pasta@03_39_53-2023_05_02.png', 'active', '2023-05-02 03:39:53'),
(36, 'Pasta', 'src/dynamic/categories_image/Pasta@03_39_53-2023_05_02.png', 'active', '2023-05-02 03:39:53'),
(37, 'Pasta', 'src/dynamic/categories_image/Pasta@03_39_54-2023_05_02.png', 'active', '2023-05-02 03:39:54'),
(38, 'Pasta', 'src/dynamic/categories_image/Pasta@03_39_54-2023_05_02.png', 'active', '2023-05-02 03:39:54'),
(39, 'Pasta', 'src/dynamic/categories_image/Pasta@03_39_54-2023_05_02.png', 'active', '2023-05-02 03:39:54'),
(40, 'Pasta', 'src/dynamic/categories_image/Pasta@03_39_54-2023_05_02.png', 'active', '2023-05-02 03:39:54'),
(41, 'Pasta', 'src/dynamic/categories_image/Pasta@03_39_55-2023_05_02.png', 'active', '2023-05-02 03:39:55'),
(42, 'Pasta', 'src/dynamic/categories_image/Pasta@03_39_55-2023_05_02.png', 'active', '2023-05-02 03:39:55'),
(43, 'Other', 'src/dynamic/categories_image/Pizza@13_13_50-2023_04_29.jpg', 'disabled', '2023-05-02 03:39:55'),
(44, 'Pasta', 'src/dynamic/categories_image/Pasta@03_39_56-2023_05_02.png', 'active', '2023-05-02 03:39:56'),
(45, 'Pasta', 'src/dynamic/categories_image/Pasta@03_39_56-2023_05_02.png', 'active', '2023-05-02 03:39:56'),
(46, 'Pasta', 'src/dynamic/categories_image/Pasta@03_39_56-2023_05_02.png', 'active', '2023-05-02 03:39:56'),
(47, 'Pasta', 'src/dynamic/categories_image/Pasta@03_40_58-2023_05_02.png', 'active', '2023-05-02 03:40:58'),
(48, 'Pasta', 'src/dynamic/categories_image/Pasta@03_41_00-2023_05_02.png', 'active', '2023-05-02 03:41:00'),
(49, 'Pasta', 'src/dynamic/categories_image/Pasta@03_41_01-2023_05_02.png', 'active', '2023-05-02 03:41:01'),
(50, 'Pasta', 'src/dynamic/categories_image/Pasta@03_41_02-2023_05_02.png', 'active', '2023-05-02 03:41:02'),
(51, 'Pasta', 'src/dynamic/categories_image/Pasta@03_41_02-2023_05_02.png', 'active', '2023-05-02 03:41:02'),
(52, 'Pasta', 'src/dynamic/categories_image/Pasta@03_41_03-2023_05_02.png', 'active', '2023-05-02 03:41:03'),
(53, 'Pasta', 'src/dynamic/categories_image/Pasta@03_41_30-2023_05_02.png', 'active', '2023-05-02 03:41:30'),
(54, 'Pasta', 'src/dynamic/categories_image/Pasta@03_41_31-2023_05_02.png', 'active', '2023-05-02 03:41:31'),
(55, 'Pasta', 'src/dynamic/categories_image/Pasta@03_41_31-2023_05_02.png', 'active', '2023-05-02 03:41:31'),
(56, 'Pasta', 'src/dynamic/categories_image/Pasta@03_41_32-2023_05_02.png', 'active', '2023-05-02 03:41:32'),
(57, 'Newest', 'src/dynamic/categories_image/Newest@02_48_06-2023_05_03.png', 'active', '2023-05-03 02:48:06');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(300) NOT NULL,
  `mobile_no` varchar(300) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL,
  `code` varchar(500) NOT NULL,
  `registered_on` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`, `mobile_no`, `password`, `status`, `code`, `registered_on`) VALUES
(2, 'Azam Practice', 'practice78454@gmail.com', '03332332332', '$2y$10$dkMj/EBRQTGhr0tm0SN74e23k9z8Pb09fRNUbEhQgQt/1WvDrMOAO', 'active', '', '2023-05-30 16:38:10'),
(3, 'Azam 48', 'azam484848@gmail.com', '03343424178', '$2y$10$tCYg8Jri.m3awztuzUAz3.PomvuC1NSXX/7M0gz/pXbELCAMvqrbm', 'active', '', '2023-05-30 16:40:20'),
(4, 'Owais', 'owais78454@gmail.com', '03108995544', '$2y$10$H1VRtKc.hnd/6v3R/JuuS.wcBs7waTqGWLJyziUPxCUiemfThqR4W', 'active', '', '2023-05-30 16:41:24'),
(5, 'Delicious', 'vdelicious428@gmail.com', '03332332332', '$2y$10$YNhG79gw6BmnVxTzolitCemUF3tUwDHgKViTyheJoGKwXJKRYtjRO', 'active', '', '2023-05-30 16:44:18'),
(6, 'Muhammad Azam', 'azam78454@gmail.com', '03101120402', '$2y$10$i4D1QIZslPs9FRbPEWRTyOZGMrEnbUmdhrNLky8zb4gIgBsJpe4Gq', 'active', '', '2023-05-31 01:20:04');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` varchar(80) NOT NULL,
  `cutted_item_price` varchar(100) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `category_id` varchar(50) NOT NULL,
  `number_of_order` varchar(50) NOT NULL,
  `status` varchar(80) NOT NULL,
  `added_on` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `item_price`, `cutted_item_price`, `image_path`, `category_id`, `number_of_order`, `status`, `added_on`) VALUES
(1, 'Beef Burger', '500', '0', 'src/dynamic/items_image/Beef Burger@04_02_21-2023_05_01.jpg', '15', '43', 'active', '2023-05-01 04:02:21'),
(3, 'Mayo Roll', '250', '0', 'src/dynamic/items_image/Mayo Roll@04_14_30-2023_05_01.jpg', '13', '28', 'active', '2023-05-01 04:14:30'),
(4, 'Zinger Burger', '200', '0', 'src/dynamic/items_image/Zinger Burger@04_59_17-2023_05_01.png', '15', '87', 'active', '2023-05-01 04:59:17'),
(5, 'Cheese Burger', '300', '0', 'src/dynamic/items_image/Cheese Burger@03_44_02-2023_05_03.jpg', '15', '13', 'active', '2023-05-03 03:44:02'),
(6, 'Zinger Burger', '500', '600', 'src/dynamic/items_image/Zinger Burger@03_44_34-2023_05_03.jpg', '57', '48', 'active', '2023-05-03 03:44:34'),
(8, 'check', '23232', '11111', 'src/dynamic/items_image/check@22_03_09-2023_05_28.jpg', '57', '4', 'active', '2023-05-28 22:03:09'),
(9, 'Malai boti Roll', '250', '0', 'src/dynamic/items_image/Malai boti Roll@16_52_22-2023_05_30.jpg', '13', '2', 'active', '2023-05-30 16:52:22');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_items`
--

CREATE TABLE `ordered_items` (
  `id` int(11) NOT NULL,
  `item_id` varchar(50) NOT NULL,
  `quantity` varchar(20) NOT NULL,
  `order_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ordered_items`
--

INSERT INTO `ordered_items` (`id`, `item_id`, `quantity`, `order_id`) VALUES
(1, '6', '3', '1'),
(2, '8', '1', '1'),
(6, '6', '3', '2'),
(7, '3', '3', '3'),
(8, '5', '3', '3'),
(9, '1', '1', '3');

-- --------------------------------------------------------

--
-- Table structure for table `order_heads`
--

CREATE TABLE `order_heads` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `customer_id` varchar(70) NOT NULL,
  `customer_name` varchar(300) NOT NULL,
  `customer_email` varchar(500) NOT NULL,
  `customer_phone_no` varchar(80) NOT NULL,
  `promo_code_id` varchar(70) NOT NULL,
  `status` varchar(255) NOT NULL,
  `added_on` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_heads`
--

INSERT INTO `order_heads` (`id`, `payment_method`, `address`, `customer_id`, `customer_name`, `customer_email`, `customer_phone_no`, `promo_code_id`, `status`, `added_on`) VALUES
(1, 'Cash on Delivery', 'check#33, Check nagri, Karachi.', '4', 'Owais', 'owais78454@gmail.com', '03108995544', '', 'delivered', '2023-05-30 16:53:45'),
(2, 'Cash on Delivery', 'House#11 (near choti market), Block#11, Area#37-B, Noor Manzil, Landhi#1, Karachi.', '6', 'Muhammad Azam', 'azam78454@gmail.com', '03101120402', '', 'delivered', '2023-06-01 04:23:52'),
(3, 'Cash on Delivery', 'House#11 (near choti market), Block#11, Area#37-B, Noor Manzil, Landhi#1, Karachi.', '6', 'Muhammad Azam', 'azam78454@gmail.com', '03101120402', '7', 'removed', '2023-06-01 04:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `promo_code`
--

CREATE TABLE `promo_code` (
  `id` int(11) NOT NULL,
  `promo_code` varchar(255) NOT NULL,
  `discount` varchar(80) NOT NULL,
  `discount_mode` varchar(100) NOT NULL,
  `minimum_amount` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `added_on` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promo_code`
--

INSERT INTO `promo_code` (`id`, `promo_code`, `discount`, `discount_mode`, `minimum_amount`, `status`, `added_on`) VALUES
(1, 'vv', '900', 'In Rupees (PKR)', '2000', 'active', '2023-05-07 05:15:45'),
(5, 'sa', '12', 'In Rupees (PKR)', '2000', 'disabled', '2023-05-26 23:15:47'),
(6, 'w', '23', 'In Percentage (%)', '2000', 'active', '2023-05-26 23:15:59'),
(7, 'qq', '2', 'In Rupees (PKR)', '1000', 'active', '2023-05-27 00:03:46'),
(8, 's', '23', 'In Percentage (%)', '3000', 'active', '2023-05-27 00:03:52'),
(9, 'b', '20', 'In Percentage (%)', '2000', 'active', '2023-05-27 17:35:12'),
(10, 'qqqqq', '22', 'In Percentage (%)', '2222', 'active', '2023-05-28 17:45:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_panel_credential`
--
ALTER TABLE `admin_panel_credential`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `ordered_items`
--
ALTER TABLE `ordered_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_heads`
--
ALTER TABLE `order_heads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promo_code`
--
ALTER TABLE `promo_code`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `admin_panel_credential`
--
ALTER TABLE `admin_panel_credential`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ordered_items`
--
ALTER TABLE `ordered_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `promo_code`
--
ALTER TABLE `promo_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
