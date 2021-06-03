-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2021 at 12:26 AM
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
-- Database: `projects`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(99) NOT NULL,
  `user` varchar(999) NOT NULL,
  `date_from` varchar(999) NOT NULL,
  `date_to` varchar(999) NOT NULL,
  `designation` varchar(999) NOT NULL,
  `status` varchar(999) NOT NULL,
  `monthly_salary` varchar(999) NOT NULL,
  `assignment_place` varchar(999) NOT NULL,
  `LAWOP` varchar(999) NOT NULL,
  `separation_date` varchar(999) NOT NULL,
  `separation_cause` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `user`, `date_from`, `date_to`, `designation`, `status`, `monthly_salary`, `assignment_place`, `LAWOP`, `separation_date`, `separation_cause`) VALUES
(36, '26aa1a10-979c-4e0d-bab1-f7e3ff97e01f', '05-12-2002', '05-12-2002', '05-12-2002', '05-12-2002', '05-12-2002', '05-12-2002', '05-12-2002', '', ''),
(37, '37c73afa-8482-4e5d-8f73-f5dfd54bac53', '05-12-2003', '05-12-2003', '05-05-2005', '05-05-2005', '05-05-2005', '05-05-2005', '05-05-2005', '05-05-2005', '05-05-2005'),
(38, '26aa1a10-979c-4e0d-bab1-f7e3ff97e01f', '05-12-2003', '0000-00-00', '05-12-1999', '05-12-1999', '05-12-1999', '05-12-1999', '05-12-1999', '05-12-1999', '05-12-1999');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(99) NOT NULL,
  `uuid` varchar(999) NOT NULL,
  `first_name` varchar(99) NOT NULL,
  `middle_name` varchar(99) NOT NULL,
  `last_name` varchar(99) NOT NULL,
  `birth_day` varchar(999) NOT NULL,
  `birth_place` varchar(99) NOT NULL,
  `email` varchar(999) NOT NULL,
  `password` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `first_name`, `middle_name`, `last_name`, `birth_day`, `birth_place`, `email`, `password`) VALUES
(8, '26aa1a10-979c-4e0d-bab1-f7e3ff97e01f', 'testtest', '', 'testtest', '12-22-2002', 'testtest', 'andueni15@gmail.com', '05a671c66aefea124cc08b76ea6d30bb'),
(10, '37c73afa-8482-4e5d-8f73-f5dfd54bac53', 'Anduen', 'Eni', 'Zhuri', '2021-06-16', 'srysrysysry', 'andueni15@gmail.com', '1fdbca81bfaa7f800a07b1fcdd5fcca1'),
(11, 'd6a51066-45a8-4a5d-8660-70f9c6fcdc33', 'xhxjdj', 'cjcjcj', 'cjcjcjctj', '2021-06-16', 'cjctjcjcj', 'ccjctjctjctj@gmail.com', '8657f9f98aec8cbd01deb9eea2bfa1a3'),
(12, '4e32cea3-b9d3-41f5-95f4-22470e5be9c2', 'gcjcgjgcjc', 'gcjcgjcj', 'hcghjcghcgj', '12-22-2002', 'cgjcgjcgj', 'fxhxfhxfh@jcghcxh', '739dddf3b42740a00eb24424809bce98');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
