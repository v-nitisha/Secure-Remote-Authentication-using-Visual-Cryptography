-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 01, 2019 at 03:49 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp_portal`
--
CREATE DATABASE IF NOT EXISTS `fyp_portal` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `fyp_portal`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `hashed_password` varchar(60) NOT NULL,
  `FULLPOWER` tinyint(1) NOT NULL DEFAULT '0',
  `security_question_id` int(100) DEFAULT NULL,
  `security_question_answer` varchar(200) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `email2` varchar(100) DEFAULT NULL,
  `hashed_challenge` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `hashed_password`, `FULLPOWER`, `security_question_id`, `security_question_answer`, `email`, `email2`, `hashed_challenge`) VALUES
(1, 'hidir', '$2y$10$Mjk2NTgwNWI0ZjE0ODg3ZO1vO/rbQZXmziPb/ZYlBVB1ixezve3cS', 1, 1, '', 'hidirprivate@gmail.com', 'hidirprivate2@gmail.com', ''),
(12, 'nitisha', '$2y$10$NTU1YmEwYzZjODFkYjk3NOeW4Y3czTSuGyPkr5tPJaXTP7s2AOX5q', 0, NULL, NULL, 'prathya_95@hotmail.com', 'v.nitisha95@gmail.com', NULL),
(5, 'test', '$2y$10$M2UyMzRlYThkNDRkM2I2YO6oG5wnduUb1yKmpIsHXUvBECyajlLGG', 0, NULL, NULL, 'test@test.com', 'test@test2.com', NULL),
(11, 'test2', '$2y$10$OGM0ZTU1OGRhMzZjZDBiMOl.MAgDTw.HmnORYvOeGPtku8EftI/3u', 0, NULL, NULL, 'a@a.com', 'a@aa.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `critical_sections`
--

DROP TABLE IF EXISTS `critical_sections`;
CREATE TABLE IF NOT EXISTS `critical_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(70) NOT NULL,
  `security_level` int(3) DEFAULT NULL,
  `fast_auth` tinyint(1) NOT NULL,
  `page_master` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `critical_sections`
--

INSERT INTO `critical_sections` (`id`, `page_name`, `security_level`, `fast_auth`, `page_master`) VALUES
(14, 'manage_admins.php', 1, 0, 'youstacia@gmail.com'),
(15, 'csacas', 1, 0, 'csa');

-- --------------------------------------------------------

--
-- Table structure for table `security_questions`
--

DROP TABLE IF EXISTS `security_questions`;
CREATE TABLE IF NOT EXISTS `security_questions` (
  `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `security_questions`
--

INSERT INTO `security_questions` (`id`, `question`) VALUES
(1, 'Name of your first pet.'),
(2, 'Name of your first neighbourhood.');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(30) NOT NULL,
  `position` int(3) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `menu_name`, `position`, `visible`, `content`) VALUES
(1, 'About Visual Crypto', 1, 1, 'This is about visual crypto.\r\n\r\nThe best way to visualize the visual cryptographic scheme is to consider a\r\nconcrete example. At the end of this extended abstract we enclose two random\r\nlooking dot patterns. To decrypt the secret message, the reader should photocopy\r\neach pattern on a separate transparency, align them carefully, and project the\r\nresult with an overhead projector.\r\n\r\nThis basic model can be extended into a visual variant of the k out of n\r\nsecret sharing problem: Given a written message, we would like to generate n\r\ntransparencies so that the original message is visible if any k (or more) of\'them\r\nare stacked together, but totally invisible if fewer than k transparencies are\r\nstacked together (or analysed by any other method). The original encryption\r\nproblem can be considered as a 2 out of 2 secret sharing problem.\r\n\r\nThe main results of this paper (besides introducing this new paradigm of\r\ncryptographic schemes) include practical implementations of a k out of n visual\r\nsecret sharing scheme for small values of k and n, as well as efficient asymptotic\r\nconstructions which can be proven optimal within certain classes of schemes.'),
(2, 'Our Members', 2, 1, 'Hidir Ibrahim - Project Manager\r\nEustacia Lim -  Lead Programmer\r\nNitisha Venkatachari - Lead Designer\r\n\r\nDr Ta - Project Supervisor'),
(3, 'Misc', 3, 1, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
