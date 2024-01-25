-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2024 at 10:59 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlineshopping`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `desc` text NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `rrp` decimal(7,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL,
  `img` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `desc`, `price`, `rrp`, `quantity`, `img`, `date_added`) VALUES
(1, 'Sophisticated Tufted Accent Chair', '<p>Tufted design on the backrest, adorned with visible buttons that create a classic, sophisticated look.</p>\r\n<h3>Features</h3>\r\n<ul>\r\n<li>The chair is set against a plain white background</li>\r\n</ul>', '388.00', '0.00', 10, 'product1.jpg', '2019-03-13 17:55:22'),
(2, 'Elegant Comfort Armchair', '<p>Luxurious comfort and modern style of the Elegant Comfort Armchair</p>', '279.00', '0.00', 34, 'product2.jpg', '2019-03-13 18:52:49'),
(3, 'Elegant Wooden Bar Stool', '<p>The natural wood finish adds a touch of rustic charm, making it a perfect addition to any contemporary or traditional decor.</p>', '79.00', '0.00', 23, 'product3.jpg', '2019-03-13 18:47:56'),
(4, 'Emerald Elegance Sofa', '<p>The plush cushions and spacious seating area ensure optimal comfort</p>', '899.00', '0.00', 7, 'product4.jpg', '2019-03-13 17:42:04'),
(5, 'Vintage Elegance Chesterfield Sofa', 'Upholstered in rich, dark brown leather, this classic piece features deep button tufting and rolled arms that seamlessly blend traditional charm with modern durability.', '1288.00', '0.00', 19, 'product5.jpg', '2024-01-16 17:27:38'),
(6, 'Modern Elegance Wooden Cabinet', 'This contemporary sideboard combines functionality and style, featuring a sleek black frame complemented by natural wooden doors and drawer', '599.00', '0.00', 30, 'product6.jpg', '2024-01-16 17:27:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
