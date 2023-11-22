-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2023 at 07:16 AM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `username`, `password`, `email`, `picture`, `account_type`, `reservation_count`, `is_archived`, `code`) VALUES
(1, 'ricardojeyms', '$2y$10$21Nsa5xTf5CQ.DfiUWM0xuxp7MsINW7DyQWhOfI2TiNq5L3wm2cye', 'richard@soar.com', NULL, 'admin', 0, 0, 0),
(8, '2020104797', '$2y$10$3Dq.7xWhJ2vtM1UVR9nmSeR2DchdRmQLyfK/nO9wjjY.QOdEAs//e', 'mj23@gmail.com', NULL, 'admin', 0, 0, 0),
(9, '2020104798', '$2y$10$xJ3QMeO6eDXwBtvLHrsyrel.BAmbmuukB3vZB/5SdRFDrSsEd55KK', 'robert.manalili.o@bulsu.edu.ph', NULL, 'admin', 0, 0, 0),
(19, '2020103030', '$2y$10$1A2qthrmbJ5LKWka1xuuruACm8AGqPu8sILhdnoxZ9hbMzoG5606y', 'sydney.bernardo.c@bulsu.edu.ph', '/img/profiledownload.jpg', 'student', 0, 1, 0),
(21, '2020107777', '$2y$10$e.xI/C4JTp9aShfpMxeIu.4q/iAmMzH0JJuWfcrq0CSH8VWAC/6mW', 'cloud.hipolito.c@bulsu.edu.ph', '/img/profileed2105546b534db4e4ebd2635a9184b3e244912e.webp', 'student', 0, 0, 0),
(23, '2020104040', '$2y$10$oXs00rYeFlj9qBmyKd2aO.KAsS1.VvC8k4lLAfZhlcw/0ovBX164e', 'mina.viniegas.o@bulsu.edu.ph', NULL, 'faculty', 0, 0, 0),
(26, '2020104796', '$2y$10$tSWF9Rnkh5.X2c/UYDFSNenSZy5ZEIdpiN3pEW3LCEZrWMHO7Rf4y', 'lara.zambrano.q@bulsu.edu.ph', NULL, 'admin', 0, 0, 0),
(27, '2020103475', '$2y$10$vUyeyqc..iM8OoPztMo43es.BOUXyY7WsMvSYMVpuryfjcIHh9zGS', 'jeaysmie.digo.m@bulsu.edu.ph', './img/profilejeays.jpg', 'student', 0, 0, 0),
(31, '2020', '$2y$10$9a6rV23YjULBDvqagS8e3ui.BGoEpEH.ArkDmNS3YI3ozq160HwBu', 'zack@gmail.com', NULL, 'student', 0, 0, 0),
(32, '2020', '$2y$10$rmX64yPbnW2HnLbkApvmu.sPaam4BHzopqY939QkhlVf3NwfaZHLe', 'zack@gmail.com', NULL, 'student', 0, 0, 0),
(33, '0404', '$2y$10$0VKZaczmsRl.657mMrZN4u/0TcwNtHg7dCrgmJC14YLgWLFNLrQ8.', 'maryqueen.casaclang.o@bulsu.edu.ph', 'assets/img/profile/108616687.jpg', 'student', 0, 0, 0),
(34, '7070', '$2y$10$n/t5A/KhwBXmw1rijT5ySOJjQG.8xvxNLviyS/KXO/x.k5/sreZMa', 'rinoa@gmail.com', NULL, 'student', 0, 0, 0),
(35, '1111', '$2y$10$MGbSdUHQ4WzK8pzaKGMHEelvZUL6/3XGIYJB/QzZPzeA/iQrZAYAm', 'sandra.velasco.c@bulsu.edu.ph', 'assets/img/woman.jpg', 'faculty', 0, 0, 0),
(36, '2020107070', '$2y$10$SKAz5dTxnospRn.29.wvXOYZq35liflnnZoRea98QzRIRcZG5Hyta', 'gelo.rivera.o@bulsu.edu.ph', './img/profile/gelo.jpg', 'alumni', 0, 0, 0),
(37, '123', '$2y$10$oj4zdmQjsZI1rOhJ9qGv.uIB94rkPli7aDn.yQQNQNrOa32a03R4a', 'juan@soar.com', './img/profile/gelo.jpg', 'faculty', 0, 0, 0),
(38, '2581406', '$2y$10$hxhT64eAXC/fXd6BRGeo3./Z5WVUcM..mZNhs0DkkSeO1MGSpbiu.', 'asd@gmail.com', NULL, 'faculty', 0, 0, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `cancel_reason` varchar(255) NOT NULL,
  `is_archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`history_id`, `reservation_id`, `date`, `start_time`, `end_time`, `user_id`, `seat_id`, `time_spent`, `cancel_reason`, `is_archived`) VALUES
(90, 151, '2023-11-14', '00:00:00', '00:00:00', 123, 4, '00:00:00', 'Changed plans', 0),
(91, 151, '2023-11-14', '00:00:00', '00:00:00', 123, 4, '00:00:00', 'Changed plans', 0),
(92, 151, '2023-11-14', '00:00:00', '00:00:00', 123, 4, '00:00:00', 'Changed plans', 0),
(93, 152, '2023-11-14', '00:00:00', '00:00:00', 123, 5, '00:00:00', 'Changed plans', 0),
(94, 153, '2023-11-14', '00:00:00', '00:00:00', 2020103475, 5, '00:00:00', 'No longer needed', 0),
(95, 147, '2023-12-05', '00:00:00', '00:00:00', 2020103475, 5, '00:00:00', 'Changed plans', 0),
(96, 154, '2023-11-17', '00:00:00', '00:00:00', 2020103475, 5, '00:00:00', 'Changed plans', 0),
(97, 155, '2023-11-29', '00:00:00', '22:46:49', 2020103475, 5, '00:00:00', '', 0),
(98, 157, '2023-11-30', '00:00:00', '00:00:00', 2020103475, 5, '00:00:00', 'Changed plans', 0),
(99, 156, '2023-11-30', '00:00:00', '00:00:00', 2020103475, 5, '00:00:00', 'No longer needed', 0),
(100, 158, '2023-11-30', '00:00:00', '00:00:00', 2020103475, 4, '00:00:00', 'Emergency', 0),
(101, 165, '2023-11-22', '00:00:00', '00:00:00', 2020107070, 125, '00:00:00', 'Change in Schedule', 0),
(102, 166, '2023-11-22', '00:00:00', '12:38:45', 2020107070, 59, '00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notif_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_archived` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notif_id`, `user_id`, `is_archived`, `message`, `date`) VALUES
(3, 2020103475, '', 'reserved seat 2 on 12:00 AM from 05:30 PM to 06:30 PM', '2023-11-14 09:12:07'),
(6, 2020103475, '', 'cancelled a reservation with reservation ID: 144', '2023-11-14 09:22:50'),
(7, 2020103475, '', 'reserved seat 4 on November 14, 2023 from 05:30 PM to 06:00 PM', '2023-11-14 09:23:37'),
(8, 2020103475, '', 'occupied seat 4 successfully.', '2023-11-14 09:29:37'),
(10, 2020103475, '', 'reserved seat 3 on November 14, 2023 from 05:45 PM to 06:15 PM', '2023-11-14 09:43:08'),
(11, 2020103475, '', 'occupied seat 3 successfully.', '2023-11-14 09:44:15'),
(12, 2020103475, '', 'was done occupying a seat.', '2023-11-14 09:44:37'),
(13, 2020103475, '', 'submitted 5 start ratings and review. Nice experience! ', '2023-11-14 09:59:01'),
(14, 2020103475, '', 'reserved seat 5 on December 5, 2023 from 08:15 PM to 08:45 PM', '2023-11-14 12:05:18'),
(15, 123, '', 'reserved seat 4 on November 14, 2023 from 08:30 PM to 09:30 PM', '2023-11-14 12:26:37'),
(16, 123, '', 'cancelled a reservation with reservation ID: 148', '2023-11-14 12:27:03'),
(17, 123, '', 'reserved seat 5 on November 14, 2023 from 08:30 PM to 09:30 PM', '2023-11-14 12:27:30'),
(18, 123, '', 'was done occupying a seat.', '2023-11-14 12:43:24'),
(19, 123, '', 'reserved seat 4 on December 8, 2023 from 09:00 PM to 10:00 PM', '2023-11-14 12:47:49'),
(20, 123, '', 'cancelled a reservation with reservation ID: 150', '2023-11-14 12:58:37'),
(21, 123, '', 'reserved seat 4 on November 14, 2023 from 09:15 PM to 10:45 PM', '2023-11-14 13:00:32'),
(22, 123, '', 'cancelled a reservation with reservation ID: 151', '2023-11-14 13:00:41'),
(23, 123, '', 'cancelled a reservation with reservation ID: 151', '2023-11-14 13:02:06'),
(24, 123, '', 'cancelled a reservation with reservation ID: 151', '2023-11-14 13:02:27'),
(25, 123, '', 'cancelled a reservation with reservation ID: 151', '2023-11-14 13:03:51'),
(26, 123, '', 'reserved seat 5 on November 14, 2023 from 09:00 PM to 09:30 PM', '2023-11-14 13:04:08'),
(27, 123, '', 'cancelled a reservation with reservation ID: 152', '2023-11-14 13:04:27'),
(28, 2020103475, '', 'reserved seat 5 on November 14, 2023 from 09:15 PM to 10:15 PM', '2023-11-14 13:08:18'),
(29, 2020103475, '', 'cancelled a reservation with reservation ID: 153', '2023-11-14 13:08:31'),
(30, 2020103475, '', 'cancelled a reservation with reservation ID: 147 ', '2023-11-17 07:30:10'),
(31, 2020103475, '', 'cancelled a reservation with reservation ID: 154 ', '2023-11-17 07:30:20'),
(32, 2020103475, '', 'reserved seat 5 on November 29, 2023 from 05:00 PM to 05:30 PM', '2023-11-17 09:00:23'),
(33, 2020103475, '', 'reserved seat 5 on November 30, 2023 from 12:30 AM to 01:00 AM', '2023-11-17 16:37:06'),
(34, 2020103475, '', 'reserved seat 5 on November 30, 2023 from 09:45 AM to 10:15 AM', '2023-11-21 01:48:47'),
(35, 2020103475, '', 'reserved seat 4 on November 30, 2023 from 09:45 AM to 10:45 AM', '2023-11-21 01:49:07'),
(36, 2020103475, '', 'reserved seat 4 on November 24, 2023 from 09:45 AM to 11:15 AM', '2023-11-21 01:49:30'),
(37, 2020103475, '', 'reserved seat 4 on November 29, 2023 from 09:45 AM to 10:15 AM', '2023-11-21 01:49:47'),
(38, 2020103475, '', 'cancelled a reservation with reservation ID: 157 ', '2023-11-21 01:53:45'),
(39, 2020103475, '', 'cancelled a reservation with reservation ID: 156 ', '2023-11-21 02:44:29'),
(40, 2020103475, '', 'cancelled a reservation with reservation ID: 158 ', '2023-11-21 02:44:47'),
(41, 2020103475, '', 'reserved seat 128 on November 22, 2023 from 10:15 AM to 11:00 PM', '2023-11-22 02:05:35'),
(42, 2020103475, '', 'reserved seat 129 on November 22, 2023 from 12:00 AM to 12:00 AM', '2023-11-22 02:05:50'),
(43, 2020103475, '', 'reserved seat 126 on November 22, 2023 from 10:15 AM to 10:30 AM', '2023-11-22 02:06:17'),
(44, 2020107070, '', 'reserved seat 5 on November 22, 2023 from 10:15 AM to 10:30 AM', '2023-11-22 02:09:24'),
(45, 2020107070, '', 'reserved seat 125 on November 22, 2023 from 10:15 AM to 10:30 AM', '2023-11-22 02:09:37'),
(46, 2020107070, '', 'reserved seat 59 on November 22, 2023 from 12:15 PM to 01:15 PM', '2023-11-22 04:09:27'),
(47, 2020107070, '', 'was done occupying a seat.', '2023-11-22 04:38:45');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`rating_id`, `rating`, `review`, `date`, `user_id`) VALUES
(7, 5, 'The seat reservation with the 3D is very convenient to use', '2023-10-23', 2020103475),
(8, 4, 'I suggest to make a notification once my reservation schedule is near', '2023-10-23', 2020103475),
(9, 5, 'I like it that you can have choices in reserving seats.', '2023-10-27', 3030),
(10, 5, 'Nice experience!', '2023-11-14', 2020103475);

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
  `rfid_no` bigint(30) NOT NULL DEFAULT 0,
  `isDone` tinyint(4) NOT NULL DEFAULT 0,
  `is_archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `date`, `start_time`, `end_time`, `user_id`, `seat_id`, `rfid_no`, `isDone`, `is_archived`) VALUES
(166, '2023-11-22', '12:15:00', '13:15:00', 2020107070, 59, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `seat_id` int(11) NOT NULL,
  `seat_number` varchar(50) NOT NULL,
  `seat_name` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `timer` varchar(50) NOT NULL,
  `reservation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`seat_id`, `seat_number`, `seat_name`, `status`, `message`, `timer`, `reservation_id`) VALUES
(1, '6_CompChair_2', 'B1', '0', 'ok', '0', 0),
(2, '6_CompChair_1', 'B2', '404', 'ok', '0', 0),
(3, '6_CompChair_5', 'B3', '0', 'ok', '0', 0),
(4, '6_CompChair_4', 'B4', '0', 'ok', '0', 0),
(5, '6_CompChair_3', 'B5', '0', 'ok', '0', 0),
(6, '10_CompChair_5', 'B6', '0', 'ok', '0', 0),
(7, '10_CompChair_1', 'B7', '0', 'ok', '0', 0),
(8, '10_CompChair_2', 'B8', '0', 'ok', '0', 0),
(9, '10_CompChair_4', 'B9', '0', 'ok', '0', 0),
(10, '10_CompChair_3', 'B10', '0', 'ok', '0', 0),
(11, '12_CompChair_2', 'B11', '0', 'ok', '0', 0),
(12, '12_CompChair_1', 'B12', '0', 'ok', '0', 0),
(13, '12_CompChair_5', 'B13', '0', 'ok', '0', 0),
(14, '12_CompChair_4', 'B14', '0', 'ok', '0', 0),
(15, '12_CompChair_3', 'B15', '0', 'ok', '0', 0),
(16, '5_CompChair_2', 'B16', '0', 'ok', '0', 0),
(17, '5_CompChair_1', 'B17', '0', 'ok', '0', 0),
(18, '5_CompChair_5', 'B18', '0', 'ok', '0', 0),
(19, '5_CompChair_4', 'B19', '0', 'ok', '0', 0),
(20, '5_CompChair_3', 'B20', '0', 'ok', '0', 0),
(21, '9_CompChair_5', 'B21', '0', 'ok', '0', 0),
(22, '9_CompChair_1', 'B22', '0', 'ok', '0', 0),
(23, '9_CompChair_2', 'B23', '0', 'ok', '0', 0),
(24, '9_CompChair_4', 'B24', '0', 'ok', '0', 0),
(25, '9_CompChair_3', 'B25', '0', 'ok', '0', 0),
(26, '11_CompChair_2', 'B26', '0', 'ok', '0', 0),
(27, '11_CompChair_1', 'B27', '0', 'ok', '0', 0),
(28, '11_CompChair_5', 'B28', '0', 'ok', '0', 0),
(29, '11_CompChair_4', 'B29', '0', 'ok', '0', 0),
(30, '11_CompChair_3', 'B30', '0', 'ok', '0', 0),
(31, '4_CompChair_2', 'B31', '0', 'ok', '0', 0),
(32, '4_CompChair_1', 'B32', '0', 'ok', '0', 0),
(33, '4_CompChair_5', 'B33', '0', 'ok', '0', 0),
(34, '4_CompChair_4', 'B34', '0', 'ok', '0', 0),
(35, '4_CompChair_3', 'B35', '0', 'ok', '0', 0),
(36, '7_CompChair_5', 'B36', '0', 'ok', '0', 0),
(37, '7_CompChair_1', 'B37', '0', 'ok', '0', 0),
(38, '7_CompChair_2', 'B38', '0', 'ok', '0', 0),
(39, '7_CompChair_4', 'B39', '0', 'ok', '0', 0),
(40, '7_CompChair_3', 'B40', '0', 'ok', '0', 0),
(41, '8_CompChair_2', 'B41', '0', 'ok', '0', 0),
(42, '8_CompChair_1', 'B42', '0', 'ok', '0', 0),
(43, '8_CompChair_5', 'B43', '0', 'ok', '0', 0),
(44, '8_CompChair_4', 'B44', '0', 'ok', '0', 0),
(45, '3_CompChair_3', 'B45', '0', 'ok', '0', 0),
(46, '3_CompChair_2', 'B46', '0', 'ok', '0', 0),
(47, '3_CompChair_1', 'B47', '0', 'ok', '0', 0),
(48, '3_CompChair_5', 'B48', '0', 'ok', '0', 0),
(49, '3_CompChair_4', 'B49', '0', 'ok', '0', 0),
(50, '3_CompChair_3', 'B50', '0', 'ok', '0', 0),
(51, '2_CompChair_5', 'B51', '0', 'ok', '0', 0),
(52, '2_CompChair_1', 'B52', '0', 'ok', '0', 0),
(53, '2_CompChair_2', 'B53', '0', 'ok', '0', 0),
(54, '2_CompChair_4', 'B54', '0', 'ok', '0', 0),
(55, '2_CompChair_3', 'B55', '0', 'ok', '0', 0),
(56, '1_CompChair_2', 'B56', '0', 'ok', '0', 0),
(57, '1_CompChair_1', 'B57', '0', 'ok', '0', 0),
(58, '1_CompChair_5', 'B58', '0', 'ok', '0', 0),
(59, '1_CompChair_4', 'B59', '0', 'ok', '0', 0),
(60, '1_CompChair_3', 'B60', '0', 'ok', '0', 0),
(61, 'CI_CompChair_4', 'A1', '0', 'ok', '0', 0),
(62, 'CI_CompChair_3', 'A2', '0', 'ok', '0', 0),
(63, 'CI_CompChair_2', 'A3', '0', 'ok', '0', 0),
(64, 'CI_CompChair_1', 'A4', '404', 'ok', '0', 0),
(65, 'CI_CompChair_5', 'A5', '0', 'ok', '0', 0),
(66, 'CI_CompChair_6', 'A6', '0', 'ok', '0', 0),
(67, 'CI_CompChair_7', 'A7', '0', 'ok', '0', 0),
(68, 'CI_CompChair_8', 'A8', '0', 'ok', '0', 0),
(69, 'CG_CompChair_4', 'A9', '404', 'ok', '0', 0),
(70, 'CG_CompChair_3', 'A10', '0', 'ok', '0', 0),
(71, 'CG_CompChair_2', 'A11', '404', 'ok', '0', 0),
(72, 'CG_CompChair_1', 'A12', '0', 'ok', '0', 0),
(73, 'CH_CompChair_5', 'A13', '0', 'ok', '0', 0),
(74, 'CH_CompChair_6', 'A14', '0', 'ok', '0', 0),
(75, 'CH_CompChair_7', 'A15', '0', 'ok', '0', 0),
(76, 'CH_CompChair_8', 'A16', '0', 'ok', '0', 0),
(77, 'CG_CompChair_4', 'A17', '0', 'ok', '0', 0),
(78, 'CG_CompChair_3', 'A18', '0', 'ok', '0', 0),
(79, 'CG_CompChair_2', 'A19', '0', 'ok', '0', 0),
(80, 'CG_CompChair_1', 'A20', '0', 'ok', '0', 0),
(81, 'CG_CompChair_5', 'A21', '0', 'ok', '0', 0),
(82, 'CG_CompChair_6', 'A22', '0', 'ok', '0', 0),
(83, 'CG_CompChair_7', 'A23', '0', 'ok', '0', 0),
(84, 'CG_CompChair_8', 'A24', '0', 'ok', '0', 0),
(85, 'CF_CompChair_4', 'A25', '0', 'ok', '0', 0),
(86, 'CF_CompChair_3', 'A26', '0', 'ok', '0', 0),
(87, 'CF_CompChair_2', 'A27', '0', 'ok', '0', 0),
(88, 'CF_CompChair_1', 'A28', '0', 'ok', '0', 0),
(89, 'CF_CompChair_5', 'A29', '0', 'ok', '0', 0),
(90, 'CF_CompChair_6', 'A30', '0', 'ok', '0', 0),
(91, 'CF_CompChair_7', 'A31', '0', 'ok', '0', 0),
(92, 'CF_CompChair_8', 'A32', '404', 'ok', '0', 0),
(93, 'CE_CompChair_4', 'A33', '0', 'ok', '0', 0),
(94, 'CE_CompChair_3', 'A34', '0', 'ok', '0', 0),
(95, 'CE_CompChair_2', 'A35', '0', 'ok', '0', 0),
(96, 'CE_CompChair_1', 'A36', '404', 'ok', '0', 0),
(97, 'CE_CompChair_5', 'A37', '0', 'ok', '0', 0),
(98, 'CE_CompChair_6', 'A38', '0', 'ok', '0', 0),
(99, 'CE_CompChair_7', 'A39', '0', 'ok', '0', 0),
(100, 'CE_CompChair_8', 'A40', '0', 'ok', '0', 0),
(101, 'CD_CompChair_4', 'A41', '0', 'ok', '0', 0),
(102, 'CD_CompChair_3', 'A42', '0', 'ok', '0', 0),
(103, 'CD_CompChair_2', 'A43', '0', 'ok', '0', 0),
(104, 'CD_CompChair_1', 'A44', '0', 'ok', '0', 0),
(105, 'CD_CompChair_5', 'A45', '0', 'ok', '0', 0),
(106, 'CD_CompChair_6', 'A46', '0', 'ok', '0', 0),
(107, 'CD_CompChair_7', 'A47', '0', 'ok', '0', 0),
(108, 'CD_CompChair_8', 'A48', '0', 'ok', '0', 0),
(109, 'CC_CompChair_4', 'A49', '0', 'ok', '0', 0),
(110, 'CC_CompChair_3', 'A50', '0', 'ok', '0', 0),
(111, 'CC_CompChair_2', 'A51', '0', 'ok', '0', 0),
(112, 'CC_CompChair_1', 'A52', '0', 'ok', '0', 0),
(113, 'CC_CompChair_5', 'A53', '0', 'ok', '0', 0),
(114, 'CC_CompChair_6', 'A54', '0', 'ok', '0', 0),
(115, 'CC_CompChair_7', 'A55', '0', 'ok', '0', 0),
(116, 'CC_CompChair_8', 'A56', '0', 'ok', '0', 0),
(117, 'CB_CompChair_4', 'A57', '0', 'ok', '0', 0),
(118, 'CB_CompChair_3', 'A58', '0', 'ok', '0', 0),
(119, 'CB_CompChair_2', 'A59', '0', 'ok', '0', 0),
(120, 'CB_CompChair_1', 'A60', '0', 'ok', '0', 0),
(121, 'CB_CompChair_5', 'A61', '0', 'ok', '0', 0),
(122, 'CB_CompChair_6', 'A62', '0', 'ok', '0', 0),
(123, 'CB_CompChair_7', 'A63', '0', 'ok', '0', 0),
(124, 'CB_CompChair_8', 'A64', '404', 'ok', '0', 0),
(125, 'CA_CompChair_4', 'A65', '0', 'ok', '0', 0),
(126, 'CA_CompChair_3', 'A66', '0', 'ok', '0', 0),
(127, 'CA_CompChair_2', 'A67', '404', 'ok', '0', 0),
(128, 'CA_CompChair_1', 'A68', '0', 'ok', '0', 0),
(129, 'CA_CompChair_5', 'A69', '0', 'ok', '0', 0),
(130, 'CA_CompChair_6', 'A70', '0', 'ok', '0', 0),
(131, 'CA_CompChair_7', 'A71', '0', 'ok', '0', 0),
(132, 'CA_CompChair_8', 'A72', '404', 'ok', '0', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settings_id`, `reservation`, `minDuration`, `maxDuration`, `reservePerDay`, `start_hour`, `end_hour`, `disabled_dates`) VALUES
(1, 0, 1, 4, 2, '10:00:00', '17:00:00', '[\"2023-10-01\",\"2023-10-08\",\"2023-10-15\",\"2023-10-22\",\"2023-10-29\",\"2023-10-07\",\"2023-10-14\",\"2023-10-28\",\"2023-10-21\",\"2023-09-02\",\"2023-09-09\",\"2023-09-16\",\"2023-09-23\",\"2023-09-30\",\"2023-11-05\",\"2023-11-12\",\"2023-11-19\",\"2023-11-26\",\"2023-12-03\",\"2023-12-10\",\"2023-12-17\",\"2023-12-24\",\"2023-12-31\",\"2023-12-02\",\"2023-12-09\",\"2023-12-16\",\"2023-12-30\",\"2023-12-23\",\"2023-12-25\",\"2023-11-25\",\"2023-11-18\",\"2023-11-11\",\"2023-11-04\",\"2024-01-07\",\"2024-01-14\",\"2024-01-21\",\"2024-01-28\",\"2024-01-06\",\"2024-01-13\",\"2024-01-20\",\"2024-01-27\",\"2024-02-03\",\"2024-02-10\",\"2024-02-17\",\"2023-09-24\",\"2023-09-17\",\"2023-09-10\",\"2023-09-03\",\"2023-08-27\"]');

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
  `bday` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `is_archived` tinyint(1) DEFAULT 0,
  `last_cancel` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `rfid_no`, `first_name`, `last_name`, `account_id`, `course_code`, `yearsec_id`, `age`, `contact_number`, `bday`, `gender`, `is_archived`, `last_cancel`) VALUES
(123, NULL, 'juan', 'soar', 37, 'FACULTY', 261, NULL, NULL, NULL, NULL, 0, NULL),
(404, '203hd5h', 'Mary Queeny', 'Casaclang', 33, 'BSN', 2, NULL, NULL, NULL, NULL, 0, NULL),
(1111, 'djr5jse', 'Sandra', 'Velasco', 35, 'FACULTY', 261, NULL, NULL, NULL, NULL, 0, NULL),
(2020, NULL, 'Zack', 'Fair', 32, 'BLIS', 1, NULL, NULL, NULL, NULL, 0, NULL),
(3030, '56uy78j', 'Sydney', 'Bernardo', 19, 'BSIT', 261, 21, '09453661518', NULL, NULL, 0, NULL),
(7070, NULL, 'Rinoa', 'Heartily', 34, 'BSA', 56, NULL, NULL, NULL, NULL, 0, NULL),
(7777, '5hfcn4e', 'Cloud', 'Hipolito', 21, 'BSN', 113, 23, '09453661517', NULL, NULL, 0, NULL),
(2581406, NULL, 'jeaysmie', 'difo', 38, 'FACULTY', 261, NULL, NULL, NULL, NULL, 0, NULL),
(2020103475, '119180184137242', 'Jeays', 'Digo', 27, 'BSIT', 165, 21, '09166750154', '2023-11-02', 'Male', 0, '2023-11-21 10:44:47'),
(2020107070, '20165143155', 'Gelo', 'Rivera', 36, 'ALUMNI', 261, NULL, NULL, NULL, NULL, 0, '2023-11-22 10:09:42');

-- --------------------------------------------------------

--
-- Table structure for table `yearsec`
--

CREATE TABLE `yearsec` (
  `yearsec_id` int(11) NOT NULL,
  `year_level` int(11) DEFAULT NULL,
  `section` varchar(10) DEFAULT NULL,
  `section_group` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notif_id`),
  ADD KEY `user_id_notif_fk` (`user_id`);

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
  ADD PRIMARY KEY (`user_id`);

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
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `occupy`
--
ALTER TABLE `occupy`
  MODIFY `occupy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `user_id_notif_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
