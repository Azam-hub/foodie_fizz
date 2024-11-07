-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2024 at 01:11 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

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
CREATE DATABASE IF NOT EXISTS `foodie_fizz` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `foodie_fizz`;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int NOT NULL,
  `address` text NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `added_on` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_panel_credential`
--

CREATE TABLE `admin_panel_credential` (
  `id` int NOT NULL,
  `email` varchar(500) NOT NULL,
  `general_password` varchar(1000) NOT NULL,
  `supervisor_password` varchar(1000) NOT NULL,
  `code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `id` int NOT NULL,
  `customer_id` varchar(80) NOT NULL,
  `item_id` varchar(80) NOT NULL,
  `quantity` varchar(80) NOT NULL,
  `added_on` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `status` varchar(100) NOT NULL,
  `added_on` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `image_path`, `status`, `added_on`) VALUES
(1, 'Burger', 'src/dynamic/categories_image/Burger@18_02_49-2024_11_07.jpg', 'active', '2024-11-07 18:02:49'),
(2, 'Roll', 'src/dynamic/categories_image/Roll@18_03_20-2024_11_07.jpg', 'active', '2024-11-07 18:03:20');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(300) NOT NULL,
  `mobile_no` varchar(300) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL,
  `code` varchar(500) NOT NULL,
  `registered_on` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` varchar(80) NOT NULL,
  `cutted_item_price` varchar(100) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `category_id` varchar(50) NOT NULL,
  `number_of_order` varchar(50) NOT NULL,
  `status` varchar(80) NOT NULL,
  `added_on` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `item_price`, `cutted_item_price`, `image_path`, `category_id`, `number_of_order`, `status`, `added_on`) VALUES
(1, 'Zinger Roll', '300', '450', 'src/dynamic/items_image/Zinger Roll@18_05_16-2024_11_07.jpg', '2', '0', 'active', '2024-11-07 18:05:16'),
(2, 'Beef Roll', '250', '0', 'src/dynamic/items_image/Beef Roll@18_05_50-2024_11_07.jpg', '2', '0', 'active', '2024-11-07 18:05:50'),
(3, 'Zinger Burger', '340', '0', 'src/dynamic/items_image/Zinger Burger@18_06_40-2024_11_07.jpg', '1', '0', 'active', '2024-11-07 18:06:40'),
(4, 'Chicken Burger', '230', '300', 'src/dynamic/items_image/Chicken Burger@18_08_13-2024_11_07.jpg', '1', '0', 'active', '2024-11-07 18:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_items`
--

CREATE TABLE `ordered_items` (
  `id` int NOT NULL,
  `item_id` varchar(50) NOT NULL,
  `quantity` varchar(20) NOT NULL,
  `order_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_heads`
--

CREATE TABLE `order_heads` (
  `id` int NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `customer_id` varchar(70) NOT NULL,
  `customer_name` varchar(300) NOT NULL,
  `customer_email` varchar(500) NOT NULL,
  `customer_phone_no` varchar(80) NOT NULL,
  `promo_code_id` varchar(70) NOT NULL,
  `status` varchar(255) NOT NULL,
  `added_on` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promo_code`
--

CREATE TABLE `promo_code` (
  `id` int NOT NULL,
  `promo_code` varchar(255) NOT NULL,
  `discount` varchar(80) NOT NULL,
  `discount_mode` varchar(100) NOT NULL,
  `minimum_amount` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `added_on` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_panel_credential`
--
ALTER TABLE `admin_panel_credential`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ordered_items`
--
ALTER TABLE `ordered_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promo_code`
--
ALTER TABLE `promo_code`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
