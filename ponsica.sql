-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 03:49 PM
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
-- Database: `ponsica`
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
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `created_at`) VALUES
(3, 'IT-CPSTONE 40/Capstone 42 :Oral Defense Schedule by Catherine Carumba', 'To all Capstone42/IT-CPSTONE40/CS-Thesis2 Teams (Second Sem 2023-2024) Pls be informed: Oral Defense Schedule: May 9-10( Thu ) Venue: UC Main CCS 538 (CCS MECCA)', '2024-05-13 13:12:24'),
(4, 'Clearance and OATH of CANDIDACY forms by Catherine Carumba - Monday, 6 May 2024, 10:44 AM', 'To all BSIT/BSCS/ACT graduating students (Second Sem 2023-2024) Please secure your clearance and OATH of CANDIDACY forms at the Registrar\'s Office (starting Thursday, April 11, 2024). The deadline for signing (Dean) on May 16, 2024(Thursday). No filing of the graduation application, No giving of the oath of Candidacy form.', '2024-05-13 13:18:57');

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
  `session` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`idno`, `firstName`, `lastName`, `purpose`, `lab`, `session`) VALUES
(21459805, 'Rhodney Dame', 'Ponsica', 'Javascript', '528', 30),
(21459805, 'Rhodney Dame', 'Ponsica', 'Java', 'Lab 526', 30),
(21448733, 'Miles', 'Campomanes', 'JavaScript', 'Lab 528', 29),
(21459805, 'Rhodney Dame', 'Ponsica', 'Python', 'Lab 524', 29),
(21485567, 'Jude', 'Saagundo', 'JavaScript', 'Lab 528', 28);

-- --------------------------------------------------------

--
-- Table structure for table `session_info`
--

CREATE TABLE `session_info` (
  `id` int(11) NOT NULL,
  `remaining_session` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `lab` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_records`
--

CREATE TABLE `time_records` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `idno` int(10) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `middleName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `age` int(10) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `purpose` varchar(25) DEFAULT NULL,
  `lab` int(10) DEFAULT NULL,
  `remaining_session` int(30) DEFAULT 30,
  `time_in` timestamp NULL DEFAULT NULL,
  `time_out` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `idno`, `firstName`, `middleName`, `lastName`, `password`, `age`, `gender`, `contact`, `email`, `address`, `purpose`, `lab`, `remaining_session`, `time_in`, `time_out`) VALUES
(22, 21459805, 'Rhodney Dame ', 'Nellas', 'Ponsica', '123', 21, 'Male', '09158906187', 'rdpons123@gmail.com', 'Cebu City', 'Python', 528, 30, NULL, NULL),
(23, 21448733, 'Miles ', 'De Guzman', 'Campomanes', '123', 21, 'Male', '123123123123', 'Miles@gmail.com', 'Cebu City', 'Python', 528, 30, NULL, NULL),
(24, 21485567, 'Jude ', 'Anova', 'Saagundo ', '123', 21, 'Male', '123123123', 'jude@gmail.com', 'Cebu City', 'C#', 528, 30, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session_info`
--
ALTER TABLE `session_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_records`
--
ALTER TABLE `time_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idno` (`idno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `session_info`
--
ALTER TABLE `session_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_records`
--
ALTER TABLE `time_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
