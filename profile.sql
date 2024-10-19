-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 19, 2024 at 04:56 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(999, 'admin@koode.com', 'admin', 'Admin', '', '', '', '0000-00-00', '', '', '', '', '', 0, '', '', '', '2024-10-18 15:50:28', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
