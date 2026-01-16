-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2026 at 04:55 AM
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
-- Database: `rajvi-associates`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT '#',
  `parent_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image_path`, `link`, `parent_id`) VALUES
(1, 'watch', 'uploads/categories/1767425340_watch-logo-design-casual-style-black-white-monochrome_1108897-1.avif', '#', 0),
(2, 'shoes', 'uploads/categories/1767439154_photo-1542291026-7eec264c27ff.jpg', '#', 0),
(3, 'perfume', 'uploads/categories/1767701050_3535901.jpg', '#', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('New','Contacted','Completed') DEFAULT 'New',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `customer_name`, `phone`, `message`, `status`, `created_at`) VALUES
(1, 'Herin Patel', '9023897448', 'price', 'New', '2026-01-05 09:15:25'),
(2, 'test', '1234567890', '', 'New', '2026-01-06 04:54:01'),
(3, 'herin', '1234567890', '', 'Contacted', '2026-01-06 05:14:03'),
(4, 'Herin Patel', '1234567890', '', 'New', '2026-01-06 05:26:18'),
(5, 'Herin Patel', '9023897448', '', 'New', '2026-01-06 09:23:30'),
(6, 'Herin Patel', '9023897448', '', 'Completed', '2026-01-09 09:24:44');

-- --------------------------------------------------------

--
-- Table structure for table `inquiry_items`
--

CREATE TABLE `inquiry_items` (
  `id` int(11) NOT NULL,
  `inquiry_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiry_items`
--

INSERT INTO `inquiry_items` (`id`, `inquiry_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 10),
(3, 3, 1, 1),
(4, 4, 2, 3),
(5, 4, 1, 2),
(6, 5, 3, 1),
(7, 6, 5, 0),
(8, 6, 1, 1),
(9, 6, 4, 15);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `discounted_price` decimal(10,2) DEFAULT NULL,
  `discount_percent` int(11) DEFAULT NULL,
  `stock_status` varchar(50) DEFAULT 'In Stock',
  `rating` decimal(3,1) DEFAULT 4.5,
  `available_units` int(11) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `long_description` text DEFAULT NULL,
  `key_features` text DEFAULT NULL,
  `category_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`category_details`)),
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `min_qty` int(11) DEFAULT 1,
  `additional_images` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand`, `product_name`, `sku`, `original_price`, `discounted_price`, `discount_percent`, `stock_status`, `rating`, `available_units`, `short_description`, `long_description`, `key_features`, `category_details`, `image`, `created_at`, `min_qty`, `additional_images`) VALUES
(1, 2, 'sonata', 'demo', '001', 1500.00, 1200.00, 20, 'In Stock', 4.5, 5000, 'test', 'test', 'hard', NULL, 'photo-1542291026-7eec264c27ff.jpg', '2026-01-03 11:34:51', 10, NULL),
(2, 1, NULL, 'test watch', '002', 1550.00, 1000.00, 35, 'In Stock', 4.5, 500, '', 'its testing description', 'simple ', NULL, 'shopping.webp', '2026-01-05 09:31:25', 10, NULL),
(3, 1, 'test', 'Shocknshop RevolveX Watch', '', 2599.00, 499.00, 81, 'In Stock', 4.5, 100, 'Shocknshop RevolveX Rotating Hollow Wheel Hub Creative Fashion Analog Silicone Magnetic Strap Wrist Watch for Men Boys -WCH368', 'Unique Design: The watch features a captivating spinning plate inside, reminiscent of a car\'s wheel, adding a distinctive touch to its appearance\r\nRobust Build: Crafted with a strong metal case and black plating, ensuring durability and a sleek, modern aesthetic that appeals to car enthusiasts.\r\nThis watch is not only a fashion statement but also a conversation starter, making it the perfect gift for anyone looking for a standout accessory.\r\nReliable Quartz Movement: High-precision quartz mechanism provides accurate timekeeping with a clear glass crystal display for easy readability.\r\nPerfect Gift for Any Occasion: A stylish and unique watch perfect for birthdays, anniversaries, and special occasions. A great choice for car enthusiasts and fashion lovers.', '', NULL, '71EhINfMPtL._SX679_.jpg', '2026-01-06 07:48:13', 0, '71v7moFfPdL._SX679_.jpg,51a6LIYnoVL._SY741_.jpg,61wwHHbG72L._SY741_.jpg,813EWfjePXL._SX679_.jpg'),
(4, 3, 'Fogg', 'Fogg Scent Impressio Perfume', '004', 650.00, 380.00, 42, 'In Stock', 4.0, 259, 'FOGG SCENT IMPRESSIO - Instantly project the perfect impression with the Amber Woody fragrance of Fogg Impressio perfume for men.\r\nFRAGRANCE NOTES: The citrusy scents of Lemon and Neroli are perfectly complemented by the alluring base notes of Vanilla and Musk. The woody scents of Teak Wood and Patchouli finish up create a special fragrance for you to make a statement.\r\nLONG-LASTING FRAGRANCE - Discover the enduring power of Fogg Impressio, meticulously formulated with 100% perfume liquid for a fragrance that stays with you all day long.\r\nIRRESISTIBLE SCENT - With a harmonious blend of alluring and distinctive fragrances, Fogg Impressio men\'s perfume will surely help you leave a lasting impression wherever you go. Prepare to be captivated by its irresistible scent, which leaves everyone impressed.\r\nMADE FOR MOMENTS: Wear it every day and make it your signature scent for regular occasions, this scent is perfect for every moment.\r\nTHE FOGG SCENT COLLECTION - The Fogg Scent Collection is curated with a selection of fragrances to create a lasting impression.', 'FOGG SCENT IMPRESSIO - Instantly project the perfect impression with the Amber Woody fragrance of Fogg Impressio perfume for men.\r\nFRAGRANCE NOTES: The citrusy scents of Lemon and Neroli are perfectly complemented by the alluring base notes of Vanilla and Musk. The woody scents of Teak Wood and Patchouli finish up create a special fragrance for you to make a statement.\r\nLONG-LASTING FRAGRANCE - Discover the enduring power of Fogg Impressio, meticulously formulated with 100% perfume liquid for a fragrance that stays with you all day long.\r\nIRRESISTIBLE SCENT - With a harmonious blend of alluring and distinctive fragrances, Fogg Impressio men\'s perfume will surely help you leave a lasting impression wherever you go. Prepare to be captivated by its irresistible scent, which leaves everyone impressed.\r\nMADE FOR MOMENTS: Wear it every day and make it your signature scent for regular occasions, this scent is perfect for every moment.\r\nTHE FOGG SCENT COLLECTION - The Fogg Scent Collection is curated with a selection of fragrances to create a lasting impression.', 'top notes , base notes , middle notes', NULL, '1767701422_71dUvB1dxBL._SL1500_.jpg', '2026-01-06 12:10:22', 15, '1767701422_71zdQXOrCPL._SL1500_.jpg,1767701422_715GAMZIwyL._SL1500_.jpg'),
(5, 3, 'denever', 'Denver Hamilton Perfume - 100Ml ', '006', 600.00, 549.00, 9, 'In Stock', 4.5, 500, 'Here are a few short Denver descriptions — you can use any one depending on your need:\r\n\r\nDenver is a vibrant city known for its mountain views, outdoor lifestyle, and modern urban culture.\r\nDenver, the “Mile High City,” blends natural beauty with a lively downtown and rich history.\r\nDenver offers fresh air, scenic landscapes, and a perfect mix of nature and city life.\r\nDenver is famous for its Rocky Mountain backdrop, clean environment, and active lifestyle.\r\n\r\nIf you want it for hotel, travel, or project use, tell me the purpose and tone 👍\r\n', 'test demo try', 'good fregrence', '{\"scent\":\"woody\",\"volume\":\"100\",\"scent_features\":\"Alcohol free\"}', '1767777695_71zdQXOrCPL._SL1500_.jpg', '2026-01-07 09:21:35', 0, '1767777695_71dUvB1dxBL._SL1500_.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `subtitle`, `image_path`, `created_at`) VALUES
(5, 'Personal Service', 'Get personalized recommendations from our luxury specialists', 'uploads/1767423605_hero.jpg', '2026-01-03 07:00:05'),
(6, 'Luxury Redefined', 'Get personalized recommendations from our luxury specialists', 'uploads/1767424179_7d81aefc4a3542bc145f778abbcf6564.jpg', '2026-01-03 07:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Super Admin','Admin','Staff') DEFAULT 'Admin',
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Admin User', 'admin@rajvi.com', '1', 'Super Admin', 'Active', '2026-01-10 11:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `product_id`, `ip_address`, `created_at`) VALUES
(22, 5, '::1', '2026-01-09 05:48:24'),
(26, 3, '::1', '2026-01-09 09:08:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiry_items`
--
ALTER TABLE `inquiry_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inquiry_id` (`inquiry_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inquiry_items`
--
ALTER TABLE `inquiry_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inquiry_items`
--
ALTER TABLE `inquiry_items`
  ADD CONSTRAINT `inquiry_items_ibfk_1` FOREIGN KEY (`inquiry_id`) REFERENCES `inquiries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
