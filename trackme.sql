-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 10, 2013 at 04:29 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `trackme`
--

-- --------------------------------------------------------

--
-- Table structure for table `car_condition`
--

CREATE TABLE IF NOT EXISTS `car_condition` (
  `car_condition_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_condition_name` varchar(50) NOT NULL,
  PRIMARY KEY (`car_condition_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `car_condition`
--

INSERT INTO `car_condition` (`car_condition_id`, `car_condition_name`) VALUES
(1, 'Mobil Baru'),
(2, 'Mobil Bekas');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `company_address` varchar(255) NOT NULL,
  `company_phone` varchar(50) NOT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `company_address`, `company_phone`) VALUES
(4, 'Brawijaya', 'Brawijaya', '0344'),
(2, 'Simetri', 'Sulfat', '0341');

-- --------------------------------------------------------

--
-- Table structure for table `company_user`
--

CREATE TABLE IF NOT EXISTS `company_user` (
  `company_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`company_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `company_user`
--

INSERT INTO `company_user` (`company_user_id`, `company_id`, `user_id`) VALUES
(14, 2, 23);

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `config_name` varchar(255) NOT NULL,
  `config_content` longtext NOT NULL,
  `hidden` int(1) NOT NULL,
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`config_id`, `company_id`, `config_name`, `config_content`, `hidden`) VALUES
(1, 0, '', '', 0),
(2, 0, 'Rental No', '18', 0),
(3, 1, 'Rental No', '2', 0),
(4, 2, 'Rental No', '2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(50) DEFAULT NULL,
  `customer_mobile` varchar(50) DEFAULT NULL,
  `customer_gender` varchar(50) DEFAULT NULL,
  `company_id` int(10) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_address`, `customer_phone`, `customer_mobile`, `customer_gender`, `company_id`) VALUES
(3, 'Puyunghai', '22', '33', '44', 'Perempuan', 0),
(4, 'Capcay', 'b', 'c', 'd', 'Laki - Laki', 0),
(5, 'Nasi Goreng', '', '2', '3', 'Laki - Laki', 0),
(6, 'Bakmi', '2', '3', '4', 'Laki - Laki', 0),
(7, 'Customer', '1', '2', '3', 'Laki - Laki', 1),
(10, 'Pak Satu', '1', '2', '3', 'Laki - Laki', 2);

-- --------------------------------------------------------

--
-- Table structure for table `device_company`
--

CREATE TABLE IF NOT EXISTS `device_company` (
  `device_company_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  PRIMARY KEY (`device_company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `device_company`
--

INSERT INTO `device_company` (`device_company_id`, `device_id`, `company_id`) VALUES
(13, 13, 4),
(14, 11, 2),
(15, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE IF NOT EXISTS `driver` (
  `driver_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `driver_name` varchar(100) DEFAULT NULL,
  `driver_address` varchar(255) DEFAULT NULL,
  `driver_phone` varchar(50) DEFAULT NULL,
  `driver_mobile` varchar(50) DEFAULT NULL,
  `driver_fee` int(10) unsigned DEFAULT NULL,
  `company_id` int(10) NOT NULL,
  PRIMARY KEY (`driver_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`driver_id`, `driver_name`, `driver_address`, `driver_phone`, `driver_mobile`, `driver_fee`, `company_id`) VALUES
(1, 'Pak Sopir', '2a', '3a', '4a', 51, 0),
(2, 'Tukang Becak', '', '', '', 0, 0),
(3, 'Mikrolet', 'asd', '', '', 0, 0),
(4, 'Truk', 'sd', 'sd', 'sd', 0, 0),
(5, 'Dokar', 'sss', '', '', 0, 0),
(7, 'Budiman', 'Sukun', '-', '03418055442', 50000, 1),
(9, 'Toni', 'Gadang', '-', '03142154788', 0, 1),
(13, 'Pak Sopir', '1', '2', '3', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rental`
--

CREATE TABLE IF NOT EXISTS `rental` (
  `rental_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rental_no` varchar(50) NOT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `uang_muka` int(10) unsigned DEFAULT NULL,
  `total_price` int(10) unsigned DEFAULT NULL,
  `sisa` int(10) unsigned DEFAULT NULL,
  `rental_desc` varchar(255) DEFAULT NULL,
  `rental_guarantee` varchar(150) NOT NULL,
  `company_id` int(10) NOT NULL,
  PRIMARY KEY (`rental_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `rental`
--

INSERT INTO `rental` (`rental_id`, `rental_no`, `customer_id`, `order_date`, `uang_muka`, `total_price`, `sisa`, `rental_desc`, `rental_guarantee`, `company_id`) VALUES
(1, '00013', 7, '2013-02-06', 0, 150006, 0, '', '', 0),
(3, '00001', 7, '2013-02-07', 0, 150000, 0, '', '', 1),
(5, '00002', 10, '2013-02-10', 0, 400000, 0, '', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `rental_detail`
--

CREATE TABLE IF NOT EXISTS `rental_detail` (
  `rental_detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rental_id` int(10) unsigned DEFAULT NULL,
  `car_id` int(10) unsigned DEFAULT NULL,
  `driver_id` int(10) unsigned DEFAULT NULL,
  `rental_status_id` int(10) unsigned DEFAULT NULL,
  `car_condition_id` int(10) unsigned DEFAULT NULL,
  `date_out` date DEFAULT NULL,
  `date_in` date DEFAULT NULL,
  `price_per_day` int(10) unsigned DEFAULT NULL,
  `destination` varchar(50) DEFAULT NULL,
  `rental_duration` varchar(100) DEFAULT NULL,
  `driver_fee` varchar(100) DEFAULT NULL,
  `driver_duration` varchar(100) DEFAULT NULL,
  `car_condition_out` varchar(100) DEFAULT NULL,
  `car_condition_in` varchar(100) DEFAULT NULL,
  `guaranty` varchar(200) DEFAULT NULL,
  `user_accept_rent` int(10) unsigned DEFAULT NULL,
  `user_accept_in` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`rental_detail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `rental_detail`
--

INSERT INTO `rental_detail` (`rental_detail_id`, `rental_id`, `car_id`, `driver_id`, `rental_status_id`, `car_condition_id`, `date_out`, `date_in`, `price_per_day`, `destination`, `rental_duration`, `driver_fee`, `driver_duration`, `car_condition_out`, `car_condition_in`, `guaranty`, `user_accept_rent`, `user_accept_in`) VALUES
(1, 1, 13, 5, 0, 0, '2013-02-06', '2013-02-07', 150000, 'Malang', '1', '', '', '', '', '', 0, 0),
(3, 1, 19, 7, 0, 0, '2013-02-09', '2013-02-11', 3, 'Jakaarta', '2', '', '', '', '', '', 0, 0),
(5, 3, 13, 7, 0, 0, '2013-02-07', '2013-02-08', 150000, '12', '1', '', '', '', '', '', 0, 0),
(6, 5, 11, 13, 0, 0, '2013-02-10', '2013-02-12', 200000, 'Denpasar', '2', '', '', '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rental_status`
--

CREATE TABLE IF NOT EXISTS `rental_status` (
  `rental_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `rental_status_name` varchar(50) NOT NULL,
  PRIMARY KEY (`rental_status_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `rental_status`
--

INSERT INTO `rental_status` (`rental_status_id`, `rental_status_name`) VALUES
(1, 'Order'),
(2, 'Keluar'),
(3, 'Kembali');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE IF NOT EXISTS `reservasi` (
  `reservasi_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_id` int(10) NOT NULL,
  `reservasi_status_id` int(10) unsigned DEFAULT NULL,
  `customer_name` varchar(150) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_phone` varchar(50) NOT NULL,
  `reservasi_capacity` int(10) unsigned DEFAULT NULL,
  `reservasi_price` int(10) unsigned DEFAULT NULL,
  `reservasi_total` int(10) unsigned DEFAULT NULL,
  `reservasi_note` varchar(255) DEFAULT NULL,
  `company_id` int(10) NOT NULL,
  PRIMARY KEY (`reservasi_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`reservasi_id`, `schedule_id`, `reservasi_status_id`, `customer_name`, `customer_address`, `customer_phone`, `reservasi_capacity`, `reservasi_price`, `reservasi_total`, `reservasi_note`, `company_id`) VALUES
(16, 13, 1, 'Budi', 'Sulfat', '03412225588', 1, 60000, 1, 'Duduk didepan', 2);

-- --------------------------------------------------------

--
-- Table structure for table `reservasi_status`
--

CREATE TABLE IF NOT EXISTS `reservasi_status` (
  `reservasi_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `reservasi_status_name` varchar(100) NOT NULL,
  PRIMARY KEY (`reservasi_status_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `reservasi_status`
--

INSERT INTO `reservasi_status` (`reservasi_status_id`, `reservasi_status_name`) VALUES
(1, 'Reserve'),
(2, 'Berangkat'),
(3, 'Sampai'),
(4, 'Batal');

-- --------------------------------------------------------

--
-- Table structure for table `roster`
--

CREATE TABLE IF NOT EXISTS `roster` (
  `roster_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roster_day` varchar(100) DEFAULT NULL,
  `roster_time` varchar(20) DEFAULT NULL,
  `roster_dest` varchar(50) DEFAULT NULL,
  `roster_capacity` int(10) unsigned DEFAULT NULL,
  `roster_price` int(10) unsigned DEFAULT NULL,
  `roster_active` int(10) unsigned DEFAULT NULL,
  `company_id` int(10) NOT NULL,
  PRIMARY KEY (`roster_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `roster`
--

INSERT INTO `roster` (`roster_id`, `roster_day`, `roster_time`, `roster_dest`, `roster_capacity`, `roster_price`, `roster_active`, `company_id`) VALUES
(5, '2,5,6,7', '06:00', 'Bali', 30, 250000, 1, 0),
(2, '2,3,4', '08:00', 'Malang', 20, 25000, 1, 0),
(3, '1,3,5', '13:00', 'Lumajang', 50, 50000, 1, 0),
(6, '1,2,5,6,7', '08:00', 'Jakarta', 100, 1000000, 0, 0),
(11, '2,3', '08:00', 'MLG - KDR', 10, 50000, 1, 1),
(12, '2,4', '08:00', 'MLG - SBY', 10, 65000, 1, 1),
(14, '1,2,3,4,5,6,7', '08:00', 'MLG - KDR', 8, 60000, 1, 2),
(15, '1,2', '08:00', 'MLG - SBY', 8, 80000, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `schedule_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roster_id` int(10) unsigned NOT NULL,
  `driver_id` int(10) unsigned DEFAULT NULL,
  `schedule_date` date DEFAULT NULL,
  `schedule_depature` varchar(50) DEFAULT NULL,
  `schedule_arrival` varchar(50) DEFAULT NULL,
  `company_id` int(10) NOT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `roster_id`, `driver_id`, `schedule_date`, `schedule_depature`, `schedule_arrival`, `company_id`) VALUES
(1, 2, 2, '2013-01-01', '2013-01-02', '2013-01-03', 0),
(2, 3, 1, '2013-01-29', '2013-02-01', '2013-02-03', 0),
(11, 12, 7, '2013-02-14', '08:00', '10:00', 1),
(13, 14, 13, '2013-02-10', '08:00', '10:00', 2),
(14, 14, 13, '2013-02-11', '08:00', '10:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `icon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banner` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `ispremium` int(11) NOT NULL DEFAULT '0',
  `agent_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `msisdn` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=405 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`, `last_login`, `icon`, `banner`, `confirmed`, `ispremium`, `agent_id`, `package_id`, `msisdn`) VALUES
(1, 'admin', 'c92021be9edcf8c36cdf355178c981a0', 'aryo@simetri.web.id', 'Administrator', '2012-07-11 11:01:42', '2012/04/18/20120418_150027_7385.jpg', NULL, 1, 0, 0, 0, NULL),
(19, 'administrator', 'b52a0a08c43cadf859373c943bdd25e7', 'joko@simetri.web.id', 'administrator2', '2012-07-11 11:01:42', '', NULL, 1, 0, 0, 0, NULL),
(18, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@nomail.com', 'user', '2012-07-11 11:01:42', '', NULL, 1, 0, 0, 0, NULL),
(20, 'joko', '9ba0009aa81e794e628a04b51eaf7d7f', 'jokonet@gmail.com', 'Joko Siswanto', '2012-12-17 10:19:18', '', NULL, 1, 0, 0, 0, NULL),
(21, 'ferdhie', '9baa7d76b70f95dba6dd71f853d21177', 'ferdhie@gmail.com', 'Herdian Ferdianto', '2012-07-11 11:01:42', '', NULL, 1, 0, 0, 0, NULL),
(22, 'aryo', '2ec87599180c059aa5444292cd98c5ff', 'aryo.sanjaya@gmail.com', 'Aryo Sanjaya', '2012-07-11 11:01:42', '', NULL, 1, 0, 0, 0, NULL),
(23, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'info@simetri.web.id', 'Demo User', '2013-02-09 08:08:15', '', NULL, 1, 0, 0, 0, '0341'),
(24, 'test', '098f6bcd4621d373cade4e832627b4f6', NULL, NULL, '2012-07-11 11:01:42', NULL, NULL, 1, 0, 0, 0, NULL),
(25, 'jokonet', '7824049fb3060066b078ec91f698a93b', NULL, NULL, '2012-07-11 11:01:42', NULL, NULL, 1, 0, 0, 0, NULL),
(26, 'RicoJayaSukma', 'eb46120382042a271b1298c0dbe5ab02', NULL, NULL, '2012-07-27 02:21:13', NULL, NULL, 1, 0, 0, 0, NULL),
(27, 'davidpan', 'adb022da1012950df11bb57561c1cace', 'davidpangputra@gmail.com', 'David Pangputra', '2012-07-27 05:54:29', '27/27.jpg', NULL, 1, 0, 0, 0, NULL),
(28, 'rizal', '150fb021c56c33f82eef99253eb36ee1', NULL, NULL, '2012-09-12 13:22:50', NULL, NULL, 1, 0, 0, 0, NULL),
(29, 'kudasakti', '2a282e7e8248de87758ac8791c86fafe', '', 'Kuda Sakti Food', '2012-11-26 05:56:23', NULL, 'kudasakti.jpg', 1, 1, 0, 0, NULL),
(30, 'sugiharto', '36eaffabb5db46e1ccb497ffa4dcec41', NULL, NULL, '2012-09-03 08:59:45', NULL, NULL, 1, 0, 0, 0, NULL),
(31, 'sulfat1', 'cc79cb4b34d0774a23492f68807d011f', NULL, 'DELIMA SOLUTION', '2012-09-13 06:36:17', NULL, NULL, 1, 0, 0, 0, NULL),
(32, 'pasuruan', '71438fa81bd5bc3fd7889f7e97dd3ef5', '', 'Polres Pasuruan', '2012-11-26 05:56:37', NULL, '32/koppolrespasuruan.png', 1, 1, 0, 0, NULL),
(33, 'JOKERz', '634fc0ce9f7685db4fb1cbf198b4869b', NULL, NULL, '2012-09-27 07:07:44', NULL, NULL, 0, 0, 0, 0, NULL),
(34, 'igo', '2661017193d7401c9fb3aa87d9407d94', NULL, NULL, '2012-09-27 13:13:56', NULL, NULL, 0, 0, 0, 0, NULL),
(35, 'bnnbatu', 'fd35bb9b0f9471dd93f197f55714f480', '', 'Badan Narkotika Nasional Kota Batu', '2012-11-26 05:56:53', NULL, 'bnnbatu.jpg', 1, 1, 0, 0, NULL),
(36, 'yusuf', '8e53c6316746bc7d02abc9532b0bfea5', NULL, NULL, '2012-10-15 05:57:15', NULL, NULL, 0, 0, 0, 0, NULL),
(37, 'nizam', '9025cab971b22a133b5d61a8a190befe', NULL, NULL, '2012-10-18 05:16:07', NULL, NULL, 0, 0, 0, 0, NULL),
(38, 'rizalkertosastro', '68ba07abf0d370630620ea43c68fabbd', 'rizalkertosastro@gmail.com', 'Rizal Kertosastro', '2012-10-18 12:53:29', NULL, NULL, 1, 0, 0, 0, NULL),
(39, 'rizalkertosasatro', 'e67ee0fe3523448cd831a42332567e5b', NULL, NULL, '2012-10-18 12:20:23', NULL, NULL, 0, 0, 0, 0, NULL),
(40, 'freddynokiac3', '6dec254b00147206770e499799c67bc7', NULL, NULL, '2012-10-19 00:35:24', NULL, NULL, 0, 0, 0, 0, NULL),
(41, 'ariawansah', '861b26042c21554df6d31e3de3ce8e6f', NULL, NULL, '2012-10-19 06:41:26', NULL, NULL, 0, 0, 0, 0, NULL),
(42, 'agil110491', '74e7664329a6d57798aa99a7c30e09fd', NULL, NULL, '2012-10-19 22:07:17', NULL, NULL, 0, 0, 0, 0, NULL),
(43, 'agil', 'ba2df6f89f0ccb2e5f2bffd2edd9a8db', NULL, NULL, '2012-10-20 03:50:42', NULL, NULL, 0, 0, 0, 0, NULL),
(44, 'ofertatabg', '47ade116e3b759464f84d8cf8f09ea4b', NULL, NULL, '2012-10-20 09:51:27', NULL, NULL, 0, 0, 0, 0, NULL),
(45, 'dhanni26', 'd4f211ea0653da4383831d644bb9db86', NULL, NULL, '2012-10-20 14:31:04', NULL, NULL, 0, 0, 0, 0, NULL),
(46, 'danni26', '16293f716259b6ca1af0c9e0a19250b8', NULL, NULL, '2012-10-20 14:44:05', NULL, NULL, 0, 0, 0, 0, NULL),
(47, 'nadzrin94', '95c43791bae6bd131bb3dfa932693742', NULL, NULL, '2012-10-21 00:12:55', NULL, NULL, 0, 0, 0, 0, NULL),
(48, 'ellgamaulina', 'e02529433b8ce1cfede30d17343877d0', NULL, NULL, '2012-10-21 03:32:52', NULL, NULL, 0, 0, 0, 0, NULL),
(49, 'damario789', '9daab09ab561f8306f732478842f059e', NULL, NULL, '2012-10-21 09:09:30', NULL, NULL, 0, 0, 0, 0, NULL),
(50, 'erapalita', '774f6008bedb63747161f6c9de151c14', NULL, NULL, '2012-10-21 16:14:23', NULL, NULL, 0, 0, 0, 0, NULL),
(51, 'bamsz', 'e9f0ffd7ff48fdbbb7f8c96ed9db0c64', NULL, NULL, '2012-10-21 18:55:48', NULL, NULL, 0, 0, 0, 0, NULL),
(52, 'Rusty86', '9dd8bf75625a7ccffaf4b69ec20b8fcc', NULL, NULL, '2012-10-21 23:37:41', NULL, NULL, 0, 0, 0, 0, NULL),
(53, 'so112so', '3961c280a57484ef33c02c1432206223', NULL, NULL, '2012-10-22 02:19:34', NULL, NULL, 0, 0, 0, 0, NULL),
(54, 'najarudin', 'af97639e88bafbfaed9eaf0fd562ac7c', NULL, NULL, '2012-10-22 02:38:49', NULL, NULL, 0, 0, 0, 0, NULL),
(55, 'zaroe', 'a0ec5addbde9f4f61d97197aef1ad40a', NULL, NULL, '2012-10-22 02:45:06', NULL, NULL, 0, 0, 0, 0, NULL),
(56, 'dewylasma', '1c2aeba6c098479f45317ac429ebbbf3', NULL, NULL, '2012-10-22 06:06:47', NULL, NULL, 0, 0, 0, 0, NULL),
(57, 'JustinBieber', '0e8b2037e9ff496b5d902047c79280ca', NULL, NULL, '2012-10-22 15:01:10', NULL, NULL, 0, 0, 0, 0, NULL),
(58, 'mchilenogu', 'c8aec13efcfecd86b130cf555197d7a4', NULL, NULL, '2012-10-22 20:12:43', NULL, NULL, 0, 0, 0, 0, NULL),
(59, 'williamrudolph', '3932762c50275a27b504b6fd05ca8235', NULL, NULL, '2012-10-22 23:11:44', NULL, NULL, 0, 0, 0, 0, NULL),
(60, 'gunabeib', '412a18dae8bb259a79a5bcf2d3851862', NULL, NULL, '2012-10-23 05:36:04', NULL, NULL, 0, 0, 0, 0, NULL),
(61, 'Betania', '40daff83e1e756c8c5481c80bddbbfb1', NULL, NULL, '2012-10-23 05:56:30', NULL, NULL, 0, 0, 0, 0, NULL),
(62, 'arirahman911', '5541f83359f7a308aa4bfaf8940028f5', NULL, NULL, '2012-10-23 09:11:53', NULL, NULL, 0, 0, 0, 0, NULL),
(63, 'rendradetu', '8fd1fb7df3a5deeb81fedc903e5505a5', NULL, NULL, '2012-10-23 16:58:19', NULL, NULL, 0, 0, 0, 0, NULL),
(64, 'luckywih7117', '3107bdf3e99ea9bdcba71e2460cbe0fa', NULL, NULL, '2012-10-23 18:53:52', NULL, NULL, 0, 0, 0, 0, NULL),
(65, 'denymuly2084', '2991cde5c0216fa1f9d6626f164776c3', NULL, NULL, '2012-10-24 01:45:12', NULL, NULL, 0, 0, 0, 0, NULL),
(66, 'denyinedz', '6066f74692942d102afebc2c7f9aae26', NULL, NULL, '2012-10-24 02:00:34', NULL, NULL, 0, 0, 0, 0, NULL),
(67, 'Riyanto', '17677539045b19f12842cdb661921e15', NULL, NULL, '2012-10-24 05:06:21', NULL, NULL, 0, 0, 0, 0, NULL),
(68, 'fenny', '739b9936893f196e416523eff0050a09', NULL, NULL, '2012-10-24 08:54:28', NULL, NULL, 0, 0, 0, 0, NULL),
(69, 'rony4', 'fe0d113f54de2d8d0f74f1697604f741', NULL, NULL, '2012-10-24 09:31:40', NULL, NULL, 0, 0, 0, 0, NULL),
(70, 'simetri', '03d1cac2617a6a630583b6b189836547', 'info@simetri.web.id', 'SIMETRI', '2013-01-15 07:20:12', NULL, NULL, 1, 0, 0, 0, NULL),
(71, 'rony5', '70c25bc5db2f60d07c0109e7cd60f837', NULL, NULL, '2012-10-25 19:12:32', NULL, NULL, 0, 0, 0, 0, NULL),
(72, 'deabendhe', 'a433e01e64071dfadc03582406612b7b', NULL, NULL, '2012-10-26 09:40:21', NULL, NULL, 0, 0, 0, 0, NULL),
(73, 'nagamotor', '22dfacd1589bfed9fa40758caa7aaf5b', NULL, NULL, '2012-10-27 01:01:36', NULL, NULL, 0, 0, 0, 0, NULL),
(74, 'aryantosck', 'db5d40a9c60040ddbe626e94b63f192d', NULL, NULL, '2012-10-27 04:53:45', NULL, NULL, 0, 0, 0, 0, NULL),
(75, 'aryanto', 'ec93a4a18b4583f53478ab55dc3c9f66', NULL, NULL, '2012-10-27 05:12:42', NULL, NULL, 0, 0, 0, 0, NULL),
(76, 'hendri', '53cb1973184658f5d374897b925744e1', NULL, NULL, '2012-10-27 15:41:16', NULL, NULL, 0, 0, 0, 0, NULL),
(77, 'yanto', '5446a97b97489f27e904d32b64eabe52', NULL, NULL, '2012-10-27 16:15:10', NULL, NULL, 0, 0, 0, 0, NULL),
(78, 'yanto86', 'fea0088f1107e3ea31ed6112cc228cf3', NULL, NULL, '2012-10-27 16:36:49', NULL, NULL, 0, 0, 0, 0, NULL),
(79, 'weggie', '33283b1d557c1c6a51b73c70d1bfcb00', NULL, NULL, '2012-10-27 19:48:23', NULL, NULL, 0, 0, 0, 0, NULL),
(80, 'krisna', '5803fc0e2e8d391557a9cebcccbf65b2', NULL, NULL, '2012-10-27 19:54:22', NULL, NULL, 0, 0, 0, 0, NULL),
(81, 'wempi', '7e72bc0d611d40ab70124227dd513085', NULL, NULL, '2012-10-27 20:03:08', NULL, NULL, 0, 0, 0, 0, NULL),
(82, 'krisnabro', '81b38e7368c636732e678c2bacabb32a', NULL, NULL, '2012-10-27 20:18:38', NULL, NULL, 0, 0, 0, 0, NULL),
(83, 'davidn', '869eaf610945cef55d5b1dac09c461e7', NULL, NULL, '2012-10-28 08:18:32', NULL, NULL, 0, 0, 0, 0, NULL),
(84, 'hasobiroid', '414dba64d9699429b8720e32770a4e44', NULL, NULL, '2012-10-28 16:28:28', NULL, NULL, 0, 0, 0, 0, NULL),
(85, 'roidradityo', 'c04a7a9cbc5f073c5b3f64a104a92a2a', NULL, NULL, '2012-10-28 16:38:18', NULL, NULL, 0, 0, 0, 0, NULL),
(86, 'jubail', '3fa3dc49e7aa87226565516c247c3be7', NULL, NULL, '2012-10-28 18:20:35', NULL, NULL, 0, 0, 0, 0, NULL),
(87, 'panda', '89406cc5e4da50a2ec2da1bd17cd1f0d', NULL, NULL, '2012-10-28 18:32:50', NULL, NULL, 0, 0, 0, 0, NULL),
(88, 'nurudin', '2f93f3e672327c71ba76c43d93a9b2c5', NULL, NULL, '2012-10-29 06:38:08', NULL, NULL, 0, 0, 0, 0, NULL),
(89, 'nurudin1010', '773956604af63ee69ff815a016b180e9', NULL, NULL, '2012-10-29 06:59:29', NULL, NULL, 0, 0, 0, 0, NULL),
(90, 'xottabic', 'bd9777d5d5f7b5f84ccb4555e990b0e1', NULL, NULL, '2012-10-29 18:17:50', NULL, NULL, 0, 0, 0, 0, NULL),
(91, 'foamclene', '0c77e7e6e348437c819b6bf560b8afdc', NULL, NULL, '2012-10-29 18:25:48', NULL, NULL, 0, 0, 0, 0, NULL),
(92, 'kimdarus', '346807106c96453eb06e99c06559dc3a', NULL, NULL, '2012-10-30 02:27:33', NULL, NULL, 0, 0, 0, 0, NULL),
(93, 'ahmadfirdaus', '9478b70fd2c0754ad560db3812afaaed', NULL, NULL, '2012-10-30 02:48:48', NULL, NULL, 0, 0, 0, 0, NULL),
(94, 'andresiyop', '72dee2b7efa12ad058c5d0face76a920', NULL, NULL, '2012-10-30 07:32:15', NULL, NULL, 0, 0, 0, 0, NULL),
(95, 'andresiyop19', 'd9698e691955d5d6f952a8570abaf262', NULL, NULL, '2012-10-30 08:03:42', NULL, NULL, 0, 0, 0, 0, NULL),
(96, 'firman', '9589616bbf98b3d5df5969a452395715', 'firman.ah@gmail.com', 'Firman', '2012-10-30 14:24:56', '96/96.jpg', NULL, 1, 0, 0, 0, NULL),
(97, 'winand', '0989ee48a74e25b0fdb57ebbc6e76030', NULL, NULL, '2012-10-30 19:58:45', NULL, NULL, 0, 0, 0, 0, NULL),
(98, 'bonnyfischera', 'b3145c0659cddbd92be061b38f53f336', NULL, NULL, '2012-11-01 02:42:54', NULL, NULL, 0, 0, 0, 0, NULL),
(99, 'didicyber', 'd5e363d8295a9537ee8f6161f7e60442', NULL, NULL, '2012-11-01 04:03:23', NULL, NULL, 0, 0, 0, 0, NULL),
(100, 'd2cyber', '8499375b12db411fe4cd3078ec042a74', NULL, NULL, '2012-11-01 04:16:35', NULL, NULL, 0, 0, 0, 0, NULL),
(101, 'zainul', '2c670460b53d9c1efdc9d0c9d839d04d', NULL, NULL, '2012-11-01 16:22:16', NULL, NULL, 0, 0, 0, 0, NULL),
(102, 'Timbhel', 'bc5118066b081bf034997204efb67a44', NULL, NULL, '2012-11-02 02:32:35', NULL, NULL, 0, 0, 0, 0, NULL),
(103, 'Vario', '75e538b7886ce62bea18844379f06ea0', NULL, NULL, '2012-11-02 02:35:49', NULL, NULL, 0, 0, 0, 0, NULL),
(104, 'hasbi', '1bd31173d5157fc5fd69dfd935b02a0e', NULL, NULL, '2012-11-02 03:48:34', NULL, NULL, 0, 0, 0, 0, NULL),
(105, 'hill8oy', 'df18ec67570d03361d8771e8ae5c15b7', NULL, NULL, '2012-11-02 13:06:52', NULL, NULL, 0, 0, 0, 0, NULL),
(106, 'hilman', 'a6e983f3d1c598b2e44ee7427ef941e4', NULL, NULL, '2012-11-02 13:19:19', NULL, NULL, 0, 0, 0, 0, NULL),
(107, 'utinamoredo', '865064a21b2accfd6c27eafd1114f798', NULL, NULL, '2012-11-03 03:28:05', NULL, NULL, 0, 0, 0, 0, NULL),
(108, 'fajardapodik', 'bac8b4a838fd8942dae3e86964c6ca6c', NULL, NULL, '2012-11-03 06:25:57', NULL, NULL, 0, 0, 0, 0, NULL),
(109, 'ariwibowo', '06eaf86999365c3c5ca45062bc286c0f', NULL, NULL, '2012-11-04 01:53:42', NULL, NULL, 0, 0, 0, 0, NULL),
(110, 'lusi', 'b540471c3c424da8637b888c36a4d23a', '', 'Lusi', '2012-11-04 05:20:43', NULL, NULL, 1, 0, 0, 0, NULL),
(111, 'tonjigeeer', '62f4c3c0b8796a6d4869072550415bfb', NULL, NULL, '2012-11-04 07:33:29', NULL, NULL, 0, 0, 0, 0, NULL),
(112, 'mgnajib', 'c60ef4fee2aaa5dca4201728a3c8cae3', NULL, NULL, '2012-11-04 09:49:44', NULL, NULL, 0, 0, 0, 0, NULL),
(113, 'oguzhanvan65', 'c51dcdbf2b03e51417939da88818f8ee', NULL, NULL, '2012-11-04 14:19:53', NULL, NULL, 0, 0, 0, 0, NULL),
(114, 'yusramansur', '880ebcb55860847b2477d47662fb93fa', NULL, NULL, '2012-11-04 15:28:20', NULL, NULL, 0, 0, 0, 0, NULL),
(115, 'suburcaballero', '5a4b1fdb5e68b4e89529716eac05de79', NULL, NULL, '2012-11-05 03:03:15', NULL, NULL, 0, 0, 0, 0, NULL),
(116, 'ch3mul', '0609b5ea1d8dfc298258669eb99d725e', NULL, NULL, '2012-11-05 07:17:51', NULL, NULL, 1, 0, 0, 0, NULL),
(117, 'alfianfakhri', 'cd51014712f472c1e3544e338316076a', NULL, NULL, '2012-11-05 11:02:20', NULL, NULL, 1, 0, 0, 0, NULL),
(118, 'frafra33', '6c7ef88c9827739b14e18853f6e2a52c', NULL, NULL, '2012-11-06 02:27:41', NULL, NULL, 0, 0, 0, 0, NULL),
(119, 'farrel', 'dbfd0e9a7baa8c4bd7b39fa5b9551368', NULL, NULL, '2012-11-06 12:16:58', NULL, NULL, 1, 0, 0, 0, NULL),
(120, 'dedit', '057829fa5a65fc1ace408f490be486ac', 'setiadiartha@yahoo.com', 'aditya setiadiartha', '2012-11-06 15:40:50', NULL, NULL, 1, 0, 0, 0, NULL),
(121, 'william', 'fba107d5d0bdefc3ed24b194c4cb966a', 'william_rdlph@yahoo.com', 'william', '2012-11-06 17:29:24', NULL, NULL, 1, 0, 0, 0, NULL),
(122, 'hasan', 'f877718d596d93e4f98d85fcb2d2c0f6', NULL, NULL, '2012-11-07 01:22:32', NULL, NULL, 0, 0, 0, 0, NULL),
(123, 'bnnmalang', '6036d5c0caa248e4b42bab931a6bad84', '', 'bnnmalang', '2012-11-26 05:57:25', NULL, 'bnnmalang.jpg', 1, 1, 0, 0, NULL),
(124, 'jukers', '2469b65df41de51708518ffe8dc9c08b', NULL, NULL, '2012-11-07 04:58:06', NULL, NULL, 1, 0, 0, 0, NULL),
(125, 'WiturAgustiningrum', '296aa98799ceac1ecadcb02914b83b23', 'wee_toer@yahoo.com', 'Witur Agustiningrum', '2012-11-07 05:33:27', NULL, NULL, 1, 0, 0, 0, NULL),
(126, 'colz1234', '6bb35235f09ca8c22dafa4e6a36221a0', NULL, NULL, '2012-11-07 15:24:17', NULL, NULL, 1, 0, 0, 0, NULL),
(127, 'caballero', 'c30e11e6590a34431fe921ac6e0d7146', NULL, NULL, '2012-11-07 22:20:18', NULL, NULL, 0, 0, 0, 0, NULL),
(128, 'gusty', '31b30e38700efe7de20da0729b4079e7', 'gusty_ptbajt@yahoo.co.id', 'gusty', '2012-11-08 09:11:09', NULL, NULL, 1, 0, 0, 0, NULL),
(129, 'damar', '312f788d7d36b532aeedaeb19acbc96b', NULL, NULL, '2012-11-11 07:30:40', NULL, NULL, 1, 0, 0, 0, NULL),
(130, 'alcantara', '6a9275bb80290da8842419def0365608', NULL, NULL, '2012-11-11 10:28:31', NULL, NULL, 1, 0, 0, 0, NULL),
(131, 'ariey', '3bf70dace22ce6fc12a4efa47ee1a5fd', NULL, NULL, '2012-11-11 10:57:04', NULL, NULL, 1, 0, 0, 0, NULL),
(132, 'Putri', 'c68fa325e0b0bc8c34fede18fc8dbe89', NULL, NULL, '2012-11-13 02:40:33', NULL, NULL, 1, 0, 0, 0, NULL),
(133, 'manchestiar84', '493aeb5695966e5d45fcb5028395e656', 'manchestiarunited@yahoo.com', 'bachtiar f tanggi', '2012-11-14 16:30:34', '133/133.jpg', '133/Photo on 10-3-12 at 3.53 AM.jpg', 1, 0, 0, 0, NULL),
(134, 'quinaya89', '99bed6e9f1b8681b1828246f834bd6a4', 'zabian_quinaya@yahoo.com', 'zabian quinaya', '2012-11-14 16:42:48', NULL, NULL, 1, 0, 0, 0, NULL),
(135, 'anitasu', '3b0f86e83d2cb207392a3bc89548bae3', NULL, NULL, '2012-11-16 00:11:30', NULL, NULL, 1, 0, 0, 0, NULL),
(136, 'anfadlhy', '09ec6356fe76efefbe539e5dffe778fb', NULL, NULL, '2012-11-16 02:48:40', NULL, NULL, 1, 0, 0, 0, NULL),
(137, '4nf4dlhy', 'b92bba4fbca932250d0329bfdc89ae71', NULL, NULL, '2012-11-16 02:46:02', NULL, NULL, 0, 0, 0, 0, NULL),
(138, 'EunikeMelani', '90baf871d6a0e8df2fd25abcb97cad7a', NULL, NULL, '2012-11-19 19:47:36', NULL, NULL, 0, 0, 0, 0, NULL),
(139, 'EunikeMelani93', '6ce25bffde3a9e70467d33503abb20e5', NULL, NULL, '2012-11-19 19:56:34', NULL, NULL, 0, 0, 0, 0, NULL),
(140, 'frankkzz', 'c9746c5791e9208f9ef0c3d3c8ec25c8', 'street_voice33@yahoo.com', 'franky siahaan', '2012-11-20 19:56:31', NULL, NULL, 1, 0, 0, 0, NULL),
(141, 'samantha', '3fee20fe594d1b36de80ce02e02c2478', NULL, NULL, '2012-11-22 11:06:27', NULL, NULL, 0, 0, 0, 0, NULL),
(142, 'sugito0079', 'c35110558973a92ac69ee89ad07af96e', NULL, NULL, '2012-11-23 06:41:31', NULL, NULL, 1, 0, 0, 0, NULL),
(143, 'vidho', '203caa578f4120f12a17e2610c3da0f5', NULL, NULL, '2012-11-24 18:24:51', NULL, NULL, 1, 0, 0, 0, NULL),
(144, 'romadhoni', '6c57adf0337b4794fdeb6da4d92fc068', 'exblopz@gmail.com', 'Muhammad Yusuf Romadhoni Al Faruq', '2012-11-24 22:50:57', '144/144.jpg', '144/logo-abuaisyah.jpg', 1, 0, 0, 0, NULL),
(145, 'Clintz01', '66945a2c7a095ee19a716abd49f00ae2', NULL, NULL, '2012-11-26 06:53:00', NULL, NULL, 1, 0, 0, 0, NULL),
(146, 'Oswaldo', '001f594271a4a46d4fe854d61cc36d08', NULL, NULL, '2012-11-26 14:09:15', NULL, NULL, 0, 0, 0, 0, NULL),
(147, 'oswaldoGonzalez', 'c0fff7f31b2ecc2551c7af0873d7ae26', NULL, NULL, '2012-11-26 14:15:29', NULL, NULL, 0, 0, 0, 0, NULL),
(148, 'syahreza', '6c39e53e594dbc9f685a00794726df32', 'syahreza_s@hotmail.com', 'SYAHREZA SIMANJUNTAK', '2012-11-27 17:15:16', NULL, NULL, 1, 0, 0, 0, NULL),
(149, 'ayaro', 'a2d3763a96c122507b0bb1fdb646e71f', NULL, 'Ayaro', '2012-11-28 13:52:38', NULL, NULL, 1, 0, 0, 0, NULL),
(150, 'andiwisran', 'dc8004d1e0800bfb3d86c13801e6d58a', NULL, NULL, '2012-12-03 04:26:08', NULL, NULL, 1, 0, 0, 0, NULL),
(151, 'agus', '829d94951879372f04d8e95e7b3c7058', '', 'Agus', '2012-12-03 18:01:16', NULL, NULL, 1, 1, 0, 0, NULL),
(152, 'andre', 'd1a30e31e25ac26b8158b8b18dadb842', NULL, NULL, '2012-12-04 04:46:03', NULL, NULL, 1, 0, 0, 0, NULL),
(153, 'Amon', 'c5a335bbf0ec9d9b2f28b9a1fcd78250', NULL, NULL, '2012-12-04 07:00:17', NULL, NULL, 1, 0, 0, 0, NULL),
(154, 'gpsku', '935bec01a7f8b19c69e8ddee86ef5510', NULL, NULL, '2012-12-04 09:55:10', NULL, NULL, 1, 0, 0, 0, NULL),
(155, 'khofeihong', 'c4c04646cfb9c33c4b83661209362ed5', 'kfeihong@gmail.com', 'christian', '2012-12-04 15:57:39', NULL, NULL, 1, 0, 0, 0, NULL),
(160, 'antok', '3c01286c1b352b4648703499184b0448', NULL, NULL, '2012-12-08 13:41:00', NULL, NULL, 0, 0, 0, 0, NULL),
(159, 'wahyu', 'f2f945b5e2ec2e8528ab5655723b1425', NULL, 'Wahyu', '2012-12-07 09:52:30', NULL, NULL, 1, 1, 0, 0, NULL),
(195, 'godink', '6194e4806ee7f19939d5c6eb142f5a68', NULL, NULL, '2012-12-28 10:10:06', NULL, NULL, 1, 0, 0, 0, NULL),
(161, 'aisyahanindya', 'd88a52e27bde1a3cde2603e115a63edf', NULL, NULL, '2012-12-08 13:47:00', NULL, NULL, 0, 0, 0, 0, NULL),
(162, 'shiro', '79870af9afd53471fa921e1a71dca26a', NULL, NULL, '2012-12-08 13:52:03', NULL, NULL, 1, 0, 0, 0, NULL),
(163, 'barium', 'df6f17925412f84be4519bee536b10cd', NULL, NULL, '2012-12-08 15:12:24', NULL, NULL, 1, 0, 0, 0, NULL),
(164, 'gelarwisnugraha', '8d9a03a1d1ba181edd48ade2a07a0e2d', 'the_djam007@yahoo.com', 'Gelar Wisnugraha', '2012-12-09 15:27:07', NULL, NULL, 1, 0, 0, 0, NULL),
(165, 'rafizadriansyah', 'ee4abe9f7d65f5ec62efb7363822a032', NULL, NULL, '2012-12-10 14:20:42', NULL, NULL, 0, 0, 0, 0, NULL),
(166, 'bca', '533944b0640e36f13f6c1550f8a6554e', '', 'bca', '2012-12-17 06:25:42', NULL, '166/kop-tugasnada.png', 1, 0, 0, 0, NULL),
(167, 'Alec', '0eb980d2d602a190e7d8660d02706f91', NULL, NULL, '2012-12-12 02:46:11', NULL, NULL, 0, 0, 0, 0, NULL),
(168, 'sigit', '00400931d5e8c41a3207712ce1f494f6', 'sigit_triyono@yahoo.com', 'sigit', '2013-01-23 00:41:39', NULL, NULL, 1, 0, 0, 0, NULL),
(169, 'adhisetiawan', 'ff831637c84a254cff4ebb0ab9d62832', NULL, NULL, '2012-12-12 15:40:34', NULL, NULL, 1, 0, 0, 0, NULL),
(170, 'saputra', '2667910f6d772c648f7bcaae97843600', NULL, NULL, '2012-12-12 22:53:26', NULL, NULL, 1, 0, 0, 0, NULL),
(171, 'meyput', 'c8121d32cfd563c3c178f498f458d886', 'devil_encexs@yahoo.com', 'saputra', '2012-12-12 23:31:34', '171/171.gif', '171/putra.jpg', 1, 0, 0, 0, NULL),
(172, 'JamesCadavid', '3d57b8e010e8a2d0d94b74ef72d1e8e0', NULL, NULL, '2012-12-13 19:30:43', NULL, NULL, 1, 0, 0, 0, NULL),
(173, 'bnnsamarinda', '6cbecf2b317185979717237ba8308057', '', 'bnnsamarinda', '2012-12-17 10:20:19', NULL, NULL, 1, 0, 0, 0, NULL),
(174, 'abhareno', 'd5de2771ba0cd0d252cbb1fd9cdd51b2', NULL, NULL, '2012-12-17 11:30:43', NULL, NULL, 0, 0, 0, 0, NULL),
(175, 'nova', '2254aa295ef86ef29aa04004de286477', NULL, NULL, '2012-12-18 00:09:28', NULL, NULL, 1, 0, 0, 0, NULL),
(176, 'radit', '3e46f482e30d9d9d6ac8393a9fa24969', '', 'radit', '2012-12-18 07:33:20', NULL, NULL, 1, 0, 0, 0, NULL),
(177, 'baranist', '215d600fd39a05f83b6da2186bdb9faf', NULL, NULL, '2012-12-18 12:34:38', NULL, NULL, 1, 0, 0, 0, NULL),
(178, 'belly', '57731a1644e63d0285c8bd8bfcfcf403', NULL, NULL, '2012-12-19 05:40:31', NULL, NULL, 1, 0, 0, 0, NULL),
(179, 'hsatria203', '1eb648d2943f4655d109b7e4f9849c48', NULL, NULL, '2012-12-19 11:14:18', NULL, NULL, 1, 0, 0, 0, NULL),
(180, 'ridhohangga', 'e58b6ffc6106e2d5f4a48887bc40e7b6', 'ridhohanggawijaya@yahoo.co.id', 'Ridho Hangga', '2012-12-20 02:09:21', NULL, NULL, 1, 0, 0, 0, NULL),
(181, 'JAMIE', 'f6c3c9a5114bcd078b51bf417f8babce', NULL, NULL, '2012-12-20 08:57:45', NULL, NULL, 0, 0, 0, 0, NULL),
(182, 'tutik', 'f1b0a555fa103b510b7ad28d7fc426a4', 'tutik@gmail.com', 'tutik', '2012-12-20 11:56:20', NULL, NULL, 1, 0, 0, 0, NULL),
(183, 'jamiefay', '2a0dc47d96ce3b91fe17e024ad74239e', NULL, NULL, '2012-12-21 00:22:13', NULL, NULL, 0, 0, 0, 0, NULL),
(184, 'craziimii', '6c46b440976dcff9eeaa8df45b256c79', NULL, NULL, '2012-12-21 00:23:48', NULL, NULL, 0, 0, 0, 0, NULL),
(185, 'luthfanrmdh', 'd583626da7069a1c680557b42ebaa021', NULL, NULL, '2012-12-21 09:07:25', NULL, NULL, 0, 0, 0, 0, NULL),
(186, 'sasmito', 'f6ca8f027f555426eb96ea49df7dba88', 'sasmito@gmail.com', 'sasmito', '2012-12-21 09:08:42', NULL, NULL, 1, 0, 7, 0, NULL),
(187, 'septa', '63e9b2903b6530b64e35c3b86059c3da', NULL, NULL, '2012-12-22 16:40:43', NULL, NULL, 0, 0, 0, 0, NULL),
(188, 'septailfan', '16037a0d906e95d1df1a55989f18d8ca', NULL, NULL, '2012-12-22 16:57:32', NULL, NULL, 1, 0, 0, 0, NULL),
(189, 'Jhon', 'cb1b1460475a1f21b21d9d74d16211a8', NULL, NULL, '2012-12-23 03:30:37', NULL, NULL, 0, 0, 0, 0, NULL),
(190, 'jhon1984', '3d1693ed0b6925ee6a8b05d0d32dbfd0', NULL, NULL, '2012-12-23 03:38:01', NULL, NULL, 1, 0, 0, 0, NULL),
(191, 'starpratama', '544328af2e74803ef7ca3883d229b9a5', '', 'Starpratama ID-Nurse', '2012-12-23 06:21:30', NULL, NULL, 1, 0, 0, 0, NULL),
(192, 'antony', 'c9fcd591c22112d0efa9e48bc27a1e8a', NULL, NULL, '2012-12-23 14:47:19', NULL, NULL, 0, 0, 0, 0, NULL),
(193, 'nazar', '384d52f51187500b9de526611415e09c', NULL, NULL, '2012-12-26 03:03:24', NULL, NULL, 1, 0, 0, 0, NULL),
(194, 'nurul', 'ab9c2f4be3d8a5d99eb68a34caf487a7', 'nurul@gmail.com', 'nurul', '2012-12-26 06:32:38', NULL, NULL, 1, 0, 0, 0, NULL),
(196, 'FaridVodka', '4ca6cd470c15353f41aa925f6c3f86d8', NULL, NULL, '2012-12-28 17:20:34', NULL, NULL, 1, 0, 0, 0, NULL),
(197, 'jairomarcano', '10324e8087d7cc98efa7d384e7295ac1', NULL, NULL, '2012-12-29 16:20:25', NULL, NULL, 0, 0, 0, 0, NULL),
(198, 'JAIROMARCANO55', 'e4bfa2adf9d734339718a61ae64d9b65', NULL, NULL, '2012-12-29 17:54:07', NULL, NULL, 0, 0, 0, 0, NULL),
(199, 'tohidin', 'db99e195af08a86aa8de0175ba155b79', NULL, NULL, '2012-12-30 15:26:59', NULL, NULL, 1, 0, 0, 0, NULL),
(200, 'isman', 'ce0e5bf55e4f71749eade7a8b95c4e46', 'isman@ygmail.com', 'isman', '2012-12-31 02:16:36', NULL, NULL, 1, 0, 0, 0, NULL),
(201, 'intelyes', '9111e17dff185ef273bd366f04699ff5', NULL, NULL, '2012-12-31 19:45:27', NULL, NULL, 1, 0, 0, 0, NULL),
(202, 'hadi', '3897205a986567bd3abac2152f6b62b0', NULL, NULL, '2013-01-01 02:39:48', NULL, NULL, 0, 0, 0, 0, NULL),
(203, 'Sardini', 'f1ec750b70301914a3bdffb8a5d6bd5a', NULL, NULL, '2013-01-01 02:48:42', NULL, NULL, 0, 0, 0, 0, NULL),
(204, 'mulyono', '323b61acabd96c48b72934738a4ef21a', NULL, NULL, '2013-01-02 04:21:20', NULL, NULL, 0, 0, 0, 0, NULL),
(205, 'imulcfc', 'fb3a9cfb0ff5f40aaf788bc569eef58f', NULL, NULL, '2013-01-02 04:23:46', NULL, NULL, 0, 0, 0, 0, NULL),
(206, 'donny', '8fb83f6c02eb7e47ae436988ecaa39eb', NULL, 'Donny', '2013-01-02 13:42:51', NULL, NULL, 1, 0, 0, 0, NULL),
(207, 'yudadibrata', '4fe108b32d89c68a907f128bc4c84b2b', NULL, NULL, '2013-01-02 17:51:15', NULL, NULL, 1, 0, 0, 0, NULL),
(208, 'heri', '81dc9bdb52d04dc20036dbd8313ed055', 'hadiirawan_irawan@yahoo.com', 'heri', '2013-01-04 18:06:23', NULL, NULL, 1, 0, 0, 0, NULL),
(209, 'Bambang', '7ddfbf0bfb340512503bdcef7b37f758', NULL, NULL, '2013-01-04 19:00:51', NULL, NULL, 1, 0, 0, 0, NULL),
(210, 'kamplik', '680ee49e28834678a71bb58c41f3ec62', 'fajarfibrianto@yahoo.co.id', 'fajar fibrianto', '2013-01-05 11:15:36', NULL, NULL, 1, 0, 0, 0, NULL),
(211, 'mahudi', '90ffc9bd29c566b91ef190bc6aa3f2c9', 'mahudiudi@gmail.com', 'mahudi', '2013-01-05 17:53:57', NULL, NULL, 1, 0, 0, 0, NULL),
(212, 'ella', 'ee01fc45afdaa6467fb138f898909bab', NULL, NULL, '2013-01-06 02:51:03', NULL, NULL, 0, 0, 0, 0, NULL),
(213, 'ivan', 'c572b2cf1ced895fefa679bd15d15a09', NULL, NULL, '2013-01-06 02:58:39', NULL, NULL, 0, 0, 0, 0, NULL),
(214, 'balitotal', 'e1e5c6bd29af1a8217e3ac6fc1ce4774', '', 'balitotal', '2013-01-23 09:14:58', NULL, NULL, 1, 0, 10, 6, NULL),
(218, 'dickyarizald', 'cbd503c04933b5c07264777717bfd101', NULL, NULL, '2013-01-07 09:45:52', NULL, NULL, 1, 0, 0, 0, NULL),
(215, 'imanullah', '906605da820914003921fc5de6ae4932', NULL, NULL, '2013-01-06 08:20:33', NULL, NULL, 0, 0, 0, 0, NULL),
(216, 'imanullahalex', '1b7ca97d3ace2deaa8d35a1138064fd6', NULL, NULL, '2013-01-06 08:25:52', NULL, NULL, 0, 0, 0, 0, NULL),
(217, 'deden', '89a1652160bc7414760827f4b5146d0f', '', 'deden', '2013-01-23 09:15:00', NULL, NULL, 1, 0, 10, 6, NULL),
(219, 'wibowo285', 'd935ff9fe39a0b204c5b522c1d4f0573', NULL, NULL, '2013-01-07 11:11:11', NULL, NULL, 1, 0, 0, 0, NULL),
(220, 'ririn', 'dc5e3b020c994e65720bac3d005c27c6', NULL, NULL, '2013-01-08 03:40:51', NULL, NULL, 1, 0, 0, 0, NULL),
(221, 'dwitriwibowo', 'f05de335b2a76f2bfe045c4bbdd5b238', NULL, NULL, '2013-01-08 08:32:10', NULL, NULL, 1, 0, 0, 0, NULL),
(222, 'tonzeh', 'a234c632a19fa74886088e281b84f036', NULL, NULL, '2013-01-08 09:56:13', NULL, NULL, 1, 0, 0, 0, NULL),
(223, 'papz', 'df540b873456465f519679d975769be5', NULL, NULL, '2013-01-09 10:15:28', NULL, NULL, 1, 0, 0, 0, NULL),
(224, 'Harvyanda', '99bc28726e81d65de1a995cbe116eb6a', NULL, NULL, '2013-01-09 12:32:13', NULL, NULL, 1, 0, 0, 0, NULL),
(225, 'kepanjen', '46840d96d9c8e829720876d9e5484acf', 'kepanjen@gmail.com', 'kepanjen', '2013-01-10 03:45:51', NULL, NULL, 1, 0, 0, 0, NULL),
(226, 'herudroid', '4dbca5655bb0e8e156d836c00d669b0f', NULL, NULL, '2013-01-10 06:19:20', NULL, NULL, 1, 0, 0, 0, NULL),
(227, 'romerio', 'd85c9a2156fb5dbc83b06dad32f24b86', NULL, NULL, '2013-01-12 21:50:35', NULL, NULL, 0, 0, 0, 0, NULL),
(228, 'romeriomatos', 'd9718247663b0bc6fba524a4801ffbf8', NULL, NULL, '2013-01-12 21:53:08', NULL, NULL, 0, 0, 0, 0, NULL),
(229, 'supriejono', '7fa177d2ab7cb63c31745511f36aea11', NULL, NULL, '2013-01-14 01:50:13', NULL, NULL, 1, 0, 0, 0, NULL),
(231, 'invianet', '86437080d513e525c6f5ce35debd9448', NULL, NULL, '2013-01-15 15:33:48', NULL, NULL, 1, 0, 0, 0, NULL),
(232, 'indies', 'e8aa789b36a3f105cf95e47630f2c4e2', NULL, NULL, '2013-01-15 15:34:38', NULL, NULL, 1, 0, 0, 0, NULL),
(233, 'akur', 'fd3e49fb17b86c22c5993d0b63dbd0e5', NULL, NULL, '2013-01-16 08:51:54', NULL, NULL, 0, 0, 0, 0, NULL),
(234, 'budikun', '8927cdbe506de54a013f1dbef25cf093', 't_use11@yahoo.com', 'budi', '2013-01-16 21:10:25', NULL, NULL, 1, 0, 0, 0, NULL),
(235, 'MAMBOROYO', '56e1e18c697a7501d14e9256b504f55a', 'd.pujangga@gmail.com', 'dimas', '2013-01-17 11:36:28', NULL, NULL, 1, 0, 0, 0, NULL),
(236, 'nando', '3a478a8914d7335d24bf3c1790e5e227', 'oneway.nando@yahoo.com', 'fernando', '2013-01-18 01:07:51', '236/236.jpg', NULL, 1, 0, 0, 0, NULL),
(237, 'fernando', '524f06366f7f4bb616d74ae0e2581466', NULL, NULL, '2013-01-18 00:45:50', NULL, NULL, 0, 0, 0, 0, NULL),
(238, 'roronoa', '0b7002b81d67727ea7d7e6ba19fc37ea', NULL, NULL, '2013-01-18 02:54:17', NULL, NULL, 1, 0, 0, 0, NULL),
(239, 'donnyrahman', 'bc27ad2074d19a2459cf8b42dd35cf07', NULL, NULL, '2013-01-18 03:00:07', NULL, NULL, 1, 0, 0, 0, NULL),
(240, 'richan', '15fc3037ef3660fc305801ed32af1e16', 'richan@amplang.com', 'Richan Situmorang', '2013-01-18 03:54:05', NULL, NULL, 1, 0, 0, 0, NULL),
(241, 'fany', '0e3dbbb9d682378e70fe622f2b9970cb', NULL, NULL, '2013-01-18 04:27:33', NULL, NULL, 1, 0, 0, 0, NULL),
(242, 'indrawp', '508994ba1d02531e88feae95246b9d30', 'mozasmania@yahoo.co.id', 'indra', '2013-01-18 04:47:33', '242/242.jpg', '242/2.jpg', 1, 0, 0, 0, NULL),
(243, 'dimasb4yu', 'a099a0efdebcd0fdd3dba4f212dfc19b', NULL, NULL, '2013-01-18 04:42:29', NULL, NULL, 0, 0, 0, 0, NULL),
(244, 'Erickryze', '0c8ca5d6c814064f60e290b082fe1d0f', NULL, NULL, '2013-01-18 05:29:17', NULL, NULL, 1, 0, 0, 0, NULL),
(245, 'dimasbayu', '457abd70094d50a7d1dfde038f9e295c', NULL, NULL, '2013-01-18 05:33:00', NULL, NULL, 0, 0, 0, 0, NULL),
(246, 'rizzaputriadindha', 'a8dfc9d2940c1243b382a74748fb3bff', NULL, NULL, '2013-01-18 05:46:46', NULL, NULL, 1, 0, 0, 0, NULL),
(247, 'rizzaputria', '9aa2fb3f10e7e4237c7f5b8eebb2d289', NULL, NULL, '2013-01-18 05:40:14', NULL, NULL, 0, 0, 0, 0, NULL),
(248, 'yudha06', '31f0d92ed16b165373bac9da6c7e55d5', NULL, NULL, '2013-01-18 05:44:56', NULL, NULL, 1, 0, 0, 0, NULL),
(249, 'evan101198', 'fc4a686288d3c6decbd3a58eba5c3e3c', NULL, NULL, '2013-01-18 05:53:04', NULL, NULL, 1, 0, 0, 0, NULL),
(250, 'busaonline', '784e3fe19f5f62aa59a88f43982179a6', 'me@busaonline.info', 'BusaÂ® Online', '2013-01-18 06:08:15', '250/250.jpg', NULL, 1, 0, 0, 0, NULL),
(251, 'forester', 'ca8118dd118fc87b6cf965f713f23fdf', 'forester.911@gmail.com', 'roni hardi putra', '2013-01-18 06:28:52', NULL, NULL, 1, 0, 0, 0, NULL),
(252, 'ovan155', '85f8339aee8193342f957ac639b478e8', NULL, NULL, '2013-01-18 07:47:08', NULL, NULL, 1, 0, 0, 0, NULL),
(253, 'oeiyohannes', 'd979871f68a9e367eb3a5df8be7c4bf4', 'oeiyohannes@sanco-indonesia.com', 'Oei Yohannes', '2013-01-18 09:02:06', NULL, NULL, 1, 0, 0, 0, NULL),
(254, 'Nrey', '152ffdf54f1bfe96a1895a2b3808c18f', NULL, NULL, '2013-01-18 10:13:21', NULL, NULL, 0, 0, 0, 0, NULL),
(255, 'jimmyjputra', 'd322b6cf11aa01b3d86784f8a4c33331', NULL, NULL, '2013-01-18 10:40:54', NULL, NULL, 1, 0, 0, 0, NULL),
(256, 'imahmariyamah', '85f582593b1581c89822ed19bc85532b', 'rima_mungil@yahoo.com', 'imah mariyamah', '2013-01-18 10:49:05', NULL, NULL, 1, 0, 0, 0, NULL),
(257, 'rieyan130509', 'e1e3629c9e40f477b0903ecd57f308cb', 'rieyan130509@gmail.com', 'ryan heryana', '2013-01-18 12:42:01', NULL, NULL, 1, 0, 0, 0, NULL),
(258, 'zal', '3626212c8f378a65617ae2407fb0a4e6', '', 'I''am rizal', '2013-01-18 13:54:52', '258/258.jpg', '258/lkpk.jpg', 1, 0, 0, 0, NULL),
(259, 'alamgena', '7278cc571e968a52de3f8b0977717617', NULL, NULL, '2013-01-18 16:16:45', NULL, NULL, 1, 0, 0, 0, NULL),
(260, 'hrihadi', 'c56cf40aec83a0582125ac98f1d3d2bb', 'hrihadi@yahoo.com', 'Hugeng Rihadi', '2013-01-18 16:47:55', NULL, NULL, 1, 0, 0, 0, NULL),
(261, 'alhamdih', 'da0578298149bbb7f912906325b15a47', NULL, NULL, '2013-01-18 18:07:55', NULL, NULL, 1, 0, 0, 0, NULL),
(262, 'risky', 'd7f97db6c918b04a7f40f4a09dd99fc5', NULL, NULL, '2013-01-18 20:31:15', NULL, NULL, 1, 0, 0, 0, NULL),
(263, 'donyunt10061', '9be3270002e6748a0677e6238d1f67a9', 'donyunt10061@yahoo.com', 'Dony Untung Prabowo', '2013-01-18 21:52:47', NULL, NULL, 1, 0, 0, 0, NULL),
(264, 'Detabagus', '529469664bf40124826d715b5ce78c04', NULL, NULL, '2013-01-18 23:03:25', NULL, NULL, 1, 0, 0, 0, NULL),
(265, 'adyttya76', '34bd1f149b7e2ef956679b1a9da58db0', NULL, NULL, '2013-01-19 03:26:47', NULL, NULL, 1, 0, 0, 0, NULL),
(266, 'erdhiandwi', '270bb7b6857717bcc87cbb4acc542dea', NULL, NULL, '2013-01-21 00:36:49', NULL, NULL, 1, 0, 0, 0, NULL),
(267, 'fian86', '5674726011f70680e3322830431f3a94', NULL, NULL, '2013-01-19 04:54:31', NULL, NULL, 1, 0, 0, 0, NULL),
(268, 'mratmada', 'd0a55d84868d31b6a23a980350f55787', NULL, NULL, '2013-01-19 05:15:02', NULL, NULL, 1, 0, 0, 0, NULL),
(269, 'fhafa', '0841df6319c88e20d5d814c2803dcc02', NULL, NULL, '2013-01-19 05:51:17', NULL, NULL, 1, 0, 0, 0, NULL),
(270, 'Oella', '47a11491b744c45a75c6f37cb3df910b', NULL, NULL, '2013-01-19 06:14:49', NULL, NULL, 1, 0, 0, 0, NULL),
(271, 'Zahraelofati', 'bd7e111a8ccbc760ca54a48f85f1d4f4', '', 'Zahra', '2013-01-19 07:48:08', NULL, NULL, 1, 0, 0, 0, NULL),
(272, 'rgzers', '825e9ab7b1c1325e28c75566b5eb64b0', 'rgzers@gmail.com', 'Rygo Imzers', '2013-01-19 08:06:39', NULL, NULL, 1, 0, 0, 0, NULL),
(273, 'fransisco', 'ad14ce08e93fffde8dc025c5e2ce12c4', NULL, NULL, '2013-01-19 08:39:21', NULL, NULL, 1, 0, 0, 0, NULL),
(274, 'marvel', '38aeb797ff2fd00395953830a89aa764', NULL, NULL, '2013-01-19 09:27:43', NULL, NULL, 1, 0, 0, 0, NULL),
(275, 'bayu', '83ae91a8c125ffa8defc5fb4a99eaf41', NULL, NULL, '2013-01-19 09:51:04', NULL, NULL, 0, 0, 0, 0, NULL),
(276, 'putrabayu', 'af99a0e98db62d64389e880f4e7a61cd', NULL, NULL, '2013-01-19 09:58:05', NULL, NULL, 1, 0, 0, 0, NULL),
(277, 'JendNagaBonar', 'dafb45a8415ba078b2eee51d021809dc', 'dax_yat@yahoo.com', 'Jend_NagaBonar', '2013-01-19 11:06:17', '277/277.jpg', NULL, 1, 0, 0, 0, NULL),
(278, 'RESTU', '777f66582c9a8199b29871ec98d4291d', NULL, NULL, '2013-01-19 11:22:06', NULL, NULL, 0, 0, 0, 0, NULL),
(279, 'sjahroel', '6a0aea0942437215d7c25b26f44c2f9a', NULL, NULL, '2013-01-19 11:37:27', NULL, NULL, 1, 0, 0, 0, NULL),
(280, 'chokyflash', 'd996a4dca43903ab205a8ae6e2173a9e', 'sebastian.felix27@yahoo.com', 'rusli', '2013-01-19 11:54:56', NULL, NULL, 1, 0, 0, 0, NULL),
(281, 'farizal', 'bea769945db4e209e0e2b96ebde7f880', NULL, NULL, '2013-01-19 11:56:40', NULL, NULL, 1, 0, 0, 0, NULL),
(282, 'grfelna', '1e3b31372cb059a3c46628a1f2c04521', NULL, NULL, '2013-01-19 16:09:29', NULL, NULL, 1, 0, 0, 0, NULL),
(283, 'Helmanseptiansh', 'd12f4b0dd63f0a1edeaae632a23faafc', 'helman.septiansyah@yahoo.com', 'Helman Septiansyah', '2013-01-19 17:27:07', '283/283.png', '283/images.jpg', 1, 0, 0, 0, NULL),
(284, 'dieto', 'bd7bb360df6d0eab849763e25c3fc80b', 'chietoq@gmail.com', 'Ditto Muliawan', '2013-01-19 19:43:38', '284/284.jpg', NULL, 1, 0, 0, 0, NULL),
(285, 'judhi', '52b5c9c3b05e56476ddfcde079547b69', NULL, NULL, '2013-01-20 00:48:54', NULL, NULL, 1, 0, 0, 0, NULL),
(286, 'khasan', '249b4dc6d3e124ac78a4a072f3cd908e', NULL, NULL, '2013-01-20 01:43:07', NULL, NULL, 1, 0, 0, 0, NULL),
(287, 'muharazt', '55249ec37bd524fef76acdaa56f3f022', NULL, NULL, '2013-01-20 03:35:02', NULL, NULL, 0, 0, 0, 0, NULL),
(288, 'SuraLaga', 'b4e2d0722a4d7a7d0846849dd1a881a5', 'madeayick@yahoo.co.id', 'SuraLaga', '2013-01-20 05:44:08', NULL, NULL, 1, 0, 0, 0, NULL),
(289, 'yuswadi', '321a4d7efb1f6be194a49cb67d9b6f57', NULL, NULL, '2013-01-20 06:32:41', NULL, NULL, 0, 0, 0, 0, NULL),
(290, 'agapoos', '20ef02007268dc1fa9efdea515e9fa20', NULL, NULL, '2013-01-20 07:06:27', NULL, NULL, 1, 0, 0, 0, NULL),
(291, 'Felix', '61783f1819263bf1ff5e1ee6469b269d', NULL, NULL, '2013-01-20 07:38:36', NULL, NULL, 1, 0, 0, 0, NULL),
(292, 'kaduk', '66e6013f0229f9e62732ee807c0ecc13', NULL, NULL, '2013-01-21 04:33:43', NULL, NULL, 1, 0, 0, 0, NULL),
(293, 'barcot', 'eb48dd4d4017fa502b601cfcb3d9f090', NULL, NULL, '2013-01-20 08:29:13', NULL, NULL, 0, 0, 0, 0, NULL),
(294, 'onekhyiee', '7a60c0b85e2d88460ad956640304e9b1', NULL, NULL, '2013-01-20 08:42:35', NULL, NULL, 0, 0, 0, 0, NULL),
(295, 'dicmul', '355336c5f9ec58733219707f1399537e', NULL, NULL, '2013-01-20 08:50:08', NULL, NULL, 0, 0, 0, 0, NULL),
(296, 'dic11mul', '822b440edda4c46a5e1dad463eaf8ebd', NULL, NULL, '2013-01-20 08:55:11', NULL, NULL, 0, 0, 0, 0, NULL),
(297, 'silentbow', '14e94b8346f5f031131cbc12abf6de9e', NULL, NULL, '2013-01-20 09:02:41', NULL, NULL, 0, 0, 0, 0, NULL),
(298, 'silentbowo', '9f91866fed044703e3a6b673ed0c470a', NULL, NULL, '2013-01-20 09:04:43', NULL, NULL, 0, 0, 0, 0, NULL),
(299, 'luckystar', 'ac7d9b092b8667de44435b33aa346250', NULL, NULL, '2013-01-20 09:29:35', NULL, NULL, 0, 0, 0, 0, NULL),
(300, 'tedygraha', '24d16918cb66f37020caa9061848a676', NULL, NULL, '2013-01-20 10:09:44', NULL, NULL, 0, 0, 0, 0, NULL),
(301, 'sunshine', '98a7b8376746708075b53601347f5d2c', NULL, NULL, '2013-01-20 10:30:08', NULL, NULL, 0, 0, 0, 0, NULL),
(302, 'redyrohmansyah', 'cdf373ba40871c0957de145611a4f151', NULL, NULL, '2013-01-20 10:30:38', NULL, NULL, 0, 0, 0, 0, NULL),
(303, 'bangjukrik', '86367d1bb0ec14275412d72151d38b94', NULL, NULL, '2013-01-20 10:40:27', NULL, NULL, 0, 0, 0, 0, NULL),
(304, 'melsonfaot', '169d01fb6a7ec0bca89e5a6297d5b007', NULL, NULL, '2013-01-20 11:04:10', NULL, NULL, 0, 0, 0, 0, NULL),
(305, 'Mifta', '9ce47653605801e85e2ea9adc59b0b52', NULL, NULL, '2013-01-20 11:22:50', NULL, NULL, 0, 0, 0, 0, NULL),
(306, 'tedy', 'a1930c790d664829bb7db55b5ca6c004', NULL, NULL, '2013-01-20 11:24:17', NULL, NULL, 0, 0, 0, 0, NULL),
(307, 'hesty', '29c6a76ecb812a284048d2fe4195ddb4', NULL, NULL, '2013-01-20 11:38:58', NULL, NULL, 0, 0, 0, 0, NULL),
(308, 'adit569', '57c4de76df0ddebbf54918243414b639', NULL, NULL, '2013-01-20 12:22:57', NULL, NULL, 0, 0, 0, 0, NULL),
(309, 'dionwangge', 'cb602e78b788524d32a8b16b558514a7', NULL, NULL, '2013-01-20 14:12:34', NULL, NULL, 0, 0, 0, 0, NULL),
(310, 'feldwinaymailcom', '5698229aeb71b67738b2ecec9dbfc31a', NULL, NULL, '2013-01-21 10:52:47', NULL, NULL, 1, 0, 0, 0, NULL),
(311, 'rizky', '2dd7eea7f0631fab002416f64b28d324', NULL, NULL, '2013-01-20 15:50:23', NULL, NULL, 0, 0, 0, 0, NULL),
(312, 'luiizmanciipe', '11cc47e70933d4d928498869e747950a', NULL, NULL, '2013-01-20 16:09:54', NULL, NULL, 0, 0, 0, 0, NULL),
(313, 'rhizky', '3002b3d9f09a2d9d026d06ee11e5b68c', NULL, NULL, '2013-01-20 17:18:52', NULL, NULL, 0, 0, 0, 0, NULL),
(314, 'thelieurd', '1fe36c70599ca9481a10196140dc7ddc', NULL, NULL, '2013-01-20 17:19:40', NULL, NULL, 0, 0, 0, 0, NULL),
(315, 'yhansha', 'a136bceb30c95f5300c465a672901ff3', NULL, NULL, '2013-01-20 20:51:16', NULL, NULL, 0, 0, 0, 0, NULL),
(316, 'yansa14', '56c82742523720d4b87d56b5c55cd6ae', NULL, NULL, '2013-01-20 20:59:03', NULL, NULL, 0, 0, 0, 0, NULL),
(317, 'herualfayed', '9d37d082ca6a765927ac1fe71fd53e07', 'heru.blankon94@gmail.com', 'heru', '2013-01-21 02:04:52', NULL, NULL, 1, 0, 0, 0, NULL),
(318, 'chairulalfayed', '2c23c1714551c75b029bdc6d7e0e333f', NULL, NULL, '2013-01-21 00:11:11', NULL, NULL, 0, 0, 0, 0, NULL),
(319, 'riznadjanati', '7c476fa17d4ddcfdc97961b9d1049115', 'riznaz_djanati@yahoo.com', 'rizna djanati', '2013-01-21 03:48:53', '319/319.gif', '319/foto0849_001.jpg', 1, 0, 0, 0, NULL),
(320, 'rudtomico', 'e29283de8fc190ca82c762dd4d3bd478', '', 'tomico', '2013-01-21 01:49:15', NULL, NULL, 1, 0, 0, 0, NULL),
(321, 'tomico', '4d38678a48ffd708dba93504b30b3321', NULL, NULL, '2013-01-21 01:16:57', NULL, NULL, 0, 0, 0, 0, NULL),
(322, 'abrahamwilly', 'ad52620371c7f46fc3e534b617a1a032', NULL, NULL, '2013-01-21 01:46:54', NULL, NULL, 1, 0, 0, 0, NULL),
(323, 'redy2012', '6af1c2b3eb1bf6a05ebbb35eb4986087', NULL, NULL, '2013-01-21 02:03:43', NULL, NULL, 1, 0, 0, 0, NULL),
(324, 'pingkantangkilisan', '615e339c157fb6e6ee1f6965fbf79dce', NULL, NULL, '2013-01-21 02:44:54', NULL, NULL, 1, 0, 0, 0, NULL),
(325, 'helmi', 'cf3750951241a8cf90e2a0fb0af63fe2', 'helmi', 'helmi', '2013-01-21 02:53:11', NULL, NULL, 1, 0, 0, 0, NULL),
(326, 'onekhyiee11', '23740c8852fbb68eea6ff55a1626db7c', 'muliawan', 'dicky', '2013-01-21 03:28:32', NULL, '326/IMG_3131-16053904.jpg', 1, 0, 0, 0, NULL),
(327, 'masamadesa', '0b484e83da539c63fa1c1695bcc51adb', NULL, NULL, '2013-01-21 03:31:11', NULL, NULL, 1, 0, 0, 0, NULL),
(328, 'queendaniz', 'd24c171e9130e4bec065d78384f1436b', 'queen.daniz@gmail.com', 'Danis Siswayanti', '2013-01-21 04:00:26', '328/328.jpg', '328/36645_128765147157627_100000724278495_186858_7', 1, 0, 0, 0, NULL),
(329, 'iyma', 'e172dd95f4feb21412a692e73929961e', 'iymabonezh@yahoo.com', 'halimahtussa''diyah', '2013-01-21 05:05:08', '329/329.jpg', '329/img_4841.jpg', 1, 0, 0, 0, NULL),
(330, 'Diens79', 'e1bf16536819623603ccddece9f8f15e', NULL, NULL, '2013-01-21 04:44:48', NULL, NULL, 1, 0, 0, 0, NULL),
(331, 'erwin', 'dee41aa7411c7882b5b406854a408519', NULL, NULL, '2013-01-21 04:48:01', NULL, NULL, 1, 0, 0, 0, NULL),
(332, 'starlucky', '0dafbc6f7295f8d0a3c45a55d5e26db7', NULL, NULL, '2013-01-21 04:45:13', NULL, NULL, 1, 0, 0, 0, NULL),
(333, 'satriapratama', 'bdcb09cb39a7a9cc25398f479ba8177d', NULL, NULL, '2013-01-21 04:53:54', NULL, NULL, 1, 0, 0, 0, NULL),
(334, 'deni', '84e5a7c08f0894f71c60ffed3da1b35a', 'denicahyadi6@gmail.com', 'deni ', '2013-01-21 05:42:41', '334/334.png', '334/new HOB 2.jpg', 1, 0, 0, 0, NULL),
(335, 'AanAnwar', 'f232a8f113428ea7d79fe50c365a985e', NULL, NULL, '2013-01-21 05:36:47', NULL, NULL, 1, 0, 0, 0, NULL),
(336, 'agunkry', '78fd2b1367c708e941a3025dbf1738c5', NULL, NULL, '2013-01-21 06:20:09', NULL, NULL, 1, 0, 0, 0, NULL),
(337, 'gunkry', 'e68d60edfb709b5834cb5e9286b4ce4b', NULL, NULL, '2013-01-21 06:17:53', NULL, NULL, 0, 0, 0, 0, NULL),
(338, 'Stipeng', '9d1cd95d4d74eaca0044b8f47f436eea', NULL, NULL, '2013-01-21 06:35:38', NULL, NULL, 1, 0, 0, 0, NULL),
(339, 'sunshinepictures', 'd4c182a0e030d28d0d64e21fda47bfd7', NULL, NULL, '2013-01-21 08:47:26', NULL, NULL, 1, 0, 0, 0, NULL),
(340, 'dian', '6cf17a5da3cc7c3d239314a9fa753ba4', 'dian.apriliany@gmail.com', 'Dian April', '2013-01-21 09:16:23', NULL, NULL, 1, 0, 0, 0, NULL),
(341, 'hidayat', '7c7db87a41c142c7ffd1bee7ac3a565a', NULL, NULL, '2013-01-21 09:13:01', NULL, NULL, 1, 0, 0, 0, NULL),
(342, 'rifan', '0e55d8609689eded4b12853ad6329b93', NULL, NULL, '2013-01-21 10:24:22', NULL, NULL, 1, 0, 0, 0, NULL),
(343, 'FarrelIqbal', 'e1ec2afc9691e3443f1e59d75c6b0ee1', NULL, NULL, '2013-01-21 10:50:05', NULL, NULL, 1, 0, 0, 0, NULL),
(344, 'WilLBack', 'e2cc7efdd5b3599cab3da84641858a40', '', 'WilLBack', '2013-01-21 11:47:32', NULL, NULL, 1, 0, 0, 0, NULL),
(345, 'dodol', '619341c46b9f60b1e71fbbf2e0daca8e', NULL, NULL, '2013-01-21 12:49:47', NULL, NULL, 1, 0, 0, 0, NULL),
(346, 'asepharyadi', '45a33b15bf1775dcdc0b3339527c208f', NULL, NULL, '2013-01-21 13:08:21', NULL, NULL, 0, 0, 0, 0, NULL),
(347, 'dezmid', 'f9afbe1ded68a315774fc9d4f881ec39', NULL, NULL, '2013-01-21 14:27:16', NULL, NULL, 0, 0, 0, 0, NULL),
(348, 'dezmid7', 'a6055cbe2087e619878dbf3f74df4af7', NULL, NULL, '2013-01-21 14:50:57', NULL, NULL, 1, 0, 0, 0, NULL),
(349, 'erickuswanto', '26c0f1181a92f20ac590d6a5b1583ac4', NULL, NULL, '2013-01-21 16:48:20', NULL, NULL, 0, 0, 0, 0, NULL),
(350, 'nicohezkiel', '078ebbe458f580869feebb69387381a3', NULL, NULL, '2013-01-21 16:54:25', NULL, NULL, 1, 0, 0, 0, NULL),
(351, 'raskalvista', '946aa0c612952da8d67dd338a43d5929', NULL, NULL, '2013-01-21 17:36:53', NULL, NULL, 1, 0, 0, 0, NULL),
(352, 'ronaldlie', 'a52fe185bcb5b76ba94b2d7824f92df7', 'ronald.lie85@yahoo.com', 'Ronald Lie', '2013-01-22 00:37:14', NULL, NULL, 1, 0, 0, 0, NULL),
(353, 'dianrabbit', 'bea04ea2fbe3a25bb3f8039be752a0f7', 'dian_yamsasni@yahoo.com', 'Dian Yamsasni Rizki', '2013-01-22 03:03:24', '353/353.jpg', '353/me n papi mami.jpg', 1, 0, 0, 0, NULL),
(354, 'irwansyah', 'bb3c9a667bf4df77e8270cc6795a18c6', NULL, NULL, '2013-01-22 05:00:29', NULL, NULL, 1, 0, 0, 0, NULL),
(355, 'QisanPeratama', '9360d670e56a0033e1b3c16580953345', NULL, NULL, '2013-01-22 05:13:14', NULL, NULL, 1, 0, 0, 0, NULL),
(356, 'afreza', '5be5b4c9c6e90e82e2964ddd8e37e147', NULL, NULL, '2013-01-22 06:02:47', NULL, NULL, 1, 0, 0, 0, NULL),
(357, 'winda', '73bc8649785cc47660ae5dc3b802cda6', NULL, NULL, '2013-01-22 08:35:53', NULL, NULL, 0, 0, 0, 0, NULL),
(358, 'windawati', '7b6b7d362a1b44df5606fc20b601146e', 'winda_ketut@ymail.com', 'windawati', '2013-01-22 10:19:48', NULL, NULL, 1, 0, 0, 0, NULL),
(359, 'rommel', '323581993ed81bbe3a03ed79291d3301', NULL, NULL, '2013-01-22 08:50:47', NULL, NULL, 0, 0, 0, 0, NULL),
(360, 'amelkyuminew', 'bc8bc55308b18be14a221bf5ca104975', NULL, NULL, '2013-01-22 08:56:47', NULL, NULL, 1, 0, 0, 0, NULL),
(361, 'sangapprawira', 'e0757d60cb4c2307fe01fbebfec21912', 'sangapprawira@yahoo.com', 'sangap prawira simanjuntak', '2013-01-22 09:48:30', '361/361.jpg', NULL, 1, 0, 0, 0, NULL),
(362, 'poetraxx', '13ccd1320c1fed0ea1ec02f472d4e98e', NULL, NULL, '2013-01-22 10:21:14', NULL, NULL, 0, 0, 0, 0, NULL),
(363, 'Abdulh', '2492153431a834b5f11c65549f293aa2', 'abdulholik@ymail.com', 'Abdul Holik', '2013-01-23 04:00:59', '363/363.jpg', '363/Chrysanthemum.jpg', 1, 0, 0, 0, NULL),
(364, 'Rully', 'd826b5868ffa6085264345e3180cfcd3', 'anak@tiga@yahoo.com', 'rully Sofiyulloh', '2013-01-22 16:50:46', NULL, NULL, 1, 0, 0, 0, NULL),
(365, 'achiangwu', '3aff2df2dc336a5ce492bee6ca866bfe', NULL, NULL, '2013-01-23 02:02:37', NULL, NULL, 0, 0, 0, 0, NULL),
(366, 'indratindaon', 'f8d93a6b3deb994b4a98452826ab6329', NULL, NULL, '2013-01-23 02:54:50', NULL, NULL, 1, 0, 0, 0, NULL),
(367, 'achiangwuyahoocom', '678402b5fd16c60b9bc36b1103a54c9f', NULL, NULL, '2013-01-23 03:18:09', NULL, NULL, 0, 0, 0, 0, NULL),
(368, 'sahrudi', '3ea3260395b96c1de94beca278f4c1a6', NULL, NULL, '2013-01-23 03:24:55', NULL, NULL, 1, 0, 0, 0, NULL),
(369, 'fandy', 'a8bdc4e33a7c41dba362355e5d905c35', NULL, NULL, '2013-01-23 04:03:37', NULL, NULL, 1, 0, 0, 0, NULL),
(370, 'aditrhaldy', 'c28a1bb382391a0357f3ca0a0cf22026', 'aditrhaldi@rocketmail.com', 'adit rhaldy', '2013-01-23 04:22:20', NULL, NULL, 1, 0, 0, 0, NULL),
(371, 'dharma', '11b80cd33a308628feaaba9857c732bb', '', 'Alphard Beruntung', '2013-01-23 12:27:46', NULL, NULL, 1, 0, 10, 6, ''),
(372, 'tiktokyaa', '830524f0379bbc27f37d1381fb3658b2', NULL, NULL, '2013-01-23 05:06:20', NULL, NULL, 1, 0, 0, 0, NULL),
(373, 'dedengsuryadi', '667b07d7957eebf453f08c666006c958', NULL, NULL, '2013-01-23 05:20:39', NULL, NULL, 1, 0, 0, 0, NULL),
(374, 'alyakania', '939e5ab4fbd66eff26ac8297e18f12ab', NULL, NULL, '2013-01-23 05:34:19', NULL, NULL, 1, 0, 0, 0, NULL),
(375, 'remi2009', 'bd650927b21e4e96e76d688e29aedd5e', NULL, NULL, '2013-01-23 07:54:58', NULL, NULL, 0, 0, 0, 0, NULL),
(376, 'juaneldo', 'ed5933de4d1b2104bfca708239401104', NULL, NULL, '2013-01-23 08:31:14', NULL, NULL, 0, 0, 0, 0, NULL),
(377, 'ekypanawa', '036fd405674d6fed34fe70c07975d4ef', NULL, NULL, '2013-01-23 09:05:19', NULL, NULL, 0, 0, 0, 0, NULL),
(378, 'angriawan', '6631a272f6d8876e578292118cbbf89f', NULL, NULL, '2013-01-23 09:19:12', NULL, NULL, 0, 0, 0, 0, NULL),
(379, 'wawan', 'ab8ccd6341810ed00842182f9ef3c709', NULL, NULL, '2013-01-23 09:23:30', NULL, NULL, 0, 0, 0, 0, NULL),
(380, 'YuniarPrihandiniRachmat', 'f2bf99a464b78246f2a62d55e9fa7c09', NULL, NULL, '2013-01-23 09:38:08', NULL, NULL, 0, 0, 0, 0, NULL),
(381, 'YuniarPrihandini', 'a09b1ab44b6445aa5050edb088b97925', NULL, NULL, '2013-01-23 09:43:09', NULL, NULL, 0, 0, 0, 0, NULL),
(382, 'aguan', 'f657a2e204281e051f5a1b606c250b43', NULL, NULL, '2013-01-23 10:03:35', NULL, NULL, 0, 0, 0, 0, NULL),
(383, 'dieta', 'b5892ed53886053204b0a44c7d9d88ca', NULL, NULL, '2013-01-23 10:06:33', NULL, NULL, 0, 0, 0, 0, NULL),
(384, 'salmanalfarisi', 'e25ef3da0b6f9f311c80043638838c0a', NULL, NULL, '2013-01-23 10:17:45', NULL, NULL, 0, 0, 0, 0, NULL),
(385, 'sumarwoto', '22a394e9e1abdc7eb8da6360859e4761', NULL, NULL, '2013-01-23 10:19:56', NULL, NULL, 0, 0, 0, 0, NULL),
(386, 'sudarwito', 'c9312752864074bd5e0a8c345de00895', NULL, NULL, '2013-01-23 12:28:21', NULL, NULL, 1, 0, 0, 0, NULL),
(387, 'nurmasofia', 'cbd3e459b4dd3fc7cf3f661ef16794c0', NULL, NULL, '2013-01-23 16:01:30', NULL, NULL, 1, 0, 0, 0, NULL),
(388, 'mdedeh', 'c5d5410e7f14ba184b44f51bf3aaa691', '', 'chupetonk', '2013-01-23 16:40:13', NULL, NULL, 1, 0, 0, 0, ''),
(389, 'komuklongves', 'b0d7afc8ffd4ec4150ce9bba29f20969', 'komuklongves@gmail.com', 'Ade Pramudita', '2013-01-23 18:44:02', NULL, NULL, 1, 0, 0, 0, ''),
(390, 'andreas', 'da227954db399164dec3459bdadada59', NULL, NULL, '2013-01-24 00:32:27', NULL, NULL, 1, 0, 0, 0, NULL),
(391, 'andhikafajar', '24cc3b780ee3dcbf8e0593b84c5f0a5b', NULL, NULL, '2013-01-24 01:36:21', NULL, NULL, 1, 0, 0, 0, NULL),
(392, 'ewink', '517263efcf75fe7a869a8182e3dbd4ed', NULL, NULL, '2013-01-24 03:08:09', NULL, NULL, 1, 0, 0, 0, NULL),
(393, 'clarafransiska', '3efc952e9bdf3fb26b8476cac40ac8c8', NULL, NULL, '2013-01-24 03:10:02', NULL, NULL, 0, 0, 0, 0, NULL),
(394, 'melrew14', 'b54610023aec2ff8ce90f49fd969249b', NULL, NULL, '2013-01-24 03:49:45', NULL, NULL, 1, 0, 0, 0, NULL),
(403, 'herry', '673491c1a59d25086ac3c58964dae71a', 'mail@mail.com', 'herry', '0000-00-00 00:00:00', '', '', 1, 1, 0, 0, '024545');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
