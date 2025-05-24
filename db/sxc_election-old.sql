-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2024 at 06:42 PM
-- Server version: 10.4.28-MariaDB-log
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sxc_election`
--
-- Project Name: `Vote_System`
--
-- Project Developer: `Muthukrishnan M1
--

CREATE DATABASE `sxc_election`;
USE `sxc_election`;
-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','sub-admin','viewer','restricted') NOT NULL DEFAULT 'viewer',
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `name`, `email`, `password`, `role`, `created_on`, `updated_on`) VALUES
(1, 'muthuabi', 'Muthukrishnan M', 'muthuabi292@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'admin', '2024-06-11 19:04:31', '2025-01-04 22:38:35'),
(2, 'sxc_vote_admin', 'Master Admin', 'sxcvote@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'admin', '2024-06-11 19:04:31', '2024-11-10 00:09:45');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `candidate_id` int(11) NOT NULL,
  `regno` varchar(10) NOT NULL,
  `name` varchar(150) NOT NULL,
  `course` varchar(100) NOT NULL,
  `year` int(1) NOT NULL DEFAULT 3,
  `post_id` int(11) NOT NULL,
  `vote_count` int(11) DEFAULT NULL,
  `image_url` varchar(500) NOT NULL,
  `shift` enum('Shift-I','Shift-II') NOT NULL,
  `election_year` varchar(10) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`candidate_id`, `regno`, `name`, `course`, `year`, `post_id`, `vote_count`, `image_url`, `shift`, `election_year`, `created_on`, `updated_on`) VALUES
(2, '21UCS107', 'Krishnan', 'BSC COMPUTER SCIENCE', 3, 3, 0, '../assets/images/candidate_images/2024/IMG_20190716_210342.jpg', 'Shift-I', '2024-25', '2024-11-09 23:01:18', '2024-11-09 23:01:18'),
(4, '21UCS106', 'Krishnan', 'BSC COMPUTER SCIENCE', 3, 3, 0, '../assets/images/candidate_images/2025/St.Xavier’s college.png', 'Shift-I', '2025-26', '2025-01-05 00:01:32', '2025-01-05 00:01:32'),
(6, '21UCS110', 'Sri', 'BSC COMPUTER SCIENCE', 3, 1, 0, '../assets/images/candidate_images/2025/minef.png', 'Shift-I', '2025-26', '2025-01-05 00:03:14', '2025-01-05 00:03:14'),
(8, '21UCS100', 'Muthukrishnan  M', 'BSC COMPUTER SCIENCE', 3, 1, 0, '../assets/images/candidate_images/2025/images7.jpg', 'Shift-I', '2025-26', '2025-01-05 00:04:13', '2025-01-05 00:04:13');

-- --------------------------------------------------------

--
-- Table structure for table `old_data_table`
--

CREATE TABLE `old_data_table` (
  `id` int(11) NOT NULL,
  `regno` varchar(10) NOT NULL,
  `post_with_shift` varchar(100) NOT NULL,
  `votes` int(11) NOT NULL,
  `election_year` varchar(10) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `poll_id` int(11) NOT NULL,
  `poll_year` varchar(10) NOT NULL,
  `poll_status` varchar(10) NOT NULL DEFAULT 'started',
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`poll_id`, `poll_year`, `poll_status`, `created_on`) VALUES
(1, '2024-25', 'ended', '2024-11-09 23:07:22'),
(2, '2025-26', 'started', '2025-01-04 23:20:10');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `post_id` int(11) NOT NULL,
  `post` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `post_shift` enum('Shift-I','Shift-II','Both') NOT NULL,
  `post_status` enum('opposed','unopposed','nocontest') NOT NULL DEFAULT 'opposed',
  `who_can_vote` enum('MF','M','F') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`post_id`, `post`, `description`, `post_shift`, `post_status`, `who_can_vote`, `created_at`, `updated_on`) VALUES
(1, 'President', 'Serves', 'Both', 'opposed', 'MF', '2024-10-13 22:30:55', '2025-01-05 00:05:22'),
(2, 'Vice President', 'Serves', 'Both', 'nocontest', 'MF', '2024-10-13 22:31:05', '2024-11-09 22:59:55'),
(3, 'Secretary', 'Serves', 'Shift-I', 'opposed', 'F', '2024-10-13 22:31:21', '2025-01-05 00:06:30'),
(4, 'Secretary', 'Serves', 'Shift-II', 'opposed', 'F', '2025-01-05 00:07:06', '2025-01-05 00:07:06');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `vote_id` int(11) NOT NULL,
  `vote` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `last_voted_on` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`vote_id`, `vote`, `candidate_id`, `created_on`, `last_voted_on`) VALUES
(3, 3, 2, '2025-01-05 00:00:45', '2025-01-05 00:59:29'),
(4, 3, 4, '2025-01-05 00:05:03', '2025-01-05 00:58:51'),
(5, 7, 6, '2025-01-05 00:56:26', '2025-01-05 01:51:10'),
(6, 4, 8, '2025-01-05 00:57:27', '2025-01-05 01:51:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`candidate_id`),
  ADD UNIQUE KEY `regno` (`regno`),
  ADD KEY `candidat_id_index` (`candidate_id`),
  ADD KEY `fk_post_candidate` (`post_id`);

--
-- Indexes for table `old_data_table`
--
ALTER TABLE `old_data_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_regno_year` (`regno`,`election_year`);

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`poll_id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `post_shift_unique` (`post`,`post_shift`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vote_id`),
  ADD UNIQUE KEY `candidate_id` (`candidate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `candidate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `old_data_table`
--
ALTER TABLE `old_data_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `poll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `fk_post_candidate` FOREIGN KEY (`post_id`) REFERENCES `position` (`post_id`) ON UPDATE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `fk_candidate_votes` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`candidate_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
