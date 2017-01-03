-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2013 at 07:52 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `takemore`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` int(9) NOT NULL,
  `private` int(1) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id_client`, `name`, `address`, `email`, `phone`, `private`) VALUES
(2, 'manel', 'rua dos ananas', 'rui_flexa@hotmail.com', 921812821, 0);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE IF NOT EXISTS `equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_service` int(11) NOT NULL,
  `entity` int(1) NOT NULL,
  `cod` varchar(50) NOT NULL,
  `budget` varchar(50) NOT NULL,
  `equipment` varchar(100) NOT NULL,
  `mark/model` varchar(100) NOT NULL,
  `n_serie` varchar(100) NOT NULL,
  `accessories` varchar(500) NOT NULL,
  `service` varchar(500) NOT NULL,
  `provided` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `id_user`, `id_client`, `id_service`, `entity`, `cod`, `budget`, `equipment`, `mark/model`, `n_serie`, `accessories`, `service`, `provided`) VALUES
(1, 3, 0, 0, 1, '17481', '', '', '', '', '', '', ''),
(2, 3, 0, 0, 1, '5030', '', '', '', '', '', '', ''),
(3, 3, 2, 0, 1, '95', '', '', '', '', '', '', ''),
(4, 3, 2, 0, 1, '19116', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `equip_problem`
--

CREATE TABLE IF NOT EXISTS `equip_problem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `problem/damage` varchar(500) NOT NULL,
  `description(client)` varchar(500) NOT NULL,
  `description(employee)` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `equip_problem`
--

INSERT INTO `equip_problem` (`id`, `problem/damage`, `description(client)`, `description(employee)`) VALUES
(1, '', '', ''),
(2, '', '', ''),
(3, '', '', ''),
(4, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `equip_status`
--

CREATE TABLE IF NOT EXISTS `equip_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `final_time` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `equip_status`
--

INSERT INTO `equip_status` (`id`, `status`, `start_date`, `end_date`, `final_time`) VALUES
(1, 'In Execution', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(2, 'In Execution', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(3, 'In Execution', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(4, 'Ready', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `id_service` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` int(9) NOT NULL,
  PRIMARY KEY (`id_service`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id_service`, `name`, `address`, `email`, `phone`) VALUES
(3, 'rui', 'rua das couves', 'rasdasdas@hotmail.com', 435435435);

-- --------------------------------------------------------

--
-- Table structure for table `service_problem`
--

CREATE TABLE IF NOT EXISTS `service_problem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `check` int(1) NOT NULL,
  `budget` varchar(50) NOT NULL,
  `confirmation` tinyint(1) NOT NULL,
  `reported_problem` varchar(500) NOT NULL,
  `sending_date` datetime NOT NULL,
  `delivery_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `service_problem`
--

INSERT INTO `service_problem` (`id`, `check`, `budget`, `confirmation`, `reported_problem`, `sending_date`, `delivery_date`) VALUES
(1, 0, '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 0, '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 0, '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `email`, `status`) VALUES
(1, 'rui', 'ca60a666306940f1f227996d6671002f', 'r_mns_21@hotmail.com', 2),
(3, 'raul', 'ca60a666306940f1f227996d6671002f', 'rafte11@hotmail.com', 1),
(4, 'lopes', '582fc884d6299814fbd4f12c1f9ae70f', 'rafte11@hotmail.com', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
