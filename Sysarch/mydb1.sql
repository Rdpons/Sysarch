-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2024 at 04:35 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 'Admin', 'Admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `created_at`) VALUES
(3, 'IT-CPSTONE 40/Capstone 42 :Oral Defense Schedule by Catherine Carumba', 'To all Capstone42/IT-CPSTONE40/CS-Thesis2 Teams (Second Sem 2023-2024) Pls be informed: Oral Defense Schedule: May 9-10( Thu ) Venue: UC Main CCS 538 (CCS MECCA)', '2024-05-13 05:12:24');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `idno` int(11) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `idno`, `firstName`, `lastName`, `message`) VALUES
(11, 21459805, 'Rhodney Dame', 'Ponsica', 'JUDE BAYOT BOANG'),
(12, 0, NULL, NULL, 'asdasd'),
(13, 21459805, NULL, NULL, 'asdasdasd'),
(14, 21459805, NULL, NULL, NULL),
(15, 21459805, NULL, NULL, NULL),
(16, 21459805, NULL, NULL, NULL),
(17, 21459805, NULL, NULL, 'asdasdasd'),
(18, 21459805, NULL, NULL, 'asdasdasd'),
(19, 21459805, NULL, NULL, 'sadasd');

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `idno` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `lab` varchar(50) NOT NULL,
  `session` int(10) NOT NULL,
  `timein` timestamp NOT NULL DEFAULT current_timestamp(),
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`idno`, `firstName`, `lastName`, `purpose`, `lab`, `session`, `timein`, `feedback`) VALUES
(21459805, 'Rhodney Dame', 'Ponsica', 'Java', 'Lab 526', 30, '2024-05-28 01:08:01', 'asdasdasd'),
(21448733, 'Miles', 'Campomanes', 'JavaScript', 'Lab 528', 29, '2024-05-28 01:08:01', NULL),
(21459805, 'Rhodney Dame', 'Ponsica', 'Python', 'Lab 524', 29, '2024-05-28 01:08:01', 'asdasdasd'),
(21485567, 'Jude', 'Saagundo', 'JavaScript', 'Lab 528', 28, '2024-05-28 01:08:01', NULL),
(21459805, 'Rhodney Dame', 'Ponsica', 'Java', 'Lab 542', 28, '2024-05-28 01:08:01', 'sadasd'),
(21459805, 'Rhodney Dame', 'Ponsica', 'Java', 'Lab 542', 27, '2024-05-28 01:08:01', NULL),
(21459805, 'Rhodney Dame', 'Ponsica', 'Java', 'Lab 542', 26, '2024-05-28 01:08:01', 'asdasdasd'),
(21459805, 'Rhodney Dame', 'Ponsica', 'Java', 'Lab 542', 29, '2024-05-28 01:13:37', 'asdasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `reserve`
--

CREATE TABLE `reserve` (
  `id` int(11) NOT NULL,
  `pcnum` int(11) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `lab` varchar(50) NOT NULL,
  `resdate` date NOT NULL,
  `restime` time NOT NULL,
  `idno` int(11) NOT NULL,
  `timein` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reserve`
--

INSERT INTO `reserve` (`id`, `pcnum`, `purpose`, `lab`, `resdate`, `restime`, `idno`, `timein`, `status`) VALUES
(0, 5, 'Java', 'Lab 542', '2024-05-08', '10:31:00', 0, '2024-05-28 02:31:49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `idno` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `middleName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `age` int(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `lab` varchar(50) NOT NULL,
  `session` int(11) DEFAULT 30,
  `timein` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `idno`, `firstName`, `middleName`, `lastName`, `password`, `age`, `gender`, `contact`, `email`, `address`, `purpose`, `lab`, `session`, `timein`) VALUES
(24, 21459805, 'Rhodney Dame', 'Nellas', 'Ponsica', '123', 21, 'Male', '09158906187', 'rdpons123@gmail.com', 'Cebu City', 'Java', 'Lab 542', 29, '2024-05-28 03:13:35'),
(25, 21448733, 'Miles ', 'De Guzman', 'Campomanes', 'asd', 21, 'Male', '09157823685', 'miles@gmail.com', 'Cebu City', 'Python', 'Lab 528', 30, '2024-05-01 17:03:48'),
(26, 21485567, 'Jude', 'Anova', 'Saagundo', '123', 21, 'Male', '09123762149', 'praised.capt006@gmail.com', 'Cebu City', 'C++', 'Lab 526', 30, '2024-05-01 17:05:22');

-- --------------------------------------------------------

--
-- Table structure for table `users_sitin`
--

CREATE TABLE `users_sitin` (
  `id` int(10) NOT NULL,
  `idno` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `middleName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `age` int(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `lab` varchar(50) NOT NULL,
  `session` int(11) DEFAULT 30,
  `timein` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_sitin`
--

INSERT INTO `users_sitin` (`id`, `idno`, `firstName`, `middleName`, `lastName`, `password`, `age`, `gender`, `contact`, `email`, `address`, `purpose`, `lab`, `session`, `timein`) VALUES
(20, 21448733, 'Miles ', 'De Guzman', 'Campomanes', '123', 21, 'Male', '09157823685', 'miles@gmail.com', 'Cebu City', 'Python', 'Lab 528', 30, '2024-05-01 17:03:48'),
(21, 21485567, 'Jude', 'Anova', 'Saagundo', '123', 21, 'Male', '09123762149', 'praised.capt006@gmail.com', 'Cebu City', 'C++', 'Lab 526', 30, '2024-05-01 17:05:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_sitin`
--
ALTER TABLE `users_sitin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users_sitin`
--
ALTER TABLE `users_sitin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
