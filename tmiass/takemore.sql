-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2013 at 07:56 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id_client`, `name`, `address`, `email`, `phone`, `private`) VALUES
(1, 'bfbgfg', 'asdad', '', 2147483647, 1),
(2, 'JMS', 'Av Fontainhas', 'rafte11@hotmail.com', 0, 0),
(3, 'manel', 'rua dos ananas', 'rui@hotmail.com', 91843434, 0),
(4, 'vcxvxcv', 'rua das couves', 'radft@hotmail.com', 918182828, 0),
(5, 'hdfg', 'dfgfdg', '', 0, 1),
(6, 'luis', 'asdad', 'asd@hotmail.com', 23432, 0),
(7, 'rui', 'rtyrty', 'rasdasdas@hotmail.com', 918234556, 0),
(8, 'rsadsad', '', '', 0, 0),
(9, '', '', '', 0, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `id_user`, `id_client`, `id_service`, `entity`, `cod`, `budget`, `equipment`, `mark/model`, `n_serie`, `accessories`, `service`, `provided`) VALUES
(1, 1, 2, 0, 1, '358314432', '32423', '', '', '', '', 'asdasd', ''),
(2, 1, 1, 0, 1, '817474039', '453534', '', '', '', '', 'sdfsdf', ''),
(3, 1, 2, 0, 1, '1463443295', '345345', '', '', '', '', 'vxvxc', ''),
(4, 1, 0, 0, 2, '153318581', '23', 'yuggyg', '', 'gvvyu', 'vyiiv', 'cytcyt', 'hbikn'),
(5, 1, 3, 0, 1, '3482482', '56', '', '', '', '', 'sdcsdc', ''),
(6, 1, 2, 0, 2, '2115807315', '', '', '', '', '', '', ''),
(7, 1, 2, 0, 2, '753674001', '56', 'sfasf', 'saf', 'sfasf', 'saf', 'saf', ''),
(8, 1, 1, 0, 1, '1790761215', '50', '', '', '', '', 'fdg', ''),
(16, 2, 7, 0, 1, '3116', '98', '', '', '', '', 'sdfsdf', ''),
(17, 1, 0, 1, 2, '9184', '90', '', '', '', '', '', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `equip_problem`
--

INSERT INTO `equip_problem` (`id`, `problem/damage`, `description(client)`, `description(employee)`) VALUES
(1, '', '', 'asdasdasd'),
(2, '', '', 'dsfsdf'),
(3, '', '', 'vxcvxc'),
(4, 'vuvut', 'ycyrd', 'hfc'),
(5, '', '', 'ccsdcsd'),
(6, '', '', ''),
(7, 'asaf', 'saf', 'saf'),
(8, '', '', 'gdfg'),
(16, '', '', 'dfsfdsf'),
(17, '', 'fdbfdbfdbd', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `equip_status`
--

INSERT INTO `equip_status` (`id`, `status`, `start_date`, `end_date`, `final_time`) VALUES
(1, 'Under Repair', '2012-12-23 08:11:11', '2012-12-25 09:11:11', '49 : 00 H'),
(2, 'Waits', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(3, 'Closed Billing', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(4, 'Waits', '2012-12-23 08:11:11', '2012-12-25 09:11:11', '49 : 00 H'),
(5, 'Closed Guaranty', '2012-12-23 08:11:11', '2013-01-07 23:45:00', '375 : 33 H'),
(6, 'Budgeted', '2012-12-23 08:11:11', '2013-04-06 23:00:00', '2509 : 48 H'),
(7, 'Budgeted', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(8, 'Closed Contract', '2012-12-23 08:11:11', '2012-12-25 09:11:11', '49 : 00 H'),
(16, 'Closed Billing', '2012-12-23 08:11:11', '2013-04-06 23:00:00', '2509H : 48 M'),
(17, 'Closed Guaranty', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id_service`, `name`, `address`, `email`, `phone`) VALUES
(1, 'asd', 'assdasd', 'dsadasd@hotmail.com', 435435435),
(3, 'lopes', 'rua dos pessegos', 'rui@hotmail.com', 987654321);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `service_problem`
--

INSERT INTO `service_problem` (`id`, `check`, `budget`, `confirmation`, `reported_problem`, `sending_date`, `delivery_date`) VALUES
(1, 0, '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 0, '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 0, '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 0, ' ', 0, ' ', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 0, '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 0, ' ', 0, ' ', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 0, ' ', 0, ' ', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 0, '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 0, '', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 1, ' 767', 1, ' 45dxcv', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `name`, `password`, `email`, `status`) VALUES
(1, 'admin', 'silva', 'ca60a666306940f1f227996d6671002f', 'r_mns_21@hotmail.com', 2),
(2, 'rui', 'rui', 'ca60a666306940f1f227996d6671002f', 'rui_flexa@hotmail.com', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
