-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2024 at 05:13 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rentals`
--

-- --------------------------------------------------------

--
-- Table structure for table `apartments`
--

CREATE TABLE `apartments` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `floors` varchar(200) NOT NULL,
  `transmission_id` int(30) NOT NULL,
  `category_id` varchar(30) NOT NULL,
  `engine_id` int(30) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `qty` int(30) NOT NULL,
  `img_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `apartments`
--

INSERT INTO `apartments` (`id`, `name`, `floors`, `transmission_id`, `category_id`, `engine_id`, `description`, `price`, `qty`, `img_path`) VALUES
(9, 'Kwa zakayo', 'Ground', 0, '7', 0, 'Rafiki Shopping Centre. Baraka shop road .BUILDING FEATURES: Available water supply, security, Reliable internet', 3500, 10, '1709818860_s2.jpg'),
(10, 'OBT', '2 floors', 0, '8', 0, 'Rafiki Shopping centre, OBT Building Spacious rooms Adequate water supply Fast and reliable internet Secure environment', 5500, 10, '1709736600_IMG-20240222-WA0019.jpg'),
(11, 'Kapken', '3 Floors', 0, '8', 0, 'Chapchap along Kabarak-Rafiki road Kapken building. Side B. Water availability Parking space Serene environment Internet supply&amp;nbsp;', 6000, 10, '1709736960_IMG-20240222-WA0016.jpg'),
(14, 'SUMMIT', '2 floors', 0, '10', 0, 'Location: Rafiki shopping centre , Carrot Road Side A. Adequate water supply, Spacious, Internet, Parking lots', 11000, 10, '1709818800_s4.jpg'),
(17, 'Denmol', '1', 0, '8', 0, 'good', 5000, 10, '1710450600_s4.jpg'),
(18, 'Chap chap', '3', 0, '10', 0, '&lt;span style=&quot;color: rgb(33, 37, 41); font-family: &amp;quot;Open Sans&amp;quot;, sans-serif; font-size: 16px; background-color: rgba(0, 0, 0, 0.075);&quot;&gt;Rafiki- chapchap Adequate Water Supply Reliable Internet Connection Parking Space&lt;/span&gt;', 20000, 5, '1710941400_s4.jpg'),
(19, 'Kabarak', '1', 0, '7', 0, 'available water', 4000, 1, '1710941880_s4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(30) NOT NULL,
  `apartment_id` int(30) NOT NULL,
  `room_no` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `apartment_id`, `room_no`, `name`, `email`, `contact`, `address`, `status`) VALUES
(72, 10, 'B12', 'Vincent Kipkurui', 'vincentbettoh@gmail.com', '254702502952', '243', 2),
(73, 16, 'A1', 'Mercy Ongoya', 'mercyakoth356@gmail.com', '254705826286', '243', 0),
(74, 16, 'A2\r\n', 'Mercy Ongoya', 'mercyakoth356@gmail.com', '254705826286', '23', 0),
(75, 14, '23', 'Vincent Kipkurui', 'vincentbettoh@gmail.com', '254702502952', '243', 2),
(76, 9, '1', 'Melody Neema', 'melody@gmail.com', '0705826286', '23', 0),
(77, 16, 'A10\r\n', 'Eric Gitau', 'eric@gmail.com', '254745598098', '55', 2),
(78, 11, '5', 'Vincent Kipkurui', 'vincentbettoh@gmail.com', '254702502952', '243', 2),
(79, 16, 'A3\r\n', 'Melody Neema', 'melneema@gmail.com', '254745598098', '243', 2),
(80, 11, '1', 'Emejen Katii', 'emejen@gmail.com', '254712968217', '45', 0),
(81, 19, '2', 'joy', 'joy@gmail.com', '254745598098', '2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bookss`
--

CREATE TABLE `bookss` (
  `id` int(30) NOT NULL,
  `car_id` int(30) NOT NULL,
  `pickup_datetime` datetime NOT NULL,
  `dropoff_datetime` datetime NOT NULL,
  `car_registration_no` varchar(200) NOT NULL,
  `car_plate_no` varchar(200) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0= cancelled,1=Pending , 2= confirmed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(7, 'Single Room', 'Rafiki shopping centre Baraka shop Road  Kwa Zakayo\r\n'),
(8, 'Bedsitter', 'Rafiki Shopping Centre, OBT Building '),
(10, '2- bedroom', 'uyuhy'),
(11, 'one- bedroom', '\r\nArusha flats');

-- --------------------------------------------------------

--
-- Table structure for table `engine_types`
--

CREATE TABLE `engine_types` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `apartment_id` int(11) NOT NULL,
  `room_no` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`apartment_id`, `room_no`, `status`) VALUES
(10, 'B12', 'available'),
(10, 'B13', 'available'),
(11, '1', 'available'),
(11, '5', 'taken'),
(14, '23', 'taken'),
(14, '24', 'available'),
(10, 'C20', 'available'),
(10, 'C21', 'available'),
(10, 'C26', 'available'),
(16, 'A1', 'available'),
(16, 'A2\r\n', 'taken'),
(16, 'A3\r\n', 'taken'),
(16, 'A4\r\n', 'available'),
(16, 'A5\r\n', 'available'),
(16, 'A6\r\n', 'available'),
(16, 'A7\r\n', 'available'),
(16, 'A8\r\n', 'available'),
(16, 'A9\r\n', 'available'),
(16, 'A10\r\n', 'available'),
(11, '3', 'available'),
(17, 'Block A No 7', 'available'),
(17, 'Block A No 3\r\n', 'available'),
(17, 'Block A No 11\r\n', 'available'),
(17, 'Block A No 15\r\n', 'available'),
(17, 'Block A No 12\r\n', 'available'),
(17, 'Block A No 17\r\n', 'available'),
(17, 'Block A No 18\r\n', 'available'),
(17, 'Block A No 20\r\n', 'available'),
(17, 'Block A No 22\r\n', 'available'),
(17, 'Block A No 25\r\n', 'available'),
(9, 'Block B No 1', 'available'),
(9, 'Block B No 2', 'available'),
(9, 'Block B No 3', 'available'),
(18, '5', 'available'),
(18, '4', 'available'),
(18, '3', 'available'),
(18, '2', 'taken'),
(18, '1', 'available'),
(19, '1', 'available'),
(19, '2', 'taken');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'House Rental Management System', 'joy@gmail.com', '0705826286', '1709726400_IMG-20240222-WA0015.jpg', '&lt;p style=&quot;text-align: justify; background: transparent; position: relative;&quot;&gt;This is a house booking system&lt;/p&gt;&lt;p&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `MerchantRequestID` varchar(255) DEFAULT NULL,
  `CheckoutRequestID` varchar(255) DEFAULT NULL,
  `ResultCode` varchar(255) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `MpesaReceiptNumber` varchar(255) DEFAULT NULL,
  `TransactionDate` datetime DEFAULT NULL,
  `PhoneNumber` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `MerchantRequestID`, `CheckoutRequestID`, `ResultCode`, `Amount`, `MpesaReceiptNumber`, `TransactionDate`, `PhoneNumber`) VALUES
(1, 'tyuy', '56', '0', '5000.00', 'ASDFJKL', '2024-03-03 05:06:53', '254702502952');

-- --------------------------------------------------------

--
-- Table structure for table `transmission_types`
--

CREATE TABLE `transmission_types` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff, 3= subscriber'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `engine_types`
--
ALTER TABLE `engine_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transmission_types`
--
ALTER TABLE `transmission_types`
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
-- AUTO_INCREMENT for table `apartments`
--
ALTER TABLE `apartments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `engine_types`
--
ALTER TABLE `engine_types`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transmission_types`
--
ALTER TABLE `transmission_types`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
