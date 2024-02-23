-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2023 at 03:32 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boat`
--
CREATE DATABASE IF NOT EXISTS `boat` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `boat`;

-- --------------------------------------------------------

--
-- Table structure for table `book_trip`
--

CREATE TABLE `book_trip` (
  `id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `starting_date` date NOT NULL,
  `end_date` date NOT NULL,
  `phone` int(11) NOT NULL,
  `num_of_adults` int(11) NOT NULL,
  `num_of_children` int(11) NOT NULL,
  `boat_type` varchar(255) NOT NULL,
  `license_accepted` int(11) NOT NULL,
  `verified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` int(11) NOT NULL,
  `trip_image` text NOT NULL,
  `trip_title` varchar(200) NOT NULL,
  `trip_price` decimal(11,2) NOT NULL,
  `trip_status` varchar(20) NOT NULL DEFAULT 'Unactive',
  `trip_participants` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `trip_image`, `trip_title`, `trip_price`, `trip_status`, `trip_participants`) VALUES
(1, 'best-islands-maldives.jpg', 'Maldives', '399.99', 'Active', 0),
(2, 'best-islands-bora-bora.jpg', 'Bora Bora, French Polynesia', '149.99', 'Active', 0),
(3, 'most-beautiful-islands-in-the-world-palawan-islands-near-el-nido.jpg', 'Palawan, Philippines', '649.99', 'Active', 0),
(4, 'best-islands-seychelles.jpg', 'Seychelles', '449.99', 'Active', 0),
(5, 'best-islands-dalmatian-islands.jpg', 'The Dalmatian Islands, Croatia', '449.99', 'Active', 0),
(6, 'best-islands-santorini.jpg', 'Santorini, Greece', '549.99', 'Active', 0),
(7, 'best-islands-cook-islands.jpg', 'The Cook Islands', '299.99', 'Active', 0),
(8, 'best-islands-kauai.jpg', 'Kauai, USA', '399.99', 'Active', 0),
(9, 'world-most-beautiful-islands-st-lucia-caribbean.jpg', 'St. Lucia, The Caribbean', '549.99', 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `sex` varchar(11) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `phonenumber` varchar(50) NOT NULL,
  `license_accepted` int(11) NOT NULL,
  `verified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `firstname`, `lastname`, `birthday`, `sex`, `role`, `phonenumber`, `license_accepted`, `verified`) VALUES
(10, 'ni', 'ni@gmail.com', '$2y$10$/zqTB9GM4IRckeQMwQ.77e0wgcX2kdDiHpGOM67U/fOGYsHdC.Vze', 'Natcha', 'Ni', '1995-01-31', 'Female', 'admin', '+36306524294', 1, 1),
(11, 'gabor', 'gabor@gmail.com', '$2y$10$bQMrrYlf.ZnOxd6RvWGDH.7QKKD1Ie57gnISHBEcHa2ygMPwzX2rm', 'Gabor', 'Farkas', '1986-02-15', 'Male', 'admin', '+36306524294', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_trip`
--
ALTER TABLE `book_trip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_id` (`trip_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
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
-- AUTO_INCREMENT for table `book_trip`
--
ALTER TABLE `book_trip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_trip`
--
ALTER TABLE `book_trip`
  ADD CONSTRAINT `book_trip_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_trip_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
