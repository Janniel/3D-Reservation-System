-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2023 at 06:50 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soar`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  `reservation_count` int(11) DEFAULT 0,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `code` mediumint(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `username`, `password`, `email`, `picture`, `account_type`, `reservation_count`, `is_archived`, `code`) VALUES
(1, 'ricardojeyms', '$2y$10$21Nsa5xTf5CQ.DfiUWM0xuxp7MsINW7DyQWhOfI2TiNq5L3wm2cye', 'richard@soar.com', NULL, 'admin', 0, 0, 0),
(8, '2020104797', '$2y$10$3Dq.7xWhJ2vtM1UVR9nmSeR2DchdRmQLyfK/nO9wjjY.QOdEAs//e', 'mj23@gmail.com', NULL, 'admin', 0, 0, 0),
(9, '2020104798', '$2y$10$xJ3QMeO6eDXwBtvLHrsyrel.BAmbmuukB3vZB/5SdRFDrSsEd55KK', 'robert.manalili.o@bulsu.edu.ph', NULL, 'admin', 0, 0, 0),
(19, '2020103030', '$2y$10$1A2qthrmbJ5LKWka1xuuruACm8AGqPu8sILhdnoxZ9hbMzoG5606y', 'sydney.bernardo.c@bulsu.edu.ph', 'assets/img/profiledownload.jpg', 'student', 0, 1, 0),
(21, '2020107777', '$2y$10$e.xI/C4JTp9aShfpMxeIu.4q/iAmMzH0JJuWfcrq0CSH8VWAC/6mW', 'cloud.hipolito.c@bulsu.edu.ph', 'assets/img/profileed2105546b534db4e4ebd2635a9184b3e244912e.webp', 'student', 0, 0, 0),
(23, '2020104040', '$2y$10$oXs00rYeFlj9qBmyKd2aO.KAsS1.VvC8k4lLAfZhlcw/0ovBX164e', 'mina.viniegas.o@bulsu.edu.ph', NULL, 'faculty', 0, 0, 0),
(26, '2020104796', '$2y$10$tSWF9Rnkh5.X2c/UYDFSNenSZy5ZEIdpiN3pEW3LCEZrWMHO7Rf4y', 'lara.zambrano.q@bulsu.edu.ph', NULL, 'admin', 0, 0, 0),
(27, '2020103475', '$2y$10$vUyeyqc..iM8OoPztMo43es.BOUXyY7WsMvSYMVpuryfjcIHh9zGS', 'jeaysmie.digo.m@bulsu.edu.ph', 'assets/img/profile95225876.jpg', 'student', 0, 1, 0),
(31, '2020', '$2y$10$9a6rV23YjULBDvqagS8e3ui.BGoEpEH.ArkDmNS3YI3ozq160HwBu', 'zack@gmail.com', NULL, 'student', 0, 1, 0),
(32, '2020', '$2y$10$rmX64yPbnW2HnLbkApvmu.sPaam4BHzopqY939QkhlVf3NwfaZHLe', 'zack@gmail.com', NULL, 'student', 0, 1, 0),
(33, '0404', '$2y$10$glpGEUgA5bILzdM1rG8s/OSRgJjcCl/JKvQEmTYmdE4leZMH6dn8O', 'maryqueen.casaclang.o@bulsu.edu.ph', 'assets/img/profile/108616687.jpg', 'student', 0, 0, 0),
(34, '7070', '$2y$10$n/t5A/KhwBXmw1rijT5ySOJjQG.8xvxNLviyS/KXO/x.k5/sreZMa', 'rinoa@gmail.com', NULL, 'student', 0, 1, 0),
(35, '1111', '$2y$10$MGbSdUHQ4WzK8pzaKGMHEelvZUL6/3XGIYJB/QzZPzeA/iQrZAYAm', 'sandra.velasco.c@bulsu.edu.ph', 'assets/img/woman.jpg', 'faculty', 0, 0, 0),
(36, '2020107070', '$2y$10$SKAz5dTxnospRn.29.wvXOYZq35liflnnZoRea98QzRIRcZG5Hyta', 'gelo.rivera.o@bulsu.edu.ph', 'assets/img/gelo.jpg', 'alumni', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(11) NOT NULL,
  `isSuperAdmin` varchar(3) DEFAULT NULL,
  `rfid_no` varchar(50) DEFAULT NULL,
  `department` varchar(10) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `mobile_no` varchar(15) DEFAULT NULL,
  `tel_no` varchar(15) DEFAULT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `linkedIn_link` varchar(255) DEFAULT NULL,
  `home_address` varchar(255) DEFAULT NULL,
  `work_status` varchar(20) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `picture_admin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `isSuperAdmin`, `rfid_no`, `department`, `first_name`, `last_name`, `gender`, `mobile_no`, `tel_no`, `fb_link`, `linkedIn_link`, `home_address`, `work_status`, `account_id`, `picture_admin`) VALUES
('2020104796', 'no', NULL, 'CAL', 'Marlon', 'Velasco', 'Male', '', '', '', '', '', 'Permanent', 26, 'assets/img/profile/2x2.jpg'),
('2020104797', 'no', NULL, 'CICT', 'Michaela ', 'Jordan', 'Female', '09453661512', '', '', '', '', 'Temporary', 8, NULL),
('2020104798', 'no', NULL, 'CLAW', 'Robert', 'Deniro', 'Male', NULL, NULL, NULL, NULL, NULL, 'Permanent', 9, NULL),
('ricardojeym', 'yes', NULL, 'CICT', 'Richard James', 'Bagay', 'Male', '0976263839', '794-2677', 'facebook.com/ricardojeyms', 'facebook.com/ricardojeyms', 'Barangay Balayong Malolos Bulacan', 'Permanent', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE `college` (
  `college_code` varchar(50) NOT NULL,
  `college_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`college_code`, `college_name`) VALUES
('CAFA', 'College of Architecture and Fine Arts'),
('CAL', 'College of Arts and Letters'),
('CBA', 'College of Business Administration'),
('CCJE', 'College of Criminal Justice Education'),
('CHTM', 'College of Hospitality and Tourism Management'),
('CICT', 'College of Information and Communications Technology'),
('CIT', 'College of Industrial Technology'),
('CLaw', 'College of Law'),
('CN', 'College of Nursing'),
('COE', 'College of Engineering'),
('COED', 'College of Education'),
('CS', 'College of Science'),
('CSER', 'College of Sports, Exercise and Recreation'),
('CSSP', 'College of Social Sciences and Philosophy'),
('GS', 'Graduate School');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_code` varchar(50) NOT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `college_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_code`, `course_name`, `college_code`) VALUES
('Alumni', 'Alumni', 'Alumni'),
('BAB', 'Bachelor of Arts in Broadcasting', 'CAL'),
('BAJ', 'Bachelor of Arts in Journalism', 'CAL'),
('BFA', 'Bachelor of Fine Arts Major in Visual Communication', 'CAFA'),
('BIT', 'Bachelor of Industrial Technology', 'CIT'),
('BLA', 'Bachelor of Landscape Architecture', 'CAFA'),
('BLIS', 'Bachelor of Library and Information Science', 'CICT'),
('BPEA', 'Bachelor of Performing Arts (Theater Track)', 'CAL'),
('BSA', 'Bachelor of Science in Accountancy', 'CBA'),
('BSAR', 'Bachelor of Science in Architecture', 'CAFA'),
('BSBA', 'Bachelor of Science in Business Administration Major in Business Economics', 'CBA'),
('BSC', 'Bachelor of Science in Criminology', 'CCJE'),
('BSCE', 'Bachelor of Science in Civil Engineering', 'COE'),
('BSCPE', 'Bachelor of Science in Computer Engineering', 'COE'),
('BSE', 'Bachelor of Science in Entrepreneurship', 'CBA'),
('BSECE', 'Bachelor of Science in Electronics Engineering', 'COE'),
('BSEE', 'Bachelor of Science in Electrical Engineering', 'COE'),
('BSHM', 'Bachelor of Science in Hospitality Management', 'CHTM'),
('BSIE', 'Bachelor of Science in Industrial Engineering', 'COE'),
('BSIS', 'Bachelor of Science in Information System', 'CICT'),
('BSIT', 'Bachelor of Science in Information Technology', 'CICT'),
('BSLM', 'Bachelor of Arts in Legal Management', 'CCJE'),
('BSME', 'Bachelor of Science in Mechanical Engineering', 'COE'),
('BSMEE', 'Bachelor of Science in Mechatronics Engineering', 'COE'),
('BSMFE', 'Bachelor of Science in Manufacturing Engineering', 'COE'),
('BSN', 'Bachelor of Science in Nursing', 'CN'),
('BSTM', 'Bachelor of Science in Tourism Management', 'CHTM'),
('Faculty', 'Faculty', 'Faculty');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `history_id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `time_spent` time DEFAULT NULL,
  `is_archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`history_id`, `reservation_id`, `date`, `start_time`, `end_time`, `user_id`, `seat_id`, `time_spent`, `is_archived`) VALUES
(44, 99, '2023-10-23', '00:00:00', '14:45:48', 3030, 1, '00:00:00', 1),
(45, 107, '2023-12-21', '00:00:00', '13:50:33', 3030, 2, '00:00:00', 1),
(46, 109, '2023-10-23', '13:59:41', '13:59:59', 2020103475, 1, '00:00:18', 1),
(47, 106, '2023-11-21', '00:00:00', '14:50:25', 7777, 1, '00:00:00', 1),
(48, 110, '2023-10-23', '14:48:57', '14:50:33', 2020103475, 1, '00:01:36', 0),
(49, 100, '2023-10-23', '00:00:00', '15:06:24', 3030, 2, '00:00:00', 0),
(51, 108, '2023-11-23', '00:00:00', '15:49:26', 3030, 5, '00:00:00', 0),
(52, 111, '2023-10-23', '14:52:54', '15:52:27', 2020103475, 1, '00:59:33', 0),
(53, 115, '2023-10-27', '00:00:00', '15:40:02', 404, 5, '00:00:00', 0),
(54, 113, '2023-10-31', '00:00:00', '15:40:02', 404, 3, '00:00:00', 0),
(55, 116, '2023-11-01', '00:00:00', '15:40:02', 7777, 1, '00:00:00', 0),
(56, 117, '2023-10-27', '15:40:32', '15:41:35', 3030, 2, '00:01:03', 0),
(57, 103, '2024-10-24', '00:00:00', '21:31:52', 7777, 4, '00:00:00', 0),
(58, 114, '2024-10-27', '00:00:00', '21:31:52', 404, 4, '00:00:00', 0),
(59, 104, '2024-10-23', '00:00:00', '21:31:52', 7777, 3, '00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `occupy`
--

CREATE TABLE `occupy` (
  `occupy_id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `time_spent` time DEFAULT NULL,
  `isDone` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `occupy`
--

INSERT INTO `occupy` (`occupy_id`, `reservation_id`, `date`, `start_time`, `end_time`, `user_id`, `seat_id`, `time_spent`, `isDone`) VALUES
(89, 109, '2023-10-23', '13:59:41', '13:59:59', 2020103475, 1, '00:00:18', 1),
(90, 110, '2023-10-23', '14:48:57', '14:50:33', 2020103475, 1, '00:01:36', 1),
(91, 111, '2023-10-23', '14:52:54', '15:52:27', 2020103475, 1, '00:59:33', 1),
(92, 117, '2023-10-27', '15:40:32', '15:41:35', 3030, 2, '00:01:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `rating_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `review` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`rating_id`, `rating`, `review`, `date`, `user_id`) VALUES
(7, 5, 'The seat reservation with the 3D is very convenient to use', '2023-10-23', 2020103475),
(8, 4, 'I suggest to make a notification once my reservation schedule is near', '2023-10-23', 2020103475),
(9, 5, 'I like it that you can have choices in reserving seats.', '2023-10-27', 3030);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `isDone` tinyint(4) NOT NULL,
  `is_archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `date`, `start_time`, `end_time`, `user_id`, `seat_id`, `isDone`, `is_archived`) VALUES
(99, '2023-10-23', '13:03:00', '14:03:00', 3030, 1, 1, 0),
(100, '2024-10-23', '13:58:00', '14:58:00', 3030, 2, 1, 0),
(103, '2024-10-24', '12:37:00', '16:37:00', 7777, 4, 1, 0),
(104, '2024-10-23', '15:37:00', '16:37:00', 7777, 3, 1, 0),
(105, '2023-10-24', '14:45:00', '15:45:00', 7777, 3, 1, 0),
(106, '2023-11-21', '12:50:00', '14:50:00', 7777, 1, 1, 0),
(107, '2023-12-21', '12:48:00', '13:48:00', 3030, 2, 1, 0),
(108, '2023-11-23', '12:48:00', '15:48:00', 3030, 5, 1, 0),
(109, '2024-10-23', '13:58:00', '14:58:00', 2020103475, 1, 1, 0),
(110, '2024-10-23', '14:48:00', '15:48:00', 2020103475, 1, 1, 0),
(111, '2024-10-23', '14:51:00', '15:51:00', 2020103475, 1, 1, 0),
(113, '2023-10-31', '13:22:00', '14:22:00', 404, 3, 1, 0),
(114, '2024-10-27', '13:22:00', '16:22:00', 404, 4, 1, 0),
(115, '2023-10-27', '13:23:00', '14:23:00', 404, 5, 1, 0),
(116, '2023-11-01', '13:35:00', '14:35:00', 7777, 1, 1, 0),
(117, '2023-10-27', '15:40:00', '16:40:00', 3030, 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `seat_id` int(11) NOT NULL,
  `seat_number` varchar(50) DEFAULT NULL,
  `data_surface` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`seat_id`, `seat_number`, `data_surface`, `status`) VALUES
(1, '1', '221 2 495 496 497 0.513 0.203 0.284\r\n', '0'),
(2, '2', '220 3 7 10 9 0.179 0.274 0.547', '0'),
(3, '3', '219 3 11 10 12 0.125 0.438 0.437', '0'),
(4, '4', '218 1 823 824 826 0.428 0.044 0.528\r\n', '0'),
(5, '5', '222 1 437 438 478 0.134 0.069 0.796', '0');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settings_id` int(11) NOT NULL,
  `reservation` tinyint(1) DEFAULT NULL,
  `minDuration` int(11) DEFAULT NULL,
  `maxDuration` int(11) DEFAULT NULL,
  `reservePerDay` int(11) NOT NULL,
  `start_hour` time NOT NULL,
  `end_hour` time NOT NULL,
  `disabled_dates` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settings_id`, `reservation`, `minDuration`, `maxDuration`, `reservePerDay`, `start_hour`, `end_hour`, `disabled_dates`) VALUES
(1, 0, 1, 4, 4, '10:00:00', '17:00:00', '[\"2023-10-01\",\"2023-10-08\",\"2023-10-15\",\"2023-10-22\",\"2023-10-29\",\"2023-10-07\",\"2023-10-14\",\"2023-10-28\",\"2023-10-21\",\"2023-09-02\",\"2023-09-09\",\"2023-09-16\",\"2023-09-23\",\"2023-09-30\",\"2023-11-05\",\"2023-11-12\",\"2023-11-19\",\"2023-11-26\",\"2023-12-03\",\"2023-12-10\",\"2023-12-17\",\"2023-12-24\",\"2023-12-31\",\"2023-12-02\",\"2023-12-09\",\"2023-12-16\",\"2023-12-30\",\"2023-12-23\",\"2023-12-25\",\"2023-11-25\",\"2023-11-18\",\"2023-11-11\",\"2023-11-04\",\"2024-01-07\",\"2024-01-14\",\"2024-01-21\",\"2024-01-28\",\"2024-01-06\",\"2024-01-13\",\"2024-01-20\",\"2024-01-27\",\"2024-02-03\",\"2024-02-10\",\"2024-02-17\",\"2023-09-24\",\"2023-09-17\",\"2023-09-10\",\"2023-09-03\",\"2023-08-27\"]');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `rfid_no` varchar(50) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `course_code` varchar(50) DEFAULT NULL,
  `yearsec_id` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `is_archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `rfid_no`, `first_name`, `last_name`, `account_id`, `course_code`, `yearsec_id`, `age`, `contact_number`, `is_archived`) VALUES
(404, '203hd5h', 'Mary Queeny', 'Casaclang', 33, 'BSN', 2, NULL, NULL, 0),
(1111, 'djr5jse', 'Sandra', 'Velasco', 35, 'FACULTY', 261, NULL, NULL, 0),
(2020, NULL, 'Zack', 'Fair', 32, 'BLIS', 1, NULL, NULL, 1),
(3030, '56uy78j', 'Sydney', 'Bernardo', 19, 'BSIT', 261, 21, '09453661518', 1),
(7070, NULL, 'Rinoa', 'Heartily', 34, 'BSA', 56, NULL, NULL, 1),
(7777, '5hfcn4e', 'Cloud', 'Hipolito', 21, 'BSN', 113, 23, '09453661517', 0),
(2020103475, '3def45t', 'Jeays', 'Digo', 27, 'BSIT', 165, NULL, NULL, 1),
(2020107070, '12sd80k', 'Gelo', 'Rivera', 36, 'ALUMNI', 261, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `yearsec`
--

CREATE TABLE `yearsec` (
  `yearsec_id` int(11) NOT NULL,
  `year_level` int(11) DEFAULT NULL,
  `section` varchar(10) DEFAULT NULL,
  `section_group` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `yearsec`
--

INSERT INTO `yearsec` (`yearsec_id`, `year_level`, `section`, `section_group`) VALUES
(1, 1, 'A', '1'),
(2, 1, 'A', '2'),
(3, 1, 'B', '1'),
(4, 1, 'B', '2'),
(5, 1, 'C', '1'),
(6, 1, 'C', '2'),
(7, 1, 'D', '1'),
(8, 1, 'D', '2'),
(9, 1, 'E', '1'),
(10, 1, 'E', '2'),
(11, 1, 'F', '1'),
(12, 1, 'F', '2'),
(13, 1, 'G', '1'),
(14, 1, 'G', '2'),
(15, 1, 'H', '1'),
(16, 1, 'H', '2'),
(17, 1, 'I', '1'),
(18, 1, 'I', '2'),
(19, 1, 'J', '1'),
(20, 1, 'J', '2'),
(21, 1, 'K', '1'),
(22, 1, 'K', '2'),
(23, 1, 'L', '1'),
(24, 1, 'L', '2'),
(25, 1, 'M', '1'),
(26, 1, 'M', '2'),
(27, 1, 'N', '1'),
(28, 1, 'N', '2'),
(29, 1, 'O', '1'),
(30, 1, 'O', '2'),
(31, 1, 'P', '1'),
(32, 1, 'P', '2'),
(33, 1, 'Q', '1'),
(34, 1, 'Q', '2'),
(35, 1, 'R', '1'),
(36, 1, 'R', '2'),
(37, 1, 'S', '1'),
(38, 1, 'S', '2'),
(39, 1, 'T', '1'),
(40, 1, 'T', '2'),
(41, 1, 'U', '1'),
(42, 1, 'U', '2'),
(43, 1, 'V', '1'),
(44, 1, 'V', '2'),
(45, 1, 'W', '1'),
(46, 1, 'W', '2'),
(47, 1, 'X', '1'),
(48, 1, 'X', '2'),
(49, 1, 'Y', '1'),
(50, 1, 'Y', '2'),
(51, 1, 'Z', '1'),
(52, 1, 'Z', '2'),
(53, 2, 'A', '1'),
(54, 2, 'A', '2'),
(55, 2, 'B', '1'),
(56, 2, 'B', '2'),
(57, 2, 'C', '1'),
(58, 2, 'C', '2'),
(59, 2, 'D', '1'),
(60, 2, 'D', '2'),
(61, 2, 'E', '1'),
(62, 2, 'E', '2'),
(63, 2, 'F', '1'),
(64, 2, 'F', '2'),
(65, 2, 'G', '1'),
(66, 2, 'G', '2'),
(67, 2, 'H', '1'),
(68, 2, 'H', '2'),
(69, 2, 'I', '1'),
(70, 2, 'I', '2'),
(71, 2, 'J', '1'),
(72, 2, 'J', '2'),
(73, 2, 'K', '1'),
(74, 2, 'K', '2'),
(75, 2, 'L', '1'),
(76, 2, 'L', '2'),
(77, 2, 'M', '1'),
(78, 2, 'M', '2'),
(79, 2, 'N', '1'),
(80, 2, 'N', '2'),
(81, 2, 'O', '1'),
(82, 2, 'O', '2'),
(83, 2, 'P', '1'),
(84, 2, 'P', '2'),
(85, 2, 'Q', '1'),
(86, 2, 'Q', '2'),
(87, 2, 'R', '1'),
(88, 2, 'R', '2'),
(89, 2, 'S', '1'),
(90, 2, 'S', '2'),
(91, 2, 'T', '1'),
(92, 2, 'T', '2'),
(93, 2, 'U', '1'),
(94, 2, 'U', '2'),
(95, 2, 'V', '1'),
(96, 2, 'V', '2'),
(97, 2, 'W', '1'),
(98, 2, 'W', '2'),
(99, 2, 'X', '1'),
(100, 2, 'X', '2'),
(101, 2, 'Y', '1'),
(102, 2, 'Y', '2'),
(103, 2, 'Z', '1'),
(104, 2, 'Z', '2'),
(105, 3, 'A', '1'),
(106, 3, 'A', '2'),
(107, 3, 'B', '1'),
(108, 3, 'B', '2'),
(109, 3, 'C', '1'),
(110, 3, 'C', '2'),
(111, 3, 'D', '1'),
(112, 3, 'D', '2'),
(113, 3, 'E', '1'),
(114, 3, 'E', '2'),
(115, 3, 'F', '1'),
(116, 3, 'F', '2'),
(117, 3, 'G', '1'),
(118, 3, 'G', '2'),
(119, 3, 'H', '1'),
(120, 3, 'H', '2'),
(121, 3, 'I', '1'),
(122, 3, 'I', '2'),
(123, 3, 'J', '1'),
(124, 3, 'J', '2'),
(125, 3, 'K', '1'),
(126, 3, 'K', '2'),
(127, 3, 'L', '1'),
(128, 3, 'L', '2'),
(129, 3, 'M', '1'),
(130, 3, 'M', '2'),
(131, 3, 'N', '1'),
(132, 3, 'N', '2'),
(133, 3, 'O', '1'),
(134, 3, 'O', '2'),
(135, 3, 'P', '1'),
(136, 3, 'P', '2'),
(137, 3, 'Q', '1'),
(138, 3, 'Q', '2'),
(139, 3, 'R', '1'),
(140, 3, 'R', '2'),
(141, 3, 'S', '1'),
(142, 3, 'S', '2'),
(143, 3, 'T', '1'),
(144, 3, 'T', '2'),
(145, 3, 'U', '1'),
(146, 3, 'U', '2'),
(147, 3, 'V', '1'),
(148, 3, 'V', '2'),
(149, 3, 'W', '1'),
(150, 3, 'W', '2'),
(151, 3, 'X', '1'),
(152, 3, 'X', '2'),
(153, 3, 'Y', '1'),
(154, 3, 'Y', '2'),
(155, 3, 'Z', '1'),
(156, 3, 'Z', '2'),
(157, 4, 'A', '1'),
(158, 4, 'A', '2'),
(159, 4, 'B', '1'),
(160, 4, 'B', '2'),
(161, 4, 'C', '1'),
(162, 4, 'C', '2'),
(163, 4, 'D', '1'),
(164, 4, 'D', '2'),
(165, 4, 'E', '1'),
(166, 4, 'E', '2'),
(167, 4, 'F', '1'),
(168, 4, 'F', '2'),
(169, 4, 'G', '1'),
(170, 4, 'G', '2'),
(171, 4, 'H', '1'),
(172, 4, 'H', '2'),
(173, 4, 'I', '1'),
(174, 4, 'I', '2'),
(175, 4, 'J', '1'),
(176, 4, 'J', '2'),
(177, 4, 'K', '1'),
(178, 4, 'K', '2'),
(179, 4, 'L', '1'),
(180, 4, 'L', '2'),
(181, 4, 'M', '1'),
(182, 4, 'M', '2'),
(183, 4, 'N', '1'),
(184, 4, 'N', '2'),
(185, 4, 'O', '1'),
(186, 4, 'O', '2'),
(187, 4, 'P', '1'),
(188, 4, 'P', '2'),
(189, 4, 'Q', '1'),
(190, 4, 'Q', '2'),
(191, 4, 'R', '1'),
(192, 4, 'R', '2'),
(193, 4, 'S', '1'),
(194, 4, 'S', '2'),
(195, 4, 'T', '1'),
(196, 4, 'T', '2'),
(197, 4, 'U', '1'),
(198, 4, 'U', '2'),
(199, 4, 'V', '1'),
(200, 4, 'V', '2'),
(201, 4, 'W', '1'),
(202, 4, 'W', '2'),
(203, 4, 'X', '1'),
(204, 4, 'X', '2'),
(205, 4, 'Y', '1'),
(206, 4, 'Y', '2'),
(207, 4, 'Z', '1'),
(208, 4, 'Z', '2'),
(209, 5, 'A', '1'),
(210, 5, 'A', '2'),
(211, 5, 'B', '1'),
(212, 5, 'B', '2'),
(213, 5, 'C', '1'),
(214, 5, 'C', '2'),
(215, 5, 'D', '1'),
(216, 5, 'D', '2'),
(217, 5, 'E', '1'),
(218, 5, 'E', '2'),
(219, 5, 'F', '1'),
(220, 5, 'F', '2'),
(221, 5, 'G', '1'),
(222, 5, 'G', '2'),
(223, 5, 'H', '1'),
(224, 5, 'H', '2'),
(225, 5, 'I', '1'),
(226, 5, 'I', '2'),
(227, 5, 'J', '1'),
(228, 5, 'J', '2'),
(229, 5, 'K', '1'),
(230, 5, 'K', '2'),
(231, 5, 'L', '1'),
(232, 5, 'L', '2'),
(233, 5, 'M', '1'),
(234, 5, 'M', '2'),
(235, 5, 'N', '1'),
(236, 5, 'N', '2'),
(237, 5, 'O', '1'),
(238, 5, 'O', '2'),
(239, 5, 'P', '1'),
(240, 5, 'P', '2'),
(241, 5, 'Q', '1'),
(242, 5, 'Q', '2'),
(243, 5, 'R', '1'),
(244, 5, 'R', '2'),
(245, 5, 'S', '1'),
(246, 5, 'S', '2'),
(247, 5, 'T', '1'),
(248, 5, 'T', '2'),
(249, 5, 'U', '1'),
(250, 5, 'U', '2'),
(251, 5, 'V', '1'),
(252, 5, 'V', '2'),
(253, 5, 'W', '1'),
(254, 5, 'W', '2'),
(255, 5, 'X', '1'),
(256, 5, 'X', '2'),
(257, 5, 'Y', '1'),
(258, 5, 'Y', '2'),
(259, 5, 'Z', '1'),
(260, 5, 'Z', '2'),
(261, 0, 'NONE', 'NONE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`college_code`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_code`),
  ADD KEY `college_code` (`college_code`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `seat_id` (`seat_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `occupy`
--
ALTER TABLE `occupy`
  ADD PRIMARY KEY (`occupy_id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `seat_id` (`seat_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `seat_id` (`seat_id`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`seat_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `course_code` (`course_code`),
  ADD KEY `yearsec_id` (`yearsec_id`);

--
-- Indexes for table `yearsec`
--
ALTER TABLE `yearsec`
  ADD PRIMARY KEY (`yearsec_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `occupy`
--
ALTER TABLE `occupy`
  MODIFY `occupy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`reservation_id`),
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `history_ibfk_3` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`seat_id`);

--
-- Constraints for table `occupy`
--
ALTER TABLE `occupy`
  ADD CONSTRAINT `occupy_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`reservation_id`),
  ADD CONSTRAINT `occupy_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `occupy_ibfk_3` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`seat_id`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`seat_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`course_code`) REFERENCES `course` (`course_code`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`yearsec_id`) REFERENCES `yearsec` (`yearsec_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
