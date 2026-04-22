-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2026 at 03:33 PM
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
-- Database: `plus_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `name`) VALUES
(1, 'admin', '123', 'Website Manager');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `priority` varchar(20) DEFAULT 'Normal',
  `description` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `date`, `time`, `location`, `type`, `priority`, `description`, `status`, `image`) VALUES
(10, 6, '2025-12-10', '04:34:00', 'KM 201.1 Northbound', 'Accident', 'High', 'Extreme car crash', 'Reviewed', 'IMG-696359eaa55fa6.44967414.jpg'),
(11, 9, '2026-01-14', '06:50:00', 'km 211 Southbound', 'Obstruction', 'Medium', 'collision from black car behind', 'Verified', 'IMG-69674a828128d1.97439459.jpg'),
(12, 10, '2026-01-15', '18:06:00', 'km 211 Southbound', 'Obstruction', 'Low', 'collision from behind', 'Rejected', 'IMG-69674e701533a0.34365780.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `postcode`, `profile_image`) VALUES
(5, 'Ihsan', 'ihsan@gmail.com', '123456', '0193904226', 'Sempang Kiri, Nogori Sembilan', '71450', 'default.png'),
(6, 'Asri', 'asri@gmail.com', '123456', '0191234658', 'Tangkak, Johor', '84000', 'default.png'),
(7, 'ihsan', 'ali@gmail.com', 'kamufuck', '01836366728', 'pagoh, johor,malaysia', '47000', 'default.png'),
(8, 'amirulbest', 'amirul@gmail.com', '123456789', '0183633798', 'pagoh,johor', '56000', 'default.png'),
(9, 'darwin', 'darwin@gmail.com', '123456', '0123456688', 'J1-11-6,BLOK J1 PPAM JINTAN,PRESINT 16', '62100', 'default.png'),
(10, 'dhummy', 'dhummy@gmail.com', '123456', '0123456688', 'J1-11-6,BLOK J1 PPAM JINTAN,PRESINT 16', '62100', 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
