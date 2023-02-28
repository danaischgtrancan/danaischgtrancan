-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2023 at 02:50 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `danaischg_trancan`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `descriptions` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `for_gender` tinyint(1) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `status`, `descriptions`, `price`, `for_gender`, `image`, `supplier_id`) VALUES
(1, 1, 'Flower Shirt', 1, 'A Flower Shirt is a shirt clothing for women', '30.00', 1, 'Pleated_Short_Skirt_1.png', 1),
(3, 5, 'Storm Bomber Black', 1, 'Storm Bomber Black is a bomber clothing', '98.00', 0, 'Storm_Bomber_Black_2.png', 2),
(5, 6, 'Vintage Tee Natural ', 1, 'Vintage Tee Natural is a long tee', '68.00', 0, 'Vintage_Tee_Natural_2.png', 2),
(6, 7, 'Herdsman Turtleneck', 1, 'Herdsman Turtleneck is a long tee for men\'s clothing', '56.00', 0, 'Herdsman-Turtleneck-2-63f6eea9cae09.webp', 2),
(7, 7, 'Wool CPO Jacket Khaki Men', 1, 'Wool CPO Jacket Khaki Men is a jacket for men', '85.00', 0, 'Wool_CPO_Jacket_Khaki_Men_1.png', 1),
(16, 4, 'Leo Cutout Wool Blazer Blue', 1, 'Leo Cutout Wool Blazer Blue for women', '85.00', 1, 'Leo_Cutout_Wool_Blazer_Blue_1.png', 2),
(26, 3, 'Loopback Trouser Natural', 0, 'Brushed Loopback Trouser Natural is a pans for men\'s clothing', '57.00', 0, 'Brushed_Loopback_Trouser_Natural_1.png', 2),
(27, 7, 'Wool CPO Jacket Black Men', 0, 'Wool CPO Jacket Black Men is jacket for men\'s', '45.00', 0, 'Wool-CPO-Jacket-Black-Men-1-63f87b5caa222.webp', 2),
(28, 3, 'Brushed Trouser Venice', 0, 'Brushed Trouser Venice is a pans for men\'s clothing', '54.00', 0, 'Brushed-Trouser-Venice-1-63f88e6dc3c2f.webp', 1),
(32, 4, 'Leo Cutout Brown Blazer ', 0, 'Leo Cutout Wool Blazer Brown for women\'s clothing', '43.00', 1, 'Leo-Cutout-Wool-Blazer-Brown-3-63f9d22cec171.png', 2),
(33, 2, 'Camellia Floral Minidress', 0, 'Camellia Floral Minidress is a dresses for women\'s clothing', '54.00', 1, 'Camellia-Floral-Minidress-3-63f22e9d7e426.png', 2),
(35, 8, 'Cropped Jacket', 0, 'Cropped Jacket is a croptop for women\'s clothing', '54.00', 1, 'Cropped_Jacket.png', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`),
  ADD KEY `IDX_D34A04AD2ADD6D8C` (`supplier_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D34A04AD2ADD6D8C` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
