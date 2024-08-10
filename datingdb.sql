-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 10, 2024 at 04:49 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datingdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `msg_from_user_id` int NOT NULL,
  `msg` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `msg_to_user_id` int NOT NULL,
  `msg_date` datetime NOT NULL,
  `is_msg_read` tinyint(1) NOT NULL DEFAULT '0',
  `msg_read_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `MSG_FROM_USER` (`msg_from_user_id`),
  KEY `MSG_TO_USER` (`msg_to_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `msg_from_user_id`, `msg`, `msg_to_user_id`, `msg_date`, `is_msg_read`, `msg_read_date`) VALUES
(1, 1, 'Hello Meet', 2, '2020-10-04 23:49:58', 1, '2020-10-04 23:58:13'),
(2, 1, 'How are you?', 2, '2020-10-04 23:50:16', 1, '2020-10-04 23:58:13'),
(3, 1, '😉', 3, '2020-10-04 23:51:07', 0, NULL),
(4, 1, '😉', 6, '2020-10-04 23:57:36', 1, '2020-10-05 00:29:24'),
(5, 2, 'Hi vatsal', 1, '2020-10-04 23:58:21', 1, '2020-10-05 00:05:47'),
(6, 2, '😉', 4, '2020-10-05 00:05:13', 0, NULL),
(7, 6, 'Hi meet', 2, '2020-10-05 00:29:41', 1, '2020-10-05 00:53:29'),
(8, 6, 'Wow', 2, '2020-10-05 00:29:51', 1, '2020-10-05 00:53:29'),
(9, 6, 'Wow', 2, '2020-10-05 00:31:02', 1, '2020-10-05 00:53:29'),
(10, 6, '😉', 3, '2020-10-05 00:31:20', 0, NULL),
(20, 9, 'Hi', 2, '2020-10-05 01:45:04', 1, '2020-10-05 01:47:37'),
(21, 9, '😉', 2, '2020-10-05 01:45:12', 1, '2020-10-05 01:47:37'),
(22, 9, 'Hi', 1, '2020-10-05 01:47:10', 0, NULL),
(23, 2, '😉', 5, '2020-10-05 01:47:31', 0, NULL),
(24, 2, 'Hey', 9, '2020-10-05 01:47:41', 1, '2020-10-05 01:48:13'),
(25, 2, '😉', 9, '2020-10-05 01:47:53', 1, '2020-10-05 01:48:13'),
(26, 10, '😉', 3, '2024-07-16 14:41:08', 0, NULL),
(27, 11, '😉', 2, '2024-07-16 15:20:48', 0, NULL),
(28, 11, '😉', 2, '2024-07-16 15:21:08', 0, NULL),
(29, 11, '😉', 2, '2024-07-16 15:21:45', 0, NULL),
(30, 11, '😉', 5, '2024-07-16 15:21:47', 0, NULL),
(31, 11, '😉', 5, '2024-07-16 15:23:10', 0, NULL),
(32, 11, '😉', 1, '2024-07-16 15:23:12', 0, NULL),
(33, 11, '♡', 10, '2024-07-16 15:24:08', 0, NULL),
(34, 11, 'hi da', 10, '2024-07-16 15:24:18', 0, NULL),
(35, 11, 'Liked your profile', 2, '2024-07-16 15:24:43', 0, NULL),
(36, 10, 'hi bhavana', 11, '2024-07-16 15:25:39', 0, NULL),
(37, 10, 'Liked your profile', 2, '2024-07-16 16:56:12', 0, NULL),
(38, 12, 'Liked your profile', 1, '2024-08-03 09:24:06', 0, NULL),
(39, 12, 'Liked your profile', 1, '2024-08-03 09:25:53', 0, NULL),
(40, 12, 'Liked your profile', 1, '2024-08-03 09:26:10', 0, NULL),
(41, 12, 'Liked your profile', 1, '2024-08-03 09:26:14', 0, NULL),
(42, 12, 'Liked your profile', 1, '2024-08-03 09:28:05', 0, NULL),
(43, 12, 'Liked your profile', 1, '2024-08-03 09:28:10', 0, NULL),
(44, 12, 'Liked your profile', 1, '2024-08-03 09:32:12', 0, NULL),
(45, 12, 'Liked your profile', 3, '2024-08-03 11:56:22', 0, NULL),
(46, 9, 'hi demo', 12, '2024-08-03 09:42:46', 0, NULL),
(47, 12, 'hi', 12, '2024-08-03 16:00:33', 0, NULL),
(48, 12, 'hi', 12, '2024-08-03 16:02:26', 0, NULL),
(49, 12, 'hi', 12, '2024-08-03 16:03:14', 0, NULL),
(50, 12, 'hi', 9, '2024-08-03 16:03:26', 0, NULL),
(51, 12, 'Liked your profile', 1, '2024-08-05 20:50:53', 0, NULL),
(52, 12, 'Liked your profile', 1, '2024-08-05 20:51:47', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `bio` varchar(500) NOT NULL,
  `birthDate` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `hobby` varchar(255) NOT NULL,
  `Job` varchar(255) NOT NULL,
  `Disabled_stats` varchar(10) NOT NULL,
  `imgUrl` text NOT NULL,
  `receive_notification` tinyint(1) NOT NULL DEFAULT '0',
  `Disability` varchar(255) NOT NULL,
  `disabilitytype` varchar(100) NOT NULL,
  `user_role` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `email`, `password`, `firstName`, `lastName`, `city`, `bio`, `birthDate`, `gender`, `hobby`, `Job`, `Disabled_stats`, `imgUrl`, `receive_notification`, `Disability`, `disabilitytype`, `user_role`, `created_date`, `modified_date`) VALUES
(1, 'Anjitha@gmail.com', 'test', 'Reenu', 'T', 'Aluva', 'Hi,\r\nPassionate to Sing\r\nLearning to play life by ears', '1995-01-12', 'male', '', '', '', './images/user_images/reenu.jpg', 1, '', '', 'premium', '2020-10-04 23:11:39', '0000-00-00 00:00:00'),
(2, 'meet@gmail.com', 'test', 'Eldhose', 'Rajesh', 'Delhi', 'I am Eldhose\r\nPleasure to meet you', '1998-05-05', 'male', '', '', '', './images/user_images/eldhose.png', 1, '', '', 'premium', '2020-10-04 23:12:37', '0000-00-00 00:00:00'),
(3, 'justin@gmail.com', 'test', 'Amal', 'Davis', 'Hyderabad', '', '1990-02-05', 'male', '', '', '', './images/user_images/amal.jpg', 0, '', '', 'premium', '2020-10-04 23:13:37', NULL),
(4, 'janki@gmail.com', 'test', 'Sachi', 'Mon', 'Hyderabad', '', '1996-12-13', 'female', '', '', '', './images/user_images/sachi.jpg', 0, '', '', 'premium', '2020-10-04 23:14:25', NULL),
(5, 'mariadb@gmail.com', 'test', 'Maria', 'DB', 'Hamilton', '', '1995-09-28', 'female', '', '', '', './images/user_images/mariadb@gmail.com_femalepic2.jpg', 0, '', '', 'premium', '2020-10-04 23:15:45', NULL),
(6, 'angelpriya@gmail.com', 'test', 'Angel', 'Priya', 'Windsor', '', '1997-05-10', 'female', '', '', '', './images/user_images/angelpriya@gmail.com_femalepic3.jpg', 0, '', '', 'premium', '2020-10-04 23:16:35', NULL),
(9, 'testing@gmail.com', 'test', 'Test', 'User', 'aluva', 'Hi,\r\nMy name is Test User\r\nI love dating', '1996-01-28', 'male', '', '', '', './images/user_images/testing@gmail.com_meet@gmail.com_malepic3.jpg', 0, '', '', 'premium', '2020-10-05 01:44:24', '0000-00-00 00:00:00'),
(10, 'adi@gmail.com', 'adithyan', 'Adithyan', 'Sreejith', 'ernakulam', '', '2000-06-23', 'male', '', '', '', './images/user_images/adi@gmail.com_angelpriya@gmail.com_femalepic3.jpg', 0, '', '', 'premium', '2024-07-16 14:08:48', NULL),
(11, 'bhav@gmail.com', 'bhavana', 'Bhavana', 'U', 'aluva', '', '2000-02-22', 'female', '', '', '', './images/user_images/bhav@gmail.com_janki@gmail.com_femalepic1.jpg', 0, '', '', 'premium', '2024-07-16 15:16:46', NULL),
(12, 'demo@gmail.com', 'demo', 'demo', 'demo', 'kerala', '', '1999-09-20', 'male', '', '', '', './images/user_images/demo@gmail.com_images.jpg', 0, '', '', 'premium', '2024-08-03 09:13:22', '0000-00-00 00:00:00'),
(17, 'model@gmail.com', 'model', 'Model', 'Kumar', 'Kalady', '', '1999-02-10', 'male', '', '', '', './images/user_images/model@gmail.com_bhav@gmail.com_janki@gmail.com_femalepic1.jpg', 0, '', '', 'premium', '2024-08-03 13:31:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_favourite_list`
--

DROP TABLE IF EXISTS `user_favourite_list`;
CREATE TABLE IF NOT EXISTS `user_favourite_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `user_id_favourited` int NOT NULL,
  `dateCreated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_favourite` (`user_id`),
  KEY `user_id_to_favourite` (`user_id_favourited`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_favourite_list`
--

INSERT INTO `user_favourite_list` (`id`, `user_id`, `user_id_favourited`, `dateCreated`) VALUES
(9, 1, 2, '2020-10-05 00:43:56'),
(10, 1, 5, '2020-10-05 00:43:59'),
(11, 1, 6, '2020-10-05 00:44:01'),
(12, 2, 4, '2020-10-05 00:54:09'),
(20, 9, 2, '2020-10-05 01:48:37'),
(25, 12, 3, '2024-08-03 11:56:24');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `MSG_FROM_USER` FOREIGN KEY (`msg_from_user_id`) REFERENCES `profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MSG_TO_USER` FOREIGN KEY (`msg_to_user_id`) REFERENCES `profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_favourite_list`
--
ALTER TABLE `user_favourite_list`
  ADD CONSTRAINT `user_id_favourite` FOREIGN KEY (`user_id`) REFERENCES `profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_to_favourite` FOREIGN KEY (`user_id_favourited`) REFERENCES `profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
