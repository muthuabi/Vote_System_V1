-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 12, 2025 at 08:12 PM
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
(1, 'muthuabi', 'MUTHUKRISHNAN', 'muthuabi292@gmail.com', 'b37e7d2627c468cee58d08def47b9032e877ed4c51f9f7886d13e4a5235074e4', 'admin', NOW(), NOW()),
(2, 'sxc_vote_admin', 'Master_Admin', 'sxcvote@gmail.com', '84bc324ff69579d9a35cf6940f44d36c36dec9b3b067efe87af20d7b0f12f7a7', 'admin', NOW(), NOW()),
(3, 'principal', 'Rev. Fr. Principal', 'sxcprince@xavierstn.edu', '69e03750027e6b1e9f95bd21d227613c0024ec799ebfb7fe281371e1153f9bda', 'viewer', NOW(), NOW()),
(4, 'leolin', 'Rev. Fr. Leolin', 'leolin@gmail.com', 'df2379fe96f800c35a8cdfe6e223083fe3ce644668ffab61747be8e0b50baa7a', 'sub-admin', NOW(), NOW()),
(5, 'coordinator', 'Web-Coordinator', 'coord@gmail.com', '620b2d0916189571adb0024c5a4304bcadd3536fab2321b3f96c4a45966872c9', 'admin', NOW(), NOW()),
(6, 'critical_support', 'Critical Support', 'critical@gmail.com', '459b8d5fc8d05dff1b7f2305ebaa9d58d8f1bf9e5eaa2d516e48877e9cc57135', 'admin', NOW(), NOW());

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

-- INSERT INTO `candidates` (`candidate_id`, `regno`, `name`, `course`, `year`, `post_id`, `vote_count`, `image_url`, `shift`, `election_year`, `created_on`, `updated_on`) VALUES
-- (9, '21UCS107', 'Krishnan', 'BSC COMPUTER SCIENCE', 3, 5, 0, '../assets/images/candidate_images/2025/IMG-20250105-WA0007.jpg', 'Shift-I', '2025-26', '2025-01-10 00:52:11', '2025-01-10 00:52:11'),
-- (10, '21UCS109', 'Muthukrishnan  M', 'BSC COMPUTER SCIENCE', 3, 5, 0, '../assets/images/candidate_images/2025/St.Xavier’s college.png', 'Shift-I', '2025-26', '2025-01-10 00:53:34', '2025-01-10 00:53:34'),
-- (11, '21UCS110', 'Someone', 'BSC MATHEMATICS', 3, 6, 0, '../assets/images/candidate_images/2025/Screenshot_2025-01-13_13-28-37.png', 'Shift-I', '2025-26', '2025-01-17 22:58:03', '2025-01-17 22:58:11'),
-- (12, '21UCS100', 'Muthu Vengadesh', 'BSC ZOOLOGY', 3, 6, 0, '../assets/images/candidate_images/2025/Screenshot_2024-12-14_01-57-04.png', 'Shift-I', '2025-26', '2025-01-17 22:58:37', '2025-01-17 22:58:37');

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

-- INSERT INTO `polls` (`poll_id`, `poll_year`, `poll_status`, `created_on`) VALUES
-- (1, '2024-25', 'ended', '2024-11-09 23:07:22'),
-- (4, '2025-26', 'ended', '2025-01-17 19:29:35');

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
   (1, 'President', 'Serves', 'Both', 'nocontest', 'MF', NOW(), NOW()),
   (2, 'Vice President', 'Serves', 'Both', 'nocontest', 'MF', NOW(), NOW()),
   (3, 'Secretary', 'Serves', 'Shift-I', 'nocontest', 'F', NOW(), NOW()),
   (4, 'Secretary', 'Serves', 'Shift-II', 'nocontest', 'F', NOW(), NOW()),
   (5, 'Joint Secretary', 'Serves', 'Shift-I', 'nocontest', 'M', NOW(), NOW()),
   (6, 'Joint Secretary', 'Serves', 'Shift-II', 'nocontest', 'M', NOW(), NOW());

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
(1, 'booth_01', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(2, 'booth_02', 'inactive', 'St Xavier\'s College', 'Student', NOW(),NOW()),
(3, 'booth_03', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(4, 'booth_04', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(5, 'booth_05', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(6, 'booth_06', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(7, 'booth_07', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(8, 'booth_08', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(9, 'booth_09', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(10, 'booth_10', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(11, 'booth_11', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(12, 'booth_12', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(13, 'booth_13', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(14, 'booth_14', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(15, 'booth_15', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(16, 'booth_16', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW()),
(17, 'booth_17', 'inactive', 'St Xavier\'s College', 'Student', NOW(), NOW());


-- ----------------------------------
-- Table structure for table `votes`
-- ----------------------------------

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

-- INSERT INTO `votes` (`vote_id`, `vote`, `candidate_id`, `created_on`, `last_voted_on`) VALUES
-- (15, 11, 9, '2025-01-21 21:00:35', '2025-03-13 00:20:56'),
-- (16, 11, 12, '2025-01-21 21:00:39', '2025-03-12 23:27:54'),
-- (17, 8, 11, '2025-01-21 21:08:33', '2025-03-13 00:14:36'),
-- (18, 10, 10, '2025-01-21 21:08:42', '2025-03-13 00:14:34');

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

-- -------------------------------------
-- Indexes for table `candidates`
-- -------------------------------------
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
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
