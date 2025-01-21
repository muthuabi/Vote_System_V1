-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 21, 2025 at 11:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
  `password` varchar(300) NOT NULL,
  `role` enum('admin','sub-admin','viewer','restricted') NOT NULL DEFAULT 'viewer',
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `name`, `email`, `password`, `role`, `created_on`, `updated_on`) VALUES
(1, 'muthuabi', 'Muthukrishnan M', 'muthuabi292@gmail.com', 'b37e7d2627c468cee58d08def47b9032e877ed4c51f9f7886d13e4a5235074e4', 'admin', '2024-06-11 19:04:31', '2025-01-09 18:30:44'),
(2, 'sxc_vote_admin', 'Master Admin', 'sxcvote@gmail.com', '84bc324ff69579d9a35cf6940f44d36c36dec9b3b067efe87af20d7b0f12f7a7', 'admin', '2024-06-11 19:04:31', '2025-01-09 21:59:34'),
(13, 'principal', 'Rev. Fr. Principal', 'sxcprince@xavierstn.edu', '69e03750027e6b1e9f95bd21d227613c0024ec799ebfb7fe281371e1153f9bda', 'viewer', '2025-01-09 19:13:52', '2025-01-13 22:56:17'),
(14, 'someone', 'Someone', 'someone@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'sub-admin', '2025-01-09 20:12:54', '2025-01-09 20:12:54'),
(15, 'critical_support', 'Critical Support', 'critical@gmail.com', '459b8d5fc8d05dff1b7f2305ebaa9d58d8f1bf9e5eaa2d516e48877e9cc57135', 'admin', '2025-01-11 19:04:31', '2025-01-11 00:09:45');

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
(9, '21UCS107', 'Krishnan', 'BSC COMPUTER SCIENCE', 3, 5, 0, '../assets/images/candidate_images/2025/IMG-20250105-WA0007.jpg', 'Shift-I', '2025-26', '2025-01-10 00:52:11', '2025-01-10 00:52:11'),
(10, '21UCS109', 'Muthukrishnan  M', 'BSC COMPUTER SCIENCE', 3, 5, 0, '../assets/images/candidate_images/2025/St.Xavier’s college.png', 'Shift-I', '2025-26', '2025-01-10 00:53:34', '2025-01-10 00:53:34'),
(11, '21UCS110', 'Someone', 'BSC MATHEMATICS', 3, 6, 0, '../assets/images/candidate_images/2025/Screenshot_2025-01-13_13-28-37.png', 'Shift-I', '2025-26', '2025-01-17 22:58:03', '2025-01-17 22:58:11'),
(12, '21UCS100', 'Muthu Vengadesh', 'BSC ZOOLOGY', 3, 6, 0, '../assets/images/candidate_images/2025/Screenshot_2024-12-14_01-57-04.png', 'Shift-I', '2025-26', '2025-01-17 22:58:37', '2025-01-17 22:58:37');

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
(4, '2025-26', 'ended', '2025-01-17 19:29:35');

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
(5, 'President', 'Serves', 'Both', 'opposed', 'MF', '2025-01-10 00:50:17', '2025-01-11 00:53:52'),
(6, 'Vice President', 'Serves', 'Both', 'opposed', 'MF', '2025-01-10 00:50:28', '2025-01-17 22:58:51');

-- --------------------------------------------------------

--
-- Table structure for table `vbooth`
--

CREATE TABLE `vbooth` (
  `vb_id` int(11) NOT NULL,
  `vb_name` varchar(100) NOT NULL,
  `vb_status` enum('active','inactive','suspended','restricted') NOT NULL DEFAULT 'inactive',
  `vb_location` varchar(200) NOT NULL DEFAULT 'SXC',
  `vb_incharge` varchar(100) NOT NULL DEFAULT 'Student',
  `createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedOn` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vbooth`
--

INSERT INTO `vbooth` (`vb_id`, `vb_name`, `vb_status`, `vb_location`, `vb_incharge`, `createdOn`, `updatedOn`) VALUES
(13, 'booth_01', 'inactive', 'Pope Auditorium', 'Krishnan', '2025-01-21 14:08:02', '2025-01-21 15:37:24'),
(15, 'booth_02', 'active', 'St Xavier\'s College', 'Krishna Moorthy', '2025-01-21 14:15:38', '2025-01-21 15:37:30');

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
(7, 33, 10, '2025-01-12 22:29:23', '2025-01-21 15:36:53'),
(8, 53, 9, '2025-01-12 22:29:40', '2025-01-21 15:36:43'),
(9, 12, 12, '2025-01-17 22:59:12', '2025-01-21 15:36:46'),
(10, 13, 11, '2025-01-17 22:59:27', '2025-01-21 15:36:55');

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
-- Indexes for table `vbooth`
--
ALTER TABLE `vbooth`
  ADD PRIMARY KEY (`vb_id`),
  ADD UNIQUE KEY `vb_name_unique` (`vb_name`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `candidate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `old_data_table`
--
ALTER TABLE `old_data_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `poll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vbooth`
--
ALTER TABLE `vbooth`
  MODIFY `vb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
